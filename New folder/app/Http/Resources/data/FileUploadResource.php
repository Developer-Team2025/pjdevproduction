<?php

namespace App\Http\Resources\data;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileUploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_name' => $this->filename,
            'file_location' => $this->file_location,
            'full_path_location' => $this->file_location . '/' . $this->filename,
        ];
    }
}
