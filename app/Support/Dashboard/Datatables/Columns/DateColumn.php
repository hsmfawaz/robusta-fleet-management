<?php

namespace App\Support\Dashboard\Datatables\Columns;

use Carbon\Carbon;

class DateColumn
{
    public static function render(?Carbon $date)
    {
        return <<<HTML
            <div>{$date->diffForHumans()}<br>{$date->format('Y-m-d h:i a')}</div>
        HTML;
    }

    public static function make($key = 'created_at')
    {
        return function ($i) use ($key) {
            return static::render(Carbon::parse(data_get($i, $key)));
        };
    }
}
