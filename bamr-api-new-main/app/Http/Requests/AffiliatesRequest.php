<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliatesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pid' => ['required', 'integer'],
            'api_key' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
