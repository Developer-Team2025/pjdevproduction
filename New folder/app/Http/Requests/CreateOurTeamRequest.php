<?php

namespace App\Http\Requests;

use App\Traits\Authorization;
use App\Traits\Validation;
use Illuminate\Foundation\Http\FormRequest;

class CreateOurTeamRequest extends FormRequest
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
            'job_position' => ['required', 'string'],
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
            'job_position.required' => 'Job Position is required',
        ];
    }
}
