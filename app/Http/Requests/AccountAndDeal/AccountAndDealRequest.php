<?php

namespace App\Http\Requests\AccountAndDeal;

use Illuminate\Foundation\Http\FormRequest;

class AccountAndDealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dealName' => 'required|string',
            'dealStage' => 'nullable|string',
            'accountName' => 'required|string',
            'accountWebsite' => 'nullable|url',
            'accountPhone' => 'nullable|string',
        ];
    }
}
