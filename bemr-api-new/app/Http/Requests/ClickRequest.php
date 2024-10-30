<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClickRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'clickid' => 'sometimes',
            'hash' => 'sometimes',
            'user_agent' => 'sometimes',
            'ip' => 'sometimes',
            'subid1' => 'sometimes',
            'subid2' => 'sometimes',
            'subid3' => 'sometimes',
            'subid4' => 'sometimes',
            'subid5' => 'sometimes',
        ];
    }

    public function validationData(): array
    {
        $data = parent::validationData();
        $default = [
            'clickid' => null,
            'subid1' => null,
            'subid2' => null,
            'subid3' => null,
            'subid4' => null,
            'subid5' => null,
            'hash' => null,
            'operator' => null,
            'user_agent' => 'default-agent',
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
