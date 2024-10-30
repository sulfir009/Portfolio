<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClickSendNumberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'msisdn' => 'required',
            'clickid' => 'required',
            'channel' => 'sometimes',
            'operator' => 'sometimes',
            'heKey' => 'sometimes',
            'hash' => 'required',
        ];
    }

    public function validationData(): array
    {
        $data = parent::validationData();
        $default = [
            'msisdn' => null,
            'clickid' => null,
            'operator' => null,
            'hash' => null,
        ];

        return array_merge($default, $data);
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
