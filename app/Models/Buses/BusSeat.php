<?php

namespace App\Models\Buses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
