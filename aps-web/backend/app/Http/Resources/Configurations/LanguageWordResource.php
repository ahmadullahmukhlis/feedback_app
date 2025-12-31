<?php

namespace App\Http\Resources\Configurations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageWordResource extends JsonResource
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
            'word' => $this->word,
            'translation' => $this->translation,
            'created_at' => $this->created_at->format(cache()->get('software-settings')?->date_format.' h:i:s A'),
        ];
    }
}
