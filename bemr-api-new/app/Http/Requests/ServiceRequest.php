<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'id_country' => ['required', 'int'],
            'id_business_number' => ['required', 'int'],
            'id_campaign_code' => ['required', 'int'],
            'id_keyword' => ['required', 'int'],

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
