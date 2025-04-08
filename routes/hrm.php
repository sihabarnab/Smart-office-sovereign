<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\HrmBackOfficeController;
//module
use App\Http\Controllers\ModuleController;



Route::group(['middleware' => 'auth','session.expired'], function () {

    Route::get('/hrm', [App\Http\Controllers\ModuleController::class, 'hrm'])->name('hrm');

    //--------------------------HRM Backoffice
    //Company
    Route::get('/hrm/company', [HrmBackOfficeController::class, 'hrmbackcompany'])->name('company');
    Route::post('/hrm/company', [HrmBackOfficeController::class, 'hrmbackcompanystore'])->name('hrmbackcompanystore');
    Route::get('/hrm/company/edit/{id}', [HrmBackOfficeController::class, 'hrmbackcompanyedit'])->name('hrmbackcompanyedit');
    Route::post('/hrm/company-up', [HrmBackOfficeController::class, 'hrmbackcompanyupdate'])->name('hrmbackcompanyupdate');

    //end Company

    //Designation
    Route::get('/hrm/designation', [HrmBackOfficeController::class, 'hrmbackdesignation'])->name('designation');
    Route::post('/hrm/designation', [HrmBackOfficeController::class, 'hrmbackdesignationstore'])->name('hrmbackdesignationstore');
    Route::get('/hrm/designation/edit/{id}', [HrmBackOfficeController::class, 'hrmbackdesignationedit'])->name('hrmbackdesignationedit');
    Route::post('/hrm/designation-up', [HrmBackOfficeController::class, 'hrmbackdesignationupdate'])->name('hrmbackdesignationupdate');
    //end Designation

    //department
    Route::get('/hrm/department', [HrmBackOfficeController::class, 'hrmbackdepartment'])->name('department');
    Route::post('/hrm/department', [HrmBackOfficeController::class, 'hrmbackdepartmentstore'])->name('hrmbackdepartmentstore');
    Route::get('/hrm/department/edit/{id}', [HrmBackOfficeController::class, 'hrmbackdepartmentedit'])->name('hrmbackdepartmentedit');
    Route::post('/hrm/department-up', [HrmBackOfficeController::class, 'hrmbackdepartmentupdate'])->name('hrmbackdepartmentupdate');
    //end department

    //section
    Route::get('/hrm/section', [HrmBackOfficeController::class, 'hrmbacksection'])->name('section');
    Route::post('/hrm/section', [HrmBackOfficeController::class, 'hrmbacksectionstore'])->name('hrmbacksectionstore');
    Route::get('/hrm/section/edit/{id}', [HrmBackOfficeController::class, 'hrmbacksectionedit'])->name('hrmbacksectionedit');
    Route::post('/hrm/section-up', [HrmBackOfficeController::class, 'hrmbacksectionupdate'])->name('hrmbacksectionupdate');
    //end Designation




    //place of posting
    Route::get('/hrm/placeposting', [HrmBackOfficeController::class, 'hrmbackplaceposting'])->name('placeposting');
    Route::post('/hrm/placeposting', [HrmBackOfficeController::class, 'hrmbackplace_postingstore'])->name('hrmbackplace_postingstore');
    Route::get('/hrm/placeposting/edit/{id}', [HrmBackOfficeController::class, 'hrmbackplace_postingedit'])->name('hrmbackplace_postingedit');
    Route::post('/hrm/placeposting/{update}', [HrmBackOfficeController::class, 'hrmbackplace_postingupdate'])->name('hrmbackplace_postingupdate');

    //end place of posting

    //Bio Device
    Route::get('/hrm/biodevice', [HrmBackOfficeController::class, 'hrmbackbio_device'])->name('biodevice');
    Route::post('/hrm/biodevice', [HrmBackOfficeController::class, 'hrmbackbio_devicestore'])->name('hrmbackbio_devicestore');
    Route::get('/hrm/biodevice/{id}', [HrmBackOfficeController::class, 'hrmbackbio_deviceedit'])->name('hrmbackbio_deviceedit');
    Route::post('/hrm/biodevice/{update}', [HrmBackOfficeController::class, 'hrmbackbio_deviceupdate'])->name('hrmbackbio_deviceupdate');
    //end Bio Device


    //policy
    Route::get('/hrm/policy', [HrmBackOfficeController::class, 'hrmbackpolicy'])->name('policy');
    Route::post('/hrm/policy', [HrmBackOfficeController::class, 'hrmbackpolicystore'])->name('hrmbackpolicystore');
    Route::get('/hrm/policy/{id}', [HrmBackOfficeController::class, 'hrmbackpolicyedit'])->name('hrmbackpolicyedit');
    Route::post('/hrm/policy/{update}', [HrmBackOfficeController::class, 'hrmbackpolicyupdate'])->name('hrmbackpolicyupdate');
    //end policy

    //holiday
    Route::get('/hrm/holiday', [HrmBackOfficeController::class, 'hrmbackholiday'])->name('holiday');
    Route::post('/hrm/holiday', [HrmBackOfficeController::class, 'hrmbackholidaystore'])->name('hrmbackholidaystore');
    Route::get('/hrm/holiday/{id}', [HrmBackOfficeController::class, 'hrmbackholidayedit'])->name('hrmbackholidayedit');
    Route::post('/hrm/holiday/{update}', [HrmBackOfficeController::class, 'hrmbackholidayupdate'])->name('hrmbackholidayupdate');



    //end holiday

    //basic_info
    Route::get('/hrm/basic_info', [HrmBackOfficeController::class, 'hrmbackbasic_info'])->name('basic_info');

    Route::post('/hrm/basic_info', [HrmBackOfficeController::class, 'hrmbackbasic_infostore'])->name('hrmbackbasic_infostore');

    Route::get('/hrm/basic_info/{id}', [HrmBackOfficeController::class, 'hrmbackbasic_infoedit'])->name('hrmbackbasic_infoedit');

    Route::post('/hrm/basic_info/{update}', [HrmBackOfficeController::class, 'hrmbackbasic_infoupdate'])->name('hrmbackbasic_infoupdate');

    Route::get('/hrm/basic_info/{company_id}', [HrmBackOfficeController::class, 'hrmbackbasic_company_id'])->name('hrmbackbasic_company_id');

    //end basic_info

    //bio_data
    Route::get('/hrm/bio_data', [HrmBackOfficeController::class, 'hrmbackbio_data'])->name('bio_data');
    Route::post('/hrm/bio_data', [HrmBackOfficeController::class, 'hrmbio_datastore'])->name('hrmbio_datastore');


    //employee_attendance report
    Route::get('/hrm/companyEmployee/{id}', [HrmBackOfficeController::class, 'companyEmployee'])->name('companyEmployee');

    // Route::post('/hrm/bio_data', [HrmBackOfficeController::class, 'hrmbackbio_datastore'])->name('hrmbackbio_datastore');

    Route::get('/hrm/bio_data/{id}', [HrmBackOfficeController::class, 'hrmbio_dataedit'])->name('hrmbio_dataedit');

    Route::post('/hrm/bio_data/{update}', [HrmBackOfficeController::class, 'hrmbio_dataupdate'])->name('hrmbio_dataupdate');


    Route::get('/biodata_file/{emp_id}', [HrmBackOfficeController::class, 'biodata_file'])->name('biodata_file');
    Route::post('/biodata_file', [HrmBackOfficeController::class, 'biodata_file_store'])->name('biodata_file_store');

    //Educational qualification
    Route::get('/educational_qualification/{emp_id}', [HrmBackOfficeController::class, 'educational_qualification'])->name('educational_qualification');
    Route::post('/educational_qualification', [HrmBackOfficeController::class, 'educational_qualification_store'])->name('educational_qualification_store');

    //Professional Training
    Route::get('/professional_training/{emp_id}', [HrmBackOfficeController::class, 'professional_training'])->name('professional_training');
    Route::post('/professional_training', [HrmBackOfficeController::class, 'professional_training_store'])->name('professional_training_store');

    //Experience
    Route::get('/experience/{emp_id}', [HrmBackOfficeController::class, 'experience'])->name('experience');
    Route::post('/experience', [HrmBackOfficeController::class, 'experience_store'])->name('experience_store');

    // biodata print -web
    // Route::get('/biodata/{employee_id}', [HrmBackOfficeController::class, 'biodata'])->name('biodata');

    Route::get('/biodata_print/{emp_id}', [HrmBackOfficeController::class, 'biodata'])->name('biodata_print');



    //end bio_data

    //salary_info
    Route::get('/hrm/salary_info', [HrmBackOfficeController::class, 'hrmbacksalary_info'])->name('salary_info');
    //end salary_info

    //employee_clossing
    Route::get('/hrm/employee_clossing', [HrmBackOfficeController::class, 'hrmbackemployee_clossing'])->name('employee_clossing');
    Route::post('/hrm/employee_clossing', [HrmBackOfficeController::class, 'hrmemp_closingstore'])->name('hrmemp_closingstore');


    //end employee_clossing

    //attn_payroll_status
    Route::get('/hrm/attn_payroll_status', [HrmBackOfficeController::class, 'hrmbackattn_payroll_status'])->name('attn_payroll_status');
    //end attn_payroll_status

    //Own Password Change
    Route::get('/hrm/profile', [HrmBackOfficeController::class, 'EmpProfile'])->name('profile');
    Route::get('/hrm/changepass', [HrmBackOfficeController::class, 'ResetPass'])->name('changepass');
    Route::post('/hrm/changepass', [HrmBackOfficeController::class, 'ResetPassstore'])->name('ResetPassstore');

    //leave_type
    Route::get('/hrm/leave_type', [HrmBackOfficeController::class, 'hrmbackleave_type'])->name('leave_type');

    Route::post('/hrm/leave_type', [HrmBackOfficeController::class, 'hrmbackleave_typestore'])->name('hrmbackleave_typestore');

    Route::get('/hrm/leave_type/{id}', [HrmBackOfficeController::class, 'hrmbackleave_typeedit'])->name('hrmbackleave_typeedit');

    Route::post('/hrm/leave_type/{update}', [HrmBackOfficeController::class, 'hrmbackleave_typeupdate'])->name('hrmbackleave_typeupdate');

    //end leave_type

    //leave_config

    Route::get('/hrm/leave_config', [HrmBackOfficeController::class, 'hrmbackleave_config'])->name('leave_config');

    Route::post('/hrm/leave_config', [HrmBackOfficeController::class, 'hrmbackleave_configstore'])->name('hrmbackleave_configstore');

    Route::get('/hrm/leave_config/{id}', [HrmBackOfficeController::class, 'hrmbackleave_configedit'])->name('hrmbackleave_configedit');

    Route::post('/hrm/leave_config/{update}', [HrmBackOfficeController::class, 'hrmbackleave_configupdate'])->name('hrmbackleave_configupdate');

    //end leave_config

    //leave_application
    Route::get('/hrm/leave_application', [HrmBackOfficeController::class, 'hrmbackleave_application'])->name('leave_application');

    Route::post('/hrm/leave_application', [HrmBackOfficeController::class, 'hrmbackleave_applicationstore'])->name('hrmbackleave_applicationstore');

    //end leave_application

    //leave_approval
    Route::get('/hrm/leave_approval', [HrmBackOfficeController::class, 'hrmbackleave_approval'])->name('leave_approval');

    Route::get('/hrm/leave_app_for_approval/{id}', [HrmBackOfficeController::class, 'hrmleave_app_approval'])->name('hrmleave_app_approval');

    Route::post('/hrm/leave_app_for_approval/{update}', [HrmBackOfficeController::class, 'hrmleave_appupdate'])->name('hrmleave_appupdate');

    //end leave_approval

    //movement
    Route::get('/hrm/movement', [HrmBackOfficeController::class, 'hrmbackmovement'])->name('movement');
    Route::post('/hrm/movement', [HrmBackOfficeController::class, 'hrmlate_applicationstore'])->name('hrmlate_applicationstore');

    //end movement

    //movement_approval
    Route::get('/hrm/movement_approval', [HrmBackOfficeController::class, 'hrmmovement_approval'])->name('movement_approval');
    Route::get('/hrm/move_app_for_approval/{id}', [HrmBackOfficeController::class, 'hrmmove_app_approval'])->name('hrmmove_app_approval');
    Route::post('/hrm/move_app_for_approval/{update}', [HrmBackOfficeController::class, 'hrmmove_appupdate'])->name('hrmmove_appupdate');

    //end movement_approval

    //data_sync
    Route::get('/hrm/data_sync', [HrmBackOfficeController::class, 'hrmbackdata_sync'])->name('data_sync');

    Route::post('/hrm/data_sync', [HrmBackOfficeController::class, 'hrmbackdata_syncstore'])->name('hrmbackdata_syncstore');




    //end data_sync

    //attendance_process
    Route::get('/hrm/attendance_process', [HrmBackOfficeController::class, 'hrmbackattendance_process'])->name('attendance_process');

    Route::post('/hrm/attendance_process', [HrmBackOfficeController::class, 'hrmbackattendance_processstore'])->name('hrmbackattendance_processstore');

    Route::post('/hrm/emp_atten_re_process', [HrmBackOfficeController::class, 'atten_re_process'])->name('emp_atten_re_process');

    //end attendance_process

    //leave_process
    Route::get('/hrm/leave_process', [HrmBackOfficeController::class, 'hrmbackleave_process'])->name('leave_process');
    Route::post('/hrm/leave_process', [HrmBackOfficeController::class, 'hrm_leave_process'])->name('hrm_leave_process');
    //end leave_process

    //movement_process
    Route::get('/hrm/movement_process', [HrmBackOfficeController::class, 'hrmbackmovement_process'])->name('movement_process');
    Route::post('/hrm/movement_process', [HrmBackOfficeController::class, 'hrm_movement_process'])->name('hrm_movement_process');
    //end movement_process

    //summary_process
    Route::get('/hrm/summary_process', [HrmBackOfficeController::class, 'hrmbacksummary_process'])->name('summary_process');

    Route::post('/hrm/summary_process', [HrmBackOfficeController::class, 'hrmbacksummary_processstore'])->name('hrmbacksummary_processstore');


    //end summary_process

    //payroll_process
    Route::get('/hrm/payroll_process', [HrmBackOfficeController::class, 'hrmbackpayroll_process'])->name('payroll_process');
    //end payroll_process

    //summery_attendance report
    Route::get('/hrm/summary_attendance', [HrmBackOfficeController::class, 'hrmbacksummary_attendance'])->name('summary_attendance');

    Route::post('/hrm/summary_attendance', [HrmBackOfficeController::class, 'hrmbacksummary_attendance_report'])->name('hrmbacksummary_attendance_report');


    //end summery_attendance

    //attendance report
    Route::get('/hrm/rpt_atten_ind', [HrmBackOfficeController::class, 'hrmattenind'])->name('rpt_atten_ind');
    Route::post('/hrm/rpt_atten_ind_show', [HrmBackOfficeController::class, 'hrmattenindrpt'])->name('hrmattenindrpt');
    //end attendance

    //employee_attendance report
    Route::get('/hrm/postingEmployee/{id}', [HrmBackOfficeController::class, 'postingEmployee'])->name('postingEmployee');

    Route::get('/hrm/postingEmployee1/{id}', [HrmBackOfficeController::class, 'postingEmployee1'])->name('postingEmployee1');



    Route::get('/hrm/employee_attendance', [HrmBackOfficeController::class, 'hrmbackemployee_attendance'])->name('employee_attendance');
    Route::post('/hrm/emp_attn_report', [HrmBackOfficeController::class, 'hrmbackemp_attn_report'])->name('hrmbackemp_attn_report');

    //end employee_attendance

    //employee punch report
    Route::get('/hrm/daily_punch', [HrmBackOfficeController::class, 'hrmbackdaily_punch'])->name('daily_punch');
    Route::post('/hrm/emp_punch_report', [App\Http\Controllers\HrmBackOfficeController::class, 'hrmbackdaily_punch_report'])->name('hrmbackdaily_punch_report');

    //end employee punch report

    //leave_application_list
    Route::get('/hrm/leave_application_list', [HrmBackOfficeController::class, 'hrmbackleave_application_list'])->name('leave_application_list');
    //end leave_application_list


    //end HRM 


    //AJAX ONLY 
       
    Route::get('get/employee/{id}', [HrmBackOfficeController::class, 'GetEmployee']);

});
