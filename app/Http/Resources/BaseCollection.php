<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'data' => $this->collection,
        ];

        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $response['links'] = [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ];

            $response['meta'] = [
                'current_page' => $this->currentPage(),
                'from'         => $this->firstItem(),
                'last_page'    => $this->lastPage(),
                'path'         => $request->url(),
                'per_page'     => $this->perPage(),
                'to'           => $this->lastItem(),
                'total'        => $this->total(),
            ];
        }

        return $response;
    }
}
