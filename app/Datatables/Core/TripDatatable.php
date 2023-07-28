<?php

namespace App\Datatables\Core;

use App\Models\Trips\Trip;
use App\Support\Dashboard\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class TripDatatable extends BaseDatatable
{
    protected string $route = 'core.trips';
    protected ?int $defaultOrder = 6;

    public function query(): Builder
    {
        return Trip::query()->with(['bus', 'fromStation', 'toStation', 'currentStation'])->withCount('bookings');
    }

    protected function columns(): array
    {
        return [
            Column::make('bus.plate_number')->content('---')->title('Bus'),
            Column::make('from_station.name')->orderable(false)->content('---')->title('From Station'),
            Column::make('to_station.name')->orderable(false)->content('---')->title('To Station'),
            Column::make('current_station.name')->orderable(false)->content('---')->title('Current Station'),
            Column::make('bookings_count')->searchable(false)->content('0')->title('Bookings count'),
            Column::make('created_at')->title('Created At'),
        ];
    }

    protected function filters(): array
    {
        return [
            'from_station.name'    => fn ($i, $q) => $i->whereRelation('fromStation', 'name', 'like', "%{$q}%"),
            'to_station.name'      => fn ($i, $q) => $i->whereRelation('fromStation', 'name', 'like', "%{$q}%"),
            'current_station.name' => fn ($i, $q) => $i->whereRelation('fromStation', 'name', 'like', "%{$q}%"),
        ];
    }

    protected function orders(): array
    {
        return [
            'created_at' => fn ($i, $k) => $i->orderBy('created_at', $k)
        ];
    }

    protected function customColumns(): array
    {
        return [
            'created_at' => function ($row) {
                return $row->created_at->format('Y-m-d')."<br>".$row->created_at->diffForHumans();
            },
        ];
    }
}