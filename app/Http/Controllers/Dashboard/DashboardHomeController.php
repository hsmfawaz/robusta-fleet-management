<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Booking;
use App\Models\Buses\Bus;
use App\Models\Station;
use App\Models\Trips\Trip;
use App\Models\User;

class DashboardHomeController
{
    public function __invoke()
    {
        return view('dashboard.home', [
            'bookings' => Booking::count(),
            'buses' => Bus::count(),
            'stations' => Station::count(),
            'trips' => Trip::count(),
            'users' => User::whereDoesntHave('roles')->count(),
        ]);
    }
}
