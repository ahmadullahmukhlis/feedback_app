<?php

namespace App\Http\Controllers\UserManagement;

use App\Events\UserUpdatedEvent;
use App\Helpers\DatatableBuilder;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Http\Resources\LoginLogResource;
use App\Http\Resources\UserManagement\ActivityLogResource;
use App\Http\Resources\UserResource;
use App\Models\LoginLog;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Models\Activity;

class UserManagementController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            LoginLog::query()->create([
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'login_succeed' => false,
                'message' => 'The provided credentials are incorrect.',
            ]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }elseif(!$user->is_active){
            LoginLog::query()->create([
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'login_succeed' => false,
                'message' => 'User is inactive.',
            ]);
            throw ValidationException::withMessages([
                'email' => ['User is inactive.'],
            ]);
        }
        $token = $user->createToken('user_token')->plainTextToken;
        LoginLog::query()->create([
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'login_succeed' => true,
            'message' => 'Logged in successfully.',
            'login_token' => $token,
        ]);
        return $token;
    }

    public function changePassword(){
        $data = \request()->validate([
            'old_password' => ['required', 'string', function($field, $value, $error){
                if(!Hash::check($value, \request()->user()->password)) $error('Old password is incorrect');
                if (Hash::check($value, \request()->user()->new_password)) $error('New password must be different then previous');
            }],
            'new_password' => ['required', 'string', Password::default()],
            'confirm_password' => ['required', 'same:new_password'],
        ]);
        \request()->user()->update([
            'password' => Hash::make($data['new_password']),
            'change_password' => false
        ]);
        return \response()->json([
            'result' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    public function user(Request $request){
        return new UserResource($request->user()->load(['roles']));
    }

    public function logout(Request $request): Response{
        \request()->user()->tokens()->delete();
        return response()->noContent();
    }

    public function index(Request $request){
        if($request->has('for_api')){
            if($request->get('search')){
                return UserResource::collection(
                    User::query()->where('id', '!=', \auth()->id())->where(function ($query){
                        $query->where('id', '!=', 1);
                        $query->where('first_name', 'LIKE', '%'.\request()->get('search').'%');
                        $query->orWhere('last_name', 'LIKE', '%'.\request()->get('search').'%');
                    })->limit(10)->get()
                );
            }else{
                return UserResource::collection(
                    User::query()->limit(100)->where('id', '!=', 1)->get()
                );
            }
        }
        $this->allowed('users-access');

        $users = User::query()->where('id', '!=', \auth()->id());
        if($request->has('from') && $request->has('to')){
            $users = $users->whereBetween('created_at', [$request->get('from'), $request->get('to')]);
        }
        $datatable = new DatatableBuilder($users, ['first_name', 'last_name', 'email']);
        return UserResource::collection($datatable->build());
    }

    public function store(UserRequest $request){
        $this->allowed('users-create');
        $data = $request->validated();
        $roles = $data['roles'];
        unset($data['roles']);
        DB::beginTransaction();
        try {
            $data['is_active'] = true;
            $data['change_password'] = true;
            $user = User::query()->create($data);
            foreach ($roles as $role){
                UserRole::query()->create([
                    'role_id' => $role,
                    'user_id' => $user->id
                ]);
            }
            DB::commit();
        }catch (\Exception $e){
            Log::error($e);
            DB::rollBack();
            return \response()->json([
                'result' => false,
                'message' => 'Something went wrong'
            ]);
        }
        return \response()->json([
            'result' => true,
            'message' => 'User created successfully'
        ]);
    }

    public function show(Request $request, User $user){

        if($request->has('show_activity_log')){
            $this->allowed('users-view-details');
            $query = Activity::query()->with(['causer'])->where('causer_id', $user->id);
            $datatable = new DatatableBuilder($query, ['description', 'subject_type', 'log_name']);
            return ActivityLogResource::collection($datatable->build());
        }else{
            $this->allowed('users-access');
            return new UserResource($user->load(['roles']));
        }

    }

    public function update(User $user, UserRequest $userRequest){
        $this->allowed('users-edit');
        $data = $userRequest->validated();
        if($userRequest->file('image')){
            Helpers::removeImageFromUrl($user->image);
        }else{
            $data['image'] = $user->image;
        }
        $roles = $data['roles'];
        DB::beginTransaction();
        try{
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'image' => $data['image'],
                'is_active' => !($data['is_active'] == 'false'),
            ]);
            if($data['password']){
                $user->update([
                    'password' => $data['password'],
                    'change_password' => true
                ]);
            }
            UserRole::query()->where('user_id', $user->id)->delete();
            foreach ($roles as $role){
                UserRole::query()->create([
                    'role_id' => $role,
                    'user_id' => $user->id
                ]);
            }
            cache()->forget('permission_keys_'.$user->id);
            DB::commit();
        }catch (\Exception $e){
            Log::error($e);
            DB::rollBack();
            return \response()->json([
                'result' => false,
                'message' => 'Something went wrong',
            ]);
        }
        event(new UserUpdatedEvent([
            'is_active' => $user->is_active,
            'message' => !$user->is_active ? 'Your account deactivate': '',
            'user_id' => $user->id
        ]));
        return \response()->json([
            'result' => true,
            'message' => 'Updated successfully',
            'update_id' => $user->id
        ]);
    }

    public function destroy(Request $request, User $user ){
        $this->allowed('users-delete');
        UserRole::query()->where('user_id', $user->id)->delete();
        $user->delete();
        return \response()->json([
            'result' => true,
            'message' => 'User deleted successfully'
        ]);
    }
    public function loginLog(Request $request){
        $this->allowed('login-log-access');
        $query = LoginLog::query();
        if($request->has('from') && $request->has('to')){
            $query = $query->whereBetween('created_at', [$request->get('from'), $request->get('to')]);
        }
        $datatable = new DatatableBuilder($query, ['email','ip_address']);
        return LoginLogResource::collection($datatable->build());
    }
}
