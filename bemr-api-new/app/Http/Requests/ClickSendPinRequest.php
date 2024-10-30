<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClickSendPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'clickid' => 'required',
            'msisdn' => 'required',
            'pin' => 'required',
            'hash' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }

    public function authorize(): bool
    {
        return true;
    }
}
