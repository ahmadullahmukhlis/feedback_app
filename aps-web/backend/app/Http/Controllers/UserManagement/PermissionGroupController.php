<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\PermissionGroupRequest;
use App\Http\Resources\UserManagement\PermissionGroupCollection;
use App\Http\Resources\UserManagement\PermissionGroupResource;
use App\Jobs\FetcherSeedFilesJob;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionGroupController extends Controller
{
    public function index(Request $request ){
        $this->allowed('');
        return PermissionGroupResource::collection(
            PermissionGroup::query()->where('permission_group_id',0)
            ->with(['groups', 'permissions'])
            ->orderBy('sort')
            ->get()
        );
    }

    public function store(PermissionGroupRequest $request ){
        $this->allowed('');
        $data = $request->validated();
        $max_sort = PermissionGroup::query()->where('permission_group_id', $data['permission_group_id'])->max('sort');
        if(PermissionGroup::query()->where('permission_group_id', $data['permission_group_id'])->count() > 0){
            $max_sort = $max_sort+1;
        }else{
            $max_sort = $max_sort > 0 ? $max_sort+1:$max_sort;
        }
        $data['sort'] = $max_sort == null?0:$max_sort;
        PermissionGroup::query()->create($data);
        FetcherSeedFilesJob::dispatch();
        return response()->json([
            'result' => true,
            'message' => 'Saved successfully',
        ]);
    }

    public function update(PermissionGroupRequest $request, PermissionGroup $permissionGroup){
        $data = $request->validated();
        $permissionGroup->update([
            'name' => $data['name'],
            'icon' => $data['icon'],
        ]);
        FetcherSeedFilesJob::dispatch();
        return response()->json([
            'result' => true,
            'message' => 'Updated successfully',
        ]);
    }

    public function updatePermissionSort(Request $request){
        $first = PermissionGroup::query()
            ->where('permission_group_id', $request->get('parent_id'))
            ->where('sort', (int)$request->get('addedIndex'))
            ->first();
        $second = PermissionGroup::query()
            ->where('permission_group_id', $request->get('parent_id'))
            ->where('sort', (int)$request->get('removedIndex'))
            ->first();
        $first->update([
            'sort' => (int)$request->get('removedIndex')
        ]);
        $second->update([
            'sort' => (int)$request->get('addedIndex')
        ]);
        FetcherSeedFilesJob::dispatch();
        return response()->noContent();
    }

    public function destroy(Request $request, PermissionGroup $permissionGroup ){
        $this->allowed('');
        if($permissionGroup->groups->count()){
            return response()->json([
                'result' => false,
                'message' => 'Permission group cannot be deleted because ('.$permissionGroup->groups->count().') children is registered for this group'
            ]);
        }
        if($permissionGroup->permissions->count()){
            return response()->json([
                'result' => false,
                'message' => 'Permission group cannot be deleted because ('.$permissionGroup->permissions->count().') permissions are not registered for'
            ]);
        }
        $permissionGroup->delete();
        FetcherSeedFilesJob::dispatch();
        return response()->json([
            'result' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}
