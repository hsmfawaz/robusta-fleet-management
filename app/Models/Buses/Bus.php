<?php

namespace App\Models\Buses;

use App\Models\Trips\Trip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const SEATS_COUNT = 12;

    protected static function booted()
    {
        self::created(function ($bus) {
            $seats = [];

            foreach (range(1, self::SEATS_COUNT) as $seat) {
                $seats[] = [
                    'seat_number' => $seat,
                    'bus_id' => $bus->id,
                ];
            }
            BusSeat::query()->insert($seats);
        });
    }

    public function active_trip()
    {
        return $this->hasOne(Trip::class)->whereNull('arrived_at');
    }

    public function seats()
    {
        return $this->hasMany(BusSeat::class);
    }
}
