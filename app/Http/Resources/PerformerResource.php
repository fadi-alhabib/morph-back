<?php

namespace App\Http\Resources;

use App\Services\S3FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $s3Service = app(S3FileUploaderService::class);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'home_description' => $this->home_description,
            'detailed_description' => $this->detailed_description,
            'image' => $this->image,
            'image_url' => $this->image ? $s3Service->getFileUrl($this->image) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
