<?php

namespace Database\Seeders;

use App\Models\Booking;
use Database\Factories\Trips\TripFactory;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        Booking::factory(10)->create();
        TripFactory::createTaskTrip();
    }
}
