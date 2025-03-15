<?php

// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Response;
// use Illuminate\Support\Facades\File;

// Route::get('/{any}', function () {
//     return Response::file(public_path("dist/index.html"));
// })->where('any', '^(?!api)(?!dist/.*\.(?:js|css|json|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot|ico|webp|mp3|mp4|ogg|wav|webm)$).*');

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('/{any}', function () {
    return Response::file(public_path("dist/index.html"));
})->where('any', '^(?!api)(?!dist/.*\.(?:js|css|json|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot|ico|webp|mp3|mp4|ogg|wav|webm)$).*');