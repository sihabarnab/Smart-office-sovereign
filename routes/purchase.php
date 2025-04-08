<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\PurchaseController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {

//--------------------------------Purchase
    Route::get('/purchase', [ModuleController::class, 'purchase'])->name('purchase');

    //purchase
    Route::get('/purchase/purchase_requisition', [PurchaseController::class, 'purchase_requisition'])->name('purchase_requisition');
    Route::post('/purchase/purchase_requisition_store', [PurchaseController::class, 'purchase_requisition_store'])->name('purchase_requisition_store');
    Route::get('/purchase/purchase_requisition_details/{id}', [PurchaseController::class, 'purchase_requisition_details'])->name('purchase_requisition_details');
    Route::post('/purchase/purchase_requisition_details_store/{id}', [PurchaseController::class, 'purchase_requisition_details_store'])->name('purchase_requisition_details_store');
    Route::get('/purchase/purchase_requisition_final/{id}', [PurchaseController::class, 'purchase_requisition_final'])->name('purchase_requisition_final');
    
    //purchase Requiction Approved and reject
    Route::get('/purchase/purchase_requisition_approved', [PurchaseController::class, 'purchase_requisition_approved'])->name('purchase_requisition_approved');
    Route::get('/purchase/purchase_requisition_approved_details/{id}', [PurchaseController::class, 'purchase_requisition_approved_details'])->name('purchase_requisition_approved_details');
    Route::post('/purchase/purchase_requisition_approved_ok/{id}', [PurchaseController::class, 'purchase_requisition_approved_ok'])->name('purchase_requisition_approved_ok');
    Route::get('/purchase/purchase_requisition_approved_reject', [PurchaseController::class, 'purchase_requisition_approved_reject'])->name('purchase_requisition_approved_reject');

   //rpt Requisition
   Route::get('/purchase/rpt_purchase_requisition_list', [PurchaseController::class, 'rpt_purchase_requisition_list'])->name('rpt_purchase_requisition_list');
   Route::get('/purchase/rpt_purchase_requisition_info', [PurchaseController::class, 'rpt_purchase_requisition_info'])->name('rpt_purchase_requisition_info');
   Route::get('/purchase/rpt_purchase_requisition_details/{id}', [PurchaseController::class, 'rpt_purchase_requisition_details'])->name('rpt_purchase_requisition_details');
    

    //purchase Invoice
    Route::get('/purchase/purchase_invoice', [PurchaseController::class, 'purchase_invoice'])->name('purchase_invoice');
    Route::get('/purchase/purchase_invoice_master/{id}', [PurchaseController::class, 'purchase_invoice_master'])->name('purchase_invoice_master');
    Route::post('/purchase/purchase_invoice_store', [PurchaseController::class, 'purchase_invoice_store'])->name('purchase_invoice_store');
    Route::get('/purchase/purchase_invoice_details/{id}', [PurchaseController::class, 'purchase_invoice_details'])->name('purchase_invoice_details');
    Route::post('/purchase/purchase_invoice_details_store/{id}', [PurchaseController::class, 'purchase_invoice_details_store'])->name('purchase_invoice_details_store');
    Route::get('/purchase/purchase_invoice_final/{id}', [PurchaseController::class, 'purchase_invoice_final'])->name('purchase_invoice_final');

    //purchase Approved
    Route::get('/purchase/purchase_approved', [PurchaseController::class, 'purchase_approved'])->name('purchase_approved');
    Route::get('/purchase/purchase_approved_details/{id}', [PurchaseController::class, 'purchase_approved_details'])->name('purchase_approved_details');
    Route::post('/purchase/purchase_approved_ok/{id}', [PurchaseController::class, 'purchase_approved_ok'])->name('purchase_approved_ok');



    //rpt purchase invoice
    Route::get('/purchase/rpt_purchase_invoice_list', [PurchaseController::class, 'rpt_purchase_invoice_list'])->name('rpt_purchase_invoice_list');
    Route::get('/purchase/rpt_purchase_invoice_info', [PurchaseController::class, 'rpt_purchase_invoice_info'])->name('rpt_purchase_invoice_info');
    Route::get('/purchase/rpt_purchase_invoice_details/{id}', [PurchaseController::class, 'rpt_purchase_invoice_details'])->name('rpt_purchase_invoice_details');

    //purchase ajax
    Route::get('/get/purchase/product_qty/{product_id}/{id}', [PurchaseController::class, 'GetPurchaseRequictionProductQty']);


    //end purchase Invoice



    //Ajax Only
    //Purchase
    Route::get('/get/indent_sub/{id}', [PurchaseController::class, 'GetIndentGroup']);
    Route::get('/get/indent_product/{id}', [PurchaseController::class, 'GetIndentProduct']);
    Route::get('/get/Add_product_stock/unit/{id}', [PurchaseController::class, 'GetProductStoreUnit']);
    Route::get('/get/supply_add/{id}', [PurchaseController::class, 'GetSupplyAddress']);

    //
    Route::get('/get/indent_product_details/{id}/{id2}', [PurchaseController::class, 'GetIndentProductDetails']);
    //End Purchase





    
    

});