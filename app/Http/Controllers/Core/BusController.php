<?php

namespace App\Http\Controllers\Core;

use App\Datatables\Core\BusDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\BusRequest;
use App\Models\Buses\Bus;

class BusController extends Controller
{
    public function index(BusDatatable $datatable)
    {
        return $datatable->render('dashboard.core.buses.index');
    }

    public function create()
    {
        return view('dashboard.core.buses.form', ['model' => null]);
    }

    public function store(BusRequest $request)
    {
        $bus = Bus::create($request->validated());
        toast(__('Bus Created Successfully'), 'success');

        return redirect()->back();
    }

    public function edit(Bus $bus)
    {
        return view('dashboard.core.buses.form', ['model' => $bus]);
    }

    public function update(BusRequest $request, Bus $bus)
    {
        $bus->update($request->validated());
        toast(__('Bus Saved Successfully'), 'success');

        return redirect()->back();
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return response()->json(['status' => true]);
    }
}
