<?php

namespace App\Http\Controllers;

use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class WorkerController extends Controller
{
    public function getAllTasks()
    {
        $m_employee = Auth::user()->emp_id;
        $cancel_task_id = DB::table('pro_journey_cancel')->pluck('task_id');
        //last 30 day 
        $today = date("Y-m-d");
        $previous30day = date("Y-m-d", strtotime("-30 day", strtotime($today)));

        $data = DB::table('pro_task_assign')
            ->where('pro_task_assign.team_leader_id', $m_employee)
            ->where('pro_task_assign.complete_task', '=', NULL) // 1 is task complete
            ->whereNotIn("pro_task_assign.task_id", $cancel_task_id)
            ->leftjoin('pro_employee_info', 'pro_task_assign.team_leader_id', 'pro_employee_info.employee_id')
            ->leftjoin('pro_projects', 'pro_task_assign.project_id', 'pro_projects.project_id')
            ->leftjoin('pro_customers', 'pro_task_assign.customer_id', 'pro_customers.customer_id')
            ->leftjoin('pro_lifts', 'pro_task_assign.lift_id', 'pro_lifts.lift_id')
            ->leftjoin('pro_complaint_register', 'pro_task_assign.complain_id', 'pro_complaint_register.complaint_register_id')
            ->select(
                'pro_task_assign.task_id',
                'pro_task_assign.department_id',
                'pro_task_assign.entry_date',
                'pro_task_assign.entry_time',
                'pro_employee_info.employee_name as team_name',
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
            ->whereBetween('pro_task_assign.entry_date', [$previous30day, $today])
            ->orderByDesc('task_id')
            ->get();

        return view('worker.home', compact('data'));
    }

    public function startJourney(Request $request)
    {
        $task_id = $request->txt_task_id;
        $m_task = DB::table('pro_task_assign')
            ->where('task_id', $task_id)
            ->first();

        $data = array();
        $data['task_id'] = $task_id;
        $data['employee_id'] =  Auth::user()->emp_id;
        $data['team_leader_id'] =  $m_task->team_leader_id;
        $data['start_journey_lat'] = $request->latitude;
        $data['start_journey_long'] = $request->longitude;
        $data['start_journey_date'] = date("Y-m-d");
        $data['start_journey_time'] = date("H:i:s");
        $data['status'] = '1';
        $journey_id = DB::table('pro_journey')->insertGetId($data);

        if ($journey_id) {
            DB::table('pro_task_assign')
                ->where('task_id', $task_id)
                ->update([
                    'status' => 'JOURNEY_STARTED',
                    'journey_started_date_time' => date("Y-m-d H:i:s"),
                ]);

            return back()->with('success', 'Start Journey Successfull!');
        } else {
            return back()->with('warning', "Consult for developer");
        }
    }

    public function openEndJourney(Request $request)
    {
        $task_id = $request->txt_task_id;
        $m_journey = DB::table('pro_journey')
            ->where('task_id', $task_id)
            ->orderByDesc('journey_id')
            ->first();

        if ($m_journey) {
            $journey_id = $m_journey->journey_id;
            return view('worker.journey', compact('task_id', 'journey_id'));
        } else {
            return back()->with('warning', "Consult for developer");
        }
    }

    public function endJourney(Request $request)
    {

        $rules = [
            'cbo_transport_type' => 'required',
            'txt_fare' => 'required',
        ];
        $customMessages = [
            'cbo_transport_type.required' => 'Transport Type is required!',
            'txt_fare.required' => 'Fare is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_journey = DB::table('pro_journey')
            ->where('journey_id', $request->taxt_journey_id)
            ->where('task_id', $request->taxt_task_id)
            ->orderByDesc('journey_id')
            ->first();

        if (isset($m_journey)) {
            if (isset($m_journey->reached_fare)) {
                return redirect()->route('worker')->with('warning', 'Data Alredy Inserted!');
            } else {
                $data = array();
                $data['task_id'] = $request->taxt_task_id;
                $data['employee_id'] =  Auth::user()->emp_id;
                $data['reached_lat'] =  $request->latitude;
                $data['reached_long'] = $request->longitude;
                $data['transport_type'] = $request->cbo_transport_type;
                $data['reached_fare'] =  $request->txt_fare;
                $data['reached_date'] = date("Y-m-d");
                $data['reached_time'] = date("H:i:s");
                $data['status'] = '2';
                DB::table('pro_journey')
                    ->where('journey_id', $request->taxt_journey_id)
                    ->update($data);

                DB::table('pro_task_assign')
                    ->where('task_id', intval($request->taxt_task_id))
                    ->update(['status' => "JOURNEY_END"]); // 4 - endJourney
                return redirect()->route('worker')->with('success', 'End Journey Successfull!');
            }
        } else {

            return back()->with('warning', "Consult for developer");
        }
    }


    public function openStartTask(Request $request)
    {
        $task_id = $request->txt_task_id;
        $m_journey = DB::table('pro_journey')
            ->where('task_id', $task_id)
            ->orderByDesc('journey_id')
            ->first();

        if ($m_journey) {
            $journey_id = $m_journey->journey_id;
            return view('worker.start_task', compact('task_id', 'journey_id'));
        } else {
            return back()->with('warning', "Consult for developer");
        }
    }



    //Image one Upload
    public function startTaskFirstImageUpload(Request $request)
    {

        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit
        // ini_set('memory_limit', '256M');

        $rules = [
            'image_1' => 'required',
        ];
        $customMessages = [
            'image_1.required' => 'Image O1 is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $dataAlredyCopy = DB::table('pro_work_start')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->first();

        if (isset($dataAlredyCopy) && isset($dataAlredyCopy->image_1)) {
            return redirect()->route('worker')->with('warning', 'Data Alredy Inserted!');
        } else {

            $data = array();
            $data['task_id'] = $request->task_id;
            $data['journey_id'] = $request->journey_id;
            $data['employee_id'] =  Auth::user()->emp_id;
            $data['active_lat'] =  $request->latitude;
            $data['active_long'] = $request->longitude;
            $data['active_date'] = date("Y-m-d");
            $data['active_time'] = date("H:i:s");
            $data['status'] = '1';

            $manager = new ImageManager(new Driver());

            if ($request->hasFile('image_1')) {
                $img_01 = $manager->read($request->file('image_1'));
                $img_01 = $img_01->resize(800, 500);
                $filename1 = $request->task_id . '01' . $request->journey_id . '.' . $request->file('image_1')->getClientOriginalExtension();
                $img_01->toJpeg(80)->save(public_path("image/active/$filename1"));
                $image_url = "public/image/active/" . $filename1;
                $data['image_1'] = $image_url;
            }

            DB::table('pro_work_start')->insert($data);
            return back()->with('success', 'First Image Upload Successfull!');
        }
    }
    //Image Two Upload
    public function startTaskSecondImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_2' => 'required',
        ];
        $customMessages = [
            'image_2.required' => 'Image 02 is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $image_2_check = DB::table('pro_work_start')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->first();

        $manager = new ImageManager(new Driver());
        if ($request->hasFile('image_2')) {
            $img_02 = $manager->read($request->file('image_2'));
            $img_02 = $img_02->resize(800, 500);
            $filename2 = $request->task_id . '02' . $request->journey_id . '.' . $request->file('image_2')->getClientOriginalExtension();
            $img_02->toJpeg(80)->save(public_path("image/active/$filename2"));
            $image_url = "public/image/active/" . $filename2;
            $data['image_2'] = $image_url;
        }
        DB::table('pro_work_start')->where('work_start_id', $image_2_check->work_start_id)->update($data);
        return back()->with('success', 'Second Image Upload Successfull!');
    }
    //Image Three Upload
    public function startTaskThirdImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_3' => 'required',
        ];
        $customMessages = [
            'image_3.required' => 'Image 03 is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $image_2_check = DB::table('pro_work_start')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->first();


        $manager = new ImageManager(new Driver());
        if ($request->hasFile('image_3')) {
            $img_03 = $manager->read($request->file('image_3'));
            $img_03 = $img_03->resize(800, 500);
            $filename3 = $request->task_id . '03' . $request->journey_id . '.' . $request->file('image_3')->getClientOriginalExtension();
            $img_03->toJpeg(80)->save(public_path("image/active/$filename3"));
            $image_url = "public/image/active/" . $filename3;
            $data['image_3'] = $image_url;
        }
        DB::table('pro_work_start')->where('work_start_id', $image_2_check->work_start_id)->update($data);
        return back()->with('success', 'Image 03 Upload Successfull!');
    }

    //Image Four Upload
    public function startTaskFourthImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_4' => 'required',
        ];
        $customMessages = [
            'image_4.required' => 'Image 04 is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $image_2_check = DB::table('pro_work_start')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->first();

        $manager = new ImageManager(new Driver());
        if ($request->hasFile('image_4')) {
            $img_04 = $manager->read($request->file('image_4'));
            $img_04 = $img_04->resize(800, 500);
            $filename4 = $request->task_id . '04' . $request->journey_id . '.' . $request->file('image_4')->getClientOriginalExtension();
            $img_04->toJpeg(80)->save(public_path("image/active/$filename4"));
            $image_url = "public/image/active/" . $filename4;
            $data['image_4'] = $image_url;
        }
        DB::table('pro_work_start')->where('work_start_id', $image_2_check->work_start_id)->update($data);
        return back()->with('success', 'Image 04 Upload Successfull!');
    }

    //Image Five Upload
    public function startTaskFifthImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_5' => 'required',
        ];
        $customMessages = [
            'image_5.required' => 'Image 02 is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $image_2_check = DB::table('pro_work_start')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->first();

        $manager = new ImageManager(new Driver());
        if ($request->hasFile('image_5')) {
            $img_05 = $manager->read($request->file('image_5'));
            $img_05 = $img_05->resize(800, 500);
            $filename5 = $request->task_id . '05' . $request->journey_id . '.' . $request->file('image_5')->getClientOriginalExtension();
            $img_05->toJpeg(80)->save(public_path("image/active/$filename5"));
            $image_url = "public/image/active/" . $filename5;
            $data['image_5'] = $image_url;
        }
        DB::table('pro_work_start')->where('work_start_id', $image_2_check->work_start_id)->update($data);
        return back()->with('success', 'Image 05 Upload Successfull!');
    }


    public function startTask(Request $request)
    {
        DB::table('pro_task_assign')
            ->where('task_id', $request->task_id)
            ->update([
                'status' => "TASK_ACTIVE",
                'task_started_date_time' => date("Y-m-d H:i:s"),
            ]);
        return redirect()->route('worker')->with('success', 'Start Task Successfull!');
    }


    public function openCompletelyEndTask(Request $request)
    {
        $task_id = $request->txt_task_id;
        $m_journey = DB::table('pro_journey')
            ->where('task_id', $task_id)
            ->orderByDesc('journey_id')
            ->first();

        if ($m_journey) {
            $journey_id = $m_journey->journey_id;
            return view('worker.complete_task', compact('task_id', 'journey_id'));
        } else {
            return back()->with('warning', "Consult for developer");
        }
    }

    //

    public function ensTaskFirstImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit



        $rules = [
            'image_1' => 'required',
        ];
        $customMessages = [
            'image_1.required' => 'Image O1 is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $manager = new ImageManager(new Driver());
        $dataAlredyCopy = DB::table('pro_work_end')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->where('status', 1)
            ->first();

        if (isset($dataAlredyCopy)) {
            return back()->with('warning', 'Data Alredy Inserted!');
        } else {
            $data = array();
            $data['task_id'] = $request->task_id;
            $data['journey_id'] = $request->journey_id;
            $data['employee_id'] =  Auth::user()->emp_id;
            $data['status'] = '1'; //Status 1 complite task
            if ($request->hasFile('image_1')) {
                $image_1 = $manager->read($request->file('image_1'));
                $image_1 = $image_1->resize(800, 500);
                $filename = $request->task_id . '01' . $request->journey_id . '.' . $request->file('image_1')->getClientOriginalExtension();
                $image_1->toJpeg(80)->save(public_path("image/complited/$filename"));
                $image_url = "public/image/complited/" . $filename;
                $data['image_1'] = $image_url;
            }
            DB::table('pro_work_end')->insert($data);
            return back()->with('success', 'Image 01 Upload Successfull!');
        }
    } // end first image


    public function endTaskSecondImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_2' => 'required',
        ];
        $customMessages = [
            'image_2.required' => 'Image O2 is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $manager = new ImageManager(new Driver());
        $data = array();
        if ($request->hasFile('image_2')) {
            $image_2 = $manager->read($request->file('image_2'));
            $image_2 = $image_2->resize(800, 500);
            $filename = $request->task_id . '02' . $request->journey_id . '.' . $request->file('image_2')->getClientOriginalExtension();
            $image_2->toJpeg(80)->save(public_path("image/complited/$filename"));
            $image_url = "public/image/complited/" . $filename;
            $data['image_2'] = $image_url;
        }
        DB::table('pro_work_end')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->update($data);
        return back()->with('success', 'Image 02 Upload Successfull!');
    } // end second image


    public function endtTaskThirdImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_3' => 'required',
        ];
        $customMessages = [
            'image_3.required' => 'Image O3 is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $manager = new ImageManager(new Driver());
        $data = array();
        if ($request->hasFile('image_3')) {
            $image_3 = $manager->read($request->file('image_3'));
            $image_3 = $image_3->resize(800, 500);
            $filename = $request->task_id . '03' . $request->journey_id . '.' . $request->file('image_3')->getClientOriginalExtension();
            $image_3->toJpeg(80)->save(public_path("image/complited/$filename"));
            $image_url = "public/image/complited/" . $filename;
            $data['image_3'] = $image_url;
        }
        DB::table('pro_work_end')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->update($data);

        return back()->with('success', 'Image 03 Upload Successfull!');
    } // end Third image


    public function endTaskFourthImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_4' => 'required',
        ];
        $customMessages = [
            'image_4.required' => 'Image O4 is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $manager = new ImageManager(new Driver());
        $data = array();
        if ($request->hasFile('image_4')) {
            $image_4 = $manager->read($request->file('image_4'));
            $image_4 = $image_4->resize(800, 500);
            $filename = $request->task_id . '04' . $request->journey_id . '.' . $request->file('image_4')->getClientOriginalExtension();
            $image_4->toJpeg(80)->save(public_path("image/complited/$filename"));
            $image_url = "public/image/complited/" . $filename;
            $data['image_4'] = $image_url;
        }
        DB::table('pro_work_end')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->update($data);

        return back()->with('success', 'Image 04 Upload Successfull!');
    } // end Fourth image

    public function endTaskFifthImageUpload(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'image_5' => 'required',
        ];
        $customMessages = [
            'image_5.required' => 'Image O4 is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $manager = new ImageManager(new Driver());
        $data = array();
        if ($request->hasFile('image_5')) {
            $image_5 = $manager->read($request->file('image_5'));
            $image_5 = $image_5->resize(800, 500);
            $filename = $request->task_id . '05' . $request->journey_id . '.' . $request->file('image_5')->getClientOriginalExtension();
            $image_5->toJpeg(80)->save(public_path("image/complited/$filename"));
            $image_url = "public/image/complited/" . $filename;
            $data['image_5'] = $image_url;
        }
        DB::table('pro_work_end')
            ->where('task_id', $request->task_id)
            ->where('journey_id', $request->journey_id)
            ->update($data);

        return back()->with('success', 'Image 05 Upload Successfull!');
    } // end Fourth image


    public function completelyEndTask(Request $request)
    {
        //Image upload big size 3MB Plus hole error
        //Set 20 digit , memory limit


        $rules = [
            'cbo_task_status' => 'required',
        ];
        $customMessages = [
            'cbo_task_status.required' => 'Complite is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $manager = new ImageManager(new Driver());

        if ($request->cbo_task_status == 1) {
            $rules = [
                'feedback' => 'required',
            ];
            $customMessages = [
                'feedback.required' => 'FeedBack is required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['employee_id'] =  Auth::user()->emp_id;
            $data['description'] = $request->description;
            $data['complete_lat'] =  $request->latitude;
            $data['complete_long'] = $request->longitude;
            $data['complete_date'] = date("Y-m-d");
            $data['complete_time'] = date("H:i:s");
            $data['status'] = '1'; //Status 1 complite task

            //quotation status
            if ($request->txt_quotation_status == "on") {
                $data['quotation_status'] = 'Need Quotation';
            } else {
                $data['quotation_status'] = '';
            }
            //Image and feedback setup
            if ($request->hasFile('feedback')) {
                $feedback = $manager->read($request->file('feedback'));
                $feedback = $feedback->resize(1200, 1200);
                $filename5 = $request->task_id . '_' . $request->journey_id . '.' . $request->file('feedback')->getClientOriginalExtension();
                $feedback->toJpeg(80)->save(public_path("image/feedback/$filename5"));
                $image_url = "public/image/feedback/" . $filename5;
                $data['feedback'] = $image_url;
            }
            DB::table('pro_work_end')
                ->where('task_id', $request->task_id)
                ->where('journey_id', $request->journey_id)
                ->update($data);
            DB::table('pro_task_assign')
                ->where('task_id', $request->task_id)
                ->update([
                    'status' => "TASK_COMPLETED",
                    'complete_task' => "1",  // completelyEndTask - 1
                ]);
            $fare = $request->txt_fare == null ? 0 : $request->txt_fare;
            DB::table('pro_journey')
                ->where('journey_id', $request->journey_id)
                ->update([
                    'extra_fare' => $fare,
                ]);
            return redirect()->route('worker')->with('success', 'Task Compelete Successfull!');
        } else {

            $rules = [
                'description' => 'required',
            ];
            $customMessages = [
                'description.required' => 'Description is required!',
            ];
            $this->validate($request, $rules, $customMessages);
            $data = array();
            $data['incomplete_lat'] =  $request->latitude;
            $data['incomplete_long'] = $request->longitude;
            //
            $data['incomplete_date'] = date("Y-m-d");
            $data['incomplete_time'] = date("H:i:s");
            $data['description'] = $request->description;
            $data['status'] = '2'; //incomplete
            if ($request->txt_quotation_status == "on") {
                $data['quotation_status'] = 'Need Quotation';
            } else {
                $data['quotation_status'] = '';
            }
            DB::table('pro_work_end')
                ->where('task_id', $request->task_id)
                ->where('journey_id', $request->journey_id)
                ->update($data);

            DB::table('pro_task_assign')
                ->where('task_id', intval($request->task_id))
                ->update(['status' => "TASK_PARTIALLY_COMPLETED"]); // 6 - partiallyEndTask
            $fare = $request->txt_fare == null ? 0 : $request->txt_fare;
            DB::table('pro_journey')
                ->where('journey_id', $request->journey_id)
                ->update([
                    'extra_fare' => $fare,
                ]);

            return redirect()->route('worker')->with('success', 'Partilly Compelete Successfull!');
        } // if ($request->cbo_task_status == 1) {
    } // end finish function


    //
    public function taskSolvingOverPhone(Request $request)
    {
        $m_employee = Auth::user()->emp_id;
        $m_task = DB::table('pro_task_assign')
            ->where('task_id', $request->task_id)
            ->first();
        if (isset($m_task)) {
            DB::table('pro_task_assign')
                ->where('task_id', $request->task_id)
                ->update([
                    'status' => "TASK_COMPLETED",
                    'complete_task' => "1",  // completelyEndTask - 1
                ]);

            $data = array();
            $data['task_id'] = $request->task_id;
            $data['employee_id'] = $m_employee;
            $data['description'] = $request->txt_remark;
            $data['complete_lat'] =  $request->latitude_01;
            $data['complete_long'] = $request->longitude_01;
            $data['complete_date'] = date("Y-m-d");
            $data['complete_time'] = date("H:i:s");
            $data['status'] = '1'; //Status 1 complite task
            $data['quotation_status'] = '';
            DB::table('pro_work_end')->insert($data);
        }
        return back()->with('success', 'Call Back Solve Over Phone Successfull!');
    }



    //

    public function cancelJourney(Request $request)
    {
        $m_employee = Auth::user()->emp_id;
        $dataAlredyCopy = DB::table('pro_journey_cancel')
            ->where('task_id', $request->task_id)
            ->where('employee_id', $m_employee)
            // ->where('status', 2)
            ->first();

        if (isset($dataAlredyCopy)) {
            return redirect()->route('worker')->with('warning', 'Data Alredy Cancel!');
        } else {

            $data = array();
            $data['task_id'] = intval($request->task_id);
            $data['employee_id'] = $m_employee;
            $data['cancel_journey_lat'] = $request->latitude_01;
            $data['cancel_journey_long'] = $request->longitude_01;
            //
            $cancel_journey_date = date("Y-m-d");
            $cancel_journey_time = date("H:i:s");
            //
            $data['cancel_journey_date'] = $cancel_journey_date;
            $data['cancel_journey_time'] = $cancel_journey_time;
            $data['status'] = '1';
            $data['valid'] = '1';
            DB::table('pro_journey_cancel')->insert($data);

            DB::table('pro_task_assign')
                ->where('task_id', intval($request->task_id))
                ->update(['status' => "JOURNEY_FAILED"]);

            return redirect()->route('worker')->with('success', 'Task Cancel!');
        }
    } //end cancel journey

    //End of the day setup

    public function endOfTheDay()
    {
        return view('worker.end_of_the_day');
    }

    public function endOfTheDayStore(Request $request)
    {

        $rules = [
            'cbo_transport_type' => 'required',
            'txt_fare' => 'required',
        ];
        $customMessages = [
            'cbo_transport_type.required' => 'Transport Type is required!',
            'txt_fare.required' => 'Fare is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_employee = Auth::user()->emp_id;
        $day_end_date = date("Y-m-d");
        $day_end_time = date("H:i:s");

        $dataAlredycopy = DB::table('pro_end_of_day')
            ->where('user_id', $m_employee)
            ->where('day_end_date', $day_end_date)
            ->first();

        if (isset($dataAlredycopy)) {
            return redirect()->route('endOfTheDay')->with('warning', 'Data Alredy Inserted!');
        } else {

            $data = array();
            $data['user_id'] =  $m_employee;
            $data['transport_type'] = $request->cbo_transport_type;
            $data['fare'] = $request->txt_fare;
            $data['day_end_lat'] =  $request->latitude;
            $data['day_end_long'] = $request->longitude;
            //
            $data['day_end_date'] = $day_end_date;
            $data['day_end_time'] = $day_end_time;
            $data['status'] = '1';
            DB::table('pro_end_of_day')->insert($data);

            // Auth::logout();
            // return redirect('/login');

            return redirect()->route('endOfTheDay')->with('success', 'Day Finish Successfully!');
        }
    } //End Of the Day
}
