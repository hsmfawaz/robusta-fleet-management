<?php

namespace App\Http\Controllers\API\Seat;

use App\Http\Resources\BusSeatResource;
use App\Models\Buses\BusSeat;
use Illuminate\Http\Request;

class ListAvailableSeatsController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|exists:stations,id',
            'to'   => 'required|exists:stations,id',
        ]);

        $seats = BusSeat::available($validated['from'], $validated['to'])->with('bus')->simplePaginate();

        return response()->json([
            'status' => true,
            'data'   => BusSeatResource::paginate($seats)
        ]);
    }
}