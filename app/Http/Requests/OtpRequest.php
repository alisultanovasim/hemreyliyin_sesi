<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OtpRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'regex:/^(\+994|0)(50|51|55|70|77)(\d{7})$/'
            ],
        ];
    }
    public function messages()
    {
        return [
            'phone.required' => 'Telefon nömrəsini daxil edin.',
            'phone.string' => 'Telefon nömrəsini düzgün formatda daxil edin.',
            'phone.regex' => 'Telefon nömrəsini düzgün daxil edin.',
        ];
    }
}
