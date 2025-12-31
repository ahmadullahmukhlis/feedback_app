<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'message' => $this->message,
            'imagePath' => $this->imagePath ? asset(Storage::url($this->imagePath)) : null,
            'created_at' => $this->created_at,
        ];
    }
}
