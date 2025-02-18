<?php

use App\Http\Controllers\API\GoogleSheetsApiController;
use App\Http\Controllers\API\OurTeamsController;
use Illuminate\Support\Facades\Route;

// Googlesheets API
Route::post('/google-api-create-row', [GoogleSheetsApiController::class, 'writeSheet']);

// Our Teams API
Route::post('/create-team-profile', [OurTeamsController::class, 'createOurTeamProfile']);
Route::get('/our-teams', [OurTeamsController::class, 'getOurTeams']);