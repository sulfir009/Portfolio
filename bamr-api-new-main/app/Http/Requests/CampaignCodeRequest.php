<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'campaign_code' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
