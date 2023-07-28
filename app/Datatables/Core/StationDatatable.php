<?php

namespace App\Datatables\Core;

use App\Models\Station;
use App\Support\Dashboard\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class StationDatatable extends BaseDatatable
{
    protected string $route = 'core.stations';

    public function query(): Builder
    {
        return Station::query();
    }

    protected function columns(): array
    {
        return [
            Column::make('name')->title('Name'),
        ];
    }
}
