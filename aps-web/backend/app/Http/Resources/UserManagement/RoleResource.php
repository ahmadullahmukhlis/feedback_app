<?php

namespace App\Http\Resources\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->id,
            'label' => $this->name,
            'role_permissions' => $this->whenLoaded('permission_ids', fn()=>$this->permission_ids->pluck('permission_id')->toArray()),
            'permissions' => $this->whenLoaded('permission_ids', fn()=>$this->permission_ids->load(['permission'])),
            'updated_by_user' => $this->whenLoaded('updated_by_user', fn()=>$this->updated_by_user),
            'created_by_user' => $this->whenLoaded('created_by_user', fn()=>$this->created_by_user),
        ];
    }
}
