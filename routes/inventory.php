<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\InventoryController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {


    //------------------------------Start Inventory

    Route::get('/inventory', [App\Http\Controllers\ModuleController::class, 'inventory'])->name('inventory');

    //Product Group
    Route::get('/inventory/product_group', [App\Http\Controllers\InventoryController::class, 'inventoryproductgroup'])->name('product_group');
    Route::post('/inventory/product_group', [App\Http\Controllers\InventoryController::class, 'inventorypgstore'])->name('inventorypgstore');
    Route::get('/inventory/product_group/edit/{id}', [App\Http\Controllers\InventoryController::class, 'inventorypgedit'])->name('inventorypgedit');
    Route::post('/inventory/product_group/{update}', [App\Http\Controllers\InventoryController::class, 'inventorypgupdate'])->name('inventorypgupdate');

    //Product Sub Group
    Route::get('/inventory/product_sub_group', [App\Http\Controllers\InventoryController::class, 'inventoryproductsubgroup'])->name('product_sub_group');
    Route::post('/inventory/product_sub_group', [App\Http\Controllers\InventoryController::class, 'inventorypgsubstore'])->name('inventorypgsubstore');
    Route::get('/inventory/product_sub_group/edit/{id}', [App\Http\Controllers\InventoryController::class, 'inventorypgsubedit'])->name('inventorypgsubedit');
    Route::post('/inventory/product_sub_group/{update}', [App\Http\Controllers\InventoryController::class, 'inventorypgsubupdate'])->name('inventorypgsubupdate');


    //Product
    Route::get('/inventory/product', [App\Http\Controllers\InventoryController::class, 'inventoryproduct'])->name('product');
    Route::post('/inventory/product', [App\Http\Controllers\InventoryController::class, 'inventoryproductstore'])->name('inventoryproductstore');
    Route::get('/inventory/product/edit/{id}', [App\Http\Controllers\InventoryController::class, 'inventoryproductedit'])->name('inventoryproductedit');
    Route::post('/inventory/product/{update}', [App\Http\Controllers\InventoryController::class, 'inventoryproductupdate'])->name('inventoryproductupdate');


    //Unit
    Route::get('/inventory/product_unit', [App\Http\Controllers\InventoryController::class, 'productunit'])->name('product_unit');
    Route::post('/inventory/product_unit', [App\Http\Controllers\InventoryController::class, 'unitstore'])->name('unitstore');
    Route::get('/inventory/product_unit/edit/{id}', [App\Http\Controllers\InventoryController::class, 'prounitedit'])->name('prounitedit');
    Route::post('/inventory/product_unit/{update}', [App\Http\Controllers\InventoryController::class, 'prounitupdate'])->name('prounitupdate');

    //Size
    Route::get('/inventory/product_size', [App\Http\Controllers\InventoryController::class, 'productsize'])->name('product_size');
    Route::post('/inventory/product_size', [App\Http\Controllers\InventoryController::class, 'sizestore'])->name('sizestore');
    Route::get('/inventory/product_size/edit/{id}', [App\Http\Controllers\InventoryController::class, 'prosizeedit'])->name('prosizeedit');
    Route::post('/inventory/product_size/{update}', [App\Http\Controllers\InventoryController::class, 'prosizeupdate'])->name('prosizeupdate');

    //Origin
    Route::get('/inventory/product_origin', [App\Http\Controllers\InventoryController::class, 'productorigin'])->name('product_origin');
    Route::post('/inventory/product_origin', [App\Http\Controllers\InventoryController::class, 'originstore'])->name('originstore');
    Route::get('/inventory/product_origin/edit/{id}', [App\Http\Controllers\InventoryController::class, 'prooriginedit'])->name('prooriginedit');
    Route::post('/inventory/product_origin/{update}', [App\Http\Controllers\InventoryController::class, 'prooriginupdate'])->name('prooriginupdate');

    //Supplier Info
    Route::get('/inventory/supplier_info', [InventoryController::class, 'supplierinfo'])->name('supplier_info');
    Route::post('/inventory/supplier_info', [InventoryController::class, 'supplier_info_store'])->name('supplier_info_store');
    Route::get('/inventory/supplier_info/edit/{id}', [InventoryController::class, 'supplier_info_edit'])->name('supplier_info_edit');
    Route::post('/inventory/supplier_info/{update}', [InventoryController::class, 'supplier_info_update'])->name('supplier_info_update');

    //Warehouse / Store Details
    Route::get('/inventory/warehouse_info', [InventoryController::class, 'warehouse_info'])->name('warehouse_info');
    Route::post('/inventory/warehouse_store', [InventoryController::class, 'warehouse_store'])->name('warehouse_store');
    Route::get('/inventory/warehouse_edit/{id}', [InventoryController::class, 'warehouse_edit'])->name('warehouse_edit');
    Route::post('/inventory/warehouse_update/{id}', [InventoryController::class, 'warehouse_update'])->name('warehouse_update');

    //Requisition
    Route::get('/inventory/mt_requisition', [InventoryController::class, 'requisition'])->name('mt_requisition');
    Route::post('/inventory/requisition_store', [InventoryController::class, 'requisition_store'])->name('mt_requisition_store');
    Route::get('/inventory/requisition/product/{id}', [InventoryController::class, 'requisition_product'])->name('mt_requisition_product');
    Route::post('/inventory/requisition/add_product/{id}', [InventoryController::class, 'requisition_add_product'])->name('mt_requisition_add_product');
    Route::get('/inventory/requisition_ff/{id}', [InventoryController::class, 'requisition_finish'])->name('mt_requisition_finish');

    //Edit Requisition
    Route::get('/inventory/requisition_product_edit/{id}', [InventoryController::class, 'requisition_product_edit'])->name('requisition_product_edit');
    Route::post('/inventory/requisition_product_update/{id}', [InventoryController::class, 'requisition_product_update'])->name('requisition_product_update');

    //Admin Requation Approved and reject
    Route::get('/inventory/mt_requisition_admin_approved_list', [InventoryController::class, 'requisition_admin_approved_list'])->name('mt_requisition_admin_approved_list');
    Route::get('/inventory/requisition_admin_approved_details/{id}', [InventoryController::class, 'requisition_admin_approved_details'])->name('mt_requisition_admin_approved_details');
    Route::post('/inventory/requisition_admin_approved_final/{id}', [InventoryController::class, 'requisition_admin_approved_final'])->name('mt_requisition_admin_approved_final');
    Route::get('/inventory/requisition_admin_approved_reject', [InventoryController::class, 'requisition_admin_approved_reject'])->name('requisition_admin_approved_reject');
    

    //RPT Requisition All
    Route::get('/inventory/rpt_mt_requisition_all', [InventoryController::class, 'RPTRequisitionAll'])->name('rpt_mt_requisition_all');
    Route::get('/inventory/rpt_requisition_details/{id}', [InventoryController::class, 'RPTRequisitionDetails'])->name('mt_rpt_requisition_details');
    Route::post('/inventory/rpt_requisition_print/{id}', [InventoryController::class, 'RPTRequisitionPrint'])->name('rpt_requisition_print');
    Route::post('/inventory/rpt_search_requation', [InventoryController::class, 'RPTRequisitionSearch'])->name('mt_rpt_search_requation');


    //Ajax Requisition
    Route::get('/get/inventory/requisition/product_unit/{id}', [InventoryController::class, 'GetProductUnit']);
    Route::get('/get/inventory/supplier_details/{id}', [InventoryController::class, 'GetSupplierDetails']);
  

    //Fund Requistion
    Route::get('/inventory/fund_requisition', [InventoryController::class, 'fund_requisition'])->name('fund_requisition');
    Route::post('/inventory/fund_requisition_store', [InventoryController::class, 'fund_requisition_store'])->name('fund_requisition_store');
    Route::get('/inventory/fund_requisition_add_more/{id}', [InventoryController::class, 'fund_requisition_add_more'])->name('fund_requisition_add_more');
    Route::post('/inventory/fund_requisition_add_more_store/{id}', [InventoryController::class, 'fund_requisition_add_more_store'])->name('fund_requisition_add_more_store');
    Route::get('/inventory/fund_requisition_details/{id}', [InventoryController::class, 'fund_requisition_details'])->name('fund_requisition_details');
    Route::post('/inventory/fund_requisition_details_store/{id}', [InventoryController::class, 'fund_requisition_details_store'])->name('fund_requisition_details_store');
    Route::get('/inventory/fund_requisition_final/{id}', [InventoryController::class, 'fund_requisition_final'])->name('fund_requisition_final');

    //rpt fund Requisition
    Route::get('/inventory/rpt_fund_requisition_list', [InventoryController::class, 'rpt_fund_requisition_list'])->name('rpt_fund_requisition_list');
    Route::get('/inventory/rpt_fund_requisition_view/{id}', [InventoryController::class, 'rpt_fund_requisition_view'])->name('rpt_fund_requisition_view');
    Route::get('/inventory/rpt_fund_requisition_print/{id}', [InventoryController::class, 'rpt_fund_requisition_print'])->name('rpt_fund_requisition_print');
    Route::post('/inventory/rpt_fund_requisition_search', [InventoryController::class, 'rpt_fund_requisition_search'])->name('rpt_fund_requisition_search');

    //Fund Requistion
    Route::get('/inventory/fund_requisition_02', [InventoryController::class, 'fund_requisition_02'])->name('fund_requisition_02');
    Route::get('/inventory/fund_requisition_details_02/{id}', [InventoryController::class, 'fund_requisition_details_02'])->name('fund_requisition_details_02');
    Route::post('/inventory/fund_requisition_details_02_ok/{id}', [InventoryController::class, 'fund_requisition_details_02_ok'])->name('fund_requisition_details_02_ok');


    // Delivery challan
    Route::get('/inventory/mt_delivery_challan', [InventoryController::class, 'mt_delivery_challan'])->name('mt_delivery_challan');
    Route::get('/inventory/mt_delivery_challan_master/{id}', [InventoryController::class, 'mt_delivery_challan_master'])->name('mt_delivery_challan_master');
    Route::post('/inventory/mt_delivery_challan_store', [InventoryController::class, 'mt_delivery_challan_store'])->name('mt_delivery_challan_store');
    Route::get('/inventory/mt_delivery_challan_details/{id}', [InventoryController::class, 'mt_delivery_challan_details'])->name('mt_delivery_challan_details');
    Route::post('/inventory/mt_delivery_challan_details_store/{id}', [InventoryController::class, 'mt_delivery_challan_details_store'])->name('mt_delivery_challan_details_store');
    Route::get('/inventory/mt_delivery_challan_final/{id}', [InventoryController::class, 'mt_delivery_challan_final'])->name('mt_delivery_challan_final');

    //RPT Delivery challan
    Route::get('/inventory/rpt_mt_delivery_challan', [InventoryController::class, 'rpt_mt_delivery_challan'])->name('rpt_mt_delivery_challan');
    Route::get('/inventory/rpt_mt_delivery_datewise', [InventoryController::class, 'rpt_mt_delivery_datewise'])->name('rpt_mt_delivery_datewise');
    Route::get('/inventory/rpt_mt_delivery_challan_view/{id}', [InventoryController::class, 'rpt_mt_delivery_challan_view'])->name('rpt_mt_delivery_challan_view');
    Route::post('/inventory/rpt_mt_delivery_challan_print/{id}', [InventoryController::class, 'rpt_mt_delivery_challan_print'])->name('rpt_mt_delivery_challan_print');

    //Ajax Delivery challan
    Route::get('/get/dc/project_address/{id}', [InventoryController::class, 'GetDcProjectAddress']);
    Route::get('/get/dc/product_details/{product_id}/{requisition_master_id}/{store_id}', [InventoryController::class, 'GetDcProductDetails']);
    // End Delivery challan
    
    
    //Material Return
    Route::get('/inventory/material_return', [InventoryController::class, 'material_return'])->name('material_return');
    Route::post('/inventory/material_return_store', [InventoryController::class, 'material_return_store'])->name('material_return_store');
    Route::get('/inventory/material_return_details/{id}', [InventoryController::class, 'material_return_details'])->name('material_return_details');
    Route::post('/inventory/material_return_details_store', [InventoryController::class, 'material_return_details_store'])->name('material_return_details_store');
    Route::get('/inventory/material_return_final/{id}', [InventoryController::class, 'material_return_final'])->name('material_return_final');
    //challan number details -return product
    Route::get('/get/delivery_challan_details/{id}', [InventoryController::class, 'GetDeliveryChallanDetails']);
    //rpt Material Return 
    Route::get('/inventory/rpt_material_return', [InventoryController::class, 'rpt_material_return'])->name('rpt_material_return');
    Route::get('/inventory/rpt_material_return_datewise', [InventoryController::class, 'rpt_material_return_datewise'])->name('rpt_material_return_datewise');
    Route::get('/inventory/rpt_material_return_view/{id}', [InventoryController::class, 'rpt_material_return_view'])->name('rpt_material_return_view');
    //End Material Return

    //product stock close
    Route::get('/inventory/product_stock_month_close', [InventoryController::class, 'product_stock_month_close'])->name('product_stock_month_close');
    Route::post('/inventory/product_stock_month_close', [InventoryController::class, 'product_stock_month_close_final'])->name('product_stock_month_close');

    //Report product stock
    Route::get('/inventory/rpt_product_stock', [InventoryController::class, 'rpt_product_stock'])->name('rpt_product_stock');
    Route::get('/inventory/rpt_product_stock_list', [InventoryController::class, 'rpt_product_stock_list'])->name('rpt_product_stock_list');
    Route::get('/inventory/rpt_product_stock_details/{product}', [InventoryController::class, 'rpt_product_stock_details'])->name('rpt_product_stock_details');
    
    
    //product stock
    Route::get('/inventory/product_stock', [InventoryController::class, 'product_stock'])->name('product_stock');
    Route::post('/inventory/product_stock_store', [InventoryController::class, 'product_stock_store'])->name('product_stock_store');

    //Product transfer
    Route::get('/inventory/product_transfer', [InventoryController::class, 'product_transfer'])->name('product_transfer');
    Route::get('/get/product_stock_detail/{product_id}/{store_id}', [InventoryController::class, 'GetProductDetails']);
    Route::post('/inventory/product_transfer_store', [InventoryController::class, 'product_transfer_store'])->name('product_transfer_store');
  


   //End Inventory


});
