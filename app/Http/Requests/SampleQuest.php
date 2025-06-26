<?php

namespace App\Http\Requests;
use App\Traits\Authorization;
use Illuminate\Foundation\Http\FormRequest;

class SampleQuest extends FormRequest
{
    use Authorization;
    /**
     * Determine if the user is authorized to make this request.
     */
    // protected array $rules = [];

    // public function addRule(string $field, array|string $rule){
    //     $this->$rules[$field]=$rule;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return[
            "name"=> ['required','string'],
        ];
    }
}
