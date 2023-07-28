<?php

use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\Core\BusController;
use App\Http\Controllers\Dashboard\Core\StationController;
use App\Http\Controllers\Dashboard\Core\TripController;
use App\Http\Controllers\Dashboard\DashboardHomeController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', DashboardHomeController::class)->name('dashboard');

    Route::prefix('core')->as('core.')->group(function () {
        Route::resource('buses', BusController::class);
        Route::resource('stations', StationController::class);
        Route::resource('trips', TripController::class);
    });

    Route::resource('bookings', BookingController::class);
    Route::resource('users', UserController::class);
});
