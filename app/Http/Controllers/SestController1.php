<?php

namespace App\Http\Controllers;

use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;

class SestController extends Controller

{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422',
                'data' => [],
                'error' => 'input field is required',
            ]);
        }

        if (Auth::attempt(['emp_id' => $request->employee_id, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->user_type == 1) {
                $user_role = "ADMIN";
            } elseif ($user->user_type == 2) {
                $user_role = "TASKER";
            }
            $m = $user->log_status;
            if ($m == '0') {
                $device = DB::table('users')
                    ->where("emp_id", $request->employee_id)
                    // ->where("device_uid", $request->deviceUID)
                    // ->where("fcmdevice_id", $request->fcmDeviceID)
                    ->first();

                if ($device->device_uid != null) {

                    if ($device->device_uid == $request->deviceUID) {
                        DB::table('users')->where("emp_id", $request->employee_id)->update(['log_status' => 1]);
                        $token =  $user->createToken('MyApp')->accessToken;
                        return response()->json([
                            'status' => "success",
                            'statuscode' => '200',
                            'data' => [
                                'token' => $token,
                                'name' => $user->full_name,
                                'phone' => $user->phone,
                                'user_role' => $user_role,
                                'user_id' => $user->emp_id,
                                'device_ID' => $user->device_uid,
                            ],
                            'error' => [],
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'faild',
                            'statuscode' => '404',
                            'data' => [],
                            'error' => 'App is running in another device',
                        ]);
                    }
                } else {
                    DB::table('users')->where("emp_id", $request->employee_id)->update([
                        'log_status' => 0,
                        'device_uid' => $request->deviceUID,
                        'fcmdevice_id' => $request->fcmDeviceID
                    ]);
                    $token =  $user->createToken('MyApp')->accessToken;
                    return response()->json([
                        'status' => "success",
                        'statuscode' => '200',
                        'data' => [
                            'token' => $token,
                            'name' => $user->full_name,
                            'phone' => $user->phone,
                            'user_role' => $user_role,
                            'user_id' => $user->emp_id,
                            'device_ID' => $user->device_uid,
                        ],
                        'error' => '',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'faild',
                    'statuscode' => '402',
                    'data' => [],
                    'error' => "Alredy login",
                ]);
            }
        } else {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '404',
                'data' => [],
                'error' => 'Unauthorised',
            ]);
        }
    }


    public function getActiveTaskInfo()
    {
    $user = Auth::user();
        $m_task_assign = DB::table('pro_task_assign')
        ->where('team_leader_id', $user->emp_id)
        ->where('status', 1)
        ->join('pro_projects', 'pro_task_assign.project_id', 'pro_projects.project_id')
        ->select('pro_task_assign.*', 'pro_projects.*' )
        ->first();

        $m_customer = DB::table('pro_customers')->where('customer_id',$m_task_assign->customer_id)->first();

        $m_lift = DB::table('pro_lifts')->where('lift_id',$m_task_assign->lift_id)->first();

        $m_team = DB::table('pro_teams')->where('team_id',$m_task_assign->team_id)->first();

        $m_complaint_register = DB::table('pro_complaint_register')->where('complaint_register_id',$m_task_assign->complain_id)->first();

// return $m_complaint_register->complaint_description;?
        $data=array();
        $data['team']= $m_team->team_name;
        $data['task_id']= $m_task_assign->task_assign_id;
        $data['project']= $m_task_assign->project_name;
        $data['project_address']= $m_task_assign->pro_address;
        $data['client']= $m_customer->customer_name;
        $data['lift']= $m_lift->lift_name;
        $data['description']= $m_complaint_register->complaint_description;


        //    return response()->json( $data);
        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => $data,
            'error' => '',
        ]);

        }

    public function startJourneyToActiveTask(Request $request)
    {

        $validator = Validator::make($request->all(), ['task_id' => 'required']);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422', //422 UNPROCESSABLE ENTITY
                'data' => [],
                'error' => 'Validation Error',
            ]);
        }

        $data = array();
        $data['task_id'] = $request->task_id;
        $data['start_journey_lat'] = $request->start_journey_lat;
        $data['start_journey_long'] = $request->start_journey_long;
        $data['start_journey_date'] = $request->start_journey_date;
        $data['start_journey_time'] = $request->start_journey_time;
        $data['status'] = '1';
        DB::table('pro_journey')->insert($data);
        $m_transport_type=DB::table('pro_transport_type')->where('valid',1)->select('pro_transport_type.transport_id','pro_transport_type.transport_name')->get();

        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => ['task_id' => $request->task_id,'transport_type' => $m_transport_type],
            // 'data2' => ['task_id' => $request->task_id],
            'error' => '',
        ]);
    }
    public function reachedActiveTaskDestination(Request $request)
    {

        $validator = Validator::make($request->all(), ['task_id' => 'required']);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422', //422 UNPROCESSABLE ENTITY
                'data' => [],
                'error' => 'Validation Error',
            ]);
        }

        //
        // https://www.google.com/maps/@23.751037,90.3643448 
        //23.751037 - lat
        //90.3643448  - long

        $m_journey = DB::table('pro_journey')
            ->where('task_id', $request->task_id)
            ->where('status', '1')
            ->first();

        $data = array();
        $data['task_id'] = $request->task_id;
        $data['reached_lat'] =  $request->reached_lat;
        $data['reached_long'] = $request->reached_long;
        $data['reached_date'] = $request->reached_date;
        $data['reached_time'] = $request->reached_time;
        $data['transport_id'] = $request->transport_id;
        $data['reached_fare'] =  $request->reached_fare;
        $data['status'] = '2';

        DB::table('pro_journey')
            ->where('journey_id', $m_journey->journey_id)
            ->update($data);

        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => [
                'task_id' => $request->task_id,
                // 'journey_id'=>$m_journey->journey_id,
            ],
            'error' => '',
        ]);
    }
    public function startActiveTask(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'image_1' => 'required',
            'image_2' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422', //422 UNPROCESSABLE ENTITY
                'data' => [],
                'error' => 'Validation Error',
            ]);
        }

        $data = array();
        $data['task_id'] = $request->task_id;
        $data['active_lat'] =  $request->active_lat;
        $data['active_long'] = $request->active_long;
        $data['active_date'] = $request->active_date;
        $data['active_time'] = $request->active_time;
        $data['status'] = '1';

        $image_1 = $request->file('image_1');
        if ($request->hasFile('image_1')) {
            $filename = $request->task_id . '01' . '.' . $request->file('image_1')->getClientOriginalExtension();
            $upload_path = "public/image/active/";
            $image_url = $upload_path . $filename;
            $image_1->move($upload_path, $filename);
            $data['image_1'] = $image_url;
        }

        $image_2 = $request->file('image_2');
        if ($request->hasFile('image_2')) {
            $filename = $request->task_id . '02' . '.' . $request->file('image_2')->getClientOriginalExtension();
            $upload_path = "public/image/active/";
            $image_url = $upload_path . $filename;
            $image_2->move($upload_path, $filename);
            $data['image_2'] = $image_url;
        }

        $image_3 = $request->file('image_3');
        if ($request->hasFile('image_3')) {
            $filename = $request->task_id . '03' . '.' . $request->file('image_3')->getClientOriginalExtension();
            $upload_path = "public/image/active/";
            $image_url = $upload_path . $filename;
            $image_3->move($upload_path, $filename);
            $data['image_3'] = $image_url;
        }

        $image_4 = $request->file('image_4');
        if ($request->hasFile('image_4')) {
            $filename = $request->task_id . '04' . '.' . $request->file('image_4')->getClientOriginalExtension();
            $upload_path = "public/image/active/";
            $image_url = $upload_path . $filename;
            $image_4->move($upload_path, $filename);
            $data['image_4'] = $image_url;
        }

        $image_5 = $request->file('image_5');
        if ($request->hasFile('image_5')) {
            $filename = $request->task_id . '05' . '.' . $request->file('image_5')->getClientOriginalExtension();
            $upload_path = "public/image/active/";
            $image_url = $upload_path . $filename;
            $image_5->move($upload_path, $filename);
            $data['image_5'] = $image_url;
        }

        DB::table('pro_work_start')->insert($data);

        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => ['task_id' => $request->task_id],
            'error' => '',
        ]);
    }
    public function activeTaskIncomplete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422', //422 UNPROCESSABLE ENTITY
                'data' => [],
                'error' => 'Validation Error',
            ]);
        }

        $data = array();
        $data['task_id'] = $request->task_id;
        $data['incomplete_lat'] =  $request->incomplete_lat;
        $data['incomplete_long'] = $request->incomplete_long;
        $data['incomplete_date'] = $request->incomplete_date;
        $data['incomplete_time'] = $request->incomplete_time;
        $data['description'] = $request->description;
        $data['status'] = '2'; //incomplete
        DB::table('pro_work_end')->insert($data);

        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => ['task_id' => $request->task_id],
            'error' => '',
        ]);
    }

    public function completedActiveTask(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'image_1' => 'required',
            'image_2' => 'required',
            'feedback' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422', //422 UNPROCESSABLE ENTITY
                'data' => [],
                'error' => 'Validation Error',
            ]);
        }
        $data = array();
        $data['task_id'] = $request->task_id;
        $data['complete_lat'] =  $request->complete_lat;
        $data['complete_long'] = $request->complete_long;
        $data['complete_date'] = $request->complete_date;
        $data['complete_time'] = $request->complete_time;
        $data['status'] = '1 '; //completed

        $feedback = $request->file('feedback');
        if ($request->hasFile('feedback')) {
            $filename =  $request->task_id . '.' . $request->file('feedback')->getClientOriginalExtension();
            $upload_path = "public/image/feedback/";
            $image_url = $upload_path . $filename;
            $feedback->move($upload_path, $filename);
            $data['feedback'] = $image_url;
        }


        $image_1 = $request->file('image_1');
        if ($request->hasFile('image_1')) {
            $filename =  $request->task_id . '01' . '.' . $request->file('image_1')->getClientOriginalExtension();
            $upload_path = "public/image/complited/";
            $image_url = $upload_path . $filename;
            $image_1->move($upload_path, $filename);
            $data['image_1'] = $image_url;
        }

        $image_2 = $request->file('image_2');
        if ($request->hasFile('image_2')) {
            $filename =  $request->task_id . '02' . '.' . $request->file('image_2')->getClientOriginalExtension();
            $upload_path = "public/image/complited/";
            $image_url = $upload_path . $filename;
            $image_2->move($upload_path, $filename);
            $data['image_2'] = $image_url;
        }

        $image_3 = $request->file('image_3');
        if ($request->hasFile('image_3')) {
            $filename =  $request->task_id . '03' . '.' . $request->file('image_3')->getClientOriginalExtension();
            $upload_path = "public/image/complited/";
            $image_url = $upload_path . $filename;
            $image_3->move($upload_path, $filename);
            $data['image_3'] = $image_url;
        }

        $image_4 = $request->file('image_4');
        if ($request->hasFile('image_4')) {
            $filename =  $request->task_id . '04' . '.' . $request->file('image_4')->getClientOriginalExtension();
            $upload_path = "public/image/complited/";
            $image_url = $upload_path . $filename;
            $image_4->move($upload_path, $filename);
            $data['image_4'] = $image_url;
        }

        $image_5 = $request->file('image_5');
        if ($request->hasFile('image_5')) {
            $filename = $request->task_id . '05' . '.' . $request->file('image_5')->getClientOriginalExtension();
            $upload_path = "public/image/complited/";
            $image_url = $upload_path . $filename;
            $image_5->move($upload_path, $filename);
            $data['image_5'] = $image_url;
        }
        DB::table('pro_work_end')->insert($data);

        // Finised task
        DB::table('pro_task_assign')
        ->where('task_assign_id', $request->task_id)
        ->update(['status' => '2']);

        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => ['task_id' => $request->task_id],
            'error' => '',
        ]);
    }

    public function partiallyCompletedActiveTask(Request $request)
    {
        //Done Status task_assign table
        DB::table('pro_task_assign')
            ->where('task_assign_id', $request->task_id)
            ->update(['status' => '2']);


        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => [],
            'error' => '',
        ]);
    }

    public function endOfTheDay(Request $request)
    {
           $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'statuscode' => '422', //422 UNPROCESSABLE ENTITY
                'data' => [],
                'error' => 'Validation Error',
            ]);
        }
        $data = array();
        $data['day_end_lat'] =  $request->day_end_lat;
        $data['user_id'] =  $request->user_id;
        $data['day_end_long'] = $request->day_end_long;
        $data['day_end_date'] = $request->day_end_date;
        $data['day_end_time'] = $request->day_end_time;
        $data['status'] = '1'; 
        DB::table('pro_end_of_day')->insert($data);
        return response()->json([
            'status' => 'success',
            'statuscode' => '200',
            'data' => [],
            'error' => '',
        ]);
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {
            $id = Auth::id();
            
            // return response()->json($id);
            DB::table('users')->where("id", $id)->update(['log_status' => 0]);
            // Auth::user()->token()->revoke();
            Token::where('user_id', $id)->update([
                'revoked' => true,
                // 'expires_at' => date('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'status' => "success",
                'statuscode' => "200",
                'data' => ['message' => 'Successfull logout'],
                'error' => '',
            ]);
        }else{
            return response()->json([
                'status' => "faild",
                'statuscode' => "401",
                'data' =>[],
                'error' => 'Unauthenticated',
            ]);
        }
    }
}
