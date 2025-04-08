<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\WorkerController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth'], function () {

    
    //--------------------------------Soverign Site Worker------------------------------
    Route::get('/worker', [WorkerController::class, 'getAllTasks'])->name('worker');
    Route::get('/worker/startJourney', [WorkerController::class, 'startJourney'])->name('startJourney');
    Route::get('/worker/endJourney', [WorkerController::class, 'openEndJourney'])->name('openEndJourney');
    Route::post('/worker/endJourney', [WorkerController::class, 'endJourney'])->name('endJourney');
    Route::get('/worker/startTask', [WorkerController::class, 'openStartTask'])->name('openStartTask');
    //start task
    Route::post('/worker/startTask_first_image_upload', [WorkerController::class, 'startTaskFirstImageUpload'])->name('startTaskFirstImageUpload');
    Route::post('/worker/startTask_second_image_upload', [WorkerController::class, 'startTaskSecondImageUpload'])->name('startTaskSecondImageUpload');
    Route::post('/worker/startTask_third_image_upload', [WorkerController::class, 'startTaskThirdImageUpload'])->name('startTaskThirdImageUpload');
    Route::post('/worker/startTask_Fourth_image_upload', [WorkerController::class, 'startTaskFourthImageUpload'])->name('startTaskFourthImageUpload');
    Route::post('/worker/startTask_fifth_image_upload', [WorkerController::class, 'startTaskFifthImageUpload'])->name('startTaskFifthImageUpload');
    Route::post('/worker/startTask', [WorkerController::class, 'startTask'])->name('startTask');
    //start task

    //End Task
    Route::get('/worker/completelyEndTask', [WorkerController::class, 'openCompletelyEndTask'])->name('openCompletelyEndTask');
    Route::post('/worker/endTask_first_image_upload', [WorkerController::class, 'ensTaskFirstImageUpload'])->name('ensTaskFirstImageUpload');
    Route::post('/worker/endTask_second_image_upload', [WorkerController::class, 'endTaskSecondImageUpload'])->name('endTaskSecondImageUpload');
    Route::post('/worker/endTask_third_image_upload', [WorkerController::class, 'endtTaskThirdImageUpload'])->name('endtTaskThirdImageUpload');
    Route::post('/worker/endTask_Fourth_image_upload', [WorkerController::class, 'endTaskFourthImageUpload'])->name('endTaskFourthImageUpload');
    Route::post('/worker/endTask_fifth_image_upload', [WorkerController::class, 'endTaskFifthImageUpload'])->name('endTaskFifthImageUpload');
    Route::post('/worker/completelyEndTask', [WorkerController::class, 'completelyEndTask'])->name('completelyEndTask');
    ////End Task

    
    //problem solve teliphone
    Route::post('/worker/task_solving_Over_phone', [WorkerController::class, 'taskSolvingOverPhone'])->name('taskSolvingOverPhone');
    
    //Task Cancel
    Route::get('/worker/cancelJourney', [WorkerController::class, 'cancelJourney'])->name('cancelJourney');
    
    //Finish Of The Day
    Route::get('/worker/endOfTheDay', [WorkerController::class, 'endOfTheDay'])->name('endOfTheDay');
    Route::post('/worker/endOfTheDayStore', [WorkerController::class, 'endOfTheDayStore'])->name('endOfTheDayStore');


    //--------------------------------End Soverign Site Worker------------------------------

});