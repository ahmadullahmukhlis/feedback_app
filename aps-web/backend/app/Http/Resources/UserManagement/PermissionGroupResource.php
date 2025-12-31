<?php

namespace App\Http\Resources\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionGroupResource extends JsonResource
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
            'icon' => $this->icon,
            'groups' => $this->whenLoaded('groups', fn()=>PermissionGroupResource::collection($this->groups)),
            'permissions' => $this->whenLoaded('permissions', fn()=>PermissionResource::collection($this->permissions))
        ];
    }
}
