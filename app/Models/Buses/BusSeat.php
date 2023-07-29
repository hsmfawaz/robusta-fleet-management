<?php

namespace App\Models\Buses;

use App\Models\Booking;
use App\Models\Trips\Trip;
use App\Models\Trips\TripStation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder available($stationFrom, $stationTo)
 */
class BusSeat extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'bus_seat_id', 'id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'bus_id', 'bus_id');
    }

    public function scopeAvailable(Builder $builder, $from, $to)
    {
        $trips = TripStation::query()->whereIn('station_id', [$from, $to])->pluck('trip_id')->toArray();

        $builder
            ->whereHas('trips', fn ($i) => $i->whereIn('trips.id', $trips))
            ->withCount([
                'bookings'                  => fn ($i) => $i->where('to_station_id', $to),
                'bookings as from_bookings' => fn ($i) => $i->where('from_station_id', $from),
            ])
            ->where('bookings_count', 0)
            ->where('from_bookings', 0);
    }
}
