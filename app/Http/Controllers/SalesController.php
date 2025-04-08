<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SalesController extends Controller
{

    //Customer
    public function customerinfo()
    {
        $data = DB::table('pro_customers')->Where('valid', '1')->orderBy('customer_id', 'desc')->get(); //query builder
        return view('sales.customer_info', compact('data'));
    }

    public function customer_info_store(Request $request)
    {
        $rules = [
            'txt_customer_name' => 'required',
            'txt_customer_add' => 'required',
            // 'txt_customer_phone' => 'required',
        ];
        $customMessages = [
            'txt_customer_name.required' => 'Customer Name is required.',
            'txt_customer_add.required' => 'Customer Address is required.',
            // 'txt_customer_phone.required' => 'Customer Phone is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_customers')->where('customer_name', $request->txt_customer_name)->where('customer_add', $request->txt_customer_add)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['customer_name'] = $request->txt_customer_name;
            $data['customer_add'] = $request->txt_customer_add;
            $data['customer_phone'] = $request->txt_customer_phone;
            $data['customer_email'] = $request->txt_customer_email;
            $data['contact_person'] = $request->txt_contact_person;
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_customers')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function customer_info_edit($id)
    {

        $m_customer = DB::table('pro_customers')->where('customer_id', $id)->first();

        return view('sales.customer_info', compact('m_customer'));
    }

    public function customer_info_update(Request $request, $update)
    {

        $rules = [
            'txt_customer_name' => 'required',
            'txt_customer_add' => 'required',
            // 'txt_customer_phone' => 'required',
        ];
        $customMessages = [
            'txt_customer_name.required' => 'Customer Name is required.',
            'txt_customer_add.required' => 'Customer Address is required.',
            // 'txt_customer_phone.required' => 'Customer Phone Number is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_customers = DB::table('pro_customers')->where('customer_id', $request->txt_customer_id)->where('customer_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_customers === null) {

            DB::table('pro_customers')->where('customer_id', $update)->update([
                'customer_name' => $request->txt_customer_name,
                'customer_add' => $request->txt_customer_add,
                'customer_phone' => $request->txt_customer_phone,
                'customer_email' => $request->txt_customer_email,
                'contact_person' => $request->txt_contact_person,
            ]);

            return redirect(route('customer_info'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Customer
    public function temporary_customer_info()
    {
        $data = DB::table('pro_customer_temp')
            ->leftJoin('pro_employee_info', 'pro_customer_temp.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_customer_temp.*',
                'pro_employee_info.employee_name'
            )
            ->Where('pro_customer_temp.user_id', Auth::user()->emp_id)
            ->Where('pro_customer_temp.valid', '1')
            ->orderBy('pro_customer_temp.customer_id', 'desc')
            ->get();
        return view('sales.temporary_customer_info', compact('data'));
    }


    public function temporary_customer_store(Request $request)
    {
        $rules = [
            'txt_customer_name' => 'required',
            'txt_customer_phone' => 'required',
        ];
        $customMessages = [
            'txt_customer_name.required' => 'Client Name is required.',
            'txt_customer_phone.required' => 'Client Phone is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_customer_temp')->where('customer_phone', $request->txt_customer_phone)
            // ->where('customer_house_no', $request->txt_customer_house_no)
            // ->where('customer_road', $request->txt_customer_road)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['customer_phone'] = $request->txt_customer_phone;
            $data['customer_name'] = $request->txt_customer_name;
            $data['customer_desig'] = $request->txt_customer_desig;
            $data['customer_road'] = $request->txt_customer_road;
            $data['customer_house_no'] = $request->txt_customer_house_no;
            $data['customer_post_code'] = $request->txt_post_code;
            $data['customer_city'] = $request->txt_city;
            $data['customer_country'] = $request->txt_country;
            $data['contact_person'] = $request->txt_contact_person;
            $data['customer_email'] = $request->txt_customer_mail;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_customer_temp')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function temporary_customer_info_edit($id)
    {

        $m_customer = DB::table('pro_customer_temp')->where('customer_id', $id)->first();
        return view('sales.temporary_customer_info', compact('m_customer'));
    }

    public function temporary_customer_info_update(Request $request)
    {

        $rules = [
            'txt_customer_name' => 'required',
            'txt_customer_phone' => 'required',
        ];
        $customMessages = [
            'txt_customer_name.required' => 'Customer Name is required.',
            'txt_customer_phone.required' => 'Customer Phone is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $update = $request->txt_customer_id;

        $abcd = DB::table('pro_customer_temp')
            ->whereNotIn("customer_id", [$update])
            ->where('customer_phone', $request->txt_customer_phone)
            // ->where('customer_house_no', $request->txt_customer_house_no)
            // ->where('customer_road', $request->txt_customer_road)
            ->first();

        if ($abcd === null) {
            DB::table('pro_customer_temp')->where('customer_id', $update)->update([
                'customer_phone' => $request->txt_customer_phone,
                'customer_name' => $request->txt_customer_name,
                'customer_desig' => $request->txt_customer_desig,
                'customer_road' => $request->txt_customer_road,
                'customer_house_no' => $request->txt_customer_house_no,
                'customer_post_code' => $request->txt_post_code,
                'customer_email' => $request->txt_customer_mail,
                'contact_person' => $request->txt_contact_person,
                'customer_city' => $request->txt_city,
                'customer_country' => $request->txt_country,
            ]);

            return redirect(route('temporary_customer_info'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //report

    public function rpt_temporary_customer_info()
    {
        $m_customer = DB::table('pro_customer_temp')
            ->leftJoin('pro_employee_info', 'pro_customer_temp.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_customer_temp.*',
                'pro_employee_info.employee_name'
            )
            ->Where('pro_customer_temp.valid', '1')
            ->orderBy('pro_customer_temp.customer_id', 'desc')
            ->get();
        return view('sales.rpt_temporary_customer_info', compact('m_customer'));
    }
    //End  Teamporary Customer




    //project
    public function projectInfo()
    {
        $projects = DB::table("pro_projects")
            ->join("pro_customers", "pro_projects.customer_id", "pro_customers.customer_id")
            ->select("pro_projects.*", "pro_customers.*")
            ->get();
        $customers = DB::table("pro_customers")
            ->where('valid', 1)
            ->get();

        return view('sales.project_info', compact('projects', 'customers'));
    }
    public function ProjectInfoStore(Request $request)
    {

        $rules = [
            'txt_project_name' => 'required',
            'cbo_customer_id' => 'required|integer|between:1,10000',
            'txt_pro_address' => 'required',
            'txt_pro_lift_quantity' => 'required',
            // 'txt_pro_contact_date' => 'required',
            // 'txt_pro_installation_date' => 'required',
            // 'txt_pro_handover_date' => 'required',
            // 'txt_warranty' => 'required',
        ];
        $customMessages = [
            'txt_project_name.required' => 'Project name is required.',

            'cbo_customer_id.required' => 'Customer is required.',
            'cbo_customer_id.integer' => 'Customer is required.',
            'cbo_customer_id.between' => 'Customer is required.',

            'txt_pro_address.required' => 'Project address is required.',
            'txt_pro_lift_quantity.required' => 'Lift quantity is required.',
            // 'txt_pro_contact_date.required' => 'Date is required.',
            // 'txt_pro_installation_date.required' => 'Project installation Date is required.',
            // 'txt_pro_handover_date.required' => 'Project handover Date is required.',
            // 'txt_warranty.required' => 'Project warranty is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $check = DB::table("pro_projects")->where('project_name', $request->txt_project_name)->first();
        if (isset($check)) {

            return back()->with('warning', "Data Already Inserted !");
        } else {

            $data = array();
            $data['project_name'] = $request->txt_project_name;
            $data['customer_id'] = $request->cbo_customer_id;
            $data['project_address'] = $request->txt_pro_address;
            $data['pro_lift_quantity'] = $request->txt_pro_lift_quantity;
            $data['contact_date'] = $request->txt_pro_contact_date;
            $data['installation_date'] = $request->txt_pro_installation_date;
            $data['handover_date'] = $request->txt_pro_handover_date;
            $data['warranty'] = $request->txt_warranty;
            $data['service_warranty'] = $request->txt_service_warranty;
            $data['contact_persone_01'] = $request->txt_contact_persone;
            $data['contact_number_01'] = $request->txt_contact_number;
            $data['contact_persone_02'] = $request->txt_contact_persone2;
            $data['contact_number_02'] = $request->txt_contact_number2;
            $data['remark'] = $request->txt_remark;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            $data['valid'] = 1;
            DB::table("pro_projects")->insert($data);
            return back()->with('success', "Data Inserted Successfully!");
        }
    }

    public function project_info_edit($id)
    {
        $m_project = DB::table('pro_projects')->where('project_id', $id)->first();

        $m_customer = DB::table("pro_customers")
            ->where('valid', 1)
            ->get();

        return view('sales.project_info', compact('m_project', 'm_customer'));
    }

    public function project_info_update(Request $request, $update)
    {

        $rules = [
            'txt_project_name' => 'required',
            'cbo_customer_id' => 'required|integer|between:1,10000',
            'txt_pro_address' => 'required',
            'txt_pro_lift_quantity' => 'required',
            // 'txt_pro_contact_date' => 'required',
            // 'txt_pro_installation_date' => 'required',
            // 'txt_pro_handover_date' => 'required',
            // 'txt_warranty' => 'required',
        ];
        $customMessages = [
            'txt_project_name.required' => 'Project name is required.',

            'cbo_customer_id.required' => 'Customer is required.',
            'cbo_customer_id.integer' => 'Customer is required.',
            'cbo_customer_id.between' => 'Customer is required.',

            'txt_pro_address.required' => 'Project address is required.',
            'txt_pro_lift_quantity.required' => 'Lift quantity is required.',
            // 'txt_pro_contact_date.required' => 'Lift Quantity is required.',
            // 'txt_pro_installation_date.required' => 'Project installation Date is required.',
            // 'txt_pro_handover_date.required' => 'Project handover Date is required.',
            // 'txt_warranty.required' => 'Project Warranty is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_projects = DB::table('pro_projects')->where('project_id', $request->txt_project_id)->where('project_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_projects === null) {

            DB::table('pro_projects')->where('project_id', $update)->update([
                'project_name' => $request->txt_project_name,
                'customer_id' => $request->cbo_customer_id,
                'project_address' => $request->txt_pro_address,
                'pro_lift_quantity' => $request->txt_pro_lift_quantity,
                'contact_date' => $request->txt_pro_contact_date,
                'installation_date' => $request->txt_pro_installation_date,
                'handover_date' => $request->txt_pro_handover_date,
                'warranty' => $request->txt_warranty,
                'service_warranty' => $request->txt_service_warranty,
                'contact_persone_01' => $request->txt_contact_persone,
                'contact_number_01' => $request->txt_contact_number,
                'contact_persone_02' => $request->txt_contact_persone2,
                'contact_number_02' => $request->txt_contact_number2,
                'remark' => $request->txt_remark,
            ]);

            return redirect(route('sales_project_info'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //End project 

    //Lift
    public function liftinfo()
    {
        $lifts = DB::table('pro_lifts')
            ->join("pro_projects", "pro_lifts.project_id", "pro_projects.project_id")
            ->select("pro_lifts.*", "pro_projects.project_name")
            ->get();
        $projects = DB::table('pro_projects')->get();
        return view('sales.lift_info', compact('lifts', 'projects'));
    }
    public function lift_info_store(Request $request)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,9999999',
            'txt_lift_name' => 'required',
        ];
        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_lift_name.required' => 'Lift name is required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['lift_name'] = $request->txt_lift_name;
        $data['remark'] = $request->txt_remark;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table("pro_lifts")->insert($data);
        return back()->with('success', "Inserted Successfull !");
    }
    public function lift_info_edit($id)
    {
        $m_lifts = DB::table('pro_lifts')->where('lift_id', $id)->first();
        $projects = DB::table('pro_projects')->get();
        return view('sales.lift_info', compact('m_lifts', 'projects'));
    }
    public function lift_info_update(Request $request, $id)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,999999999',
            'txt_lift_name' => 'required',
        ];
        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_lift_name.required' => 'Lift name is required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['lift_name'] = $request->txt_lift_name;
        $data['remark'] = $request->txt_remark;
        DB::table("pro_lifts")->where('lift_id', $id)->update($data);
        return redirect()->route('sales_lift_info')->with('success', "Updated Successfull !");
    }

    //End Lift

    //Task
    public function create_task()
    {
        $sales_task = DB::table('pro_sales_task')
            ->leftJoin('pro_employee_info', 'pro_sales_task.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_customer_temp', 'pro_sales_task.customer_id', 'pro_customer_temp.customer_id')
            ->select(
                'pro_sales_task.*',
                'pro_employee_info.employee_name',
                "pro_customer_temp.customer_name",
                "pro_customer_temp.customer_desig",
                "pro_customer_temp.customer_phone",
                "pro_customer_temp.customer_house_no",
                "pro_customer_temp.customer_road",
                "pro_customer_temp.customer_city",
                "pro_customer_temp.customer_post_code",
                "pro_customer_temp.customer_country"

            )
            ->where('pro_sales_task.user_id', Auth::user()->emp_id)
            ->whereIn('pro_sales_task.status', [1, 2, 3])
            ->get();

        $m_customer = DB::table('pro_customer_temp')
            ->leftJoin('pro_employee_info', 'pro_customer_temp.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_customer_temp.*',
                'pro_employee_info.employee_name'
            )
            ->Where('pro_customer_temp.user_id', Auth::user()->emp_id)
            ->Where('pro_customer_temp.valid', '1')
            ->orderBy('pro_customer_temp.customer_id', 'desc')
            ->get();

        return view('sales.create_task', compact('sales_task', 'm_customer'));
    }

    public function store_task(Request $request)
    {
        $rules = [
            'txt_task_title' => 'required',
            'cbo_task_type' => 'required',
            'cbo_customer' => 'required',
            'txt_due_date' => 'required',
            'cbo_task_priority' => 'required',
        ];
        $customMessages = [
            'txt_task_title.required' => 'Task Title is required.',
            'cbo_task_type.required' => 'Type is required.',
            'cbo_customer.required' => 'Type is required.',
            'txt_due_date.required' => 'Due Date is required.',
            'cbo_task_priority.required' => 'Priority is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['task_title'] = $request->txt_task_title;
        $data['task_type'] = $request->cbo_task_type;
        $data['customer_id'] = $request->cbo_customer;
        $data['due_date'] = $request->txt_due_date;
        $data['priority'] = $request->cbo_task_priority;
        $data['user_id'] = Auth::user()->emp_id;
        $data['status'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_sales_task')->insert($data);
        return back()->with('success', "Add Successfull");
    }

    // journey
    public function sales_start_journey(Request $request)
    {
        $data = array();
        $data['task_id'] = $request->txt_task_id;
        $data['start_journey_lat'] = $request->latitude;
        $data['start_journey_long'] = $request->longitude;
        $data['start_journey_date'] = date("Y-m-d");
        $data['start_journey_time'] = date("h:i:s");
        $data['user_id'] = Auth::user()->emp_id;
        $data['status'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_sales_journey')->insert($data);
        DB::table('pro_sales_task')->where('task_id', $request->txt_task_id)->update(['status' => 2]);
        return back()->with('success', "Add Successfull");
    }
    public function sales_end_journey($task_id)
    {
        $journey =  DB::table('pro_sales_journey')->where('task_id', $task_id)->orderByDesc('journey_id')->first();
        return view('sales.journey', compact('journey'));
    }
    public function sales_end_journey_store(Request $request)
    {
        $data = array();
        $data['task_id'] = $request->txt_task_id;
        $data['reached_lat'] = $request->latitude;
        $data['reached_long'] = $request->longitude;
        $data['reached_date'] = date("Y-m-d");
        $data['reached_time'] = date("h:i:s");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_sales_journey')->where('journey_id', $request->taxt_journey_id)->update($data);
        DB::table('pro_sales_task')->where('task_id', $request->txt_task_id)->update(['status' => 3]);
        return redirect()->route('create_task')->with('success', "Add Successfull");
    }
    //Review task
    public function review_task($task_id)
    {
        $task =  DB::table('pro_sales_task')->where('user_id', Auth::user()->emp_id)->where('task_id', $task_id)->first();
        return view('sales.review_task', compact('task'));
    }
    public function review_task_store(Request $request)
    {

        $rules = [
            'feedback' => 'required|mimes:jpeg,JPEG,png,PNG,jpg,JPG,gif,svg',
            'description' => 'required',
            'cbo_task_status' => 'required',
        ];
        $customMessages = [
            'feedback.required' => 'File is required.',
            'feedback.mimes' => 'Image Only (jpeg,JPEG,png,PNG,jpg,JPG,gif,svg).',
            'description.required' => 'Description is required.',
            'cbo_task_status.required' => 'Complite is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['review_lat'] = $request->latitude;
        $data['review_long'] = $request->longitude;
        $data['review_date'] = date("Y-m-d");
        $data['review_time'] = date("h:i:s");
        $data['review_remarks'] = $request->description;
        $data['review_status'] = $request->cbo_task_status;
        $data['status'] = 4;

        //Image and feedback setup
        $manager = new ImageManager(new Driver());
        if ($request->hasFile('feedback')) {
            $feedback = $manager->read($request->file('feedback'));
            $feedback = $feedback->resize(1200, 1200);
            $filename5 = $request->txt_task_id . '.' . $request->file('feedback')->getClientOriginalExtension();
            $feedback->toJpeg(80)->save(public_path("image/sales/feedback/$filename5"));
            $image_url = "public/image/sales/feedback/" . $filename5;
            $data['feedback'] = $image_url;
        }
        DB::table('pro_sales_task')->where('task_id', $request->txt_task_id)->update($data);
        return redirect()->route('create_task')->with('success', "Review Add Successfull");
    }

    //task Report
    public function rpt_sales_task_list()
    {
        $form = date("Y-m-d");
        $to = date("Y-m-d");
        $employee_id =  "old('cbo_employee_id')";
        $sales_task = DB::table('pro_sales_task')
            ->leftJoin('pro_employee_info', 'pro_sales_task.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_customer_temp', 'pro_sales_task.customer_id', 'pro_customer_temp.customer_id')
            ->select(
                'pro_sales_task.*',
                'pro_employee_info.employee_name',
                "pro_customer_temp.customer_name",
                "pro_customer_temp.customer_desig",
                "pro_customer_temp.customer_phone",
                "pro_customer_temp.customer_house_no",
                "pro_customer_temp.customer_road",
                "pro_customer_temp.customer_city",
                "pro_customer_temp.customer_post_code",
                "pro_customer_temp.customer_country"

            )
            // ->whereIn('pro_sales_task.status', [1, 2, 3,4])
            ->where('pro_sales_task.due_date', $form)
            ->get();

        $employees = DB::table("pro_employee_info")
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->where('valid', 1)
            ->get();
        return view('sales.rpt_sales_task_list', compact('sales_task', 'employees', 'form', 'to', 'employee_id'));
    }

    public function rpt_sales_task_search(Request $request)
    {

        $form = date("Y-m-d");
        $to = date("Y-m-d");
        $employee_id = $request->cbo_employee_id;
        $employees = DB::table("pro_employee_info")
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->where('valid', 1)
            ->get();

        if ($request->txt_from && $request->txt_to && $request->cbo_employee_id) {

            $sales_task = DB::table('pro_sales_task')
                ->leftJoin('pro_employee_info', 'pro_sales_task.user_id', 'pro_employee_info.employee_id')
                ->leftJoin('pro_customer_temp', 'pro_sales_task.customer_id', 'pro_customer_temp.customer_id')
                ->select('pro_sales_task.*', 'pro_employee_info.employee_name','pro_customer_temp.customer_name')
                ->where('pro_sales_task.user_id', $request->cbo_employee_id)
                ->whereBetween('pro_sales_task.due_date', [$request->txt_from, $request->txt_to])
                ->orderByDesc('pro_sales_task.task_id')
                ->get();
        } else if ($request->txt_from && $request->txt_to && $request->cbo_employee_id == null) {
            $sales_task = DB::table('pro_sales_task')
                ->leftJoin('pro_employee_info', 'pro_sales_task.user_id', 'pro_employee_info.employee_id')
                ->leftJoin('pro_customer_temp', 'pro_sales_task.customer_id', 'pro_customer_temp.customer_id')
                ->select('pro_sales_task.*', 'pro_employee_info.employee_name','pro_customer_temp.customer_name')
                ->whereBetween('pro_sales_task.due_date', [$request->txt_from, $request->txt_to])
                ->orderByDesc('pro_sales_task.task_id')
                ->get();
        } else if ($request->txt_from == null && $request->txt_to == null && $request->cbo_employee_id) {
            $sales_task = DB::table('pro_sales_task')
                ->leftJoin('pro_employee_info', 'pro_sales_task.user_id', 'pro_employee_info.employee_id')
                ->leftJoin('pro_customer_temp', 'pro_sales_task.customer_id', 'pro_customer_temp.customer_id')
                ->select('pro_sales_task.*', 'pro_employee_info.employee_name','pro_customer_temp.customer_name')
                ->where('pro_sales_task.user_id', $request->cbo_employee_id)
                ->orderByDesc('pro_sales_task.task_id')
                ->get();
        } else {
            $sales_task = DB::table('pro_sales_task')
                ->leftJoin('pro_employee_info', 'pro_sales_task.user_id', 'pro_employee_info.employee_id')
                ->leftJoin('pro_customer_temp', 'pro_sales_task.customer_id', 'pro_customer_temp.customer_id')
                ->select('pro_sales_task.*', 'pro_employee_info.employee_name','pro_customer_temp.customer_name')
                ->orderByDesc('pro_sales_task.task_id')
                ->get();
        }

        return view('sales.rpt_sales_task_list', compact('sales_task', 'employees', 'form', 'to', 'employee_id'));
    }



    //quotation
    public function sales_quotation()
    {
        $m_customer = DB::table('pro_customer_temp')
            ->leftJoin('pro_employee_info', 'pro_customer_temp.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_customer_temp.*',
                'pro_employee_info.employee_name'
            )
            ->Where('pro_customer_temp.user_id', Auth::user()->emp_id)
            ->Where('pro_customer_temp.valid', '1')
            ->orderBy('pro_customer_temp.customer_id', 'desc')
            ->get();

        return view('sales.sales_quotation', compact('m_customer'));
    }

    public function SalesCustomerDetails($customer_id)
    {
        $m_customer = DB::table('pro_customer_temp')
            ->where('customer_id', $customer_id)
            ->first();
        $data = "$m_customer->customer_house_no $m_customer->customer_road $m_customer->customer_city  $m_customer->customer_post_code  $m_customer->customer_country";
        return response()->json($data);
    }

    public function sales_quotation_initial_store(Request $request)
    {

        $rules = [
            'txt_date' => 'required',
            'cbo_customer' => 'required',
            'txt_project_address' => 'required',
            'txt_subject' => 'required',
        ];
        $customMessages = [
            'txt_date.required' => 'Quotation date is required.',
            'cbo_customer.required' => 'Select Customer.',
            'txt_project_address.required' => 'Select Customer.',
            'txt_subject.required' => 'Select Customer.',
        ];

        $this->validate($request, $rules, $customMessages);


        //Add purchase Master
        $last_quotation_id = DB::table("pro_sales_quotation_master")->orderByDesc("quotation_id")->first();
        if ($last_quotation_id == null) {
            $quotation_no = "SVRN" . date("ymd") . "00001";
        } else {
            $quotation_no = "SVRN" . date("ymd") . str_pad((substr($last_quotation_id->quotation_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        }

        $data = array();
        $data['quotation_no'] = $quotation_no;
        $data['quotation_date'] = $request->txt_date;
        $data['customer_id'] = $request->cbo_customer;
        $data['project_address'] = $request->txt_project_address;
        $data['subject'] = $request->txt_subject;
        $quotation_id =  DB::table('pro_sales_quotation_master')->insertGetId($data);
        return redirect()->route('sales_quotation_details', $quotation_id)->with('success', "Add Successfully");
    }

    public function sales_quotation_details($quotation_id)
    {

        $m_sales_quotation_master =  DB::table('pro_sales_quotation_master')
            ->leftJoin("pro_customer_temp", 'pro_sales_quotation_master.customer_id', 'pro_customer_temp.customer_id')
            ->select(
                'pro_sales_quotation_master.*',
                'pro_customer_temp.customer_name',
                'pro_customer_temp.customer_desig',
                'pro_customer_temp.customer_house_no',
                'pro_customer_temp.customer_road',
                'pro_customer_temp.customer_post_code',
                'pro_customer_temp.customer_city',
                'pro_customer_temp.customer_country',
            )
            ->where('pro_sales_quotation_master.quotation_id', $quotation_id)
            ->first();

        return view('sales.sales_quotation_details', compact('m_sales_quotation_master'));
    }
}
