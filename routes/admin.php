<?php

use Illuminate\Support\Facades\Route;
//Admin
use App\Http\Controllers\AdminController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {

    Route::get('/admin', [App\Http\Controllers\ModuleController::class, 'admin'])->name('admin');

    //----------------------------Admin User Management
    //User
    Route::get('/admin/create_user', [App\Http\Controllers\AdminController::class, 'admincuser'])->name('create_user');
    Route::post('/admin/create_user', [App\Http\Controllers\AdminController::class, 'admincuserstore'])->name('admincuserstore');
    Route::get('/admin/create_user/{id}', [App\Http\Controllers\AdminController::class, 'admincuseredit'])->name('admincuseredit');
    Route::post('/admin/create_user/{update}', [App\Http\Controllers\AdminController::class, 'admincuserupdate'])->name('admincuserupdate');
    Route::get('/admin/user_permission/{id}', [App\Http\Controllers\AdminController::class, 'admincuser_permission'])->name('admincuser_permission');

    Route::get('/admin/moduleMainMenu/{id}', [App\Http\Controllers\AdminController::class, 'moduleMainMenu'])->name('moduleMainMenu');

    //User Module and company
    Route::get('admin/user_module_and_company', [AdminController::class, 'UserModuleCompany'])->name('user_module_and_company');
    Route::post('/user_mc_list', [AdminController::class, 'user_mc_list'])->name('user_mc_list');
    //Module
    Route::get('admin/user_module_edit/{emp_id}', [AdminController::class, 'user_module_edit'])->name('user_module_edit');
    Route::post('admin/user_module_update/{emp_id}', [AdminController::class, 'user_module_update'])->name('user_module_update');
    //company
    Route::get('admin/user_company_edit/{emp_id}', [AdminController::class, 'user_company_edit'])->name('user_company_edit');
    Route::post('admin/user_company_update/{emp_id}', [AdminController::class, 'user_company_update'])->name('user_company_update');

    //User Menu Permission
    Route::get('admin/user_menu_permission', [AdminController::class, 'user_menu_permission'])->name('user_menu_permission');
    Route::get('admin/user_menu_permission_list', [AdminController::class, 'user_menu_permission_list'])->name('user_menu_permission_list');
    Route::get('admin/module_all_menu_permission', [AdminController::class, 'module_all_menu_permission'])->name('module_all_menu_permission');
    Route::get('admin/main_menu_all_permission', [AdminController::class, 'main_menu_all_permission'])->name('main_menu_all_permission');
    Route::get('admin/sub_menu_wise_permission', [AdminController::class, 'sub_menu_wise_permission'])->name('sub_menu_wise_permission');

    //user menu create
    Route::get('admin/user_menu_create', [AdminController::class, 'user_menu_create'])->name('user_menu_create');
    Route::get('admin/user_menu_store', [AdminController::class, 'user_menu_store'])->name('user_menu_store');
    Route::get('admin/user_menu_edit/{id}', [AdminController::class, 'user_menu_edit'])->name('user_menu_edit');
    Route::post('admin/user_menu_update/{id}', [AdminController::class, 'user_menu_update'])->name('user_menu_update');

    //user paassword reset
    Route::get('admin/user_password_reset', [AdminController::class, 'user_password_reset'])->name('user_password_reset');
    Route::post('admin/user_password_update', [AdminController::class, 'user_password_update'])->name('user_password_update');



    //AJAX ADMIN 
    Route::get('/get/company/{id}', [AdminController::class, 'GetCompany']);
    Route::get('get/employee1/{id}', [AdminController::class, 'GetEmployee1']);
    Route::get('/get/main_menu/{id}', [AdminController::class, 'GetMainMenu']);
});
