<?php

namespace App\Http\Resources\UserManagement;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            'causer' => new UserResource($this->causer),
            'subject_type' => $this->subject_type,
            'description' => $this->description,
            'properties' => $this->properties,
            'created_at' => $this->created_at->format(cache()->get('software-settings')?->date_format.' h:i:s A'),
        ];
    }
}
