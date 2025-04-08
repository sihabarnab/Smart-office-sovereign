<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Team
    public function TeamInfo()
    {
        $teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->where('pro_teams.valid', 1)
            ->get();
        $get_team_leader_id = DB::table("pro_teams")
            ->where('valid', 1)
            ->pluck('team_leader_id');
        $leaders = DB::table("pro_employee_info")
            ->whereNotIn('employee_id', $get_team_leader_id)
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->where('valid', 1)
            ->get();
        return view('service.team_info', compact('teams', 'leaders'));
    }

    public function TeamInfoStore(Request $request)
    {
        $rules = [
            'txt_team_name' => 'required',
            'cbo_leader_id' => 'required',
        ];
        $customMessages = [
            'txt_team_name.required' => 'Team name is required.',
            'cbo_leader_id.required' => 'Leader is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['team_name'] = $request->txt_team_name;
        $data['team_leader_id'] = $request->cbo_leader_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        $data['status'] = 1;
        $inserted = DB::table("pro_teams")->insert($data);
        return back()->with('success', "Data Inserted Successfully!");
    }

    public function TeamInfoEdit($id)
    {
        $edit_teams = DB::table("pro_teams")
            ->join("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name")
            ->where('pro_teams.valid', 1)
            ->where('pro_teams.team_id', $id)
            ->first();
        $get_team_leader_id = DB::table("pro_teams")
            ->where('valid', 1)
            ->whereNotIn('team_leader_id', ["$edit_teams->team_leader_id"])
            ->pluck('team_leader_id');
        $leaders = DB::table("pro_employee_info")
            ->whereNotIn('employee_id', $get_team_leader_id)
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->where('valid', 1)
            ->get();
        return view('service.team_info', compact('edit_teams', 'leaders'));
    }

    public function TeamInfoUpdate(Request $request, $id)
    {
        $rules = [
            'txt_team_name' => 'required',
            'cbo_leader_id' => 'required',
        ];
        $customMessages = [
            'txt_team_name.required' => 'Team name is required.',
            'cbo_leader_id.required' => 'Leader is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['team_name'] = $request->txt_team_name;
        $data['team_leader_id'] = $request->cbo_leader_id;
        $inserted = DB::table("pro_teams")->where('team_id', $id)->update($data);
        return redirect()->route('team_info')->with('success', "Data Updated Successfully!");
    }


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

        return view('service.project_info', compact('projects', 'customers'));
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

        return view('service.project_info', compact('m_project', 'm_customer'));
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
                'owner' => $request->txt_owner,
                'owner_number' => $request->txt_owner_number,
                'contact_persone_01' => $request->txt_contact_persone,
                'contact_number_01' => $request->txt_contact_number,
                'contact_persone_02' => $request->txt_contact_persone2,
                'contact_number_02' => $request->txt_contact_number2,
                'remark' => $request->txt_remark,
            ]);

            return redirect(route('project_info'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Lift
    public function liftinfo()
    {
        $lifts = DB::table('pro_lifts')
            ->join("pro_projects", "pro_lifts.project_id", "pro_projects.project_id")
            ->select("pro_lifts.*", "pro_projects.project_name")
            ->get();
        $projects = DB::table('pro_projects')->get();
        return view('service.lift_info', compact('lifts', 'projects'));
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
        return view('service.lift_info', compact('m_lifts', 'projects'));
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
        return redirect()->route('lift_info')->with('success', "Updated Successfull !");
    }

    //Contact Service 
    public function contractserviceinfo()
    {
        $contact_services = DB::table('pro_ct_services')
            ->join("pro_projects", "pro_ct_services.project_id", "pro_projects.project_id")
            ->join("pro_customers", "pro_projects.customer_id", "pro_customers.customer_id")
            ->select("pro_ct_services.*", "pro_projects.project_name", "pro_customers.customer_name")
            ->get();

        $projects = DB::table("pro_projects")
            ->where('valid', '1')
            ->get();

        $m_bill_type = DB::table("pro_bill_type")
            ->where('valid', '1')
            ->get();

        return view('service.contract_service_info', compact('contact_services', 'projects', 'm_bill_type'));
    }
    public function contract_service_info_store(Request $request)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,20000',
            'txt_ct_period_start' => 'required',
            'txt_ct_period_end' => 'required',
            'cbo_lift_id' => 'required',
            'txt_service_bill' => 'required',
            'cbo_bill_type_id' => 'required|integer|between:1,10',
            'txt_file' => 'mimes:pdf|max:5141',
        ];
        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_ct_period_start.required' => 'Start date is required.',
            'txt_ct_period_end.required' => 'End date is required.',
            'cbo_lift_id.required' => 'Lift is required.',
            'txt_service_bill.required' => 'Service bill is required.',
            'cbo_bill_type_id.required' => 'Bill type is required.',
            'cbo_bill_type_id.integer' => 'Bill type is required.',
            'cbo_bill_type_id.between' => 'Bill type is required.',
            'txt_file.mimes' => 'Upload only PDF File.',
            'txt_file.max' => 'Max file size 5MB.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['ct_period_start'] = $request->txt_ct_period_start;
        $data['ct_period_end'] = $request->txt_ct_period_end;
        $data['lift_id'] = $request->cbo_lift_id;
        $data['service_bill'] = $request->txt_service_bill;
        $data['bill_type_id'] = $request->cbo_bill_type_id;
        $data['remark'] = $request->txt_remark;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;

        //File
        $file = $request->file('txt_file');
        if ($request->hasFile('txt_file')) {
            $filename = $request->file('txt_file')->getClientOriginalName();
            $upload_path = "public/image/ct_service/";
            $image_url = $upload_path . $filename;
            $file->move($upload_path, $filename);
            $data['file'] = $image_url;
        }

        DB::table("pro_ct_services")->insert($data);
        return back()->with('success', "Inserted Successfull !");
    }

    public function contract_service_info_edit($id)
    {
        $m_ct_services = DB::table('pro_ct_services')->where('ct_service_id', $id)->first();

        $projects = DB::table("pro_projects")
            ->where('valid', '1')
            ->get();

        $m_bill_type = DB::table("pro_bill_type")
            ->where('valid', '1')
            ->get();

        $m_lift = DB::table('pro_lifts')
            ->where("lift_id", $m_ct_services->lift_id)
            ->where('valid', '1')
            ->first();

        return view('service.contract_service_info', compact('m_ct_services', 'projects', 'm_bill_type', 'm_lift'));
    }
    public function contract_service_info_update(Request $request, $id)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,20000',
            'txt_ct_period_start' => 'required',
            'txt_ct_period_end' => 'required',
            'cbo_lift_id' => 'required',
            'txt_service_bill' => 'required',
            'cbo_bill_type_id' => 'required|integer|between:1,10',
            'txt_file' => 'mimes:pdf|max:5141',
        ];

        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_ct_period_start.required' => 'Start date is required.',
            'txt_ct_period_end.required' => 'End date is required.',
            'cbo_lift_id.required' => 'Lift is required.',
            'txt_service_bill.required' => 'Service bill is required.',
            'cbo_bill_type_id.required' => 'Bill type is required.',
            'cbo_bill_type_id.integer' => 'Bill type is required.',
            'cbo_bill_type_id.between' => 'Bill type is required.',
            'txt_file.mimes' => 'Upload only PDF File.',
            'txt_file.max' => 'Max file size 5MB.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['ct_period_start'] = $request->txt_ct_period_start;
        $data['ct_period_end'] = $request->txt_ct_period_end;
        $data['lift_id'] = $request->cbo_lift_id;
        $data['service_bill'] = $request->txt_service_bill;
        $data['bill_type_id'] = $request->cbo_bill_type_id;
        $data['remark'] = $request->txt_remark;
        $data['user_id'] = Auth::user()->emp_id;

        //File
        $file = $request->file('txt_file');
        if ($request->hasFile('txt_file')) {
            $filename = $request->file('txt_file')->getClientOriginalName();
            $upload_path = "public/image/ct_service/";
            $image_url = $upload_path . $filename;
            $file->move($upload_path, $filename);
            $data['file'] = $image_url;
        }

        DB::table("pro_ct_services")->where("ct_service_id", $id)->update($data);
        return redirect()->route('contract_service_info')->with('success', "Updated Successfull !");
    }



    //task assign
    public function taskassign()
    {
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name")
            ->get();
        // return $m_teams;
        $mt_task_assign = DB::table('pro_task_assign')
            ->where('complete_task', NULL)
            ->where('department_id', 1)
            ->where('valid', 1)
            ->orderByDesc('task_id')
            ->take(30)
            ->get();

        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();

        $m_project = DB::table('pro_projects')
            ->where('valid', '1')
            ->get();

        $m_lift = DB::table('pro_lifts')
            ->where('valid', '1')
            ->get();

        return view('service.task_assign', compact('m_teams', 'mt_task_assign', 'm_customer', 'm_project', 'm_lift'));
    }
    public function task_assign_store(Request $request)
    {
        $rules = [
            'cbo_customer_id' => 'required',
            'cbo_project_id' => 'required',
            'cbo_lift_id' => 'required',
            'cbo_team_id' => 'required',
            'txt_remark' => 'required',
        ];

        $customMessages = [
            'cbo_customer_id.required' => 'Select complain.',
            'cbo_project_id.required' => 'Select Project.',
            'cbo_lift_id.required' => 'Select Lift.',
            'cbo_team_id.required' => 'Select Team.',
            'txt_remark.required' => 'Remark is Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $complain_id = DB::table('pro_complaint_register')->insertGetId([
            'customer_id' => $request->cbo_customer_id,
            'project_id' => $request->cbo_project_id,
            'lift_id' => $request->cbo_lift_id,
            'complaint_description' => $request->txt_remark,
            'department_id' => 1,
            'status' => 2,
            'valid' => 1,
            'user_id' => Auth::user()->emp_id,
            'entry_date' => date("Y-m-d"),
            'entry_time' => date("h:i:s"),
        ]);


        $data = array();
        $teams = DB::table("pro_teams")->where("team_id", $request->cbo_team_id)->first();
        $data['complain_id'] = $complain_id;
        $data['customer_id'] = $request->cbo_customer_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['department_id'] = 1; //1 -- Servicing
        $data['lift_id'] = $request->cbo_lift_id;
        $data['team_id'] = $request->cbo_team_id;
        $data['team_leader_id'] = $teams->team_leader_id;
        $data['user_id'] = Auth::user()->emp_id;
        $data['remark'] = $request->txt_remark;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");

        $task_id = DB::table('pro_task_assign')->insertGetId($data);
        if ($task_id) {
            DB::table('pro_complaint_register')->where('complaint_register_id', $request->cbo_complain_id)
                ->update([
                    'status' => 2,
                ]);

            return redirect()->route('helper_information', $task_id);
        } else {
            return back()->with('warning', "Data Not Found !");
        }
    }

    public function task_assign_edit($id)
    {
        $m_teams = DB::table("pro_teams")
            ->join("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name")
            ->get();
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();

        $m_task_assign = DB::table('pro_task_assign')
            ->leftJoin('pro_customers', 'pro_task_assign.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_projects', 'pro_task_assign.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_lifts', 'pro_task_assign.lift_id', 'pro_lifts.lift_id')
            ->leftJoin('pro_complaint_register', 'pro_task_assign.complain_id', 'pro_complaint_register.complaint_register_id')
            ->select(
                'pro_task_assign.*',
                'pro_projects.project_name',
                'pro_lifts.lift_name',
                'pro_customers.customer_name',
                'pro_complaint_register.complaint_description'
            )
            ->where("pro_task_assign.task_id", $id)
            ->first();

        return view('service.task_assign', compact('m_teams', 'm_task_assign', 'm_customer'));
    }
    public function task_assign_update(Request $request, $id)
    {
        $rules = [
            'cbo_customer_id' => 'required',
            'cbo_project_id' => 'required',
            'cbo_lift_id' => 'required',
            'cbo_team_id' => 'required',
            'txt_remark' => 'required',
        ];
        $customMessages = [
            'cbo_customer_id.required' => 'Select complain.',
            'cbo_project_id.required' => 'Select Project.',
            'cbo_lift_id.required' => 'Select Lift.',
            'cbo_team_id.required' => 'Select Team.',
            'txt_remark.required' => 'Remark is Required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $ci_teams = DB::table('pro_teams')->Where('team_id', $request->cbo_team_id)->first();
        $m_task = DB::table('pro_task_assign')->where("task_id", $id)->first();
        DB::table('pro_complaint_register')->where('complaint_register_id', $m_task->complain_id)
            ->update([
                'customer_id' => $request->cbo_customer_id,
                'project_id' => $request->cbo_project_id,
                'lift_id' => $request->cbo_lift_id,
                'complaint_description' => $request->txt_remark,
                'user_id' => Auth::user()->emp_id,
            ]);
        $data = array();
        $data['customer_id'] = $request->cbo_customer_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['lift_id'] = $request->cbo_lift_id;
        $data['team_id'] = $request->cbo_team_id;
        $data['team_leader_id'] = $ci_teams->team_leader_id;
        // $data['user_id'] = Auth::user()->emp_id;
        $data['remark'] = $request->txt_remark;
        DB::table('pro_task_assign')->where("task_id", $id)->update($data);
        return redirect()->route('helper_information', $id);
    }

    //Add Helper 

    public function helper_information($id)
    {
        $task = DB::table('pro_task_assign')->where("task_id", $id)->first();
        $helper_id = DB::table('pro_helpers')
            ->where('valid', 1)
            ->where('task_id', $id)
            ->pluck('helper_id');

        $data = ["$task->team_leader_id"];

        for ($i = 0; $i < count($helper_id); $i++) {
            array_push($data, $helper_id[$i]);
        }

        $helper = DB::table('pro_employee_info')
            ->whereNotIn('employee_id',  $data)
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->get();

        $mt_task_assign = DB::table('pro_task_assign')->where('task_id', $id)->first();
        return view('service.helper_information', compact('mt_task_assign', 'helper'));
    }

    public function edit_helper($id)
    {
        $edit_helper =  DB::table('pro_helpers')->where('id', $id)->first();
        $data = ["$edit_helper->team_leader_id"];
        $helper = DB::table('pro_employee_info')
            ->whereNotIn('employee_id', $data)
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->get();
        return view('service.helper_information', compact('edit_helper', 'helper'));
    }

    public function remove_helper($id)
    {
        DB::table('pro_helpers')->where('id', $id)->update(['valid' => 0, 'status' => 0]);
        return back()->with('Success', "Remove Successfully");
    }

    public function update_helper(Request $request, $id)
    {
        $rules = [
            'cbo_employee_id' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Helper.',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_helper =  DB::table('pro_helpers')->where('id', $id)->first();
        $task_id = $m_helper->task_id;
        DB::table('pro_helpers')->where('id', $id)->update([
            'helper_id' => $request->cbo_employee_id
        ]);
        return redirect()->route('helper_information', $task_id);
    }

    public function add_helper(Request $request, $task_id)
    {
        $rules = [
            'cbo_employee_id' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Helper.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $ms_task_assign = DB::table('pro_task_assign')->where('task_id', $task_id)->first();
        //
        $teams = DB::table("pro_teams")->where("team_id", $ms_task_assign->team_id)->first();
        $data['team_leader_id'] = $teams->team_leader_id;
        $data['team_id'] = $ms_task_assign->team_id;
        //
        $data['task_id'] = $task_id;
        $data['project_id'] = $ms_task_assign->project_id;
        $data['lift_id'] = $ms_task_assign->lift_id;
        $data['complain_id'] = $ms_task_assign->complain_id;
        $data['customer_id'] = $ms_task_assign->customer_id;
        $data['helper_id'] = $request->cbo_employee_id;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_time'] = date("h:i:s");
        $data['entry_date'] = date("Y-m-d");
        DB::table('pro_helpers')->insert($data);
        return back()->with('success', "Add Successfull !");
    }

    public function task_assign_final()
    {
        return redirect()->route('task_assign');
    }
    //End Add Helper

    //RPT Task Register / Complain Register

    public function RPTTaskComplain()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $m_task_register = DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->leftJoin("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
            ->select("pro_complaint_register.*", "pro_customers.*", "pro_projects.*", "pro_lifts.*")
            ->where('pro_complaint_register.department_id', 1)
            ->where('pro_complaint_register.valid', '1')
            ->where('pro_complaint_register.entry_date', date('Y-m-d'))
            ->get();

        return view('service.rpt_task_complain', compact('m_task_register', 'form', 'to'));
    }



    //
    public function rpt_search_task_complain(Request $request)
    {
        $rules = [
            'txt_from' => 'required',
            'txt_to' => 'required',
        ];

        $customMessages = [
            'txt_from.required' => 'Form is Required.',
            'txt_to.required' => 'To is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $search_task_register = DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->leftJoin("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
            ->select("pro_complaint_register.*", "pro_customers.*", "pro_projects.*", "pro_lifts.*")
            ->where('pro_complaint_register.department_id', 1)
            ->where('pro_complaint_register.valid', '1')
            ->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;

        return view('service.rpt_task_complain', compact('search_task_register', 'form', 'to'));
    }

    //End RPT Complain

    //Return Material 

    public function return_material()
    {
        $complain = DB::table('pro_complaint_register')
            ->where('department_id', 1)
            ->where('status', 2)
            ->where('task_status', null)
            ->where('return_status', null)
            ->get();
        return view('service.return_material', compact('complain'));
    }

    public function add_return_material($id)
    {

        $complain = DB::table('pro_complaint_register')->where('complaint_register_id', $id)->first();

        $product_id = DB::table('pro_requisition_details')->where('status', 3)->where('complain_id', $id)->pluck('product_id');

        $ret_product_id = DB::table('pro_material_return_details')->where('complain_id', $id)->pluck('product_id');

        $product = DB::table('pro_product')
            ->whereNotIn('product_id', $ret_product_id)
            ->whereIn('product_id', $product_id)
            ->get();

        return view('service.return_material_info', compact('complain', 'product'));
    }

    public function store_return_material(Request $request, $complain_id, $product_id)
    {


        $complain = DB::table('pro_complaint_register')->where('complaint_register_id', $complain_id)->first();
        $task = DB::table('pro_task_assign')->where('complain_id', $complain_id)->first();
        $product = DB::table('pro_product')->where('product_id', $product_id)->first();

        $check_qty = $request->txt_good_qty + $request->txt_bad_qty;
        if ($check_qty > $request->txt_total_qty) {
            return back()->with('warning', "Requisition Qty ($request->txt_total_qty) Less then Request Qty ($check_qty)");
        }

        $data = array();
        $data['return_date'] = date("Y-m-d");
        $data['complain_id'] = $complain_id;
        $data['task_id'] = $task->task_id;
        $data['customer_id'] = $task->customer_id;
        $data['team_leader_id'] = $task->team_leader_id;
        $data['project_id'] = $task->project_id;
        $data['lift_id'] = $task->lift_id;
        $data['pg_id'] = $product->pg_id;
        $data['pg_sub_id'] = $product->pg_sub_id;
        $data['product_id'] = $product->product_id;
        $data['total_qty'] = $request->txt_total_qty;
        $data['useable_qty'] = $request->txt_good_qty;
        $data['damage_qty'] = $request->txt_bad_qty;
        $data['user_id'] = Auth::user()->emp_id;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        DB::table('pro_material_return_details')->insert($data);

        $product_id = DB::table('pro_requisition_details')->where('status', 3)->where('complain_id', $complain_id)->pluck('product_id');

        $req_row = DB::table('pro_product')
            ->whereIn('product_id', $product_id)
            ->count();

        $return_row = DB::table('pro_material_return_details')
            ->where('complain_id', $complain_id)
            ->count();

        if ($req_row ==  $return_row) {
            DB::table('pro_complaint_register')->where('complaint_register_id', $complain_id)->update(['return_status' => 1]);
            return redirect()->route('return_material');
        }

        return back()->with('success', 'Add Successfull!');
    }

    //End Return Material 



    //Requisition
    public function material_issue()
    {
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name")
            ->get();


        $m_smim_task_id = DB::table('pro_service_material_issue_master')
            ->where('status', 2)
            ->pluck('task_id');

        $m_complaint_register = DB::table('pro_task_assign')
            ->where('department_id', 1)
            ->whereNotIn('task_id', $m_smim_task_id)
            ->where('complete_task', null)
            ->where('valid', 1)
            ->orderByDesc('task_id')
            ->get();

        $m_product = DB::table('pro_product')
            ->where('valid', 1)
            ->get();


        return view('service.material_issue', compact('m_teams', 'm_complaint_register', 'm_product'));
    }

    // requisition master
    public function material_issue_store(Request $request)
    {

        $rules = [
            'cbo_complain_id' => 'required|integer|between:1,2000',
            'cbo_product' => 'required|integer|between:1,20000',
            'txt_product_qty' => 'required',
        ];

        $customMessages = [
            'cbo_complain_id.required' => 'Select Complain.',
            'cbo_complain_id.integer' => 'Select Complain.',
            'cbo_complain_id.between' => 'Select Complain.',
            'cbo_product.required' => 'Select Product.',
            'cbo_product.integer' => 'Select Product.',
            'cbo_product.between' => 'Select Product.',
            'txt_product_qty.required' => 'Product Quantity is Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $ms_task_assign = DB::table('pro_task_assign')->where('task_id', $request->cbo_complain_id)->first();
        $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();

        //12 digit   
        $last_req_no = DB::table('pro_service_material_issue_master')->orderByDesc("smi_no")->first();
        if (isset($last_req_no->smi_no)) {
            $req_no = "SOVMI" . date("my") . str_pad((substr($last_req_no->smi_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $req_no = "SOVMI" . date("my") . "00001";
        }

        //master
        $data = array();
        $data['smi_no'] = $req_no;
        $data['complain_id'] = $ms_task_assign->complain_id;
        $data['department_id'] = $ms_task_assign->department_id;
        $data['task_id'] = $ms_task_assign->task_id;
        $data['team_leader_id'] = $ms_task_assign->team_leader_id;
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        $req_master_id = DB::table('pro_service_material_issue_master')
            // ->orderBy('requisition_master_id','asc')
            ->insertGetId($data);

        //Details
        $data = array();
        $data['smi_master_id'] = $req_master_id;
        $data['smi_no'] =  $req_no;
        $data['complain_id'] = $ms_task_assign->complain_id;
        $data['task_id'] = $ms_task_assign->task_id;
        $data['team_leader_id'] = $ms_task_assign->team_leader_id;
        $data['department_id'] = $ms_task_assign->department_id;
        $data['pg_id'] = "$m_product->pg_id";
        $data['pg_sub_id'] = "$m_product->pg_sub_id";
        $data['product_id'] = $request->cbo_product;
        $data['product_qty'] = $request->txt_product_qty;
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_service_material_issue_details')->insert($data);


        return redirect()->route('material_issue_details', $req_master_id);
    }

    // requisition details
    public function material_issue_details($id)
    {
        $req_master = DB::table('pro_service_material_issue_master')->where('smi_master_id', $id)->first();
        $ms_task_assign = DB::table('pro_task_assign')->where('task_id', $req_master->task_id)->first();
        $m_product = DB::table('pro_product')
            ->where('valid', 1)
            ->get();
        $req_details = DB::table('pro_service_material_issue_details')->where('smi_master_id', $id)->get();
        return view('service.material_issue_details', compact('ms_task_assign', 'req_master', 'm_product', 'req_details'));
    }
    public function material_issue_details_store(Request $request, $id)
    {

        $rules = [
            // 'cbo_product_group' => 'required|integer|between:1,2000',
            'cbo_product' => 'required|integer|between:1,20000',
            'txt_product_qty' => 'required',
        ];

        $customMessages = [
            // 'cbo_product_group.required' => 'Select Product Group.',
            // 'cbo_product_group.integer' => 'Select Product Group.',
            // 'cbo_product_group.between' => 'Select Product Group.',
            'cbo_product.required' => 'Select Product.',
            'cbo_product.integer' => 'Select Product.',
            'cbo_product.between' => 'Select Product.',
            'txt_product_qty.required' => 'Product Quantity is Required.',
        ];

        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $req_master = DB::table('pro_service_material_issue_master')->where('smi_master_id', $id)->first();
        $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();

        $data = array();
        $data['smi_master_id'] = $req_master->smi_master_id;
        $data['smi_no'] = $req_master->smi_no;
        $data['complain_id'] = $req_master->complain_id;
        $data['task_id'] = $req_master->task_id;
        $data['team_leader_id'] = $req_master->team_leader_id;
        $data['department_id'] = $req_master->department_id;
        $data['pg_id'] =  "$m_product->pg_id";
        $data['pg_sub_id'] = "$m_product->pg_sub_id";
        $data['product_id'] = $request->cbo_product;
        $data['product_qty'] = $request->txt_product_qty;
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_service_material_issue_details')->insert($data);
        return redirect()->route('material_issue_details', $id)->with('success', "Add Successfully!");
    }

    public function material_issue_final($id)
    {
        DB::table('pro_service_material_issue_master')->where('smi_master_id', $id)->update(['status' => 2]);
        DB::table('pro_service_material_issue_details')->where('smi_master_id', $id)->update(['status' => 2]);
        return redirect()->route('material_issue')->with('success', "Add Successfully!");
    }

    //Approved list
    public function RequisitionListApproved()
    {
        $m_user_id = Auth::user()->emp_id;
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('department_id', 1)
            ->where('valid', 1)
            ->where('status', 2)
            ->get();
        return view('service.requisition_list_approved', compact('m_requisition_master'));
    }

    public function requisition_list_approved_details($id)
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('requisition_master_id', $id)
            ->where('department_id', 1)
            ->where('valid', 1)
            ->where('status', 2)
            ->first();

        $m_requisition_details = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->where('status', 2)
            ->get();
        return view('service.requisition_list_approved_details', compact('m_requisition_details', 'm_requisition_master'));
    }

    public function requisition_list_confirm(Request $request, $id)
    {
        $rules = [
            'txt_approved_qty' => 'required',
        ];

        $customMessages = [
            'txt_approved_qty.required' => 'Approved Quantity is Required.',
        ];

        $this->validate($request, $rules, $customMessages);


        $user = Auth::user();
        $r_details = DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->first();

        if ($request->txt_approved_qty > $r_details->product_qty) {
            return back()->with('success', "Approved Quantity Can not getter then product qty.");
        }

        DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->update([
                'status' => 3, // 3 - Accept Requisition department head
                'approved_qty' => $request->txt_approved_qty,
                'approved_id' => $user->emp_id,
                'approved_date' => date("Y-m-d"),
                'approved_time' => date("H:i:s"),
            ]);

        //
        $data = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $r_details->requisition_master_id)
            ->where('valid', 1)
            ->count();

        $data2 = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $r_details->requisition_master_id)
            ->where('valid', 1)
            ->where('status', 3)
            ->count();

        if ($data ==  $data2) {
            DB::table('pro_requisition_master')
                ->where('requisition_master_id', '=', $r_details->requisition_master_id)
                ->update([
                    'status' => 3, // 3 - Accept requisition department head
                    'approved_id' => $user->emp_id,
                    'approved_date_time' => date("Y-m-d H:i:s"),
                ]);

            return redirect()->route('requisition_list_approved')->with('success', "Approved Successfully!");
        } else {
            return back()->with('success', "Add Successfully!");
        }
    }

    //Requation Admin Approved
    public function requisition_admin_approved_list()
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('department_id', 1)
            ->where('status', 3)
            ->where('valid', 1)
            ->get();
        return view('service.requisition_admin_approved_list', compact('m_requisition_master'));
    }

    public function requisition_admin_approved_details($id)
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('requisition_master_id', $id)
            ->where('department_id', 1)
            ->where('valid', 1)
            ->where('status', 3)
            ->first();

        $m_requisition_details = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->where('status', 3)
            ->get();
        return view('service.requisition_admin_approved_details', compact('m_requisition_details', 'm_requisition_master'));
    }

    public function requisition_admin_approved_final(Request $request, $id)
    {
        $rules = [
            'txt_approved_qty' => 'required',
        ];

        $customMessages = [
            'txt_approved_qty.required' => 'Approved Quantity is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $user = Auth::user();
        $r_details = DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->first();

        if ($request->txt_approved_qty > $r_details->product_qty) {
            return back()->with('success', "Approved Quantity Can not getter then product qty.");
        }

        DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->update([
                'status' => 4, // 4 - Accept Requisition Admin
                'final_approved_qty' => $request->txt_approved_qty,
                'final_approved_id' => $user->emp_id,
                'final_approved_date' => date("Y-m-d"),
                'final_approved_time' => date("H:i:s"),
            ]);

        //
        $data = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $r_details->requisition_master_id)
            ->where('valid', 1)
            ->count();

        $data2 = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $r_details->requisition_master_id)
            ->where('valid', 1)
            ->where('status', 4)
            ->count();

        if ($data ==  $data2) {
            DB::table('pro_requisition_master')
                ->where('requisition_master_id', '=', $r_details->requisition_master_id)
                ->update([
                    'status' => 4, // 4 - Accept requisition Admin
                    'final_approved_id' => $user->emp_id,
                    'final_approved_date_time' => date("Y-m-d H:i:s"),
                ]);

            return redirect()->route('requisition_admin_approved_list')->with('success', "Approved Successfully!");
        } else {
            return back()->with('success', "Add Successfully!");
        }
    }

    //Requation Admin Approved End 

    //accept
    public function requisition_list_approved_details_accept($id)
    {
        $user = Auth::user();
        DB::table('pro_requisition_details')
            ->where('requisition_master_id', '=', $id)
            ->update([
                'status' => 4, // 4 - Accept Requisition
            ]);
        DB::table('pro_requisition_master')
            ->where('requisition_master_id', '=', $id)
            ->update([
                'status' => 4, // 4- requisition Complite
                'approved_id' => $user->emp_id,
                'approved_date_time' => date("Y-m-d H:i:s"),
            ]);

        $req_maaster = DB::table('pro_requisition_master')
            ->where('requisition_master_id', '=', $id)
            ->first();

        DB::table('pro_task_assign')
            ->where('task_id', $req_maaster->task_id)
            ->update(['complete_task' => NULL]);

        return redirect()->route('requisition_list_approved');
    }

    //reject
    public function requisition_list_approved_details_reject($id)
    {
        $user = Auth::user();
        DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->update([
                'status' => 4, // 4 - Reject Requisition Details
            ]);
        DB::table('pro_requisition_master')
            ->where('requisition_master_id', $id)
            ->update([
                'status' => 4, // 4 - Reject requisition 
                'approved_id' => $user->emp_id,
                'approved_date_time' => date("Y-m-d H:i:s"),
            ]);

        $req_maaster = DB::table('pro_requisition_master')
            ->where('requisition_master_id', '=', $id)
            ->first();

        DB::table('pro_task_assign')
            ->where('task_id', $req_maaster->task_id)
            ->update(['complete_task' => NULL]);

        return redirect()->route('requisition_list_approved');
    }

    //RPT Requisition
    public function RPTRequisitionUser()
    {
        $user = Auth::user()->emp_id;
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('team_leader_id', $user)
            ->whereNotIn('status', [1, 2])
            // ->where('status', "!=", 2)
            ->where('valid', 1)
            ->get();
        return view('service.rpt_requisition_user', compact('m_requisition_master'));
    }

    public function rpt_material_issue()
    {

        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $m_requisition_master = DB::table('pro_service_material_issue_master')
            ->where('status', 2)
            ->where('entry_date', date("Y-m-d"))
            ->where('department_id', 1)
            ->where('valid', 1)
            ->get();

        return view('service.rpt_material_issue', compact('m_requisition_master', 'form', 'to'));
    }

    public function RPTRequisitionSearch(Request $request)
    {

        $rules = [
            'txt_from' => 'required',
            'txt_to' => 'required',
        ];

        $customMessages = [
            'txt_from.required' => 'Form is Required.',
            'txt_to.required' => 'To is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $search_requisition_master = DB::table('pro_service_material_issue_master')
            ->where('status', 2)
            ->whereBetween('entry_date', [$request->txt_from, $request->txt_to])
            ->where('department_id', 1)
            ->where('valid', 1)
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;

        return view('service.rpt_material_issue', compact('search_requisition_master', 'form', 'to'));
    }

    public function RPTRequisitionDetails($id)
    {

        $m_requisition_master = DB::table('pro_service_material_issue_master')
            ->where('smi_master_id', $id)
            ->where('valid', 1)
            ->first();

        $m_requisition_details = DB::table('pro_service_material_issue_details')
            ->where('smi_master_id', $id)
            ->where('valid', 1)
            ->get();
        return view('service.rpt_requisition_details', compact('m_requisition_details', 'm_requisition_master'));
    }

    //RPT Task User
    public function RPTTaskUser()
    {
        $mt_task_assigns = DB::table('pro_task_assign')
            ->where('team_leader_id', Auth::user()->emp_id)
            ->where('valid', 1)
            ->get();
        return view('service.rpt_task_user', compact('mt_task_assigns'));
    }

    //RPT Task All
    public function RPTTaskAll()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $mt_task_assigns = DB::table('pro_task_assign')
            ->where('entry_date', date('Y-m-d'))
            ->where('department_id', 1)
            ->where('valid', 1)
            ->get();

        return view('service.rpt_task_all', compact('mt_task_assigns', 'form', 'to'));
    }
    //RPT Task Search
    public function RPTTaskSearch(Request $request)
    {
        $rules = [
            'txt_from' => 'required',
            'txt_to' => 'required',
        ];

        $customMessages = [
            'txt_from.required' => 'Form is Required.',
            'txt_to.required' => 'To is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $search_task = DB::table('pro_task_assign')
            ->whereBetween('entry_date', [$request->txt_from, $request->txt_to])
            ->where('department_id', 1)
            ->where('valid', 1)
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;


        return view('service.rpt_task_all', compact('search_task', 'form', 'to'));
    }


    //rpt task View
    public function RPTTaskView($task_id)
    {
        $mt_task_assign = DB::table('pro_task_assign')
            ->where('task_id', $task_id)
            ->where('valid', 1)
            ->first();
        return view('service.rpt_task_view', compact('mt_task_assign'));
    }



    // Servicing Bill
    public function servicing_bill()
    {
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();
        return view('service.servicing_bill', compact('m_customer'));
    }

    public function previous_due($project_id, $customer_id)
    {
        $service_bill_grand_total = DB::table('pro_service_bill_master')
            ->where('customer_id', $customer_id)
            ->where('project_id', $project_id)
            ->where('valid', 1)
            ->sum('grand_total');

        $service_recive_total = DB::table('pro_service_money_receipt')
            ->where('customer_id', $customer_id)
            ->where('project_id', $project_id)
            ->where('valid', 1)
            ->sum('paid_amount');
        $due = $service_bill_grand_total - $service_recive_total;

        return response()->json($due);
    }

    public function servicing_bill_store(Request $request)
    {
        $rules = [
            'cbo_customer_id' => 'required',
            'cbo_project_id' => 'required',
            'txt_start_date' => 'required',
            'txt_end_date' => 'required',
            'txt_month_qty' => 'required',
            'txt_lift_qty' => 'required',
            'txt_rate' => 'required',
            'txt_description' => 'required',
            'txt_subject' => 'required',
        ];

        $customMessages = [
            'cbo_customer_id.required' => 'Select Customer.',
            'cbo_project_id.required' => 'Select Project.',
            'txt_start_date.required' => 'Start Date is Required.',
            'txt_end_date.required' => 'End Date is Required.',
            'txt_month_qty.required' => 'Month Qty is Required.',
            'txt_lift_qty.required' => 'Lift Qty is Required.',
            'txt_rate.required' => 'Rate is Required.',
            'txt_description.required' => 'Description is Required.',
            'txt_subject.required' => 'Subject is Required.',
        ];
        $this->validate($request, $rules, $customMessages);


        if ($request->txt_due) {
            $rules = [
                'txt_due_description' => 'required',
            ];

            $customMessages = [
                'txt_due_description.required' => 'Due Description Required.',
            ];
            $this->validate($request, $rules, $customMessages);
        }


        $m_bill = DB::table('pro_service_bill_master')->orderByDesc("service_bill_master_id")->first();
        if ($m_bill == null) {
            $service_bill_no = date("ymd") . "00001SB";
        } else {
            $array = str_split("$m_bill->service_bill_no");
            $old_year =  "$array[0]$array[1]";
            $current_year = date('y');
            if ($current_year > $old_year) {
                $service_bill_no = date("ymd") . "00001SB";
            } else {
                $mnum = str_replace("SB", "", $m_bill->service_bill_no);
                $service_bill_no =  date("ymd") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "SB";
            }
        }


        $vat_percent = $request->txt_vpp == null ? 0 : $request->txt_vpp;
        $ait_percent = $request->txt_tt == null ? 0 : $request->txt_tt;

        $discount = $request->txt_discount == null ? 0 : $request->txt_discount;
        $vat = $request->txt_vat == null ? 0 : $request->txt_vat;
        $ait = $request->txt_ait == null ? 0 : $request->txt_ait;
        $other = $request->txt_other == null ? 0 : $request->txt_other;
        $sub_total =  ($request->txt_month_qty * ($request->txt_rate * $request->txt_lift_qty));
        $grand_total =  ($sub_total + $vat + $ait + $other) - $discount;


        $data = array();
        $data['service_bill_no'] = $service_bill_no;
        $data['customer_id'] = $request->cbo_customer_id;
        $data['bill_date'] = date("Y-m-d");
        $data['project_id'] = $request->cbo_project_id;
        $data['subject'] = $request->txt_subject;
        $data['issue_date'] = $request->txt_issue_date;
        $data['description'] = $request->txt_description;
        //
        $startDate = $request->txt_start_date . '-01';
        $endDate = date("Y-m-t", strtotime($request->txt_end_date . '-01'));
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        //
        $data['vat_percent'] = $vat_percent;
        $data['ait_percent'] = $ait_percent;
        //
        $data['month_qty'] = $request->txt_month_qty;
        $data['lift_qty'] = $request->txt_lift_qty;
        $data['rate'] = $request->txt_rate;
        $data['total'] =  $sub_total;
        $data['discount'] = $discount;
        $data['vat'] =  $vat;
        $data['ait'] =   $ait;
        $data['other'] = $other;

        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        //
        $previous_due = $request->txt_due == null ? 0 : $request->txt_due;
        $data['grand_total'] = $grand_total;
        //
        $data['previous_due'] = $previous_due;
        $data['due_description'] = $request->txt_due_description;
        $service_bill_master_id = DB::table('pro_service_bill_master')->insertGetId($data);
        return redirect()->route('rpt_servicing_bill_view', $service_bill_master_id);
    }

    //servicing_bill_update

    public function servicing_bill_list()
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            // ->where('update_user_id', null)
            ->where('status', 1)
            ->orderByDesc('service_bill_master_id')
            ->get();
        return view('service.servicing_bill_list', compact('service_bill_master'));
    }

    public function servicing_bill_edit($id)
    {
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $id)
            ->where('status', 1)
            ->first();
        $m_project = DB::table('pro_projects')
            ->Where('project_id', $service_bill_master->project_id)
            ->where('valid', 1)
            ->first();
        return view('service.servicing_bill_edit', compact('service_bill_master', 'm_customer', 'm_project'));
    }

    public function servicing_bill_update(Request $request, $id)
    {
        $rules = [
            'txt_start_date' => 'required',
            'txt_end_date' => 'required',
            'txt_month_qty' => 'required',
            'txt_lift_qty' => 'required',
            'txt_rate' => 'required',
            'txt_description' => 'required',
            'txt_subject' => 'required',
        ];

        $customMessages = [
            'txt_start_date.required' => 'Start Date is Required.',
            'txt_end_date.required' => 'End Date is Required.',
            'txt_month_qty.required' => 'Month Qty is Required.',
            'txt_lift_qty.required' => 'Lift Qty is Required.',
            'txt_rate.required' => 'Rate is Required.',
            'txt_description.required' => 'Description is Required.',
            'txt_subject.required' => 'Subject is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $vat_percent = $request->txt_vpp == null ? 0 : $request->txt_vpp;
        $ait_percent = $request->txt_tt == null ? 0 : $request->txt_tt;

        $discount = $request->txt_discount == null ? 0 : (int)($request->txt_discount);
        $vat = $request->txt_vat == null ? 0 : (int)$request->txt_vat;
        $ait = $request->txt_ait == null ? 0 : (int)$request->txt_ait;
        $other = $request->txt_other == null ? 0 : (int)$request->txt_other;
        $sub_total =  ($request->txt_month_qty * ($request->txt_rate * $request->txt_lift_qty));
        $grand_total =  ($sub_total + $vat + $ait + $other) - $discount;


        $data = array();
        $data['subject'] = $request->txt_subject;
        $data['issue_date'] = $request->txt_issue_date;
        $data['description'] = $request->txt_description;
        $data['due_description'] = $request->txt_due_description;
        $data['start_date'] = $request->txt_start_date;
        $data['end_date'] = $request->txt_end_date;
        //
        $data['vat_percent'] = $vat_percent;
        $data['ait_percent'] = $ait_percent;
        //
        $data['month_qty'] = $request->txt_month_qty;
        $data['lift_qty'] = $request->txt_lift_qty;
        $data['rate'] = $request->txt_rate;
        $data['total'] =  $sub_total;
        $data['discount'] = $discount;
        $data['vat'] =  $vat;
        $data['ait'] =   $ait;
        $data['other'] = $other;
        $data['grand_total'] = $grand_total;
        $data['update_user_id'] = Auth::user()->emp_id;
        $data['update_date'] = date("Y-m-d");
        $data['update_time'] = date("h:i:s");
        DB::table('pro_service_bill_master')->where('service_bill_master_id', $id)->update($data);
        return redirect()->route('rpt_servicing_bill_view', $id)->with('success', "Update Successfull!");
    }

    //report servicing bill
    public function rpt_servicing_bill_list()
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('status', 1)
            ->orderByDesc('service_bill_master_id')
            ->get();
        return view('service.rpt_servicing_bill_list', compact('service_bill_master'));
    }
    public function rpt_search_serviceing_bill(Request $request)
    {
        $rules = [
            'txt_from' => 'required',
            'txt_to' => 'required',
        ];

        $customMessages = [
            'txt_from.required' => 'From is required.',
            'txt_to.required' => 'To is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $service_bill_master = DB::table('pro_service_bill_master')
            ->whereBetween('pro_service_bill_master.bill_date', [$request->txt_from, $request->txt_to])
            ->whereIn('status', [1, 2])
            ->get();
        return view('service.rpt_servicing_bill_list', compact('service_bill_master'));
    }
    public function rpt_servicing_bill_view($id)
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $id)
            ->first();
        return view('service.rpt_servicing_bill_view', compact('service_bill_master'));
    }
    public function rpt_servicing_bill_print($id)
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $id)
            ->first();
        return view('service.rpt_servicing_bill_print', compact('service_bill_master'));
    }

    //

    public function rpt_bill_summery()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');
        $m_project = DB::table('pro_projects')
            ->where('valid', 1)
            ->get();
        return view('service.rpt_bill_summery', compact('m_project', 'form', 'to'));
    }
    public function rpt_bill_summery_details($id)
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('project_id', $id)
            ->where('valid', 1)
            ->get();

        $m_money_receipt = DB::table('pro_service_money_receipt')
            ->where('project_id', $id)
            ->where('valid', 1)
            ->get();

        return view('service.rpt_bill_summery_details', compact('service_bill_master', 'm_money_receipt'));
    }
    //Bill Assign

    public function bill_assign()
    {
        $bill_assign_list = DB::table('pro_service_bill_assign')
            ->whereIn('status', [1, 2])
            ->orderByDesc('bill_assign_id')
            ->take('50')
            ->get();
        $service_bill_master = DB::table('pro_service_bill_master')
            ->whereIn('status', [1, 2])
            ->whereNull('bill_status')
            ->orderByDesc('service_bill_master_id')
            ->get();
        $m_employee = DB::table('pro_employee_info')
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->get();
        return view('service.bill_assign', compact('service_bill_master', 'm_employee', 'bill_assign_list'));
    }

    public function bill_assign_store(Request $request)
    {
        $rules = [
            'cbo_service_bill_no' => 'required',
            'cbo_employee_id' => 'required',
            'txt_remark' => 'required',
        ];

        $customMessages = [
            'cbo_service_bill_no.required' => 'Select Bill No.',
            'cbo_employee_id.required' => 'Select Employee.',
            'txt_remark.required' => 'Remark is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_no', $request->cbo_service_bill_no)
            ->first();

        $data = array();
        $data['service_bill_master_id'] = $service_bill_master->service_bill_master_id;
        $data['service_bill_no'] = $service_bill_master->service_bill_no;
        $data['customer_id'] = $service_bill_master->customer_id;
        $data['project_id'] = $service_bill_master->project_id;
        $data['employee_id'] = $request->cbo_employee_id;
        $data['remarks'] = $request->txt_remark;
        $data['colection_date'] = date("Y-m-d");
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_service_bill_assign')->insert($data);

        return back()->with('success', "Assign Successfully");
    }

    public function bill_assign_list()
    {
        $bill_assign_list = DB::table('pro_service_bill_assign')
            ->whereIn('status', [1, 2, 3])
            ->orderByDesc('bill_assign_id')
            ->get();

        return view('service.bill_assign_list', compact('bill_assign_list'));
    }

    //

    public function serviceStartJourney(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        $bill_assign_list = DB::table('pro_service_bill_assign')
            ->where('bill_assign_id', $bill_assign_id)
            ->update([
                'start_journey_lat' => $request->latitude,
                'start_journey_long' => $request->longitude,
                'start_journey_date' => date("Y-m-d"),
                'start_journey_time' => date("H:i:s"),
                'status' => 2,
            ]);
        return back()->with('success', 'Start Journey Successfull!');
    }

    public function ServiceEndJourney(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        return view('service.bill_assign_journey', compact('bill_assign_id'));
    }

    public function ServiceEndJourneyStore(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        $bill_assign_list = DB::table('pro_service_bill_assign')
            ->where('bill_assign_id', $bill_assign_id)
            ->update([
                'reached_lat' => $request->latitude,
                'reached_long' => $request->longitude,
                'reached_date' => date("Y-m-d"),
                'reached_time' => date("H:i:s"),
                'reached_fare' => $request->txt_fare,
                'transport_type' => $request->cbo_transport_type,
                'status' => 3,
            ]);
        return redirect()->route('bill_assign_list')->with('success', 'End Journey Successfull!');
    }

    public function review(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        return view('service.review', compact('bill_assign_id'));
    }



    public function review_final(Request $request)
    {
        $rules = [
            'txt_remark' => 'required',
        ];

        $customMessages = [
            'txt_remark.required' => 'Description is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $bill_assign_id = $request->txt_bill_assign_id;
        DB::table('pro_service_bill_assign')
            ->where('bill_assign_id', $bill_assign_id)
            ->update([
                'status' => 4,
                'review' => $request->txt_remark,
            ]);

        return redirect()->route('bill_assign_list')->with('success', 'Review Successfull!');
    }

    //Bill Collection list
    public function bill_collection_list()
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            ->whereIn('status', [1, 2])
            ->whereNull('bill_status')
            ->orderByDesc('service_bill_master_id')
            ->get();
        return view('service.bill_collection_list', compact('service_bill_master'));
    }
    public function servicing_add_money($id)
    {
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $id)
            ->first();
        $m_customer = DB::table('pro_customers')
            ->where('customer_id', $service_bill_master->customer_id)
            ->where('valid', '1')
            ->first();
        $m_money_receipt = DB::table('pro_service_money_receipt')
            ->where('service_bill_master_id', $id)
            ->get();
        return view('service.servicing_add_money', compact('service_bill_master', 'm_customer', 'm_money_receipt'));
    }

    public function servicing_store_money(Request $request)
    {
        $rules = [
            'cbo_payment_type' => 'required',
            'txt_amount' => 'required',
        ];

        $customMessages = [
            'cbo_payment_type.required' => 'Payment type is required.',
            'txt_amount.required' => 'Amount is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->cbo_payment_type == 2) {
            $rules = [
                'txt_bank' => 'required',
                'txt_dd_no' => 'required',
                'txt_dd_date' => 'required',
            ];

            $customMessages = [
                'txt_bank.required' => 'Bank is required.',
                'txt_dd_no.required' => 'Chq/PO/DD No is required.',
                'txt_dd_date.required' => 'Chq/PO/DD Date is required.',
            ];
            $this->validate($request, $rules, $customMessages);
        }

        //receipt_no
        $m_receipt = DB::table('pro_service_money_receipt')->orderByDesc("receipt_no")->first();
        if ($m_receipt == null) {
            $money_receipt_no = date("ymd") . "00001SMR";
        } else {
            $array = str_split("$m_receipt->receipt_no");
            $old_year =  "$array[0]$array[1]";
            $current_year = date('y');
            if ($current_year > $old_year) {
                $money_receipt_no = date("ymd") . "00001SMR";
            } else {
                $mnum = str_replace("SMR", "", $m_receipt->receipt_no);
                $money_receipt_no =  date("ymd") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "SMR";
            }
        }

        //
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $request->txt_service_bill_master_id)
            ->first();

        $data = array();
        $data['receipt_no'] = $money_receipt_no;
        $data['service_bill_master_id'] = $service_bill_master->service_bill_master_id;
        $data['customer_id'] = $service_bill_master->customer_id;
        $data['project_id'] = $service_bill_master->project_id;
        $data['collection_date'] = date("Y-m-d");
        $data['payment_type'] = $request->cbo_payment_type; // 1->cash , 2->checq
        $data['bank'] = $request->txt_bank;
        $data['chq_no'] = $request->txt_dd_no;
        $data['chq_date'] = $request->txt_dd_date;
        $data['paid_amount'] = $request->txt_amount;
        $data['amount_word'] = $request->txt_amount_word;
        $data['remark'] = $request->txt_remark;
        $data['status'] = '1';
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_service_money_receipt')->insert($data);

        //status 
        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $request->txt_service_bill_master_id)
            ->update(['status' => 2]);

        $service_bill_master = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $request->txt_service_bill_master_id)
            ->update(['status' => 2]);

        return redirect()->route('bill_collection_list')->with('success', 'Add Successfully');
    }

    public function service_mr_list($id)
    {
        $m_money_receipt = DB::table('pro_service_money_receipt')
            ->where('service_bill_master_id', $id)
            ->get();
        return view('service.service_mr_list', compact('m_money_receipt'));
    }

    //Bill Collection list
    public function approved_bill_collection()
    {
        $service_money_receipt = DB::table('pro_service_money_receipt')
            ->where('valid', 1)
            ->orderByDesc('smr_id')
            ->get();
        return view('service.approved_bill_collection', compact('service_money_receipt'));
    }

    public function approved_bill_collection_ok(Request $request)
    {
        //
        $service_mr = DB::table('pro_service_money_receipt')
            ->where('smr_id', $request->txt_smr_id)
            ->first();
        DB::table('pro_service_money_receipt')
            ->where('smr_id', $request->txt_smr_id)
            ->update([
                'approved_id' => Auth::user()->emp_id,
                'approved_status' => 1,
                'approved_date' => date("Y-m-d"),
                'approved_time' => date("h:i:s")
            ]);
        DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $service_mr->service_bill_master_id)
            ->update([
                'approved_id' => Auth::user()->emp_id,
                'approved_status' => 1
            ]);

        //bill status -> complite payment
        $service_bill_grand_total = DB::table('pro_service_bill_master')
            ->where('service_bill_master_id', $service_mr->service_bill_master_id)
            ->where('valid', 1)
            ->sum('grand_total');

        $service_recive_total = DB::table('pro_service_money_receipt')
            ->where('service_bill_master_id', $service_mr->service_bill_master_id)
            ->where('approved_status', 1)
            ->where('valid', 1)
            ->sum('paid_amount');

        if ($service_recive_total == $service_bill_grand_total) {
            DB::table('pro_service_bill_master')
                ->where('service_bill_master_id', $service_mr->service_bill_master_id)
                ->update(["bill_status" => 1]);
        }
        return back()->with('success', 'Received Successfuly');
    }


    // End Money receipt

    public function RPTServiceInvoiceList()
    {
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();

        return view('service.rpt_service_invoic_list', compact('m_customer'));
    }
    public function RPTServiceInvoiceDetails($id)
    {
        $ser_bill_master = DB::table('pro_service_bill_master')
            ->where('customer_id', $id)
            ->where('valid', 1)
            ->get();

        $m_paid_amount = DB::table('pro_money_receipt')
            ->where('customer_id', $id)
            ->where('valid', '1')
            ->sum('paid_amount');

        return view('service.rpt_service_invoic_details', compact('ser_bill_master', 'm_paid_amount'));
    }

    //warrenty_period 
    public function warrenty_period()
    {
        $contact_service = DB::table('pro_ct_services')->get();
        return view('service.warrenty_period', compact('contact_service'));
    }

    public function rpt_service_summery()
    {
        $form = "";
        $to = "";
        $employee_01 = "";
        $project_01 = "";

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
            ->where('pro_task_assign.department_id', 1)
            ->where('pro_task_assign.valid', '1')
            ->orderByDesc('pro_task_assign.task_id')
            ->take(100)
            ->get();
        return view('service.rpt_service_summery', compact('m_task_register', 'form', 'to', 'employee_01', 'project_01'));
    }

    //RPT Task Search
    public function rpt_summery_search(Request $request)
    {

        $employee = $request->cbo_employee_id;
        $project = $request->cbo_projet_id;

        if ($request->txt_to && $request->txt_from) {
            $to2 = $request->txt_to;
            $form2 = $request->txt_from;
        } else {
            $to2 = date('Y-m-d');
            $form2 = "1990-01-01";
        }

        $data = DB::table('pro_task_assign')
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
            ->where('pro_task_assign.department_id', 1)
            ->where('pro_task_assign.valid', '1')
            ->whereBetween('pro_task_assign.entry_date', [$form2, $to2])
            ->orderByDesc('pro_task_assign.task_id');

        if ($employee && $project == null) {
            $m_task_register = $data->where('pro_task_assign.team_leader_id', $employee)->get();
        } elseif ($employee == null && $project) {
            $m_task_register = $data->where('pro_task_assign.project_id', $project)
                ->get();
        } elseif ($employee && $project) {
            $m_task_register = $data->where('pro_task_assign.team_leader_id', $employee)
                ->where('pro_task_assign.project_id', $project)
                ->get();
        } else {
            $m_task_register = $data->get();
        }


        $employee_01 =  $employee == null ? "" : $employee;
        $project_01 =  $project == null ? "" : $project;
        $form = $request->txt_from == null ? "" : $request->txt_from;
        $to = $request->txt_to == null ? "" : $request->txt_to;

        return view('service.rpt_service_summery', compact('m_task_register', 'form', 'to', 'employee_01', 'project_01'));
    }

    //Ajax call get- Project
    public function GetProject($id)
    {
        $data = DB::table('pro_projects')
            ->where('valid', '1')
            ->where('customer_id', $id)
            ->get();
        return json_encode($data);
    }
    public function GetLift($id)
    {
        $data = DB::table('pro_lifts')
            ->where('valid', '1')
            ->where('project_id', $id)
            ->get();
        return json_encode($data);
    }

    public function GetReqProductSubGroup($id)
    {
        $data = DB::table('pro_product_sub_group')
            ->where('pg_id', $id)
            ->get();
        return response()->json($data);
    }


    public function GetReqProduct($id)
    {
        $data = DB::table('pro_product')
            ->where('pg_id', $id)
            ->get();
        return response()->json($data);
    }

    // public function GetProductSubGroup($id, $id2)
    // {

    //     $product = DB::table('pro_requisition_details')->where('requisition_master_id', $id2)->pluck('pg_sub_id');

    //     $data = DB::table('pro_product_sub_group')
    //         ->where('pg_id', $id)
    //         // ->whereNotIn("pg_sub_id", $product)
    //         ->get();

    //     return response()->json($data);
    // }

    public function GetProduct($id, $id2)
    {

        $product = DB::table('pro_requisition_details')->where('requisition_master_id', $id2)->pluck('product_id');

        $data = DB::table('pro_product')
            ->where('pg_sub_id', $id)
            ->whereNotIn("product_id", $product)
            ->get();

        return response()->json($data);
    }

    //service materila issue

    // public function GetSMIProductSubGroup($id, $id2)
    // {
    //     $product = DB::table('pro_service_material_issue_details')->where('smi_master_id', $id2)->pluck('pg_sub_id');

    //     $data = DB::table('pro_product_sub_group')
    //         ->where('pg_id', $id)
    //         // ->whereNotIn("pg_sub_id", $product)
    //         ->get();

    //     return response()->json($data);
    // }

    public function GetSMIProduct($id, $id2)
    {
        $product = DB::table('pro_service_material_issue_details')->where('smi_master_id', $id2)->pluck('product_id');

        $data = DB::table('pro_product')
            ->where('pg_id', $id)
            ->whereNotIn("product_id", $product)
            ->get();

        return response()->json($data);
    }


    public function GetProductUnit($id)
    {
        $product = DB::table('pro_product')
            ->where('product_id', $id)
            ->first();
        $data = DB::table('pro_units')->where('unit_id', $product->unit_id)->first();
        return response()->json($data);
    }

    //Get money receive 
    public function GetMoneyReceipt($id)
    {
        $data = DB::table('pro_projects')
            ->where('valid', '1')
            ->where('customer_id', $id)
            ->get();
        return json_encode($data);
    }

    //Get bill Project
    public function GetCompliteProject($id)
    {

        $project_id = DB::table('pro_complaint_register')
            ->where('customer_id', $id)
            ->where('bill_status', NULL)
            ->where('valid', 1)
            ->pluck('project_id');

        $data = DB::table('pro_projects')
            ->whereIn('project_id', $project_id)
            ->where('customer_id', $id)
            ->where('valid', '1')
            ->get();

        return json_encode($data);
    }
}
