<?php

namespace App\Http\Controllers\API;
use App\Http\Requests\SampleQuest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleRequest extends Controller
{
    //

    public function sample(SampleQuest $request){
        // $request->addRule('name',['required', 'string']);

        return response()->json(['data'=>'success'],200);
    }
}
