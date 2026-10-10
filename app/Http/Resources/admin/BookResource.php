<?php

namespace App\Http\Resources\admin;

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
            "user"          => $this->user,
        ];
    }
}
