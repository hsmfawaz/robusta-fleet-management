<?php

namespace App\Http\Controllers\Core;

use App\Actions\Dashboard\Core\Trip\CreateTripAction;
use App\Actions\Dashboard\Core\Trip\UpdateTripAction;
use App\Datatables\Core\TripDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\TripRequest;
use App\Models\Buses\Bus;
use App\Models\Station;
use App\Models\Trips\Trip;

class TripController extends Controller
{
    public function index(TripDatatable $datatable)
    {
        return $datatable->render('dashboard.core.trips.index');
    }

    public function create()
    {
        return view('dashboard.core.trips.form', $this->formData());
    }

    public function store(TripRequest $request, CreateTripAction $action)
    {
        $action->handle($request->validated());

        toast(__('Trip Created Successfully'), 'success');

        return redirect()->back();
    }

    public function edit(Trip $trip)
    {
        return view('dashboard.core.trips.form', $this->formData($trip));
    }

    public function update(TripRequest $request, Trip $trip, UpdateTripAction $action)
    {
        $action->handle($trip, $request->validated());
        toast(__('Trip Saved Successfully'), 'success');

        return redirect()->back();
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return response()->json(['status' => true]);
    }

    private function formData(Trip $trip = null)
    {
        $selectedStations = $trip?->load('stations.station')->stations
            ->map(fn ($i) => [
                'id' => $i->station_id,
                'label' => $i->station->name,
                'station_order' => $i->station_order,
                'current_station' => (bool) $i->current_station,
            ])
            ->sortBy('station_order')
            ->values()
            ->toArray();

        return [
            'model' => $trip,
            'buses' => Bus::all()->mapWithKeys(fn ($item) => [$item->id => $item->plate_number]),
            'stations' => Station::all()->mapWithKeys(fn ($item) => [$item->id => $item->name]),
            'oldStations' => old('stations', $selectedStations ?? []),
        ];
    }
}
