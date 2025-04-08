<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


//department_id -> 4 electrical
class ElectricalController extends Controller
{
    public function elc_task_assign()
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
            ->where('department_id', 4)
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
        return view('electrical.elc_task_assign', compact('mech_employee', 'mt_task_assign', 'm_customer', 'm_project', 'm_lift'));
    }

    public function elc_task_assign_store(Request $request)
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
            'department_id' => 4,
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
        $data['department_id'] = 4; //4 -- Electrical
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

            return redirect()->route('elc_helper_information', $task_id);
        } else {
            return back()->with('warning', "Data Not Found !");
        }
    }

    public function elc_task_assign_edit($id)
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

        return view('electrical.elc_task_assign', compact('mech_employee', 'm_task_assign', 'm_customer'));
    }
    public function elc_task_assign_update(Request $request, $id)
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
        return redirect()->route('elc_helper_information', $id);
    }

    public function elc_helper_information($id)
    {
        $task = DB::table('pro_task_assign')->where("task_id", $id)->first();
        $helper_id = DB::table('pro_helpers')
            ->where('valid', 1)
            ->where('task_id', $id)
            ->pluck('helper_id');

        $data = ["$task->team_leader_id", '00000101', '00000102', '00000103', '00000104', '00000184', '00000185', '00000186'];

        for ($i = 0; $i < count($helper_id); $i++) {
            array_push($data, $helper_id[$i]);
        }

        $helper = DB::table('pro_employee_info')
            ->whereNotIn('employee_id', $data)
            ->where('working_status', 1)
            ->get();

        $mt_task_assign = DB::table('pro_task_assign')->where('task_id', $id)->first();
        return view('electrical.helper_information', compact('mt_task_assign', 'helper'));
    }

    public function elc_add_helper(Request $request, $task_id)
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

    public function elc_edit_helper($id)
    {
        $edit_helper =  DB::table('pro_helpers')->where('id', $id)->first();
        $data = ["$edit_helper->team_leader_id", '00000101', '00000102', '00000103', '00000104', '00000184', '00000185', '00000186'];
        $helper = DB::table('pro_employee_info')
            ->whereNotIn('employee_id', $data)
            ->where('working_status', 1)
            ->get();
        return view('electrical.helper_information', compact('edit_helper', 'helper'));
    }

    public function elc_remove_helper($id)
    {
        DB::table('pro_helpers')->where('id', $id)->update(['valid' => 0, 'status' => 0]);
        return back()->with('Success', "Remove Successfully");
    }

    public function elc_update_helper(Request $request, $id)
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
        return redirect()->route('elc_helper_information', $task_id);
    }


    public function elc_task_assign_final()
    {
        return redirect()->route('elc_task_assign');
    }

    //end task assign entry

    public function rpt_electrical_summery()
    {
        $form = "";
        $to = "";
        $employee_01 = "";
        $project_01 = "";
        return view('electrical.rpt_electrical_summery', compact('form', 'to', 'employee_01', 'project_01'));
    }

    //RPT Task Search
    public function rpt_electrical_summery_search(Request $request)
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
                    ->where('pro_task_assign.department_id', 4)
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
                    ->where('pro_task_assign.department_id', 4)
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
                    ->where('pro_task_assign.department_id', 4)
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
                    ->where('pro_task_assign.department_id', 4)
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
                    ->where('pro_task_assign.department_id', 4)
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
                        ->where('pro_task_assign.department_id', 4)
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
                        ->where('pro_task_assign.department_id', 4)
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

        return view('electrical.rpt_electrical_summery', compact('m_task_register', 'form', 'to', 'employee_01', 'project_01'));
    }

    //rpt task View
    public function rpt_elc_task_view($task_id)
    {
        $mt_task_assign = DB::table('pro_task_assign')
            ->where('task_id', $task_id)
            ->where('valid', 1)
            ->first();
        return view('electrical.rpt_task_view', compact('mt_task_assign'));
    }
}
