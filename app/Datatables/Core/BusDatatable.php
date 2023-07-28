<?php

namespace App\Datatables\Core;

use App\Models\Buses\Bus;
use App\Support\Dashboard\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class BusDatatable extends BaseDatatable
{
    protected string $route = 'core.buses';

    public function query(): Builder
    {
        return Bus::query();
    }

    protected function columns(): array
    {
        return [
            Column::make('plate_number')->title('Plate Number'),
        ];
    }
}
