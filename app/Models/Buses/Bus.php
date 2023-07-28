<?php

namespace App\Models\Buses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        self::created(function ($bus) {
            $seats = [];

            foreach (range(1, 12) as $seat) {
                $seats[] = [
                    'seat_number' => $seat,
                    'bus_id' => $bus->id,
                ];
            }
            BusSeat::query()->insert($seats);
        });
    }

    public function seats()
    {
        return $this->hasMany(BusSeat::class);
    }
}
