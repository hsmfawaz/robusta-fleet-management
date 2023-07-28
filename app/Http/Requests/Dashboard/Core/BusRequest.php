<?php

namespace App\Http\Requests\Dashboard\Core;

use Illuminate\Foundation\Http\FormRequest;

class BusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'plate_number' => 'required|string|max:255',
        ];
    }
}
