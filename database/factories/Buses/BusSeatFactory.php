<?php

namespace Database\Factories\Buses;

use App\Models\Buses\Bus;
use App\Models\Buses\BusSeat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BusSeat>
 */
class BusSeatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'bus_id'      => Bus::factory(),
            'seat_number' => $this->faker->numberBetween(1, 12),
        ];
    }
}
