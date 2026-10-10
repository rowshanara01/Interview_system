<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id"            => $this->id,
            "title"         => $this->title,
            "author"        => $this->author,
            "description"   => $this->description,
            "user_id"       => $this->user_id,
            "distance"      => $this->when(isset($this->distance), round($this->distance, 2) . ' km'),
            "user"     => $this->whenLoaded('user', function() {
                return [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                ];
            }),
        ];
    }
}
