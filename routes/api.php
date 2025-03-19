<?php

use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\GoogleSheetsApiController;
use App\Http\Controllers\API\OurTeamsController;
use App\Http\Controllers\API\SampleRequest;
use Illuminate\Support\Facades\Route;

// Googlesheets API
Route::post('/google-api-create-row', [GoogleSheetsApiController::class, 'writeSheet']);

// Our Teams API
Route::post('/create-team-profile', [OurTeamsController::class, 'createOurTeamProfile']);
Route::get('/our-teams', [OurTeamsController::class, 'getOurTeams']);
Route::get('/certificates', [CertificateController::class, 'getCertificates']);
Route::post('/sample', [SampleRequest::class, 'sample']);

// Edit Routes