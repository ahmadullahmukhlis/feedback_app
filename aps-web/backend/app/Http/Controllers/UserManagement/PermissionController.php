<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\PermissionRequest;
use App\Jobs\FetcherSeedFilesJob;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function store(PermissionRequest $request ){
        $this->allowed('');
        $data = $request->validated();
        Permission::query()->create($data);
        FetcherSeedFilesJob::dispatch();
        return response()->json([
            'result' => true,
            'message' => 'Permission created successfully'
        ]);
    }

    public function destroy(Permission $permission, Request $request ){
        $this->allowed('');
        if(RolePermission::query()->where('permission_id', $permission->id)->count() > 0){
            return response()->json([
                'result' => false,
                'message' => 'Permission cannot be deleted'
            ]);
        }
        $permission->delete();
        FetcherSeedFilesJob::dispatch();
        return response()->json([
            'result' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }
}
