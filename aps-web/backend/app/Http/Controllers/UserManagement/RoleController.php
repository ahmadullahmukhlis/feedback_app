<?php

namespace App\Http\Controllers\UserManagement;

use App\Events\UserUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\RoleRequest;
use App\Http\Resources\UserManagement\PermissionGroupResource;
use App\Http\Resources\UserManagement\RoleResource;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request ){
        if($request->has('fetch_all')){
            return RoleResource::collection(
                Role::query()->get()
            );
        }
        $this->allowed('roles-access');
        $roles = Role::query();
        if(auth()->id()!=1){
            $role_ids = auth()->user()->load(['roles.role'])->roles->map(function($item){
                return $item->role->id;
            });
            $roles = Role::query()->where('id', '!=', $role_ids);
        }
        return RoleResource::collection(
            $roles->get()
        );
    }
    public function store(RoleRequest $request ){
        $this->allowed('roles-create');
        $data = $request->validated();
        Role::query()->create($data);
        return response()->json([
            'result' => true,
            'message' => 'Role created successfully'
        ]);
    }

    public function show(Request $request, Role $role ){
        $this->allowed('roles-view-details');
        return response()->json([
            'role' => new RoleResource($role->load(['permission_ids', 'updated_by_user', 'created_by_user'])),
            'permission_groups' => PermissionGroupResource::collection(
                PermissionGroup::query()->where('permission_group_id', 0)
                    ->with(['groups', 'permissions'])
                    ->orderBy('sort')
                    ->get()
            )
        ]);
    }

    public function update(Request $request, Role $role){
        $this->allowed('roles-edit');
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', Rule::unique('roles')->ignore($role)],
            'role_permissions' => ['nullable', 'array']
        ]);
        $role->update([
            'name' => $data['name'],
            'updated_by' => auth()->id()
        ]);
        RolePermission::query()->where('role_id', $role->id)->delete();
        foreach ($data['role_permissions'] as $permission_id){
            RolePermission::query()->create([
                'permission_id' => $permission_id,
                'role_id' => $role->id
            ]);
        }
        $user_ids = UserRole::query()->where('role_id', $role->id)->pluck('user_id')->toArray();
        foreach ($user_ids as $id){
            Cache::forget('permission_keys_'.$id);
        }
        event(new UserUpdatedEvent('Updated event'));
        return response()->json([
            'result' => true,
            'message' => 'Role updated successfully'
        ]);
    }

    public function destroy(Request $request, Role $role ){
        $this->allowed('roles-delete');
        if($role->permission_ids->count() > 0){
            return response()->json([
                'result' => false,
                'message' => 'Role cannot be deleted because there are some permissions attach to it'
            ]);
        }
        if($role->users->count() > 0){
            return response()->json([
                'result' => false,
                'message' => 'Role cannot be deleted because some users have this role'
            ]);
        }
        $role->delete();
        return response()->json([
            'result' => true,
            'message' => 'Role deleted successfully'
        ]);
    }
}
