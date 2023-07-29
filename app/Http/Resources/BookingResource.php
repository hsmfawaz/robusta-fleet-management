<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'trip_id'    => $this->trip_id,
            'seat'       => new BusSeatResource($this->whenLoaded('seat')),
            'from'       => new StationResource($this->whenLoaded('fromStation')),
            'to'         => new StationResource($this->whenLoaded('toStation')),
            'created_at' => $this->created_at,
        ];
    }
}
