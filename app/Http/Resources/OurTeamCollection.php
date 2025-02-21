<?php

namespace App\Http\Resources;

use App\Http\Resources\data\OurTeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OurTeamCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['our_teams' => OurTeamResource::collection($this->collection->sortBy('fullname')->values())];
    }
}