<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\ServiceController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {

    //------------------------------Start Service
    Route::get('/service', [App\Http\Controllers\ModuleController::class, 'service'])->name('service');

    //Team
    Route::get('/service/team_info', [ServiceController::class, 'TeamInfo'])->name('team_info');
    Route::post('/service/team_info', [ServiceController::class, 'TeamInfoStore'])->name('TeamInfoStore');
    Route::get('/service/teams_edit/{id}', [ServiceController::class, 'TeamInfoEdit'])->name('TeamInfoEdit');
    Route::post('/service/teams_update/{id}', [ServiceController::class, 'TeamInfoUpdate'])->name('TeamInfoUpdate');

    //Project
    Route::get('/service/project_info', [ServiceController::class, 'projectInfo'])->name('project_info');
    Route::post('/service/project_info', [ServiceController::class, 'ProjectInfoStore'])->name('ProjectInfoStore');
    Route::get('/service/project_info/edit/{id}', [ServiceController::class, 'project_info_edit'])->name('project_info_edit');
    Route::post('/service/project_info/{update}', [ServiceController::class, 'project_info_update'])->name('project_info_update');

    //lifts
    Route::get('/service/lift_info', [ServiceController::class, 'liftinfo'])->name('lift_info');
    Route::post('/service/lift_info', [ServiceController::class, 'lift_info_store'])->name('lift_info_store');
    Route::get('/service/lift_info/edit/{id}', [ServiceController::class, 'lift_info_edit'])->name('lift_info_edit');
    Route::post('/service/lift_info/{update}', [ServiceController::class, 'lift_info_update'])->name('lift_info_update');

    //contact_services
    Route::get('/service/contract_service_info', [ServiceController::class, 'contractserviceinfo'])->name('contract_service_info');
    Route::post('/service/contract_service_info', [ServiceController::class, 'contract_service_info_store'])->name('contract_service_info_store');
    Route::get('/service/contract_service_info/edit/{id}', [ServiceController::class, 'contract_service_info_edit'])->name('contract_service_info_edit');
    Route::post('/service/contract_service_info/{update}', [ServiceController::class, 'contract_service_info_update'])->name('contract_service_info_update');

    //Task Assign
    Route::get('/service/task_assign', [ServiceController::class, 'taskassign'])->name('task_assign');
    Route::post('/service/task_assign', [ServiceController::class, 'task_assign_store'])->name('task_assign_store');
    Route::get('/service/task_assign/edit/{id}', [ServiceController::class, 'task_assign_edit'])->name('task_assign_edit');
    Route::post('/service/task_assign/{update}', [ServiceController::class, 'task_assign_update'])->name('task_assign_update');


    //Task Assign Helper
    Route::get('/service/helper_information/{id}', [ServiceController::class, 'helper_information'])->name('helper_information');
    Route::post('/service/add_helper/{task_id}', [ServiceController::class, 'add_helper'])->name('add_helper');
    Route::get('/service/edit_helper/{id}', [ServiceController::class, 'edit_helper'])->name('edit_helper');
    Route::get('/service/remove_helper/{id}', [ServiceController::class, 'remove_helper'])->name('remove_helper');
    Route::post('/service/update_helper/{id}', [ServiceController::class, 'update_helper'])->name('update_helper');
    Route::get('/service/task_assign_final', [ServiceController::class, 'task_assign_final'])->name('task_assign_final');


    //Task cancel list
    // Route::get('/service/task_cancel', [ServiceController::class, 'taskassign'])->name('task_cancel');




    //Material Issue
    Route::get('/service/material_issue', [ServiceController::class, 'material_issue'])->name('material_issue');
    Route::post('/service/material_issue_store', [ServiceController::class, 'material_issue_store'])->name('material_issue_store');
    Route::get('/service/material_issue_details/{id}', [ServiceController::class, 'material_issue_details'])->name('material_issue_details');
    Route::post('/service/material_issue_details_store/{id}', [ServiceController::class, 'material_issue_details_store'])->name('material_issue_details_store');
    Route::get('/service/material_issue_final/{id}', [ServiceController::class, 'material_issue_final'])->name('material_issue_final');


    // RPT Requisition List User
    Route::get('/service/rpt_requisition_user', [ServiceController::class, 'RPTRequisitionUser'])->name('rpt_requisition_user');

    //RPT Material All
    Route::get('/service/rpt_material_issue', [ServiceController::class, 'rpt_material_issue'])->name('rpt_material_issue');
    Route::get('/service/rpt_requisition_details/{id}', [ServiceController::class, 'RPTRequisitionDetails'])->name('rpt_requisition_details');
    Route::post('/service/rpt_search_requation', [ServiceController::class, 'RPTRequisitionSearch'])->name('rpt_search_requation');

    //RPT Task User 
    Route::get('/service/rpt_task_user', [ServiceController::class, 'RPTTaskUser'])->name('rpt_task_user');
    //RPT Task All
    Route::get('/service/rpt_task_all', [ServiceController::class, 'RPTTaskAll'])->name('rpt_task_all');
    Route::get('/service/rpt_search_task', [ServiceController::class, 'RPTTaskSearch'])->name('rpt_search_task');
    Route::get('/service/rpt_task_view/{task_id}', [ServiceController::class, 'RPTTaskView'])->name('rpt_task_view');

    //RPT Complain Register
    Route::get('/service/rpt_task_complain', [ServiceController::class, 'RPTTaskComplain'])->name('rpt_task_complain');
    Route::post('/service/rpt_search_task_complain', [ServiceController::class, 'rpt_search_task_complain'])->name('rpt_search_task_complain');


    //Return Material 
    Route::get('/service/return_material', [ServiceController::class, 'return_material'])->name('return_material');
    Route::get('/service/add_return_material/{id}', [ServiceController::class, 'add_return_material'])->name('add_return_material');
    Route::post('/service/store_return_material/{complain_id}/{product_id}', [ServiceController::class, 'store_return_material'])->name('store_return_material');


    //Service bill
    Route::get('/service/servicing_bill', [ServiceController::class, 'servicing_bill'])->name('servicing_bill');
    Route::post('/service/servicing_bill_store', [ServiceController::class, 'servicing_bill_store'])->name('servicing_bill_store');
    Route::get('/get/service/previous_due/{project_id}/{customer_id}', [ServiceController::class, 'previous_due'])->name('previous_due');

    //bill update
    Route::get('/service/servicing_bill_list', [ServiceController::class, 'servicing_bill_list'])->name('servicing_bill_list');
    Route::get('/service/servicing_bill_edit/{id}', [ServiceController::class, 'servicing_bill_edit'])->name('servicing_bill_edit');
    Route::post('/service/servicing_bill_update/{id}', [ServiceController::class, 'servicing_bill_update'])->name('servicing_bill_update');

    //rpt service bill
    Route::get('/service/rpt_servicing_bill_list', [ServiceController::class, 'rpt_servicing_bill_list'])->name('rpt_servicing_bill_list');
    Route::get('/service/rpt_search_serviceing_bill', [ServiceController::class, 'rpt_search_serviceing_bill'])->name('rpt_search_serviceing_bill');
    Route::get('/service/rpt_servicing_bill_view/{id}', [ServiceController::class, 'rpt_servicing_bill_view'])->name('rpt_servicing_bill_view');
    Route::get('/service/rpt_servicing_bill_print/{id}', [ServiceController::class, 'rpt_servicing_bill_print'])->name('rpt_servicing_bill_print');


    // Bill assign
    Route::get('/service/bill_assign', [ServiceController::class, 'bill_assign'])->name('bill_assign');
    Route::post('/service/bill_assign_store', [ServiceController::class, 'bill_assign_store'])->name('bill_assign_store');

    //
    Route::get('/service/bill_assign_list', [ServiceController::class, 'bill_assign_list'])->name('bill_assign_list');

    //startJourney and endJourney
    Route::get('/service/start_journey', [ServiceController::class, 'serviceStartJourney'])->name('serviceStartJourney');
    Route::get('/service/end_journey', [ServiceController::class, 'ServiceEndJourney'])->name('ServiceEndJourney');
    Route::post('/service/end_journey', [ServiceController::class, 'ServiceEndJourneyStore'])->name('ServiceEndJourneyStore');

    //Review
    Route::get('/service/review', [ServiceController::class, 'review'])->name('review');
    Route::post('/service/review_final', [ServiceController::class, 'review_final'])->name('review_final');

    //Bill collection
    Route::get('/service/bill_collection_list', [ServiceController::class, 'bill_collection_list'])->name('bill_collection_list');
    Route::get('/service/servicing_add_money/{id}', [ServiceController::class, 'servicing_add_money'])->name('servicing_add_money');
    Route::post('/service/servicing_store_money', [ServiceController::class, 'servicing_store_money'])->name('servicing_store_money');
    Route::get('/service/service_mr_list/{id}', [ServiceController::class, 'service_mr_list'])->name('service_mr_list');
    //bill approved
    Route::get('/service/approved_bill_collection', [ServiceController::class, 'approved_bill_collection'])->name('approved_bill_collection');
    Route::get('/service/approved_bill_collection_ok', [ServiceController::class, 'approved_bill_collection_ok'])->name('approved_bill_collection_ok');

    //RPT Client invoice
    Route::get('/service/rpt_service_invoic_list', [ServiceController::class, 'RPTServiceInvoiceList'])->name('rpt_service_invoic_list');
    Route::get('/service/rpt_service_invoic_details/{id}', [ServiceController::class, 'RPTServiceInvoiceDetails'])->name('rpt_service_invoic_details');

    //RPT  Warrenty/service Period Summery
    Route::get('/service/warrenty_period', [ServiceController::class, 'warrenty_period'])->name('warrenty_period');

    //RPT Summery
    Route::get('/service/rpt_service_summery', [ServiceController::class, 'rpt_service_summery'])->name('rpt_service_summery');
    Route::get('/service/rpt_summery_search', [ServiceController::class, 'rpt_summery_search'])->name('rpt_summery_search');

    // bill summery
    Route::get('/service/rpt_bill_summery', [ServiceController::class, 'rpt_bill_summery'])->name('rpt_bill_summery');
    Route::get('/service/rpt_bill_summery_details/{id}', [ServiceController::class, 'rpt_bill_summery_details'])->name('rpt_bill_summery_details');




    //End service


    //only ajax call

    Route::get('get/project/{id}', [ServiceController::class, 'GetProject']);
    Route::get('get/lift/{id}', [ServiceController::class, 'GetLift']);

    //servicing requation  // material issue
    // Route::get('/get/requisition_product/{id}', [ServiceController::class, 'GetReqProduct']);
    // Route::get('/get/requisition_product_sub/{id}', [ServiceController::class, 'GetReqProductSubGroup']);
    Route::get('/get/requisition/product_unit/{id}', [ServiceController::class, 'GetProductUnit']);
    Route::get('/get/requisition/product/{id}/{id2}', [ServiceController::class, 'GetProductSubGroup']);
    Route::get('/get/requisition/product1/{id}/{id2}', [ServiceController::class, 'GetProduct']);

    //service material issue
    // Route::get('/get/smi/product/{id}/{id2}', [ServiceController::class, 'GetSMIProductSubGroup']);
    Route::get('/get/smi/product1/{id}/{id2}', [ServiceController::class, 'GetSMIProduct']);

    //Money receipt
    Route::get('get/money_receipt/project/{id}', [ServiceController::class, 'GetMoneyReceipt']);
    //Bill 
    Route::get('get/complete_project/{id}', [ServiceController::class, 'GetCompliteProject']);
});
