<?php

namespace App\Models\Trips;

use App\Models\Booking;
use App\Models\Buses\Bus;
use App\Models\Station;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder active()
 */
class Trip extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function stations()
    {
        return $this->hasMany(TripStation::class)->orderBy('station_order');
    }

    public function fromStation()
    {
        return $this->hasOneThrough(Station::class, TripStation::class, 'trip_id', 'id', 'id', 'station_id')
                    ->oldest('station_order');
    }

    public function toStation()
    {
        return $this->hasOneThrough(Station::class, TripStation::class, 'trip_id', 'id', 'id', 'station_id')
                    ->latest('station_order');
    }

    public function currentStation()
    {
        return $this->hasOneThrough(Station::class, TripStation::class, 'trip_id', 'id', 'id', 'station_id')
                    ->oldest('station_order')
                    ->where('current_station', true);
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('arrived_at', null);
    }

    public function tickets()
    {
        return $this->hasMany(TripTicket::class);
    }

    public function generateTickets()
    {
        $this->tickets()->delete();
        $tickets = [];
        for ($i = 0, $maxI = $this->stations->count(); $i < $maxI; $i++) {
            $current = $this->stations[$i];
            $next = $this->stations[$i + 1] ?? null;
            $afterNext = $this->stations[$i + 2] ?? null;

            if (! $next) {
                continue;
            }
            $tickets[] = [
                'trip_id'         => $this->id,
                'from_station_id' => $current->station_id,
                'to_station_id'   => $next->station_id,
            ];
            if (! $afterNext) {
                continue;
            }

            $tickets[] = [
                'trip_id'         => $this->id,
                'from_station_id' => $current->station_id,
                'to_station_id'   => $afterNext->station_id,
            ];
        }
        $this->tickets()->createMany($tickets);
    }
}
