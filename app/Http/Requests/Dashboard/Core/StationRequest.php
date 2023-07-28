<?php

namespace App\Http\Requests\Dashboard\Core;

use Illuminate\Foundation\Http\FormRequest;

class StationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:199'
        ];
    }
}
