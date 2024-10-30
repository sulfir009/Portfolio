<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeywordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keyword' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
