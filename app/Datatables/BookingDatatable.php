<?php

namespace App\Datatables;

use App\Models\Booking;
use App\Support\Dashboard\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class BookingDatatable extends BaseDatatable
{
    protected ?string $actionable = 'delete';

    protected string $route = 'bookings';

    protected ?int $defaultOrder = 5;

    public function query(): Builder
    {
        return Booking::query()->with(['seat.bus', 'fromStation', 'toStation', 'user']);
    }

    protected function columns(): array
    {
        return [
            Column::make('user.name')->content('---')->title('User'),
            Column::make('seat.bus.plate_number')->orderable(false)->content('---')->title('Bus Plate'),
            Column::computed('seat.seat_number')->content('---')->title('Seat'),
            Column::make('from_station.name')->orderable(false)->content('---')->title('From Station'),
            Column::make('to_station.name')->orderable(false)->content('---')->title('To Station'),
            Column::make('created_at')->title('Booked At'),
        ];
    }

    protected function filters(): array
    {
        return [
            'seat.bus.plate_number' => fn ($i, $q) => $i->whereRelation('seat.bus', 'plate_number', 'like', "%$q%"),
        ];
    }

    protected function orders(): array
    {
        return [
            'created_at' => fn ($i, $k) => $i->orderBy('created_at', $k),
        ];
    }

    protected function customColumns(): array
    {
        return [
            'created_at' => function ($row) {
                return $row->created_at->format('Y-m-d').'<br>'.$row->created_at->diffForHumans();
            },
        ];
    }
}
