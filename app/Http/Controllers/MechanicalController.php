<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//department_id -> 3 Mechanical
class MechanicalController extends Controller
{

    //start project
    public function projectInfo()
    {
        $projects = DB::table("pro_projects")
            ->join("pro_customers", "pro_projects.customer_id", "pro_customers.customer_id")
            ->select("pro_projects.*", "pro_customers.customer_name")
            ->get();
        $customers = DB::table("pro_customers")
            ->where('valid', 1)
            ->get();

        return view('mechanical.mech_project_info', compact('projects', 'customers'));
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

        // $handover_date = $request->txt_pro_handover_date;
        // $warranty = $request->txt_warranty;
        // $time = strtotime("$handover_date");
        // $warranty_end_date = date("Y-m-d", strtotime("+$warranty month", $time));

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
        return view('mechanical.mech_project_info', compact('m_project', 'm_customer'));
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

            return redirect(route('mech_project_info'))->with('success', 'Data Updated Successfully!');
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
        return view('mechanical.mech_lift_info', compact('lifts', 'projects'));
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
        return view('mechanical.mech_lift_info', compact('m_lifts', 'projects'));
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
        return redirect()->route('mech_lift_info')->with('success', "Updated Successfull !");
    }
    //End Lift


    public function mech_task_assign()
    {
        $data = ['00000101', '00000102', '00000103', '00000104', '00000184', '00000185', '00000186'];
        $mech_employee = DB::table('pro_employee_info')
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select('pro_employee_info.*', 'pro_department.department_name')
            ->whereNotIn('employee_id', $data)
            ->where('working_status', 1)
            ->get();

        $mt_task_assign = DB::table('pro_task_assign')
            ->where('complete_task', NULL)
            ->where('department_id', 3)
            ->where('valid', 1)
            ->orderByDesc('task_id')
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
        return view('mechanical.mech_task_assign', compact('mech_employee', 'mt_task_assign', 'm_customer', 'm_project', 'm_lift'));
    }

    public function mech_task_assign_store(Request $request)
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
            'department_id' => 3,
            'status' => 2,
            'valid' => 1,
            'user_id' => Auth::user()->emp_id,
            'entry_date' => date("Y-m-d"),
            'entry_time' => date("h:i:s"),
        ]);


        $data = array();
        $data['complain_id'] = $complain_id;
        $data['customer_id'] = $request->cbo_customer_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['department_id'] = 3; //3 -- Mechanical
        $data['lift_id'] = $request->cbo_lift_id;
        $data['team_leader_id'] = $request->cbo_team_id;
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

            return redirect()->route('mech_helper_information', $task_id);
        } else {
            return back()->with('warning', "Data Not Found !");
        }
    }

    public function mech_task_assign_edit($id)
    {
        $data = ['00000101', '00000102', '00000103', '00000104', '00000184', '00000185', '00000186'];
        $mech_employee = DB::table('pro_employee_info')
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select('pro_employee_info.*', 'pro_department.department_name')
            ->whereNotIn('employee_id', $data)
            ->where('working_status', 1)
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

        return view('mechanical.mech_task_assign', compact('mech_employee', 'm_task_assign', 'm_customer'));
    }
    public function mech_task_assign_update(Request $request, $id)
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
        $data['team_leader_id'] = $request->cbo_team_id;
        $data['user_id'] = Auth::user()->emp_id;
        $data['remark'] = $request->txt_remark;
        DB::table('pro_task_assign')->where("task_id", $id)->update($data);
        return redirect()->route('mech_helper_information', $id);
    }

    public function mech_helper_information($id)
    {
        $task = DB::table('pro_task_assign')->where("task_id", $id)->first();
        $helper_id = DB::table('pro_helpers')
            ->where('task_id', $id)
            ->pluck('helper_id');

        $data = ["$task->team_leader_id"];

        for ($i = 0; $i < count($helper_id); $i++) {
            array_push($data, $helper_id[$i]);
        }

        $helper = DB::table('pro_employee_info')
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select('pro_employee_info.*', 'pro_department.department_name')
            ->whereNotIn('employee_id', $data)
            ->where('pro_employee_info.leader_healper_status', 1)
            ->where('pro_employee_info.working_status', 1)
            ->Where('pro_employee_info.valid', 1)
            ->get();

        $mt_task_assign = DB::table('pro_task_assign')->where('task_id', $id)->first();
        return view('mechanical.helper_information', compact('mt_task_assign', 'helper'));
    }

    public function mech_add_helper(Request $request, $task_id)
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
        $data['team_leader_id'] = $ms_task_assign->team_leader_id;
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

    public function mech_edit_helper($id)
    {
        $edit_helper =  DB::table('pro_helpers')->where('id', $id)->first();
        $data = ["$edit_helper->team_leader_id"];
        $helper = DB::table('pro_employee_info')
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select('pro_employee_info.*', 'pro_department.department_name')
            ->whereNotIn('employee_id', $data)
            ->where('pro_employee_info.leader_healper_status', 1)
            ->where('pro_employee_info.working_status', 1)
            ->Where('pro_employee_info.valid', 1)
            ->get();

        return view('mechanical.helper_information', compact('edit_helper', 'helper'));
    }

    public function mech_remove_helper($id)
    {
        DB::table('pro_helpers')->where('id', $id)->update(['valid' => 0, 'status' => 0]);
        return back()->with('Success', "Remove Successfully");
    }

    public function mech_update_helper(Request $request, $id)
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
        return redirect()->route('mech_helper_information', $task_id);
    }


    public function mech_task_assign_final()
    {
        return redirect()->route('mech_task_assign');
    }

    //end task assign entry

    public function rpt_mechanical_summery()
    {
        $form = "";
        $to = "";
        $employee_01 = "";
        $project_01 = "";
        return view('mechanical.rpt_mechanical_summery', compact('form', 'to', 'employee_01', 'project_01'));
    }

    //RPT Task Search
    public function rpt_mechanical_summery_search(Request $request)
    {

        $employee = $request->cbo_employee_id;
        $project = $request->cbo_projet_id;


        if ($employee && $project == null) {
            $rules = [
                'cbo_employee_id' => 'required',
            ];

            $customMessages = [
                'cbo_employee_id.required' => 'Employee is Required.',
            ];
            $this->validate($request, $rules, $customMessages);

            if ($request->txt_from) {
                $rules = [
                    'txt_to' => 'required',
                    'txt_from' => 'required',
                ];

                $customMessages = [
                    'txt_to.required' => 'To is Required.',
                    'txt_from.required' => 'Form is Required.',
                ];
                $this->validate($request, $rules, $customMessages);

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
                    ->where('pro_task_assign.department_id', 3)
                    ->where('pro_task_assign.valid', '1')
                    ->where('pro_task_assign.team_leader_id', $employee)
                    ->whereBetween('pro_task_assign.entry_date', [$request->txt_from, $request->txt_to])
                    ->orderByDesc('pro_task_assign.task_id')
                    ->get();
            } //with date
            else {
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
                    ->where('pro_task_assign.department_id', 3)
                    ->where('pro_task_assign.valid', '1')
                    ->where('pro_task_assign.team_leader_id', $employee)
                    ->orderByDesc('pro_task_assign.task_id')
                    ->get();
            } //witout date
        } else if ($employee == null && $project) {
            $rules = [
                'cbo_projet_id' => 'required',
            ];

            $customMessages = [
                'cbo_projet_id.required' => 'Employee is Required.',
            ];
            $this->validate($request, $rules, $customMessages);

            if ($request->txt_from) {
                $rules = [
                    'txt_to' => 'required',
                    'txt_from' => 'required',
                ];

                $customMessages = [
                    'txt_to.required' => 'To is Required.',
                    'txt_from.required' => 'From is Required.',
                ];
                $this->validate($request, $rules, $customMessages);

                $form = $request->txt_from;
                $to = $request->txt_to;

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
                    ->where('pro_task_assign.department_id', 3)
                    ->where('pro_task_assign.valid', '1')
                    ->where('pro_task_assign.project_id', $project)
                    ->whereBetween('pro_task_assign.entry_date', [$request->txt_from, $request->txt_to])
                    ->orderByDesc('pro_task_assign.task_id')
                    ->get();
            } //with date
            else {
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
                    ->where('pro_task_assign.department_id', 3)
                    ->where('pro_task_assign.valid', '1')
                    ->where('pro_task_assign.project_id', $project)
                    ->orderByDesc('pro_task_assign.task_id')
                    ->get();
            } //witout date
        } else { //default 

            if ($employee == null && $project == null) {
                $rules = [
                    'txt_to' => 'required',
                    'txt_from' => 'required',
                ];

                $customMessages = [
                    'txt_to.required' => 'To is Required.',
                    'txt_from.required' => 'From is Required.',
                ];
                $this->validate($request, $rules, $customMessages);

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
                    ->where('pro_task_assign.department_id', 3)
                    ->where('pro_task_assign.valid', '1')
                    ->whereBetween('pro_task_assign.entry_date', [$request->txt_from, $request->txt_to])
                    ->orderByDesc('pro_task_assign.task_id')
                    ->get();
            } // without employee and developer only  date
            else {

                $rules = [
                    'cbo_employee_id' => 'required',
                    'cbo_projet_id' => 'required',
                ];

                $customMessages = [
                    'cbo_employee_id.required' => 'Employee is Required.',
                    'cbo_projet_id.required' => 'Employee is Required.',
                ];
                $this->validate($request, $rules, $customMessages);

                if ($request->txt_from) {
                    $rules = [
                        'txt_to' => 'required',
                        'txt_from' => 'required',
                    ];

                    $customMessages = [
                        'txt_to.required' => 'To is Required.',
                        'txt_from.required' => 'From is Required.',
                    ];
                    $this->validate($request, $rules, $customMessages);

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
                        ->where('pro_task_assign.department_id', 3)
                        ->where('pro_task_assign.valid', '1')
                        ->where('pro_task_assign.team_leader_id', $employee)
                        ->where('pro_task_assign.project_id', $project)
                        ->whereBetween('pro_task_assign.entry_date', [$request->txt_from, $request->txt_to])
                        ->orderByDesc('pro_task_assign.task_id')
                        ->get();
                } //with date
                else {
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
                        ->where('pro_task_assign.department_id', 3)
                        ->where('pro_task_assign.valid', '1')
                        ->where('pro_task_assign.team_leader_id', $employee)
                        ->where('pro_task_assign.project_id', $project)
                        ->orderByDesc('pro_task_assign.task_id')
                        ->get();
                } //witout date

            } //with employ and developer 


        } //default


        $employee_01 =  $employee == null ? "" : $employee;
        $project_01 =  $project == null ? "" : $project;
        $form = $request->txt_from == null ? "" : $request->txt_from;
        $to = $request->txt_to == null ? "" : $request->txt_to;

        return view('mechanical.rpt_mechanical_summery', compact('m_task_register', 'form', 'to', 'employee_01', 'project_01'));
    }

    //rpt task View
    public function rpt_mech_task_view($task_id)
    {
        $mt_task_assign = DB::table('pro_task_assign')
            ->where('task_id', $task_id)
            ->where('valid', 1)
            ->first();
        return view('mechanical.rpt_task_view', compact('mt_task_assign'));
    }
}
