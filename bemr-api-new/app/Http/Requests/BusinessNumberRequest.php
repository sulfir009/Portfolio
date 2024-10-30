<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessNumberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'business_number' => ['required', 'int']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
