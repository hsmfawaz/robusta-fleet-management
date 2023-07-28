<?php

namespace Database\Factories\Trips;

use App\Models\Station;
use App\Models\Trips\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trips\TripStation>
 */
class TripStationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'station_id' => Station::factory(),
            'trip_id' => Trip::factory(),
            'station_order' => $this->faker->randomDigit(),
            'current_station' => $this->faker->boolean,
        ];
    }
}
