<?php

namespace App\Support\Dashboard\Datatables\Columns;

use Illuminate\Support\Arr;

class UserColumn
{
    public static function render($relation = '', \Closure|string $route = 'dashboard.user.users.show')
    {
        return function ($model) use ($route, $relation) {
            $data = filled($relation) ? data_get($model, $relation) : $model;
            $name = $data?->name ?? 'No User';
            $avatar = $data?->photo
                ? "<img src='$data->photo' alt='$name' class='w-100'>"
                : strtoupper(mb_substr($name, 0, 1));
            $color = Arr::random(['success', 'info', 'warning', 'danger']);
            $bg = $data?->photo ? '' : "bg-light-$color text-$color";
            $code = $data->id ?? '---';

            if ($route instanceof \Closure) {
                $route = $route($model);
            } elseif (filled($route)) {
                $route = route($route, $data?->id ?? 0);
            } else {
                $route = 'javascript:;';
            }

            return <<<HTML
                <div class='d-flex align-items-center'>
                    <div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                        <div class='symbol-label fs-3 $bg'>
                           $avatar 
                        </div>
                    </div>
                    <div class='d-flex flex-column'>
                        <a href='$route'><span class='text-gray-800 text-hover-primary mb-1'>$name</span></a>
                        <span class='text-gray-800 text-hover-primary mb-1'>$code</span>
                    </div>
                </div>
        HTML;
        };
    }
}
