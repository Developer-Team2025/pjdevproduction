<?php

namespace App\Http\Controllers\API;
use App\Http\Requests\ResultRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    //

    public function try(ResultRequest $request){

        return response()->json(['message' => 'GET request successful!'], 200);
    }
}
