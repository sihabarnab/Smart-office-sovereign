<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\MaintenanceController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {



    //----------------------------------maintenance 
    Route::get('/maintenance', [ModuleController::class, 'maintenance'])->name('maintenance');

    //mode of payment
    Route::get('/maintenance/mode_of_payment', [MaintenanceController::class, 'mode_of_payment'])->name('mode_of_payment');
    Route::post('/maintenance/mode_of_payment_store', [MaintenanceController::class, 'mode_of_payment_store'])->name('mode_of_payment_store');
    Route::get('/maintenance/mode_of_payment_edit/{id}', [MaintenanceController::class, 'mode_of_payment_edit'])->name('mode_of_payment_edit');
    Route::post('/maintenance/mode_of_payment_update', [MaintenanceController::class, 'mode_of_payment_update'])->name('mode_of_payment_update');

    //Team
    Route::get('/maintenance/mt_team_info', [MaintenanceController::class, 'TeamInfo'])->name('mt_team_info');
    Route::post('/maintenance/team_info_store', [MaintenanceController::class, 'TeamInfoStore'])->name('mt_team_info_store');
    Route::get('/maintenance/teams_edit/{id}', [MaintenanceController::class, 'TeamInfoEdit'])->name('mt_TeamInfoEdit');
    Route::post('/maintenance/teams_update/{id}', [MaintenanceController::class, 'TeamInfoUpdate'])->name('mt_TeamInfoUpdate');

    //Project
    Route::get('/maintenance/mt_project_info', [MaintenanceController::class, 'projectInfo'])->name('mt_project_info');
    Route::post('/maintenance/project_info', [MaintenanceController::class, 'ProjectInfoStore'])->name('mt_ProjectInfoStore');
    Route::get('/maintenance/project_info/edit/{id}', [MaintenanceController::class, 'project_info_edit'])->name('mt_project_info_edit');
    Route::post('/maintenance/project_info/{update}', [MaintenanceController::class, 'project_info_update'])->name('mt_project_info_update');

    //lifts
    Route::get('/maintenance/mt_lift_info', [MaintenanceController::class, 'liftinfo'])->name('mt_lift_info');
    Route::post('/maintenance/lift_info', [MaintenanceController::class, 'lift_info_store'])->name('mt_lift_info_store');
    Route::get('/maintenance/lift_info/edit/{id}', [MaintenanceController::class, 'lift_info_edit'])->name('mt_lift_info_edit');
    Route::post('/maintenance/lift_info/{update}', [MaintenanceController::class, 'lift_info_update'])->name('mt_lift_info_update');

    //contact_services
    Route::get('/maintenance/mt_contract_service_info', [MaintenanceController::class, 'contractserviceinfo'])->name('mt_contract_service_info');
    Route::post('/maintenance/contract_service_info', [MaintenanceController::class, 'contract_service_info_store'])->name('mt_contract_service_info_store');
    Route::get('/maintenance/contract_service_info/edit/{id}', [MaintenanceController::class, 'contract_service_info_edit'])->name('mt_contract_service_info_edit');
    Route::post('/maintenance/contract_service_info/{update}', [MaintenanceController::class, 'contract_service_info_update'])->name('mt_contract_service_info_update');

    //Project Complite
    Route::get('/maintenance/project_complite', [MaintenanceController::class, 'project_complite'])->name('project_complite');
    Route::post('/maintenance/project_complite/store', [MaintenanceController::class, 'project_complite_store'])->name('project_complite_store');

    //Complaint Register
    Route::get('/maintenance/mt_complaint_register', [MaintenanceController::class, 'ComplaintRegister'])->name('mt_complaint_register');
    Route::post('/maintenance/complaint_register', [MaintenanceController::class, 'complaint_register_store'])->name('mt_complaint_register_store');
    Route::get('/maintenance/complaint_register/edit/{id}', [MaintenanceController::class, 'complaint_register_edit'])->name('mt_complaint_register_edit');
    Route::post('/maintenance/complaint_register/{update}', [MaintenanceController::class, 'complaint_register_update'])->name('mt_complaint_register_update');

    //Task Assign
    Route::get('/maintenance/mt_task_assign', [MaintenanceController::class, 'taskassign'])->name('mt_task_assign');
    Route::get('/maintenance/mt_task_assign_massage/{id}', [MaintenanceController::class, 'mt_task_assign_massage'])->name('mt_task_assign_massage');
    Route::post('/maintenance/task_assign', [MaintenanceController::class, 'task_assign_store'])->name('mt_task_assign_store');
    Route::get('/maintenance/task_assign/edit/{id}', [MaintenanceController::class, 'task_assign_edit'])->name('mt_task_assign_edit');
    Route::post('/maintenance/task_assign/{update}', [MaintenanceController::class, 'task_assign_update'])->name('mt_task_assign_update');

    //Task Assign Helper
    Route::get('/maintenance/helper_information/{id}', [MaintenanceController::class, 'helper_information'])->name('mt_helper_information');
    Route::post('/maintenance/add_helper/{task_id}', [MaintenanceController::class, 'add_helper'])->name('mt_add_helper');
    Route::get('/maintenance/edit_helper/{id}', [MaintenanceController::class, 'edit_helper'])->name('mt_edit_helper');
    Route::get('/maintenance/remove_helper/{id}', [MaintenanceController::class, 'remove_helper'])->name('mt_remove_helper');
    Route::post('/maintenance/update_helper/{id}', [MaintenanceController::class, 'update_helper'])->name('mt_update_helper');
    Route::get('/maintenance/task_assign_final', [MaintenanceController::class, 'task_assign_final'])->name('mt_task_assign_final');

    //Task cancel list
    Route::get('/maintenance/task_cancel_list', [MaintenanceController::class, 'taskcancellist'])->name('mt_task_cancel_list');
    Route::get('/maintenance/mt_task_reassign/{task_id}', [MaintenanceController::class, 'taskReassign'])->name('mt_task_reassign');


    //Ajax Requisition
    Route::get('/get/maintenance/requisition/product_unit/{id}', [MaintenanceController::class, 'GetProductUnit']);

    //money receipt
    Route::get('/maintenance/mt_money_receipt_user', [MaintenanceController::class, 'MoneyReceipUser'])->name('mt_money_receipt_user');
    Route::get('/maintenance/money_receipt_admin', [MaintenanceController::class, 'MoneyReceiptAdmin'])->name('mt_money_receipt_admin');
    Route::post('/maintenance/money_receipt_store', [MaintenanceController::class, 'money_receipt_store'])->name('mt_money_receipt_store');
    Route::get('/maintenance/money_receipt_edit/{id}', [MaintenanceController::class, 'money_receipt_edit'])->name('mt_money_receipt_edit');
    Route::post('/maintenance/money_receipt_update/{id}', [MaintenanceController::class, 'money_receipt_update'])->name('mt_money_receipt_update');

    //Quotation
    Route::get('/maintenance/mt_quotation', [MaintenanceController::class, 'mt_quotation'])->name('mt_quotation');
    Route::post('/maintenance/mt_quotation_store', [MaintenanceController::class, 'mt_quotation_store'])->name('mt_quotation_store');
    Route::get('/maintenance/mt_quotation_details/{id}', [MaintenanceController::class, 'mt_quotation_details'])->name('mt_quotation_details');
    Route::post('/maintenance/mt_quotation_details_store/{id}', [MaintenanceController::class, 'mt_quotation_details_store'])->name('mt_quotation_details_store');
    Route::post('/maintenance/mt_quotation_repair_store/{id}', [MaintenanceController::class, 'mt_quotation_repair_store'])->name('mt_quotation_repair_store');
    //final
    Route::get('/maintenance/mt_quotation_final/{id}', [MaintenanceController::class, 'mt_quotation_final'])->name('mt_quotation_final');
    Route::post('/maintenance/mt_quotation_final_store/{id}', [MaintenanceController::class, 'mt_quotation_final_store'])->name('mt_quotation_final_store');
    //edit details and remove
    Route::get('/maintenance/mt_quotation_details_edit/{id}', [MaintenanceController::class, 'mt_quotation_details_edit'])->name('mt_quotation_details_edit');
    Route::get('/maintenance/mt_quotation_details_remove', [MaintenanceController::class, 'mt_quotation_details_remove'])->name('mt_quotation_details_remove');
    Route::post('/maintenance/mt_quotation_details_update/{id}', [MaintenanceController::class, 'mt_quotation_details_update'])->name('mt_quotation_details_update');

    //Quotation MGM approved, status ->3 & reject ->5
    Route::get('/maintenance/mt_quotation_approved_mgm', [MaintenanceController::class, 'mt_quotation_approved_mgm'])->name('mt_quotation_approved_mgm');
    Route::get('/maintenance/mt_quotation_approved_details_mgm', [MaintenanceController::class, 'mt_quotation_approved_details_mgm'])->name('mt_quotation_approved_details_mgm');
    Route::get('/maintenance/quotation_approved_massage/{id}', [MaintenanceController::class, 'quotation_approved_massage'])->name('quotation_approved_massage');
    Route::get('/maintenance/mt_quotation_accept/{id}', [MaintenanceController::class, 'mt_quotation_accept'])->name('mt_quotation_accept');
    Route::post('/maintenance/mt_quotation_reject/{id}', [MaintenanceController::class, 'mt_quotation_reject'])->name('mt_quotation_reject');

    //Customer Quotation Approve -> customer_status: 1 inital entry
    Route::get('/maintenance/mt_quotation_customer_approved', [MaintenanceController::class, 'mt_quotation_customer_approved'])->name('mt_quotation_customer_approved');
    Route::get('/maintenance/mt_customer_quotation_approved_edit', [MaintenanceController::class, 'mt_customer_quotation_approved_edit'])->name('mt_customer_quotation_approved_edit');
    Route::get('/maintenance/mt_customer_quotation_approved_remove', [MaintenanceController::class, 'mt_customer_quotation_approved_remove'])->name('mt_customer_quotation_approved_remove');
    Route::get('/maintenance/mt_customer_quotation_all_approved', [MaintenanceController::class, 'mt_customer_quotation_all_approved'])->name('mt_customer_quotation_all_approved');
    //notification accept url
    Route::get('/maintenance/mt_customer_quotation_approved/{id}/edit', [MaintenanceController::class, 'mt_customer_quotation_approved_edit_url'])->name('mt_customer_quotation_approved_edit_url');
    Route::post('/maintenance/mt_customer_quotation_approved_update/{id}', [MaintenanceController::class, 'mt_customer_quotation_approved_update'])->name('mt_customer_quotation_approved_update');
    Route::post('/maintenance/mt_customer_quotation_approved_final/{id}', [MaintenanceController::class, 'mt_customer_quotation_approved_final'])->name('mt_customer_quotation_approved_final');

    //Customer Quotation Approve MGM  -> customer_status: 2 accept , 3 reject
    Route::get('/maintenance/mt_quotation_customer_approved_mgm', [MaintenanceController::class, 'mt_quotation_customer_approved_mgm'])->name('mt_quotation_customer_approved_mgm');
    Route::get('/maintenance/mt_quotation_customer_approved_details_mgm', [MaintenanceController::class, 'mt_quotation_customer_approved_details_mgm'])->name('mt_quotation_customer_approved_details_mgm');
    Route::get('/maintenance/quotation_customer_approved_massage/{id}', [MaintenanceController::class, 'quotation_customer_approved_massage'])->name('quotation_customer_approved_massage');
    Route::get('/maintenance/mt_customer_quotation_accept/{id}', [MaintenanceController::class, 'mt_customer_quotation_accept'])->name('mt_customer_quotation_accept');
    Route::post('/maintenance/mt_customer_quotation_reject/{id}', [MaintenanceController::class, 'mt_customer_quotation_reject'])->name('mt_customer_quotation_reject');

    // Ajax Quotation
    Route::get('/get/mt_quotation/product_unit/{product_id}', [MaintenanceController::class, 'GetMtProductUnit']);
    Route::post('/get/customer', [MaintenanceController::class, 'GetCustomer'])->name('GetCustomer');
    Route::get('/get/customer_details/{project_id}', [MaintenanceController::class, 'GetCustomerDetails']);
    Route::get('/get/approved_quotation/{id}', [MaintenanceController::class, 'GetApprovedQuotation']);
    Route::get('/get/prepare_quotation/{id}', [MaintenanceController::class, 'GetPrepareQuotation']);

    //RPT Quotation
    Route::get('/maintenance/rpt_mt_quotation_list', [MaintenanceController::class, 'rpt_mt_quotation_list'])->name('rpt_mt_quotation_list');
    Route::get('/get/mt/rpt_quotation_list', [MaintenanceController::class, 'GetMtRptQuotationList']);
    Route::get('/maintenance/rpt_mt_quotation_view/{id}', [MaintenanceController::class, 'rpt_mt_quotation_view'])->name('rpt_mt_quotation_view');
    Route::get('/maintenance/rpt_mt_quotation_print/{id}', [MaintenanceController::class, 'rpt_mt_quotation_print'])->name('rpt_mt_quotation_print');



    //Bill status -> 1 inital, 2 final approved
    // Bill
    Route::get('/maintenance/mt_bill', [MaintenanceController::class, 'mt_bill'])->name('mt_bill');
    Route::post('/maintenance/mt_bill_store', [MaintenanceController::class, 'mt_bill_store'])->name('mt_bill_store');

    //Bill Update
    Route::get('/maintenance/mt_bill_update_list', [MaintenanceController::class, 'mt_bill_update_list'])->name('mt_bill_update_list');
    Route::get('/maintenance/mt_bill_update_details/{id}', [MaintenanceController::class, 'mt_bill_update_details'])->name('mt_bill_update_details');
    Route::post('/maintenance/mt_bill_update_store', [MaintenanceController::class, 'mt_bill_update_store'])->name('mt_bill_update_store');
    Route::get('/maintenance/mt_bill_update_remove', [MaintenanceController::class, 'mt_bill_update_remove'])->name('mt_bill_update_remove');
    Route::post('/maintenance/mt_bill_update_repair_store', [MaintenanceController::class, 'mt_bill_update_repair_store'])->name('mt_bill_update_repair_store');
    Route::post('/maintenance/mt_bill_update_due_description', [MaintenanceController::class, 'mt_bill_update_due_description'])->name('mt_bill_update_due_description');
    Route::post('/maintenance/mt_bill_update_final', [MaintenanceController::class, 'mt_bill_update_final'])->name('mt_bill_update_final');

    //RPT Bill 
    Route::get('/maintenance/rpt_mt_bill_list', [MaintenanceController::class, 'rpt_mt_bill_list'])->name('rpt_mt_bill_list');
    Route::get('/maintenance/rpt_mt_bill_view/{id}', [MaintenanceController::class, 'rpt_mt_bill_view'])->name('rpt_mt_bill_view');
    Route::get('/maintenance/rpt_mt_bill_print/{id}', [MaintenanceController::class, 'rpt_mt_bill_print'])->name('rpt_mt_bill_print');

    //rpt bill summery
    Route::get('/maintenance/rpt_mt_bill_summery', [MaintenanceController::class, 'rpt_mt_bill_summery'])->name('rpt_mt_bill_summery');


    //Bill opening balance
    Route::get('/maintenance/opening_bill', [MaintenanceController::class, 'opening_bill'])->name('opening_bill');
    Route::post('/maintenance/opening_bill_store', [MaintenanceController::class, 'opening_bill_store'])->name('opening_bill_store');

    // Bill assign
    Route::get('/maintenance/mt_bill_assign', [MaintenanceController::class, 'mt_bill_assign'])->name('mt_bill_assign');
    Route::post('/maintenance/mt_bill_assign_store', [MaintenanceController::class, 'mt_bill_assign_store'])->name('mt_bill_assign_store');

    //
    Route::get('/maintenance/mt_bill_assign_list', [MaintenanceController::class, 'mt_bill_assign_list'])->name('mt_bill_assign_list');

    //startJourney and endJourney
    Route::get('/maintenance/start_journey', [MaintenanceController::class, 'mtStartJourney'])->name('mtStartJourney');
    Route::get('/maintenance/end_journey', [MaintenanceController::class, 'mtEndJourney'])->name('mtEndJourney');
    Route::post('/maintenance/end_journey', [MaintenanceController::class, 'mtEndJourneyStore'])->name('mtEndJourneyStore');

    //review
    Route::get('/maintenance/mt_task_review', [MaintenanceController::class, 'mt_task_review'])->name('mt_task_review');
    Route::post('/maintenance/mt_task_review_final', [MaintenanceController::class, 'mt_task_review_final'])->name('mt_task_review_final');
    //End  Bill assign

    //office
    //Bill collection
    Route::get('/maintenance/mt_bill_collection_list', [MaintenanceController::class, 'mt_bill_collection_list'])->name('mt_bill_collection_list');
    Route::get('/maintenance/mt_bill_collection_info', [MaintenanceController::class, 'mt_bill_collection_info'])->name('mt_bill_collection_info');
    //current bill
    Route::get('/maintenance/maintenance_add_money/{id}', [MaintenanceController::class, 'maintenance_add_money'])->name('maintenance_add_money');
    Route::post('/maintenance/maintenance_store_money', [MaintenanceController::class, 'maintenance_store_money'])->name('maintenance_store_money');
    //due bill
    Route::get('/maintenance/maintenance_due_add_money/{id}', [MaintenanceController::class, 'maintenance_due_add_money'])->name('maintenance_due_add_money');
    Route::post('/maintenance/maintenance_due_store_money', [MaintenanceController::class, 'maintenance_due_store_money'])->name('maintenance_due_store_money');
    //
    Route::get('/maintenance/maintenance_mr_list/{id}', [MaintenanceController::class, 'maintenance_mr_list'])->name('maintenance_mr_list');
    //bill approved
    Route::get('/maintenance/mt_approved_bill_collection', [MaintenanceController::class, 'mt_approved_bill_collection'])->name('mt_approved_bill_collection');
    Route::get('/maintenance/mt_approved_bill_collection_ok', [MaintenanceController::class, 'mt_approved_bill_collection_ok'])->name('mt_approved_bill_collection_ok');
    //Ajax
    Route::get('/get/bill/customer_quotation/{id}', [MaintenanceController::class, 'GetBillCustomerQuotation']);

    //End Bill

    //Report 

    //RPT Complain Register
    Route::get('/maintenance/rpt_mt_task_complain', [MaintenanceController::class, 'RPTTaskComplain'])->name('rpt_mt_task_complain');
    Route::get('/maintenance/rpt_search_task_complain', [MaintenanceController::class, 'rpt_search_task_complain'])->name('mt_rpt_search_task_complain');

    //RPT Task All
    Route::get('/maintenance/rpt_mt_task_all', [MaintenanceController::class, 'RPTTaskAll'])->name('rpt_mt_task_all');
    Route::get('/maintenance/rpt_search_task', [MaintenanceController::class, 'RPTTaskSearch'])->name('mt_rpt_search_task');
    Route::get('/maintenance/rpt_task_view/{task_id}', [MaintenanceController::class, 'RPTTaskView'])->name('mt_rpt_task_view');

    //RPT Summery
    Route::get('/maintenance/rpt_summery', [MaintenanceController::class, 'rpt_summery'])->name('rpt_summery');
    Route::get('/maintenance/rpt_summery_search', [MaintenanceController::class, 'rpt_summery_search'])->name('rpt_mt_summery_search');

    //rpt Summery 


    //rpt All report Summery
    Route::get('/maintenance/rpt_all_report_summery', [MaintenanceController::class, 'rpt_all_report_summery'])->name('rpt_all_report_summery');
    Route::get('/maintenance/rpt_all_report_summery_list', [MaintenanceController::class, 'rpt_all_report_summery_list'])->name('rpt_all_report_summery_list');
    Route::get('get/summery/project_list/{id}', [MaintenanceController::class, 'RptGetProjectList']);


    //End maintenance


});
