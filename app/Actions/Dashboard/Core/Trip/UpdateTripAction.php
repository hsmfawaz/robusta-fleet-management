<?php

namespace App\Actions\Dashboard\Core\Trip;

use App\Models\Trips\Trip;
use App\Models\Trips\TripStation;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateTripAction
{
    private Trip $trip;

    public function handle(Trip $trip, array $data)
    {
        $this->trip = $trip;
        return DB::transaction(function () use ($data) {
            $stations = collect((array) Arr::pull($data, 'stations', []))->unique('id')->values()->all();
            $currentStation = (int) Arr::pull($data, 'current_station', 0);
            $this->trip->update($data);

            $this->syncStations($stations, $currentStation);

            return $this->trip;
        });
    }

    private function deleteStations($stationsIDX)
    {
        TripStation::query()
                   ->where('trip_id', $this->trip->id)
                   ->whereNotIn('station_id', $stationsIDX)
                   ->delete();
    }

    private function createStations(array $stations, array $oldStations)
    {
        $newStations = collect($stations)->filter(function ($i) use ($oldStations) {
            return ! in_array($i['id'], $oldStations);
        });
        TripStation::insert($newStations->map(function ($i) {
            return [
                'station_id'      => $i['id'],
                'trip_id'         => $this->trip->id,
                'station_order'   => $i['station_order'],
                'current_station' => false
            ];
        })->all());
    }

    protected function setCurrentStation(int $currentStation): void
    {
        TripStation::query()
                   ->where('trip_id', $this->trip->id)
                   ->where('station_order', $currentStation)
                   ->update(['current_station' => true]);
    }

    protected function syncStations(array $stations, int $currentStation): void
    {
        $stationsIDX = collect($stations)->pluck('id')->toArray();

        $this->deleteStations($stationsIDX);

        $old = TripStation::query()->where('trip_id', $this->trip->id)->get();
        $this->createStations($stations, $old->pluck('station_id')->toArray());

        $this->updateStations($stations, $old);

        $this->setCurrentStation($currentStation);
    }

    private function updateStations(array $stations, Collection $old)
    {
        $mapped = $old->keyBy('station_id');
        foreach ($stations as $station) {
            if (! isset($mapped[$station['id']])) {
                continue;
            }
            $mapped[$station['id']]->update([
                'station_order'   => $station['station_order'],
                'current_station' => false
            ]);
        }
    }
}