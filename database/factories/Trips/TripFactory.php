<?php

namespace Database\Factories\Trips;

use App\Models\Buses\Bus;
use App\Models\Trips\Trip;
use App\Models\Trips\TripStation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{

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
            'arrived_at' => $this->faker->time(),
        ];
    }
}
