<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::group(['middleware' => 'auth','session.expired'], function () {

    Route::get('/get/alart_massage', function () {
        $m_employee  = Auth::user()->emp_id;
        $data = DB::table('pro_alart_massage')->where('report_to', $m_employee)->where('valid', 1)->get();
        return response()->json($data);
    })->name('alart_massage');

    Route::get('/remove/alart_massage/{id}', function ($id) {

        $m_employee  = Auth::user()->emp_id;
        if ($id == 0) {
            DB::table('pro_alart_massage')->where('report_to', $m_employee)->update(['valid' => 0]);
            return response()->json('allDelete');
        } else {
            DB::table('pro_alart_massage')->where('report_to', $m_employee)->where('alart_massage_id', $id)->update(['valid' => 0]);
            return response()->json('success');
        }
    });
}); //End Auth check


//dashboard service report
Route::get('/servicing_report', function () {
    $m_task_register = DB::table('pro_task_assign')
        ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_task_assign.customer_id")
        ->leftJoin("pro_projects", "pro_projects.project_id", "pro_task_assign.project_id")
        ->leftJoin("pro_complaint_register", "pro_task_assign.complain_id", "pro_complaint_register.complaint_register_id")
        ->select(
            "pro_task_assign.*",
            "pro_customers.customer_name",
            "pro_projects.project_name",
            "pro_complaint_register.complaint_description",
            "pro_complaint_register.user_id as assign_by"
        )
        ->where('pro_task_assign.complete_task', null)
        ->where('pro_task_assign.department_id', 1)
        ->where('pro_task_assign.valid', '1')
        ->orderByDesc('pro_task_assign.task_id')
        ->take(30)
        ->get();
    return view('servicing_report', compact('m_task_register'));
});

//Dashboard Maintenance report
Route::get('/maintenance_report', function () {
    $m_task_register = DB::table('pro_complaint_register')
        ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
        ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
        ->leftJoin("pro_task_assign", "pro_complaint_register.complaint_register_id", "pro_task_assign.complain_id")
        ->select(
            "pro_complaint_register.*",
            "pro_customers.customer_name",
            "pro_projects.project_name",
        )
        ->where('pro_complaint_register.department_id', 2)
        ->where('pro_complaint_register.valid', '1')
        ->where('pro_task_assign.complete_task', null)
        ->orderByDesc('pro_complaint_register.complaint_register_id')
        ->take(30)
        ->get();
    return view('maintenance_report', compact('m_task_register'));
});


// distance
Route::get('/distance', function () {
    // $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=23.7781399,90.3672009&destinations=23.7806808,90.40614";
    $url = "https://www.google.com/maps/dir/23.7781399,90.3672009/'23.7806808,90.40614'/@23.7728658,90.3659681,14z";
    // $ch = curl_init();
    // // Disable SSL verification

    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // // Will return the response, if false it print the response
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // // Set the url
    // curl_setopt($ch, CURLOPT_URL, $url);
    // // Execute
    // $result = curl_exec($ch);
    // // Closing
    // curl_close($ch);

    // $result_array = json_decode($result);
    // return print_r($result_array);
    return   $response = file_get_contents($url);
    // Decode the JSON data into an associative array
    $dataArray = json_decode($response, true);
});


//Clear route cache
Route::get('/route-clear', function () {
    \Artisan::call('route:clear');
    return 'Routes cleared';
});


// Clear view clear
Route::get('/view-clear', function () {
    \Artisan::call('view:clear');
    return 'View cleared';
});

//config clear
Route::get('/config-clear', function () {
    \Artisan::call('config:clear');
    return 'View cleared';
});

// Clear cache using optimize:clear
Route::get('/optimize-clear', function () {
    \Artisan::call('optimize:clear');
    return 'Optimize view, route, config cache cleared';
});


//SMS Test 

// Route::get('/smsDemoTest/{id}/{id2}', function ($id,$id2) {

//     $Message = "$id2";
//     $toUser = "$id";
//     $url = "http://103.53.84.15:8746/sendtext?apikey=6948f557699c4b79&secretkey=3c084517&callerID=sovereign&toUser=" . urlencode($toUser) . "&messageContent=" . urlencode($Message);
//     $response = file_get_contents($url);
//     return $dataArray = json_decode($response, true);
// });

// Route::get('/smsDemoTest02/{id}/{id2}', function ($id,$id2) {

//     $Message = "$id2";
//     $toUser = "$id";
//     $my_url = "http://103.53.84.15:8746/sendtext/6948f557699c4b79/3c084517";
//     $data = array();
//     $data['callerID']="cn";
//     $data['toUser']=$toUser;
//     $data['messageContent']=$Message;
//     $json = json_encode($data);
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_URL, $my_url);
//     $response = curl_exec($ch);
//     curl_close($ch);
//     // massage status check
//     return  $dataArray = json_decode($response, true);
// });



