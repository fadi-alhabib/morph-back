<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'whatsapp_link' => $this->whatsapp_link,
            'x_link'        => $this->x_link,
            'youtube_link'  => $this->youtube_link,
            'instagram_link' => $this->instagram_link,
            'phone_number'  => $this->phone_number,
            'email'         => $this->email,
            'location'      => $this->location,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
