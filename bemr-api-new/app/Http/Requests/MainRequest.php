<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hash' => ['required', 'string', 'size:20'],
            'campaigns_key_binom' => ['required', 'string', 'size:20'],
            'aff_company_id' => ['required', 'integer'],
            'pid' => ['required', 'integer'],
            'id_services' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
