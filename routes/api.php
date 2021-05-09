<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// import controllers
use App\Http\Controllers\SportController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//end points for the sports controller
Route::apiResource('sports', SportController::class);

//end points for the leagues controller
Route::apiResource('league', LeagueController::class);

//end points for the teams controller
Route::apiResource('teams', TeamController::class);

//create endpoint that runs the fetch method to import sports data from the api in the google doc
Route::get('/fetchSports', [SportController::class, 'fetch']);

//create endpoint that runs the fetch method to import leagues data from the api in the google doc
Route::get('/fetchLeagues', [LeagueController::class, 'fetch']);


//create endpoint that runs the fetch method to import teams data from the api in the google doc
Route::get('/fetchTeams', [TeamController::class, 'fetch']);