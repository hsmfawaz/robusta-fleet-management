<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Trips\Trip;
use App\Models\Trips\TripStation;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        Trip::factory(30)->create()->each(function ($trip) {
            TripStation::factory(5)->for($trip)->create();
        });
        Booking::factory(30)->create();
    }
}
