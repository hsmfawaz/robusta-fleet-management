<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Core\StationDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\StationRequest;
use App\Models\Station;

class StationController extends Controller
{
    public function index(StationDatatable $datatable)
    {
        return $datatable->render('dashboard.core.stations.index');
    }

    public function create()
    {
        return view('dashboard.core.stations.form', ['model' => null]);
    }

    public function store(StationRequest $request)
    {
        Station::create($request->validated());
        toast(__('Station Created Successfully'), 'success');

        return redirect()->back();
    }

    public function edit(Station $station)
    {
        return view('dashboard.core.stations.form', ['model' => $station]);
    }

    public function update(StationRequest $request, Station $station)
    {
        $station->update($request->validated());
        toast(__('Station Saved Successfully'), 'success');

        return redirect()->back();
    }

    public function destroy(Station $station)
    {
        $station->delete();

        return response()->json(['status' => true]);
    }
}
