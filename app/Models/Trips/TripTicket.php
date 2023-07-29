<?php

namespace App\Models\Trips;

use App\Models\Booking;
use App\Models\Station;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder available($stationFrom, $stationTo)
 */
class TripTicket extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function scopeAvailable(Builder $builder, $stationFrom, $stationTo)
    {
        return $builder
            ->where('from_station_id', $stationFrom)
            ->where('to_station_id', $stationTo);
    }
}
