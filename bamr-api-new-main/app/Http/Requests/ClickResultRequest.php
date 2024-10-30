<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClickResultRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'clickid' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            response()->json(['status' => 400, 'statusText' => "empty clickid"])
        );
    }

    public function authorize(): bool
    {
        return true;
    }
}
