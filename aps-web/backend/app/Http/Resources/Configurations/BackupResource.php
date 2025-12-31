<?php

namespace App\Http\Resources\Configurations;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupResource extends JsonResource
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
            'user' => $this->user?$this->user->first_name.' '.$this->user->last_name:'By system',
            'path' => $this->path,
            'size' => Helpers::formatFileSize($this->size),
            'created_at' => $this->created_at->format(cache()->get('software-settings')?->date_format.' h:i:s A'),
        ];
    }
}
