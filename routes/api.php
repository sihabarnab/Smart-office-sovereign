<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicingController;
use App\Http\Controllers\SestController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
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

//login
Route::post('/v1/login', [SestController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    //Tasker Part
    Route::get('/v1/getAllTasks', [SestController::class, 'getAllTasks']);
    Route::post('/v1/startJourney', [SestController::class, 'startJourney']);
    Route::post('/v1/cancelJourney', [SestController::class, 'cancelJourney']);
    Route::post('/v1/endJourney', [SestController::class, 'endJourney']);
    Route::post('/v1/startTask', [SestController::class, 'startTask']);
    Route::post('/v1/partiallyEndTask', [SestController::class, 'partiallyEndTask']);
    Route::post('/v1/completelyEndTask', [SestController::class, 'completelyEndTask']);
    Route::post('/v1/endOfTheDay', [SestController::class, 'endOfTheDay']);

    //Admin Part
    Route::get('/v1/getAllComplain', [SestController::class, 'getAllComplain']);
    Route::get('/v1/getAllRequisition', [SestController::class, 'getAllRequisition']);
    Route::get('/v1/getRequisitionDetail/{id}', [SestController::class, 'getRequisitionDetail']);
    Route::post('/v1/requisitionAccept', [SestController::class, 'requisitionAccept']);
    Route::post('/v1/requisitionReject', [SestController::class, 'requisitionReject']);

    //logout
    Route::post('/v1/logout', [SestController::class, 'logout']);
});