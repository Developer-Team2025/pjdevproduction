<?php

namespace App\Http\Requests;

use App\Traits\Authorization;
use App\Traits\Validation;
use Illuminate\Foundation\Http\FormRequest;

class GoogleSheetsApiRequest extends FormRequest
{
    use Authorization, Validation;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'string'],
            'inquiry_type' => ['required', 'string'],
            'country' => ['required', 'string'],
            'accept_privacy' => ['required', 'integer', 'in:1'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fullname.required' => 'Fullname is required',
            'email.required' => 'Email Address is required',
            'email.email' => 'Please provide a valid email address',
            'phone.required' => 'Phone # is required',
            'inquiry_type.required' => 'Inquiry Type is required',
            'country.required' => 'Country is required',
            'accept_privacy.in' => 'You must accept the privacy policy',
        ];
    }
}
