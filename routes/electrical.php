<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\ElectricalController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {

    
    //--------------------------------Soverign Site Worker------------------------------
    Route::get('/electrical', [ModuleController::class, 'electrical'])->name('electrical');
   //Task Assign
   Route::get('/electrical/elc_task_assign', [ElectricalController::class, 'elc_task_assign'])->name('elc_task_assign');
   Route::post('/electrical/elc_task_assign_store', [ElectricalController::class, 'elc_task_assign_store'])->name('elc_task_assign_store');
   Route::get('/electrical/elc_task_assign_edit/{id}', [ElectricalController::class, 'elc_task_assign_edit'])->name('elc_task_assign_edit');
   Route::post('/electrical/elc_task_assign_update/{update}', [ElectricalController::class, 'elc_task_assign_update'])->name('elc_task_assign_update');
   //
   Route::get('/electrical/elc_helper_information/{id}', [ElectricalController::class, 'elc_helper_information'])->name('elc_helper_information');
   Route::post('/electrical/elc_add_helper/{id}', [ElectricalController::class, 'elc_add_helper'])->name('elc_add_helper');
   Route::get('/electrical/elc_edit_helper/{id}', [ElectricalController::class, 'elc_edit_helper'])->name('elc_edit_helper');
   Route::get('/electrical/elc_remove_helper/{id}', [ElectricalController::class, 'elc_remove_helper'])->name('elc_remove_helper');
   Route::post('/electrical/elc_update_helper/{id}', [ElectricalController::class, 'elc_update_helper'])->name('elc_update_helper');
   Route::get('/electrical/elc_task_assign_final', [ElectricalController::class, 'elc_task_assign_final'])->name('elc_task_assign_final');

    //RPT Summery
    Route::get('/electrical/rpt_electrical_summery', [ElectricalController::class, 'rpt_electrical_summery'])->name('rpt_electrical_summery');
    Route::get('/electrical/rpt_electrical_summery_search', [ElectricalController::class, 'rpt_electrical_summery_search'])->name('rpt_electrical_summery_search');
    Route::get('/electrical/rpt_elc_task_view/{task_id}', [ElectricalController::class, 'rpt_elc_task_view'])->name('rpt_elc_task_view');


    //--------------------------------End Soverign Site Worker------------------------------

});