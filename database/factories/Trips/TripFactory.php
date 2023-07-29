<?php

namespace Database\Factories\Trips;

use App\Models\Buses\Bus;
use App\Models\Station;
use App\Models\Trips\Trip;
use App\Models\Trips\TripStation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{

    public static function createTaskTrip()
    {
        $stations = Station::factory()->createMany([
            ['name' => 'Cairo'],
            ['name' => 'AlFayyum'],
            ['name' => 'AlMinya'],
            ['name' => 'Asyut'],
        ])->keyBy('name');
        $trip = Trip::create(['bus_id' => Bus::factory()->create()->id,]);
        $trip->stations()->createMany([
            ['station_id' => $stations['Cairo']->id, 'station_order' => 0, 'current_station' => 1],
            ['station_id' => $stations['AlFayyum']->id, 'station_order' => 1, 'current_station' => 0],
            ['station_id' => $stations['AlMinya']->id, 'station_order' => 2, 'current_station' => 0],
            ['station_id' => $stations['Asyut']->id, 'station_order' => 3, 'current_station' => 0],
        ]);

        return [$trip, $stations];
    }

    public function configure()
    {
        return parent::configure()->afterCreating(function (Trip $trip) {
            TripStation::factory(random_int(2, 6))->create([
                'trip_id' => $trip->id
            ]);
        });
    }

    public function definition(): array
    {
        return [
            'bus_id'     => Bus::factory(),
            'arrived_at' => null,
        ];
    }
}
