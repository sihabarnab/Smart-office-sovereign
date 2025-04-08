<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\SalesController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {


    //Start Sales
    Route::get('/sales', [App\Http\Controllers\ModuleController::class, 'sales'])->name('sales');
    //Main Customer Info
    Route::get('/sales/customer_info', [SalesController::class, 'customerinfo'])->name('customer_info');
    Route::post('/sales/customer_info', [SalesController::class, 'customer_info_store'])->name('customer_info_store');
    Route::get('/sales/customer_info/edit/{id}', [SalesController::class, 'customer_info_edit'])->name('customer_info_edit');
    Route::post('/sales/customer_info/{update}', [SalesController::class, 'customer_info_update'])->name('customer_info_update');


    //temporary Customer
    Route::get('/sales/temporary_customer_info', [SalesController::class, 'temporary_customer_info'])->name('temporary_customer_info');
    Route::post('/sales/temporary_customer_store', [SalesController::class, 'temporary_customer_store'])->name('temporary_customer_store');
    Route::get('/sales/temporary_customer_info/edit/{id}', [SalesController::class, 'temporary_customer_info_edit'])->name('temporary_customer_info_edit');
    Route::post('/sales/temporary_customer_info', [SalesController::class, 'temporary_customer_info_update'])->name('temporary_customer_info_update');

    // report
    Route::get('/sales/rpt_temporary_customer_info', [SalesController::class, 'rpt_temporary_customer_info'])->name('rpt_temporary_customer_info');


    //Project
    Route::get('/sales/project_info', [SalesController::class, 'projectInfo'])->name('sales_project_info');
    Route::post('/sales/project_info', [SalesController::class, 'ProjectInfoStore'])->name('sales_ProjectInfoStore');
    Route::get('/sales/project_info/edit/{id}', [SalesController::class, 'project_info_edit'])->name('sales_project_info_edit');
    Route::post('/sales/project_info/{update}', [SalesController::class, 'project_info_update'])->name('sales_project_info_update');
    //lifts
    Route::get('/sales/lift_info', [SalesController::class, 'liftinfo'])->name('sales_lift_info');
    Route::post('/sales/lift_info', [SalesController::class, 'lift_info_store'])->name('sales_lift_info_store');
    Route::get('/sales/lift_info/edit/{id}', [SalesController::class, 'lift_info_edit'])->name('sales_lift_info_edit');
    Route::post('/sales/lift_info/{update}', [SalesController::class, 'lift_info_update'])->name('sales_lift_info_update');

    //create Task
    Route::get('/sales/create_task', [SalesController::class, 'create_task'])->name('create_task');
    Route::post('/sales/store_task', [SalesController::class, 'store_task'])->name('store_task');
    //Journey
    Route::get('/sales/start_journey', [SalesController::class, 'sales_start_journey'])->name('sales_start_journey');
    Route::get('/sales/end_journey/{task_id}', [SalesController::class, 'sales_end_journey'])->name('sales_end_journey');
    Route::post('/sales/end_journey_store', [SalesController::class, 'sales_end_journey_store'])->name('sales_end_journey_store');
    //review task
    Route::get('/sales/review_task/{task_id}', [SalesController::class, 'review_task'])->name('review_task');
    Route::post('/sales/review_task_store', [SalesController::class, 'review_task_store'])->name('review_task_store');


    //rpt Task
    Route::get('/sales/rpt_sales_task_list', [SalesController::class, 'rpt_sales_task_list'])->name('rpt_sales_task_list');
    Route::get('/sales/rpt_sales_task_search', [SalesController::class, 'rpt_sales_task_search'])->name('rpt_sales_task_search');

    //Quotation
    Route::get('/sales/sales_quotation', [SalesController::class, 'sales_quotation'])->name('sales_quotation');
    Route::post('/sales/sales_quotation_initial_store', [SalesController::class, 'sales_quotation_initial_store'])->name('sales_quotation_initial_store');
    Route::get('/sales/sales_quotation_details/{quotation_id}', [SalesController::class, 'sales_quotation_details'])->name('sales_quotation_details');
    
    //
    Route::get('/get/sales/customer_details/{customer_id}', [SalesController::class, 'SalesCustomerDetails']);


    //End Sales




});
