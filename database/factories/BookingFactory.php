<?php

namespace Database\Factories;

use App\Models\Buses\BusSeat;
use App\Models\Station;
use App\Models\Trips\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bus_seat_id' => BusSeat::factory(),
            'to_station_id' => Station::factory(),
            'from_station_id' => Station::factory(),
            'user_id' => User::factory(),
            'trip_id' => Trip::factory(),
        ];
    }
}
