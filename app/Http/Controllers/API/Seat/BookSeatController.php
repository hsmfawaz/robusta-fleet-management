<?php

namespace App\Http\Controllers\API\Seat;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Buses\BusSeat;
use App\Models\Trips\Trip;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class BookSeatController
{
    public function __invoke(Request $request, BusSeat $seat)
    {
        $validated = $request->validate([
            'from' => 'required|exists:stations,id',
            'to' => 'required|exists:stations,id',
        ]);

        $booking = $this->getBooking($seat, $validated);

        return response()->json([
            'status' => true,
            'data' => new BookingResource($booking),
        ], Response::HTTP_CREATED);
    }

    public function notAvailable()
    {
        throw ValidationException::withMessages([
            'seat' => 'Seat is not available',
        ]);
    }

    protected function createBooking(
        BusSeat $seat,
        array $validated,
        Trip $trip
    ) {
        $booking = Booking::create([
            'bus_seat_id' => $seat->id,
            'from_station_id' => $validated['from'],
            'trip_id' => $trip->id,
            'to_station_id' => $validated['to'],
            'user_id' => auth()->id(),
        ]);

        $booking->load('seat.bus', 'fromStation', 'toStation');

        return $booking;
    }

    private function getTrip($seat, $validated)
    {
        $stationFilter = fn ($i) => $i->whereIn('station_id', [$validated['from'], $validated['to']]);

        $trip = $seat->trips()
            ->whereHas('stations', $stationFilter)
            ->whereNull('arrived_at')
            ->first();

        if (! $trip) {
            $this->notAvailable();
        }

        return $trip;
    }

    private function getBooking(BusSeat $seat, array $validated): ?Booking
    {
        try {
            return Cache::lock("book-seat-{$seat->id}", 10)->block(10, function () use ($validated, $seat) {
                $seatAvailable = $seat->available($validated['from'], $validated['to'])
                    ->where('id', $seat->id)
                    ->exists();

                if (! $seatAvailable) {
                    $this->notAvailable();
                }

                $trip = $this->getTrip($seat, $validated);

                return $this->createBooking($seat, $validated, $trip);
            });
        } catch (LockTimeoutException $e) {
            $this->notAvailable();
        }
    }
}
