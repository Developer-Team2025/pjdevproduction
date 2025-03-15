<?php

namespace App\Http\Requests;

use App\Traits\Authorization;
use App\Traits\Validation;
use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'file.required' => 'A file is required to upload.',
            'file.file' => 'The uploaded file must be a valid file.',
            'file.mimes' => 'Only jpeg, png, jpg, and pdf files are allowed.',
            'file.max' => 'The file size must not exceed 2MB.',
        ];
    }
}
