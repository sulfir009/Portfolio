<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country' => ['required'],
            'ip_address' => ['required', 'ip']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
