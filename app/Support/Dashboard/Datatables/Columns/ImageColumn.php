<?php

namespace App\Support\Dashboard\Datatables\Columns;

class ImageColumn
{
    public static function render($imageSource, int $width = 70, int $height = 70)
    {
        return <<<HTML
            <img src="$imageSource" width="{$width}px" height="{$height}px" class="rounded border border-2" alt="" />
        HTML;
    }
}
