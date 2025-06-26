<?php

namespace App\Http\Requests;
use App\Traits\Authorization;
use App\Traits\Validating;
use Illuminate\Foundation\Http\FormRequest;

class SampleRequest extends FormRequest
{
    use Authorization, Validating;
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected array $rules = [];
    protected array $message = [];
    public function AddRule(string $field, array|string $rule){

        $this->rules[$field]=$rule;
        
    }
    public function AddMessage(string $field, array|string $rule){

        $this->message[$field]=$rule;
        
    }
    public function rules(): array
    {
        return $this->rules;
    }

    public function message():array{
        return $this->message;
    }
}
