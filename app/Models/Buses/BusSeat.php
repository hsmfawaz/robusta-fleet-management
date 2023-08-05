<?php

namespace App\Models\Buses;

use App\Models\Booking;
use App\Models\Trips\Trip;
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
        $trips = Trip::query()
                     ->join('trip_stations as from', function ($join) use ($from) {
                         $join->on('trips.id', '=', 'from.trip_id')
                              ->where('from.station_id', $from);
                     })
                     ->join('trip_stations as to', function ($join) use ($to) {
                         $join->on('trips.id', '=', 'to.trip_id')
                              ->where('to.station_id', $to);
                     })
                     ->where('from.station_order', '<=', 'to.station_order')
                     ->pluck('trips.id')
                     ->toArray();
        $builder
            ->whereHas('trips', fn ($i) => $i->whereIn('trips.id', $trips))
            ->whereDoesntHave('bookings', fn ($i) => $i->where('to_station_id', $to))
            ->whereDoesntHave('bookings', fn ($i) => $i->where('from_station_id', $from));
    }
}
