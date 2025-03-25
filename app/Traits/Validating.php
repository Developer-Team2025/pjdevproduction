<?php

namespace App\Traits;
use Illuminate\Contracts\Validation\Validator;
trait Validating
{
    //

    public function failedData(array $rules, array $messages = []){
        
        $validator = validator($this->all(), $rules, $messages);

        return [
            'fails' => $validator->fails(),
            'errors' => $validator->errors(),
            'validated' => $validator->fails() ? [] : $validator->validated(),
        ];
    
    }
}
