<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageViewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'method' => $this->method,
            'ip' => $this->ip,
            'referer' => $this->referer,
            'user_agent' => $this->user_agent,
            'viewed_at' => $this->viewed_at?->toDateTimeString(),
        ];
    }
}
