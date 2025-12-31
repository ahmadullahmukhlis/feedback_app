<?php

namespace App\Http\Resources;

use App\Http\Resources\UserManagement\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;

class   UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'full_name' => $this->first_name.' '.$request->last_name,
            'last_name' => $this->last_name,
            'image' => $this->image,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'change_password' => $this->change_password,
            'permissions' => $this->whenLoaded('roles', fn()=> $this->permissions()),
            'roles' => $this->whenLoaded('roles', function(){
                return RoleResource::collection(Role::query()->whereIn('id', $this->roles->pluck('role_id')->toArray())->get());
            }),
            'created_at' => Date::make($this->created_at)->format('Y-m-d h:i A'),
        ];
    }
}
