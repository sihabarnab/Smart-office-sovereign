<?php

namespace App\Http\Controllers;

use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;

class SestController extends Controller

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/login",
     *     description="",
     *     tags={"login"},
     *     @OA\Parameter(
     *     in="query",
     *     name="employee_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *       )
     *      ),
     * 
     *     @OA\Parameter(
     *     in="query",
     *     name="password",
     *     required=true,
     *      ),
     * 
     *     @OA\Parameter(
     *     in="query",
     *     name="device_uid",
     *     required=false,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     * 
     *     @OA\Parameter(
     *     in="query",
     *     name="fcm_device_id",
     *     required=false,
     *    @OA\Schema(
     *        type="string",
     *       )
     *      ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     * mediaType="application/json",
     *      )
     *    ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="Alredy login"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="App is running in another device"
     *      )
     * 
     *   
     * )
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'status_code' => 422,
                'data' => NULL,
                'error' => 'input field is required',
            ], 422);
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
                    // ->where("device_uid", $request->device_uid)
                    // ->where("fcmdevice_id", $request->fcm_device_id)
                    ->first();

                if ($device->device_uid != null) {

                    if ($device->device_uid == $request->device_uid) {
                        DB::table('users')->where("emp_id", $request->employee_id)->update(['log_status' => 0]);
                       // $user_biodata = DB::table('pro_employee_biodata')->where("employee_id", $request->employee_id)->first();

                        $token =  $user->createToken('MyApp')->accessToken;
                        return response()->json([
                            'status' => "success",
                            'status_code' => 200,
                            'data' => [
                                'token' => $token,
                                'name' => $user->full_name,
                                'phone' => $user->phone,
                                'user_role' => $user_role,
                                'user_id' => $user->emp_id,
                                'device_id' => $user->device_uid,
                                'user_image' => NULL,
                            ],
                            'error' => '',
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'faild',
                            'status_code' => 404,
                            'data' => NULL,
                            'error' => 'App is running in another device',
                        ], 404);
                    }
                } else {
                    DB::table('users')->where("emp_id", $request->employee_id)->update([
                        'log_status' => 0,
                        // 'device_uid' => $request->device_uid,
                        'fcmdevice_id' => $request->fcm_device_id
                    ]);
                    //$user_biodata = DB::table('pro_employee_biodata')->where("employee_id", $request->employee_id)->first();
                    $token =  $user->createToken('MyApp')->accessToken;
                    return response()->json([
                        'status' => "success",
                        'status_code' => 200,
                        'data' => [
                            'token' => $token,
                            'name' => $user->full_name,
                            'phone' => $user->phone,
                            'user_role' => $user_role,
                            'user_id' => $user->emp_id,
                            'device_id' => $user->device_uid,
                            'user_image' => NULL,
                        ],
                        'error' => '',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'fail',
                    'status_code' => 402,
                    'data' => NULL,
                    'error' => "Alredy login",
                ], 402);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'status_code' => 401,
                'data' => NULL,
                'error' => 'Unauthenticated',
            ], 401);
        }
    }


    //Start Tasker Part

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\get(
     *     path="/smartoffice/api/v1/getAllTasks",
     *     description="",
     *     tags={"getAllTasks"},
     * security={
     *       {"passport": {}},
     *      },
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     * mediaType="application/json",
     *      )
     *    ),
     *  @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function getAllTasks()
    {
        $user = Auth::user();
        $data = DB::table('pro_task_assign')
            ->where('pro_task_assign.team_leader_id', $user->emp_id)
            ->where('pro_task_assign.complete_task', '=', NULL) // 1 is task complete
            ->join('pro_teams', 'pro_task_assign.team_id', 'pro_teams.team_id')
            ->join('pro_projects', 'pro_task_assign.project_id', 'pro_projects.project_id')
            ->join('pro_customers', 'pro_task_assign.customer_id', 'pro_customers.customer_id')
            ->join('pro_lifts', 'pro_task_assign.lift_id', 'pro_lifts.lift_id')
            ->join('pro_complaint_register', 'pro_task_assign.complain_id', 'pro_complaint_register.complaint_register_id')
            ->select(
                'pro_task_assign.task_id',
                'pro_teams.team_name',
                'pro_projects.project_name',
                'pro_projects.project_address',
                'pro_customers.customer_name',
                'pro_lifts.lift_name',
                'pro_complaint_register.complaint_description',
                'pro_task_assign.status',
                'pro_task_assign.latitude',
                'pro_task_assign.longitude',
                'pro_task_assign.journey_started_date_time',
                'pro_task_assign.task_started_date_time',
            )
            ->get();

        if (!$data->count()) {
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => NULL,
                'error' => '',
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => $data,
                'error' => '',
            ]);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/startJourney",
     *     description="",
     *     tags={"startJourney"},
     *    security={
     *       {"passport": {}},
     *      },
     *   @OA\Parameter(
     *     in="query",
     *     name="task_id",
     *     required=true,
     *     @OA\Schema(
     *        format="int64",
     *        type="integer",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     * 
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     *          mediaType="application/json",
     *          )
     *       ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function startJourney(Request $request)
    {
        // return date($request->date_time);
        $validator = Validator::make($request->all(), ['task_id' => 'required']);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'status_code' => 422, //422 UNPROCESSABLE ENTITY
                'data' => NULL,
                'error' => 'Validation Error',
            ], 422);
        }

        $data = array();
        $data['task_id'] = intval($request->task_id);
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['start_journey_lat'] = $request->latitude;
        $data['start_journey_long'] = $request->longitude;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $start_journey_date = date("Y-m-d", $seconds);
        $start_journey_time = date("H:i:s", $seconds);
        //
        $data['start_journey_date'] = $start_journey_date;
        $data['start_journey_time'] = $start_journey_time;
        $data['status'] = '1';
       $journey_id = DB::table('pro_journey')->insertGetId($data);
        // $m_transport_type = DB::table('pro_transport_type')->where('valid', 1)->select('pro_transport_type.transport_id', 'pro_transport_type.transport_name')->get();

        DB::table('pro_task_assign')
            ->where('task_id', intval($request->task_id))
            ->update([
                'status' => 'JOURNEY_STARTED',
                'journey_started_date_time' => date("Y-m-d H:i:s", $seconds),
            ]);

        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            // 'data' => ['task_id' => intval($request->task_id)],
            'data' => [
                'task_id' => intval($request->task_id),
                'journey_id'=>$journey_id,
            ],
            'error' => '',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/cancelJourney",
     *     description="",
     *     tags={"cancelJourney"},
     *    security={
     *       {"passport": {}},
     *      },
     *   @OA\Parameter(
     *     in="query",
     *     name="task_id",
     *     required=true,
     *     @OA\Schema(
     *        format="int64",
     *        type="integer",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     * 
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     *          mediaType="application/json",
     *          )
     *       ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function cancelJourney(Request $request)
    {
        $validator = Validator::make($request->all(), ['task_id' => 'required']);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'status_code' => 422, //422 UNPROCESSABLE ENTITY
                'data' => NULL,
                'error' => 'Validation Error',
            ], 422);
        }

        $data = array();
        $data['task_id'] = intval($request->task_id);
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['cancel_journey_lat'] = $request->latitude;
        $data['cancel_journey_long'] = $request->longitude;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $cancel_journey_date = date("Y-m-d", $seconds);
        $cancel_journey_time = date("H:i:s", $seconds);
        //
        $data['cancel_journey_date'] = $cancel_journey_date;
        $data['cancel_journey_time'] = $cancel_journey_time;
        $data['status'] = '1';
        $data['valid'] = '1';
        DB::table('pro_journey_cancel')->insert($data);

        DB::table('pro_task_assign')
            ->where('task_id', intval($request->task_id))
            ->update(['status' => "JOURNEY_FAILED"]);

        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'data' => NULL,
            'error' => '',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/endJourney",
     *     description="",
     *     tags={"endJourney"},
     *    security={
     *       {"passport": {}},
     *      }, 
     *     @OA\Parameter(
     *     in="query",
     *     name="task_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *        format="int64",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     *     @OA\Parameter(
     *     in="query",
     *     name="transport_type",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *     @OA\Parameter(
     *     in="query",
     *     name="fare",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *       )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(mediaType="application/json",),
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function endJourney(Request $request)
    {
        $validator = Validator::make($request->all(), ['task_id' => 'required']);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'status_code' => 422, //422 UNPROCESSABLE ENTITY
                'data' => NULL,
                'error' => 'Validation Error',
            ], 422);
        }

        //
        // https://www.google.com/maps/@23.751037,90.3643448 
        //23.751037 - lat
        //90.3643448  - long

        $m_journey = DB::table('pro_journey')
            ->where('task_id', intval($request->task_id))
            ->where('journey_id', intval($request->journey_id))
            ->where('status', '1')
            ->first();

        $data = array();
        $data['task_id'] = intval($request->task_id);
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['reached_lat'] =  $request->latitude;
        $data['reached_long'] = $request->longitude;
        $data['transport_type'] = $request->transport_type;
        $data['reached_fare'] =  $request->fare;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $reached_date = date("Y-m-d", $seconds);
        $reached_time = date("H:i:s", $seconds);
        //
        $data['reached_date'] = $reached_date;
        $data['reached_time'] = $reached_time;
        $data['status'] = '2';

        DB::table('pro_journey')
            ->where('journey_id',intval($request->journey_id))
            ->update($data);

        DB::table('pro_task_assign')
            ->where('task_id', intval($request->task_id))
            ->update(['status' => "JOURNEY_END"]); // 4 - endJourney

        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'data' => [
                'task_id' =>intval($request->task_id),
                'journey_id'=>intval($request->journey_id),
            ],
            'error' => '',
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/startTask",
     *     description="",
     *     tags={"startTask"},
     *    security={
     *       {"passport": {}},
     *      },
     *     @OA\Parameter(
     *     in="query",
     *     name="task_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *        format="int64",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * 
     *      @OA\RequestBody(
     *     required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object", 
     *               required={"image_1","image_2"},
     *               @OA\Property(
     *                  property="image_1",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_2",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_3",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_4",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_5",
     *                  type="file",
     *               ),
     *           ),
     *       )
     *     ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(mediaType="application/json",),
     *         ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function startTask(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'image_1' => 'required',
            'image_2' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'status_code' => 422, //422 UNPROCESSABLE ENTITY
                'data' => NULL,
                'error' => 'Validation Error',
            ], 422);
        }

        $data = array();
        $data['task_id'] = intval($request->task_id);
        $data['journey_id'] = intval($request->journey_id);
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['active_lat'] =  $request->latitude;
        $data['active_long'] = $request->longitude;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $active_date = date("Y-m-d", $seconds);
        $active_time = date("H:i:s", $seconds);
        //
        $data['active_date'] = $active_date;
        $data['active_time'] = $active_time;
        $data['status'] = '1';
	
	$data['image_1']='';
        $data['image_2']='';
        $data['image_3']='';
        $data['image_4']='';
        $data['image_5']='';

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

        DB::table('pro_task_assign')
            ->where('task_id', intval($request->task_id))
            ->update([
                'status' => "TASK_ACTIVE",
                'task_started_date_time' => date("Y-m-d H:i:s", $seconds),
            ]);

        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            // 'data' => ['task_id' => intval($request->task_id)],
            'data' => [
                'task_id' =>intval($request->task_id),
                'journey_id'=>intval($request->journey_id),
            ],

	        'image_1' =>  $data['image_1'],
            'image_2' =>  $data['image_2'],
            'image_3' =>  $data['image_3'],
            'image_4' =>  $data['image_4'],
            'image_5' =>  $data['image_5'],
            'error' => '',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/partiallyEndTask",
     *     description="",
     *     tags={"partiallyEndTask"},
     *    security={
     *       {"passport": {}},
     *      },
     *     @OA\Parameter(
     *     in="query",
     *     name="task_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *        format="int64",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     *     @OA\Parameter(
     *     in="query",
     *     name="description",
     *     required=true,
     *      @OA\Schema(
     *        type="string",
     *       )
     *      ),
     * 
     * @OA\RequestBody(
     *     required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object", 
     *               required={"image_1","image_2"},
     *               @OA\Property(
     *                  property="image_1",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_2",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_3",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_4",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_5",
     *                  type="file",
     *               ),
     *           ),
     *       )
     *     ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\mediaType(mediaType="application/json",),
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ) 
     * )
     */
    public function partiallyEndTask(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'faild',
                'status_code' => 422, //422 UNPROCESSABLE ENTITY
                'data' => NULL,
                'error' => 'Validation Error',
            ], 422);
        }

        $data = array();
        $data['task_id'] = intval($request->task_id);
        $data['journey_id'] = intval($request->journey_id);
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['incomplete_lat'] =  $request->latitude;
        $data['incomplete_long'] = $request->longitude;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $incomplete_date = date("Y-m-d", $seconds);
        $incomplete_time = date("H:i:s", $seconds);
        //
        $data['incomplete_date'] = $incomplete_date;
        $data['incomplete_time'] = $incomplete_time;
        $data['description'] = $request->description;
        $data['status'] = '2'; //incomplete

        //incomplite image
        $image_1 = $request->file('image_1');
        if ($request->hasFile('image_1')) {
            $filename =  $request->task_id . '01' . '.' . $request->file('image_1')->getClientOriginalExtension();
            $upload_path = "public/image/incomplete/";
            $image_url = $upload_path . $filename;
            $image_1->move($upload_path, $filename);
            $data['image_1'] = $image_url;
        }

        $image_2 = $request->file('image_2');
        if ($request->hasFile('image_2')) {
            $filename =  $request->task_id . '02' . '.' . $request->file('image_2')->getClientOriginalExtension();
            $upload_path = "public/image/incomplete/";
            $image_url = $upload_path . $filename;
            $image_2->move($upload_path, $filename);
            $data['image_2'] = $image_url;
        }

        $image_3 = $request->file('image_3');
        if ($request->hasFile('image_3')) {
            $filename =  $request->task_id . '03' . '.' . $request->file('image_3')->getClientOriginalExtension();
            $upload_path = "public/image/incomplete/";
            $image_url = $upload_path . $filename;
            $image_3->move($upload_path, $filename);
            $data['image_3'] = $image_url;
        }

        $image_4 = $request->file('image_4');
        if ($request->hasFile('image_4')) {
            $filename =  $request->task_id . '04' . '.' . $request->file('image_4')->getClientOriginalExtension();
            $upload_path = "public/image/incomplete/";
            $image_url = $upload_path . $filename;
            $image_4->move($upload_path, $filename);
            $data['image_4'] = $image_url;
        }

        $image_5 = $request->file('image_5');
        if ($request->hasFile('image_5')) {
            $filename = $request->task_id . '05' . '.' . $request->file('image_5')->getClientOriginalExtension();
            $upload_path = "public/image/incomplete/";
            $image_url = $upload_path . $filename;
            $image_5->move($upload_path, $filename);
            $data['image_5'] = $image_url;
        }

        DB::table('pro_task_assign')
            ->where('task_id', intval($request->task_id))
            ->update(['status' => "TASK_PARTIALLY_COMPLETED"]); // 6 - partiallyEndTask

        DB::table('pro_work_end')->insert($data);
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            // 'data' => ['task_id' => intval($request->task_id)],
            'data' => [
                'task_id' =>intval($request->task_id),
                'journey_id'=>intval($request->journey_id),
            ],
            'error' => '',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/completelyEndTask",
     *     description="",
     *     tags={"completelyEndTask"},
     *    security={
     *       {"passport": {}},
     *      }, 
     *     @OA\Parameter(
     *     in="query",
     *     name="task_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *        format="int64",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * 
     *      @OA\RequestBody(
     *     required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object", 
     *               required={"feedback","image_1","image_2"},
     *               @OA\Property(
     *                  property="feedback",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_1",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_2",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_3",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_4",
     *                  type="file",
     *               ),
     *               @OA\Property(
     *                  property="image_5",
     *                  type="file",
     *               ),
     *           ),
     *       )
     *     ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\mediaType(mediaType="application/json",),
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function completelyEndTask(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'image_1' => 'required',
            'image_2' => 'required',
            'feedback' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'status_code' => 422, //422 UNPROCESSABLE ENTITY
                'data' => NULL,
                'error' => 'Validation Error',
            ], 422);
        }
        $data = array();
        $data['task_id'] = intval($request->task_id);
        $data['journey_id'] = intval($request->journey_id);
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['complete_lat'] =  $request->latitude;
        $data['complete_long'] = $request->longitude;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $complete_date = date("Y-m-d", $seconds);
        $complete_time = date("H:i:s", $seconds);
        //
        $data['complete_date'] = $complete_date;
        $data['complete_time'] = $complete_time;
        $data['status'] = '1 ';

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

        DB::table('pro_task_assign')
            ->where('task_id', intval($request->task_id))
            ->update([
                'status' => "TASK_COMPLETED",
                'complete_task' => "1",  // completelyEndTask - 1
            ]);

        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            // 'data' => ['task_id' => intval($request->task_id)],
            'data' => [
                'task_id' =>intval($request->task_id),
                'journey_id'=>intval($request->journey_id),
            ],
            'error' => '',
        ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/endOfTheDay",
     *     description="",
     *     tags={"endOfTheDay"},
     *    security={
     *       {"passport": {}},
     *      },
     * 
     *   @OA\Parameter(
     *     in="query",
     *     name="latitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="longitude",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *       )
     *      ),
     *   @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * 
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\mediaType(mediaType="application/json",),
     *       ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function endOfTheDay(Request $request)
    {
        $user = Auth::user();
        $data = array();
        $data['user_id'] =  $user->emp_id;
        $data['day_end_lat'] =  $request->latitude;
        $data['day_end_long'] = $request->longitude;
        //
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;
        $day_end_date = date("Y-m-d", $seconds);
        $day_end_time = date("H:i:s", $seconds);
        //
        $data['day_end_date'] = $day_end_date;
        $data['day_end_time'] = $day_end_time;
        $data['status'] = '1';
        DB::table('pro_end_of_day')->insert($data);
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'data' => NULL,
            'error' => '',
        ]);
    }

    //End Tasker Part




    //Admin Part

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\get(
     *     path="/smartoffice/api/v1/getAllRequisition",
     *     description="",
     *     tags={"getAllRequisition"},
     * security={
     *       {"passport": {}},
     *      },
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     * mediaType="application/json",
     *      )
     *    ),
     *  @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */


    public function getAllRequisition()
    {
        $data = DB::table('pro_requisition_master')
            ->where('pro_requisition_master.status', '=', 2)
            ->join('pro_employee_biodata', 'pro_requisition_master.team_leader_id', 'pro_employee_biodata.employee_id')
            ->join('pro_task_assign', 'pro_requisition_master.task_id', 'pro_task_assign.task_id')
            ->join('pro_projects', 'pro_task_assign.project_id', 'pro_projects.project_id')
            ->select(
                'pro_requisition_master.requisition_master_id',
                'pro_employee_biodata.employee_name',
                'pro_projects.project_name',
                // 'pro_projects.project_address',
                // 'pro_complaint_register.complaint_description',
            )
            ->get();


        if (!$data->count()) {
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => NULL,
                'error' => '',
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => $data,
                'error' => '',
            ]);
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/requisitionAccept",
     *     description="",
     *     tags={"requisitionAccept"},
     * security={
     *       {"passport": {}},
     *      },
     * 
     * @OA\Parameter(
     *     in="query",
     *     name="requisition_master_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *       )
     *      ),
     *  @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     * mediaType="application/json",
     *      )
     *    ),
     *  @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function requisitionAccept(Request $request)
    {
        $data = DB::table('pro_requisition_details')
            ->where('requisition_master_id', '=', $request->requisition_master_id)
            ->update([
                'status' => 3, // 2 - Accept Requisition
            ]);

        // $all_details = DB::table('pro_requisition_details')
        // ->where('requisition_master_id', '=', $request->requisition_master_id)
        // ->get();

        // $approved_requistion = DB::table('pro_requisition_details')
        // ->where('requisition_master_id', '=', $request->requisition_master_id)
        // ->where('status','=',2) //Accept
        // ->orWhere('status','=',3) //Reject
        // ->get();

        $user = Auth::user();
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;

        DB::table('pro_requisition_master')
            ->where('requisition_master_id', '=', $request->requisition_master_id)
            ->update([
                'status' => 3, // 3 - requisition Complite
                'approved_id' => $user->emp_id,
                'approved_date_time' => date("Y-m-d H:i:s", $seconds),
            ]);

        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'data' => NULL,
            'error' => '',
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/requisitionReject",
     *     description="",
     *     tags={"requisitionReject"},
     * security={
     *       {"passport": {}},
     *      },
     * 
     * @OA\Parameter(
     *     in="query",
     *     name="requisition_master_id",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *       )
     *      ),
     * @OA\Parameter(
     *     in="query",
     *     name="date_time",
     *     required=true,
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     * mediaType="application/json",
     *      )
     *    ),
     *  @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function requisitionReject(Request $request)
    {
        $user = Auth::user();
        $milseconds = $request->date_time;
        $seconds = $milseconds / 1000;

        $data = DB::table('pro_requisition_details')
            ->where('requisition_master_id', '=', $request->requisition_master_id)
            ->update([
                'status' => 4, // 4 - Reject Requisition
            ]);

        // $all_details = DB::table('pro_requisition_details')
        // ->where('requisition_master_id', '=', $request->requisition_master_id)
        // ->get();

        // $approved_requistion = DB::table('pro_requisition_details')
        // ->where('requisition_master_id', '=', $request->requisition_master_id)
        // ->where('status','=',2) //Accept
        // ->orWhere('status','=',3) //Reject
        // ->get();


        DB::table('pro_requisition_master')
            ->where('requisition_master_id', '=', $request->requisition_master_id)
            ->update([
                'status' => 4, // 4 - requisition Not complite
                'approved_id' => $user->emp_id,
                'approved_date_time' => date("Y-m-d H:i:s", $seconds),
            ]);


        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'data' => NULL,
            'error' => '',
        ]);
    }

    //End Admin Part

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\post(
     *     path="/smartoffice/api/v1/logout",
     *     description="",
     *     tags={"logout"},
     * security={
     *       {"passport": {}},
     *      },
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\mediaType(
     * mediaType="application/json",
     *      )
     *     ),
     *       @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
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
                'status_code' => 200,
                'data' => ['message' => 'Successfull logout'],
                'error' => '',
            ]);
        } else {
            return response()->json([
                'status' => "faild",
                'status_code' => 401,
                'data' => NULL,
                'error' => 'Unauthenticated',
            ], 401);
        }
    }
}
