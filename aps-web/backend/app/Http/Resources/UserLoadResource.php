<?php

namespace App\Http\Resources;

use App\Models\Support;
use App\Models\SupportResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoadResource extends JsonResource
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
            'last_name' => $this->last_name,
            'email' => $this->email,
            'image' => $this->image,
            'message' => $this->lastMessage($this->id),

        ];
    }
    public function lastMessage($id)
    {
        $data = [];
        $message = null;
        $created_at = null;
        $isread = false;
        $online = false;

        $support = Support::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($support) {
            $response = SupportResponse::where('support_id', $support->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($response) {
                $message = $response->message;
                $created_at = $response->created_at;
                $isread = false;
                $online = false; // user not online if there’s a response
            } else {
                $message = $support->message;
                $created_at = $support->created_at;
                $isread = true;

                // Only support message, check if it’s within 5 minutes
                $createdAt = Carbon::parse($support->created_at)->timezone(config('app.timezone'));
                $now = Carbon::now();
                $online = $now->diffInMinutes($createdAt) < 5; // ✅ boolean
            }
        }

        $data['last_message'] = $message;
        $data['last_message_created_at'] = $created_at;
        $data['unread'] = $isread;
        $data['online'] = $online;

        return $data;
    }
}
