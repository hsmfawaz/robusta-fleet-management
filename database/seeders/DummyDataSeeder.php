<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Trips\Trip;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        Booking::factory(30)->create();
        Trip::all()->each->generateTickets();
    }
}
