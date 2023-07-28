<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$this->user?->id,
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($this->isMethod('PUT')) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }
}
