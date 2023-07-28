<?php

namespace App\Datatables;

use App\Models\User;
use App\Support\Dashboard\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class UserDatatable extends BaseDatatable
{
    protected string $route = 'users';

    public function query(): Builder
    {
        return User::query()->whereDoesntHave('roles')->withCount('bookings');
    }

    protected function columns(): array
    {
        return [
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('bookings_count')->searchable(false)->content('0')->title('Bookings count'),
            Column::make('created_at')->title('Joined At'),
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
