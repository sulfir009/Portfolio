<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliatesInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_affiliates' => ['integer'],
            'id_country' => ['required', 'integer'],
            'postback_url' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
