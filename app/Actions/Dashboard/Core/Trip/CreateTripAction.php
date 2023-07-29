<?php

namespace App\Actions\Dashboard\Core\Trip;

use App\Models\Trips\Trip;
use App\Models\Trips\TripStation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateTripAction
{
    public function handle(array $data)
    {
        return DB::transaction(function () use ($data) {
            $stations = Arr::pull($data, 'stations', []);
            $currentStation = (int) Arr::pull($data, 'current_station', 0);
            $trip = Trip::create($data);

            $this->assignStations($stations, $currentStation, $trip);

            return $trip;
        });
    }

    protected function assignStations(array $stations, int $currentStation, Trip $trip): void
    {
        TripStation::insert(collect($stations)->map(function ($i) use ($trip) {
            return [
                'station_id'      => $i['id'],
                'trip_id'         => $trip->id,
                'station_order'   => $i['station_order'],
                'current_station' => false,
            ];
        })->all());

        TripStation::query()
                   ->where('trip_id', $trip->id)
                   ->where('station_order', $currentStation)
                   ->update(['current_station' => true]);
    }
}
