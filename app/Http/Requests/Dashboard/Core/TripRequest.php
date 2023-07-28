<?php

namespace App\Http\Requests\Dashboard\Core;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'bus_id'                   => 'required|exists:buses,id',
            'stations'                 => 'required|array|min:2',
            'stations.*.id'            => 'required|exists:stations,id',
            'stations.*.station_order' => 'required|int|min:0',
            'current_station'          => 'nullable',
        ];
    }
}
