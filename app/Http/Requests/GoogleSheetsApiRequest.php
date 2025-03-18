<?php

namespace App\Http\Requests;

use App\Services\GoogleServices;
use App\Traits\Authorization;
use App\Traits\Validation;
use Illuminate\Foundation\Http\FormRequest;

class GoogleSheetsApiRequest extends FormRequest
{
    use Authorization, Validation;

    protected $googleServices;

    public function __construct(GoogleServices $googleServices)
    {
        parent::__construct();
        $this->googleServices = $googleServices;
    }

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

    /**
     * Perform additional validation to check for duplicate entries.
     *
     * @param Validator $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $ssid = '1660409-8EKI1oxfJXP55EFfgNnmrwAU3H_sLyEyNuik';
            $sheet_tab = 'Sheet2';

            // Retrieve existing sheet data
            $existingData = $this->googleServices->sheets($ssid, $sheet_tab);

            if ($existingData) {
                // Prepare the incoming row for comparison
                $inputRow = [
                    $this->input('fullname'),
                    $this->input('email'),
                    $this->input('phone'),
                    $this->input('inquiry_type'),
                    $this->input('country'),
                    $this->boolean('accept_privacy') ? "Accepted" : "Not Accepted",
                    $this->input('date_now'),
                ];

                $incomingRow = implode('|', array_map('strtolower', array_map('trim', $inputRow)));

                // Check for duplicates
                foreach ($existingData as $row) {
                    $existingRow = implode('|', array_map('strtolower', array_map('trim', $row)));

                    if ($existingRow === $incomingRow) {
                        $validator->errors()->add('duplicate', 'Duplicate entry detected. This data already exists.');
                        break;
                    }
                }
            }
        });
    }
}
