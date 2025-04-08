<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\MechanicalController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {


    //--------------------------------Soverign Site Worker------------------------------
    Route::get('/mechanical', [ModuleController::class, 'mechanical'])->name('mechanical');

    //Project
    Route::get('/mechanical/mech_project_info', [MechanicalController::class, 'projectInfo'])->name('mech_project_info');
    Route::post('/mechanical/project_info', [MechanicalController::class, 'ProjectInfoStore'])->name('mech_ProjectInfoStore');
    Route::get('/mechanical/project_info/edit/{id}', [MechanicalController::class, 'project_info_edit'])->name('mech_project_info_edit');
    Route::post('/mechanical/project_info/{update}', [MechanicalController::class, 'project_info_update'])->name('mech_project_info_update');

    //lifts
    Route::get('/mechanical/mech_lift_info', [MechanicalController::class, 'liftinfo'])->name('mech_lift_info');
    Route::post('/mechanical/lift_info', [MechanicalController::class, 'lift_info_store'])->name('mech_lift_info_store');
    Route::get('/mechanical/lift_info/edit/{id}', [MechanicalController::class, 'lift_info_edit'])->name('mech_lift_info_edit');
    Route::post('/mechanical/lift_info/{update}', [MechanicalController::class, 'lift_info_update'])->name('mech_lift_info_update');

    //Task Assign
    Route::get('/mechanical/mech_task_assign', [MechanicalController::class, 'mech_task_assign'])->name('mech_task_assign');
    Route::post('/mechanical/mech_task_assign_store', [MechanicalController::class, 'mech_task_assign_store'])->name('mech_task_assign_store');
    Route::get('/mechanical/mech_task_assign_edit/{id}', [MechanicalController::class, 'mech_task_assign_edit'])->name('mech_task_assign_edit');
    Route::post('/mechanical/mech_task_assign_update/{update}', [MechanicalController::class, 'mech_task_assign_update'])->name('mech_task_assign_update');
    //
    Route::get('/mechanical/mech_helper_information/{id}', [MechanicalController::class, 'mech_helper_information'])->name('mech_helper_information');
    Route::post('/mechanical/mech_add_helper/{id}', [MechanicalController::class, 'mech_add_helper'])->name('mech_add_helper');
    Route::get('/mechanical/mech_edit_helper/{id}', [MechanicalController::class, 'mech_edit_helper'])->name('mech_edit_helper');
    Route::get('/mechanical/mech_remove_helper/{id}', [MechanicalController::class, 'mech_remove_helper'])->name('mech_remove_helper');
    Route::post('/mechanical/mech_update_helper/{id}', [MechanicalController::class, 'mech_update_helper'])->name('mech_update_helper');
    Route::get('/mechanical/mech_task_assign_final', [MechanicalController::class, 'mech_task_assign_final'])->name('mech_task_assign_final');

    //RPT Summery
    Route::get('/mechanical/rpt_mechanical_summery', [MechanicalController::class, 'rpt_mechanical_summery'])->name('rpt_mechanical_summery');
    Route::get('/mechanical/rpt_mechanical_summery_search', [MechanicalController::class, 'rpt_mechanical_summery_search'])->name('rpt_mechanical_summery_search');
    Route::get('/mechanical/rpt_mech_task_view/{task_id}', [MechanicalController::class, 'rpt_mech_task_view'])->name('rpt_mech_task_view');


    //--------------------------------End Soverign Site Worker------------------------------

});
