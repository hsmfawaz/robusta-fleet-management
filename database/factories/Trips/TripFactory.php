<?php

namespace Database\Factories\Trips;

use App\Models\Buses\Bus;
use App\Models\Trips\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    public function definition(): array
    {
        return [
            'bus_id' => Bus::factory(),
        ];
    }
}
