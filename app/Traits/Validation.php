<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait Validation
{
    /**
     * Override the failedValidation method to return only the "errors" object.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        // Take the first error message for each field
        $errors = collect($validator->errors())->mapWithKeys(function ($messages, $fields) {
            return [$fields => $messages[0]];
        })->toArray();

        // Extract field names and ensure error messages follow "is required" format
        $field_names = array_keys($errors);
        $error['errors'] = implode(', ', array_map(fn($fields) => ucfirst(str_replace('_', ' ', $fields)), $field_names)) . ' is required';

        // Throw HttpResponseException response
        throw new HttpResponseException(response()->json($errors, 422));
    }
}