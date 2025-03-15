<?php

namespace App\Http\Resources\data;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fullname' => $this->fullname,
            'job_position' => $this->job_position,
            'profile_img' => new FileUploadResource($this->whenLoaded('teamProfileImages')),
        ];
    }
}