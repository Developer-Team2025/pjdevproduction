<?php

namespace App\Http\Controllers\API;
use App\Http\Requests\SampleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    //
        //
        public function sample(SampleRequest $request){
            $request->AddRule('name',['required','string']);
            $request->AddMessage('name.required', 'wala man');
            // $request->validate($request->rules(), $request->message());
            $validationResult = $request->failedData($request->rules(), $request->message());
            if ($validationResult['fails']) {
                return response()->json([
                    'status' => 'error',
                    'errors' => collect($validationResult['errors'])->map(fn ($msg)=> $msg[0])
                ], 422);
            }
            return response()->json(['data'=>'sucess']);
        }
}
