<?php

namespace App\Http\Resources;

use App\Support\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusResource extends JsonResource
{
    use WithPagination;

    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'seat_number' => $this->plate_number,
        ];
    }
}
