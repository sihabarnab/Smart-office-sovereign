<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SMS\create_sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeUnit\FunctionUnit;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //auto process , send sms
    use create_sms;

    //Mode of pament
    public function mode_of_payment()
    {
        $m_mode = DB::table('pro_mode_of_payment')->where('valid', 1)->get();
        return view('maintenance.mode_of_payment', compact('m_mode'));
    }

    public function mode_of_payment_store(Request $request)
    {
        $rules = [
            'txt_remark' => 'required',
        ];
        $customMessages = [
            'txt_remark.required' => 'Title is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['mode_title'] = $request->txt_remark;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table("pro_mode_of_payment")->insert($data);
        return back()->with('success', "Data Inserted Successfully!");
    }

    public function mode_of_payment_edit($id)
    {
        $m_mode_edit = DB::table('pro_mode_of_payment')->where('mode_id', $id)->first();
        return view('maintenance.mode_of_payment', compact('m_mode_edit'));
    }

    public function mode_of_payment_update(Request $request)
    {
        $rules = [
            'txt_remark' => 'required',
        ];
        $customMessages = [
            'txt_remark.required' => 'Title is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['mode_title'] = $request->txt_remark;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        DB::table("pro_mode_of_payment")->where('mode_id', $request->txt_mode_id)->update($data);
        return redirect()->route('mode_of_payment')->with('success', "Data Update Successfully!");
    }

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
        return view('maintenance.mt_team_info', compact('teams', 'leaders'));
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
        return view('maintenance.mt_team_info', compact('edit_teams', 'leaders'));
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
        return redirect()->route('mt_team_info')->with('success', "Data Updated Successfully!");
    }
    //End Team

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

        return view('maintenance.mt_project_info', compact('projects', 'customers'));
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

        return view('maintenance.mt_project_info', compact('m_project', 'm_customer'));
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

            return redirect(route('mt_project_info'))->with('success', 'Data Updated Successfully!');
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
        return view('maintenance.mt_lift_info', compact('lifts', 'projects'));
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
        return view('maintenance.mt_lift_info', compact('m_lifts', 'projects'));
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
        return redirect()->route('mt_lift_info')->with('success', "Updated Successfull !");
    }
    //End Lift


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

        return view('maintenance.mt_contract_service_info', compact('contact_services', 'projects', 'm_bill_type'));
    }
    public function contract_service_info_store(Request $request)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,20000',
            'txt_ct_period_start' => 'required',
            'txt_ct_period_end' => 'required',
            'txt_lift_qty' => 'required',
            'txt_service_bill' => 'required',
            'cbo_bill_type_id' => 'required|integer|between:1,10',
        ];
        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_ct_period_start.required' => 'Start date is required.',
            'txt_ct_period_end.required' => 'End date is required.',
            'txt_lift_qty.required' => 'Lift qty is required.',
            'txt_service_bill.required' => 'Service bill is required.',
            'cbo_bill_type_id.required' => 'Bill type is required.',
            'cbo_bill_type_id.integer' => 'Bill type is required.',
            'cbo_bill_type_id.between' => 'Bill type is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['ct_period_start'] = $request->txt_ct_period_start;
        $data['ct_period_end'] = $request->txt_ct_period_end;
        $data['lift_qty'] = $request->txt_lift_qty;
        $data['service_bill'] = $request->txt_service_bill;
        $data['bill_type_id'] = $request->cbo_bill_type_id;
        $data['remark'] = $request->txt_remark;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
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

        return view('maintenance.mt_contract_service_info', compact('m_ct_services', 'projects', 'm_bill_type'));
    }
    public function contract_service_info_update(Request $request, $id)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,20000',
            'txt_ct_period_start' => 'required',
            'txt_ct_period_end' => 'required',
            'txt_lift_qty' => 'required',
            'txt_service_bill' => 'required',
            'cbo_bill_type_id' => 'required|integer|between:1,10',
        ];

        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_ct_period_start.required' => 'Start date is required.',
            'txt_ct_period_end.required' => 'End date is required.',
            'txt_lift_qty.required' => 'Lift qty is required.',
            'txt_service_bill.required' => 'Service bill is required.',
            'cbo_bill_type_id.required' => 'Bill type is required.',
            'cbo_bill_type_id.integer' => 'Bill type is required.',
            'cbo_bill_type_id.between' => 'Bill type is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['ct_period_start'] = $request->txt_ct_period_start;
        $data['ct_period_end'] = $request->txt_ct_period_end;
        $data['lift_qty'] = $request->txt_lift_qty;
        $data['service_bill'] = $request->txt_service_bill;
        $data['bill_type_id'] = $request->cbo_bill_type_id;
        $data['remark'] = $request->txt_remark;
        DB::table("pro_ct_services")->where("ct_service_id", $id)->update($data);
        return redirect()->route('mt_contract_service_info')->with('success', "Updated Successfull !");
    }
    // End Contact service 

    //Project Complite
    public function project_complite()
    {

        $m_project = DB::table('pro_projects')
            ->leftJoin('pro_customers', 'pro_projects.customer_id', 'pro_customers.customer_id')
            ->select('pro_projects.*', 'pro_customers.*')
            ->where('pro_projects.valid', '1')
            ->get();

        return view('maintenance.project_complite', compact('m_project'));
    }

    public function project_complite_store(Request $request)
    {
        $rules = [
            'cbo_project_id' => 'required|integer|between:1,20000',
            'txt_pro_handover_date' => 'required',
        ];

        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'txt_pro_handover_date.required' => 'Complite Date is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_project = DB::table('pro_projects')->where('project_id', $request->cbo_project_id)->first();
        if ($m_project->warranty_end_date == null) {
            $handover_date = $request->txt_pro_handover_date;

            DB::table('pro_projects')->where('project_id', $request->cbo_project_id)->update([
                'handover_date' =>   $handover_date,
                // 'user_id' =>Auth::user()->emp_id(),
            ]);
            return back()->with('success', "Data Updated Successfully!");
        } else {
            return back()->with('warning', "Alredy Updated Successfully!");
        }
    }




    //Task Register
    public function ComplaintRegister()
    {
        $m_complaint_register = DB::table('pro_complaint_register')
            ->join("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->join("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->join("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
            ->select("pro_complaint_register.*", "pro_customers.*", "pro_projects.*", "pro_lifts.*")
            ->where('pro_complaint_register.department_id', '2')
            ->where('pro_complaint_register.valid', '1')
            ->where('pro_complaint_register.status', '1')
            ->orderByDesc('pro_complaint_register.complaint_register_id')
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

        return view('maintenance.mt_complaint_register', compact('m_complaint_register', 'm_customer', 'm_project', 'm_lift'));
    }

    public function complaint_register_store(Request $request)
    {
        $rules = [
            'cbo_customer_id' => 'required|integer|between:1,10000000000',
            'cbo_project_id' => 'required|integer|between:1,2000000',
            'cbo_lift_id' => 'required|integer|between:1,20000000',
            'txt_complaint_description' => 'required',
            // 'requirement' => 'required',
        ];

        $customMessages = [
            'cbo_customer_id.required' => 'Select client.',
            'cbo_customer_id.integer' => 'Select client.',
            'cbo_customer_id.between' => 'Select client.',
            'cbo_project_id.required' => 'Select project.',
            'cbo_project_id.integer' => 'Select project.',
            'cbo_project_id.between' => 'Select project.',
            'cbo_lift_id.required' => 'Select lift.',
            'cbo_lift_id.integer' => 'Select lift.',
            'cbo_lift_id.between' => 'Select lift.',
            'txt_complaint_description.required' => 'Complaint description is required.',
        ];

        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $data = array();
        $data['customer_id'] = $request->cbo_customer_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['lift_id'] = $request->cbo_lift_id;
        $data['complaint_description'] = $request->txt_complaint_description;
        $data['department_id'] = 2; //'2'=>'Maintenance'	
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['valid'] = 1;
        $data['entry_time'] = date("h:i:s");
        $data['entry_date'] = date("Y-m-d");
        $complain_id = DB::table('pro_complaint_register')->insertGetId($data);
        if ($complain_id) {
            $m_complaint_register = DB::table('pro_complaint_register')
                ->join("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
                ->join("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
                ->join("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
                ->select("pro_complaint_register.*", "pro_customers.customer_name", "pro_projects.project_name", "pro_lifts.lift_name")
                ->where('pro_complaint_register.complaint_register_id', $complain_id)
                ->where('pro_complaint_register.department_id', '2')
                ->where('pro_complaint_register.valid', '1')
                ->first();

            $messages = "$m_complaint_register->complaint_description | $m_complaint_register->project_name | $m_complaint_register->lift_name | Date: $m_complaint_register->entry_date | 
            Time: $m_complaint_register->entry_time";
            $report_to = "00000117";
            $link = route("mt_task_assign_massage", $complain_id);
            DB::table('pro_alart_massage')->insert([
                'massage' => $messages,
                'refarence_id' => "c$complain_id",
                'report_to' => $report_to,
                'user_id' => $m_user_id,
                'entry_time' => date("h:i:s"),
                'entry_date' => date("Y-m-d"),
                'valid' => 1,
                'department_id' => 2,  //2 is maintenance
                'link' => $link,
                'color' => "maintenance_color"
            ]);

            //Start Send sms in mobile
            //fixed employee send massage
            $get_employee_phone = DB::table('pro_employee_info')->where('employee_id', '00000117')->first();
            $get_employee_phone_02 = DB::table('pro_employee_info')->where('employee_id', '00000141')->first();

            $multiple_mobile_number = ["88$get_employee_phone_02->mobile", "88$get_employee_phone->mobile"];
            $mobile_massage = "$m_complaint_register->project_name|$m_complaint_register->complaint_description";
            for ($i = 0; $i < 2; $i++) {
                $mobile_number =  $multiple_mobile_number[$i];
                //check mobile number
                if (strlen($mobile_number) == 13) {
                    $response = $this->SendSMS($mobile_number, $mobile_massage);
                    if ($response == 'success') {
                        DB::table('pro_sms')->insert(['mobile_number' => $mobile_number, 'massage' => $mobile_massage, 'status' => 1]);
                    } else {
                        return back()->with('warning', " SMS Send Faild!.");
                    }
                    // if ($response == 'success') {
                } else {
                    return back()->with('warning', "Add data and SMS Send Faild!, valid phone number required.");
                }
                // if (strlen($mobile_number) == 13) {
            }
            //for($i=0;$i<2;$i++){
            //end Send sms in mobile


            return back()->with('success', " SMS Send and Add Data Successfully !");
        } else {
            return back()->with('warning', "Data insert Faild!");
        }
    }

    public function complaint_register_edit($id)
    {
        $m_complaint_register1 = DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->leftJoin("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
            ->select("pro_complaint_register.*", "pro_customers.*", "pro_projects.*", "pro_lifts.*")
            ->where('complaint_register_id', $id)
            ->first();

        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();

        $m_project = DB::table('pro_projects')
            ->where('valid', '1')
            ->get();

        $m_lift = DB::table('pro_lifts')
            ->where('valid', '1')
            ->get();

        return view('maintenance.mt_complaint_register', compact('m_complaint_register1', 'm_customer', 'm_project', 'm_lift'));
    }

    public function complaint_register_update(Request $request, $id)
    {
        $rules = [
            'cbo_customer_id' => 'required|integer|between:1,200000000000',
            'cbo_project_id' => 'required|integer|between:1,20000000000',
            'cbo_lift_id' => 'required|integer|between:1,2000000000000',
            'txt_complaint_description' => 'required',
            // 'requirement' => 'required',
        ];

        $customMessages = [
            'cbo_customer_id.required' => 'Select client.',
            'cbo_customer_id.integer' => 'Select client.',
            'cbo_customer_id.between' => 'Select client.',
            'cbo_project_id.required' => 'Select project.',
            'cbo_project_id.integer' => 'Select project.',
            'cbo_project_id.between' => 'Select project.',
            'cbo_lift_id.required' => 'Select lift.',
            'cbo_lift_id.integer' => 'Select lift.',
            'cbo_lift_id.between' => 'Select lift.',
            'txt_complaint_description.required' => 'Complaint description is required.',
        ];

        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $data = array();
        $data['customer_id'] = $request->cbo_customer_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['lift_id'] = $request->cbo_lift_id;
        $data['complaint_description'] = $request->txt_complaint_description;
        DB::table('pro_complaint_register')->where('complaint_register_id', $id)->update($data);
        return redirect()->route('mt_complaint_register')->with('success', "Data Updated Successfully!");
    }

    //End Register


    //task assign
    public function taskassign()
    {
        //last 30 day 
        $today = date("Y-m-d");
        $previous30day = date("Y-m-d", strtotime("-30 day", strtotime($today)));

        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->get();

        $m_task_register = DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->select(
                "pro_complaint_register.*",
                "pro_customers.customer_name",
                "pro_projects.project_name",
            )
            ->where('pro_complaint_register.department_id', 2)
            ->where('pro_complaint_register.valid', 1)
            ->where('pro_complaint_register.status', 2)
            ->whereBetween('pro_complaint_register.entry_date', [$previous30day, $today])
            ->orderByDesc('pro_complaint_register.complaint_register_id')
            ->get();


        $m_complaint_register = DB::table('pro_complaint_register')
            ->where('department_id', 2)
            ->where('valid', 1)
            ->where('status', 1)
            ->whereBetween('entry_date', [$previous30day, $today])
            ->orderByDesc('complaint_register_id')
            ->get();

        return view('maintenance.mt_task_assign', compact('m_teams', 'm_task_register', 'm_complaint_register'));
    }

    public function mt_task_assign_massage($id)
    {
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->get();
        $row_complaint_register = DB::table('pro_complaint_register')
            ->where('department_id', 2)
            ->where('complaint_register_id', $id)
            ->first();

        return view('maintenance.mt_task_assign_massage', compact('m_teams', 'row_complaint_register'));
    }
    public function task_assign_store(Request $request)
    {
        $rules = [
            'cbo_complain_id' => 'required|required|integer|between:1,10000000000',
            'cbo_team_id' => 'required|required|integer|between:1,200000',
        ];

        $customMessages = [
            'cbo_complain_id.required' => 'Select complain.',
            'cbo_complain_id.integer' => 'Select complain.',
            'cbo_complain_id.between' => 'Select complain.',
            'cbo_team_id.required' => 'Select team.',
            'cbo_team_id.integer' => 'Select team.',
            'cbo_team_id.between' => 'Select team.',
        ];

        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $data = array();
        $complain = DB::table("pro_complaint_register")->where("complaint_register_id", $request->cbo_complain_id)->first();
        $teams = DB::table("pro_teams")->where("team_id", $request->cbo_team_id)->first();
        $data['complain_id'] = $request->cbo_complain_id;
        $data['customer_id'] = $complain->customer_id;
        $data['project_id'] = $complain->project_id;
        $data['lift_id'] = $complain->lift_id;
        $data['team_id'] = $request->cbo_team_id;
        $data['team_leader_id'] = $teams->team_leader_id;
        $data['department_id'] = $complain->department_id; //2 ->Maintenance
        $data['remark'] = $request->txt_remark;
        $data['valid'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_time'] = date("h:i:s");
        $data['entry_date'] = date("Y-m-d");
        $task_id = DB::table('pro_task_assign')->insertGetId($data);
        if ($task_id) {
            DB::table('pro_complaint_register')->where('complaint_register_id', $request->cbo_complain_id)
                ->update([
                    'status' => 2,
                ]);
            // Web notification disable
            DB::table('pro_alart_massage')->where('report_to', $m_user_id)->where('refarence_id', "c$request->cbo_complain_id")->update(['valid' => 0]);

            //Start Send sms in mobile
            $get_project = DB::table('pro_projects')->where('project_id', $complain->project_id)->first();
            $project_name = $get_project->project_name;
            $get_leader_phone = DB::table('pro_employee_info')->where('employee_id', $teams->team_leader_id)->first();
            $mobile_number = "88$get_leader_phone->mobile";
            $massage = "$project_name|$complain->complaint_description";

            //check mobile number
            if (strlen($mobile_number) == 13) {
                $response = $this->SendSMS($mobile_number, $massage);
                if ($response == 'success') {
                    DB::table('pro_sms')->insert(['mobile_number' => $mobile_number, 'massage' => $massage, 'status' => 1]);
                    return redirect()->route('mt_helper_information', $task_id)->with('success', "SMS Send Successfully !");
                } else {
                    return redirect()->route('mt_helper_information', $task_id)->with('warning', "SMS Send Faild!");
                }
                // if ($response == 'success') {
            } else {
                return redirect()->route('mt_helper_information', $task_id)->with('warning', "SMS Send Faild!, valid phone number required.");
            }
            // if (strlen($mobile_number) == 13) {
            //End Send sms in mobile

            // return redirect()->route('mt_helper_information', $task_id)->with('success', "Assign Successfully.");
        } else {
            return back()->with('warning', "Data Not Found !");
        }
        //if ($task_id) {
    }

    public function task_assign_edit($id)
    {
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->get();
        $m_task_assign = DB::table('pro_task_assign')->where("task_id", $id)->first();

        $m_complaint_register =  DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->leftJoin("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
            ->select(
                "pro_complaint_register.*",
                "pro_customers.customer_name",
                "pro_projects.project_name",
                "pro_lifts.lift_name",
            )
            ->where('pro_complaint_register.department_id', 2)
            ->where('pro_complaint_register.valid', 1)
            ->where('pro_complaint_register.status', 2)
            ->orderByDesc('pro_complaint_register.complaint_register_id')
            ->get();

        return view('maintenance.mt_task_assign', compact('m_teams', 'm_task_assign', 'm_complaint_register'));
    }
    public function task_assign_update(Request $request, $id)
    {
        $rules = [
            'cbo_complain_id' => 'required',
            'cbo_team_id' => 'required',
        ];

        $customMessages = [
            'cbo_complain_id.required' => 'Select complain.',
            'cbo_team_id.required' => 'Select team.',
        ];

        $this->validate($request, $rules, $customMessages);
        $ci_teams = DB::table('pro_teams')->Where('team_id', $request->cbo_team_id)->first();

        $data = array();
        $data['complain_id'] = $request->cbo_complain_id;
        $data['team_id'] = $request->cbo_team_id;
        $data['team_leader_id'] = $ci_teams->team_leader_id;
        $data['remark'] = $request->txt_remark;
        DB::table('pro_task_assign')->where("task_id", $id)->update($data);
        return redirect()->route('mt_helper_information', $id)->with('success', "Updated Successfully!");
    }

    //Add Helper 

    public function helper_information($id)
    {
        $task = DB::table('pro_task_assign')->where("task_id", $id)->first();
        $helper_id = DB::table('pro_helpers')
            ->where('task_id', $id)
            ->where('valid', 1)
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
        return view('maintenance.helper_information', compact('mt_task_assign', 'helper'));
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

    public function edit_helper($id)
    {
        $edit_helper =  DB::table('pro_helpers')->where('id', $id)->first();
        $data = ["$edit_helper->team_leader_id", '00000101', '00000102', '00000103', '00000104', '00000184', '00000185', '00000186'];
        $helper = DB::table('pro_employee_info')
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select('pro_employee_info.*', 'pro_department.department_name')
            ->whereNotIn('employee_id', $data)
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->get();
        return view('maintenance.helper_information', compact('edit_helper', 'helper'));
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
        return redirect()->route('mt_helper_information', $task_id)->with('success', "Add Successfull !");
    }

    public function task_assign_final()
    {
        return redirect()->route('mt_task_assign')->with('success', "Add Successfull !");;
    }
    //End Task Assign


    //Task cancel list 
    public function taskcancellist()
    {
        $mt_task_assigns = DB::table('pro_task_assign')
            ->where('department_id', 2)
            ->where('status', 'JOURNEY_FAILED')
            ->where('valid', 1)
            ->orderByDesc('task_id')
            ->get();
        return view('maintenance.mt_task_cancel_list', compact('mt_task_assigns'));
    }

    public function taskReassign($task_id)
    {
        $mt_task_assigns = DB::table('pro_task_assign')
            ->where('task_id', $task_id)
            ->where('department_id', 2)
            ->where('valid', 1)
            ->first();
        return view('maintenance.mt_task_reassign', compact('mt_task_assigns'));
    }



    //Money receipt
    public function MoneyReceipUser()
    {
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();
        $m_money_receipt = DB::table('pro_money_receipt')
            ->where('valid', '1')
            ->get();
        return view('maintenance.mt_money_receipt_user', compact('m_customer', 'm_money_receipt'));
    }
    public function MoneyReceiptAdmin()
    {
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();
        $m_money_receipt = DB::table('pro_money_receipt')
            ->where('valid', '1')
            ->get();
        return view('maintenance.mt_money_receipt_admin', compact('m_customer', 'm_money_receipt'));
    }

    public function money_receipt_store(Request $request)
    {
        $rules = [
            'cbo_customer' => 'required|integer|between:1,20000000',
            'txt_collection_date' => 'required',
            'cbo_payment_type' => 'required|integer|between:1,2000000',
            'txt_amount' => 'required',
        ];

        $customMessages = [
            'cbo_customer.required' => 'Select Customer.',
            'cbo_customer.integer' => 'Select Customer.',
            'cbo_customer.between' => 'Select Customer.',
            'txt_collection_date.required' => 'Date is required.',
            'cbo_payment_type.required' => 'Payment type is required.',
            'cbo_payment_type.integer' => 'Payment type is required.',
            'cbo_payment_type.between' => 'Payment type is required.',
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
        $mr = DB::table('pro_money_receipt')->orderByDesc("receipt_no")->first();

        if ($mr != null) {
            $store = array();
            $number = str_split($mr->receipt_no);
            for ($i = 0; $i < 2; $i++) {
                $store[$i] = $number[$i];
            }
            $year = implode("", $store);
            $new_year = date("y");

            if ($year  == $new_year) {
                $money_receipt_no =  $mr->receipt_no + 1;
            } else {
                $money_receipt_no = date("ym") . "00001";
            }
        } else {
            $money_receipt_no = date("ym") . "00001";
        }

        $data = array();
        $data['receipt_no'] = $money_receipt_no;
        $data['department_id'] = 2;
        $data['customer_id'] = $request->cbo_customer;
        $data['collection_date'] = $request->txt_collection_date;
        $data['payment_type'] = $request->cbo_payment_type;
        $data['bank'] = $request->txt_bank;
        $data['chq_no'] = $request->txt_dd_no;
        $data['chq_date'] = $request->txt_dd_date;
        $data['paid_amount'] = $request->txt_amount;
        $data['amount_word'] = $request->txt_amount_word;
        $data['remark'] = $request->txt_remark;
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_money_receipt')->insert($data);
        return back()->with('success', "Inserted Successfully!");
    }

    public function money_receipt_edit($id)
    {
        $m_customer = DB::table('pro_customers')
            ->where('valid', '1')
            ->get();

        $m_money_receipt_edit = DB::table('pro_money_receipt')
            ->where('money_receipt_id', $id)
            ->first();

        return view('maintenance.mt_money_receipt_admin', compact('m_customer', 'm_money_receipt_edit'));
    }

    public function money_receipt_update(Request $request, $id)
    {
        $rules = [
            'cbo_customer' => 'required|integer|between:1,200000',
            'txt_collection_date' => 'required',
            'cbo_payment_type' => 'required|integer|between:1,200000',
            'txt_amount' => 'required',
        ];

        $customMessages = [
            'cbo_customer.required' => 'Select Customer.',
            'cbo_customer.integer' => 'Select Customer.',
            'cbo_customer.between' => 'Select Customer.',
            'txt_collection_date.required' => 'Date is required.',
            'cbo_payment_type.required' => 'Payment type is required.',
            'cbo_payment_type.integer' => 'Payment type is required.',
            'cbo_payment_type.between' => 'Payment type is required.',
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

        $data = array();
        $data['customer_id'] = $request->cbo_customer;
        $data['collection_date'] = $request->txt_collection_date;
        $data['payment_type'] = $request->cbo_payment_type;
        $data['bank'] = $request->txt_bank;
        $data['chq_no'] = $request->txt_dd_no;
        $data['chq_date'] = $request->txt_dd_date;
        $data['paid_amount'] = $request->txt_amount;
        $data['amount_word'] = $request->txt_amount_word;
        $data['remark'] = $request->txt_remark;

        DB::table('pro_money_receipt')
            ->where('money_receipt_id', $id)
            ->update($data);

        return redirect()->route('mt_money_receipt_admin')->with('success', "Updated Successfully!");
    }

    //End Money Receipt



    //quotation
    public function mt_quotation()
    {
        $m_projects = DB::table('pro_projects')->where('valid', 1)->get();
        $all_quotation_master = DB::table('pro_maintenance_quotation_master')->where('status', 1)->where('valid', 1)->get();
        $reject_quotation_master = DB::table('pro_maintenance_quotation_master')->where('status', 5)->where('valid', 1)->get();
        return view('maintenance.mt_quotation', compact('all_quotation_master', 'm_projects', 'reject_quotation_master'));
    }

    public function mt_quotation_store(Request $request)
    {
        $rules = [
            'txt_customer' => 'required',
            'txt_date' => 'required',
            'txt_address' => 'required',
            'txt_subject' => 'required',
            'txt_valid_until' => 'required',
            'cbo_mode_of_payment' => 'required',
        ];
        $customMessages = [
            'txt_customer.required' => 'Customer name required.',
            'txt_date.required' => 'Date required.',
            'txt_address.required' => 'Address required.',
            'txt_subject.required' => 'Subject required.',
            'txt_valid_until.required' => 'Valid Until required.',
            'cbo_mode_of_payment.required' => 'Select Mode of Payment.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $entry_date = date('Y-m-d');
        $entry_time = date('h:i:s');



        $quotation = DB::table('pro_maintenance_quotation_master')->orderByDesc("quotation_master_id")->first();
        if (isset($quotation)) {
            $mnum = str_replace("Q", "", $quotation->quotation_master_id);
            $quotation_master_id =  date("ymd") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "Q";
        } else {
            $quotation_master_id = date("ymd") . "00001Q";
        }

        //customer
        if ($request->cbo_project_id) {
            $m_project = DB::table('pro_projects')->where('project_id', $request->cbo_project_id)->where('valid', 1)->first();
            $customer =  DB::table('pro_customers')
                ->where('customer_id', $m_project->customer_id)
                ->first();
            $customer_id =  $customer->customer_id;
        }
        // new customer
        else {
            $customer =  DB::table('pro_customers')
                ->where('customer_name', $request->txt_customer)
                ->where('customer_add', $request->txt_address)
                ->first();
            if ($customer) {
                $customer_id =  $customer->customer_id;
            } else {
                $customer_id = DB::table('pro_customers')->insertGetId([
                    'customer_name' => $request->txt_customer,
                    'customer_add' => $request->txt_address,
                    'customer_email' => $request->txt_email,
                    'customer_phone' => $request->txt_mobile_number,
                    'contact_person' => $request->txt_attention,
                    'entry_date' => $entry_date,
                    'entry_time' => $entry_time,
                    'valid' => 1,
                ]);
            }
        }


        $data = array();
        $data['project_id'] = $request->cbo_project_id;
        $data['customer_id'] = $customer_id;
        $data['customer_name'] = $request->txt_customer;
        $data['customer_address'] = $request->txt_address;
        $data['customer_mobile'] = $request->txt_mobile_number;
        $data['subject'] = $request->txt_subject;
        $data['offer_valid'] = $request->txt_valid_until;
        $data['reference'] = $request->txt_reference_name;
        $data['reference_mobile'] = $request->txt_reference_number;
        $data['attention'] = $request->txt_attention;
        $data['entry_date'] = $entry_date;
        $data['entry_time'] = $entry_time;
        $data['user_id'] = $m_user_id;
        $data['valid'] = 1;
        $data['status'] = 1;
        $data['mode_payment_status'] = $request->cbo_mode_of_payment; // 1 yes , 2 No -> mode of payment Not show report
        //
        $data['quotation_master_id'] =  $quotation_master_id;
        $data['quotation_date'] = $request->txt_date;
        //
        $quotation_id = DB::table('pro_maintenance_quotation_master')->insertGetId($data);
        return redirect()->route('mt_quotation_details', $quotation_id);
    }

    public function mt_quotation_details($id)
    {
        $all_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->get();

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')->where('quotation_id', $id)->first();
        $use_product_id = DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->pluck('product_id');

        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->whereNotIn('product_id', $use_product_id)
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', 'ASC')
            ->get();
        return view('maintenance.quotation_details', compact('m_quotation_master', 'm_product', 'all_quotation_details'));
    }

    public function mt_quotation_details_store(Request $request, $id)
    {
        $rules = [
            'cbo_product' => 'required',
            'txt_rate' => 'required',
            'txt_quantity' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product.',
            'txt_rate.required' => 'Rate is required.',
            'txt_quantity.required' => 'Quantity is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $check_product = DB::table('pro_maintenance_quotation_details')
            ->where('product_id', $request->cbo_product)
            ->where('valid', 1)
            ->where('quotation_id', $id)
            ->first();
        if ($check_product) {
            return back()->with('warning', "Alredy Product ADD");
        } else {

            $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();
            $m_quotation_master = DB::table('pro_maintenance_quotation_master')
                ->where('quotation_id', $id)
                ->first();

            $data = array();
            $data['customer_id'] = $m_quotation_master->customer_id;
            $data['quotation_id'] = $m_quotation_master->quotation_id;
            $data['quotation_master_id'] = $m_quotation_master->quotation_master_id;
            $data['quotation_date'] = $m_quotation_master->quotation_date;
            $data['pg_id'] = $m_product->pg_id;
            $data['pg_sub_id'] = $m_product->pg_sub_id;
            $data['product_id'] = $request->cbo_product;
            $data['qty'] = $request->txt_quantity;
            $data['rate'] = $request->txt_rate;
            $data['total'] = $request->txt_rate * $request->txt_quantity;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            $data['user_id'] = Auth::user()->emp_id;
            $data['valid'] = 1;
            $data['status'] = 1;
            DB::table('pro_maintenance_quotation_details')->insert($data);
            return redirect()->route('mt_quotation_details', $id)->with('success', 'Received Successfull !');
        }
    }

    public function mt_quotation_final($id)
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();
        return view('maintenance.quotation_details_final', compact('m_quotation_master', 'm_quotation_details'));
    }

    public function mt_quotation_repair_store(Request $request, $id)
    {

        $rules = [
            'txt_repair_descrption' => 'required',
            'txt_repair_qty' => 'required',
            'txt_repair_price' => 'required',
        ];
        $customMessages = [
            'txt_repair_descrption.required' => 'Repair descrption is required.',
            'txt_repair_price.required' => 'Repair Price is required.',
            'txt_repair_qty.required' => 'Repair Qty is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['repair_descrption'] = $request->txt_repair_descrption;
        $data['repair_price'] = $request->txt_repair_price == null ? 0 : $request->txt_repair_price;
        $data['repair_qty'] = $request->txt_repair_qty == null ? 0 : $request->txt_repair_qty;
        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update($data);
        return back()->with('success', 'Add Successfull !');
    }

    public function mt_quotation_final_store(Request $request, $id)
    {

        $discount_percent = $request->txt_dpp == null ? 0 : $request->txt_dpp;
        $vat_percent = $request->txt_vpp == null ? 0 : $request->txt_vpp;
        $ait_percent = $request->txt_tt == null ? 0 : $request->txt_tt;
        $other_percent = $request->txt_ot == null ? 0 : $request->txt_ot;


        $vat = $request->txt_vat == null ? 0 : (int)$request->txt_vat;
        $ait = $request->txt_ait  == null ? 0 : (int)$request->txt_ait;
        $discount = $request->txt_discount == null ? 0 : (int)$request->txt_discount;
        $other = $request->txt_other == null ? 0 : (int)$request->txt_other;

        $data = array();
        $data['discount_percent'] = $discount_percent;
        $data['vat_percent'] = $vat_percent;
        $data['ait_percent'] = $ait_percent;
        $data['other_percent'] = $other_percent;

        $data['vat'] = $vat;
        $data['ait'] = $ait;
        $data['discount'] = $discount;
        $data['other'] = $other;
        $data['sub_total'] = $request->txt_subtotal;
        $data['quotation_total'] = ((int)$request->txt_subtotal + $vat + $ait + $other) - $discount;
        $data['status'] = 2;
        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update($data);

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->update(['status' => 2]);

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        if ($m_quotation_master) {
            //Notification for our website
            DB::table('pro_alart_massage')->where('refarence_id', "Q$id")->update(['valid' => 0]);
            $messages = "$m_quotation_master->quotation_master_id | Quotation | Sub: $m_quotation_master->subject  | Date: $m_quotation_master->entry_date | 
                        Time: $m_quotation_master->entry_time";
            $report_to = ["00000104", "00000184", "00000185", "00000186"];
            $link = route("quotation_approved_massage", $id);

            for ($i = 0; $i < count($report_to); $i++) {
                DB::table('pro_alart_massage')->insert([
                    'massage' => $messages,
                    'refarence_id' => "Q$m_quotation_master->quotation_id",
                    'report_to' => $report_to[$i],
                    'user_id' => Auth::user()->emp_id,
                    'entry_date' => date("Y-m-d"),
                    'entry_time' => date("h:i:s"),
                    'valid' => 1,
                    'department_id' => 2,  //2 is maintenance
                    'link' => $link,
                    'color' => "maintenance_color"
                ]);
            }
        }

        return redirect()->route('mt_quotation')->with('success', 'Final Add Successfull !');
    }

    //edit
    public function mt_quotation_details_edit($id)
    {
        $quotation_details_edit = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_id',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_id',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_details_id', $id)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->first();
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')->where('quotation_id', $quotation_details_edit->quotation_id)->first();
        $product_group = DB::table('pro_product_group')->where('valid', 1)->get();
        return view('maintenance.quotation_details', compact('quotation_details_edit', 'product_group', 'm_quotation_master'));
    }
    public function mt_quotation_details_remove(Request $request)
    {
        $id = $request->txt_details;
        $data = array();
        $data['qty'] = 0;
        $data['rate'] = 0;
        $data['total'] = 0;
        $data['valid'] = 0;
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_details_id', $id)
            ->update($data);

        return back()->with('success', 'Remove Successfull!');
    }
    public function mt_quotation_details_update(Request $request, $id)
    {
        $rules = [
            'txt_rate' => 'required',
            'txt_quantity' => 'required',
        ];
        $customMessages = [
            'txt_rate.required' => 'Rate is required.',
            'txt_quantity.required' => 'Quantity is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['qty'] = $request->txt_quantity;
        $data['rate'] = $request->txt_rate;
        $data['total'] = $request->txt_rate * $request->txt_quantity;

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_details_id', $id)
            ->where('valid', 1)
            ->update($data);

        $get_quotation_id =  DB::table('pro_maintenance_quotation_details')
            ->where('quotation_details_id', $id)
            ->first();
        return redirect()->route('mt_quotation_details', $get_quotation_id->quotation_id)->with('success', 'Updated Successfull !');
    }



    //Quotation MGM Approved 
    public function mt_quotation_approved_mgm()
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('status', 2)
            ->orderByDesc('quotation_id')
            ->get();
        return view('maintenance.mt_quotation_approved_mgm', compact('m_quotation_master'));
    }

    public function mt_quotation_approved_details_mgm(Request $request)
    {
        $rules = [
            'cbo_quotation_id' => 'required',
        ];
        $customMessages = [
            'cbo_quotation_id.required' => 'Select Quotation.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $request->cbo_quotation_id)
            ->first();

        $m_quotation_approved_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $request->cbo_quotation_id)
            ->where('pro_maintenance_quotation_details.status', 2)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        return view('maintenance.mt_quotation_approved_details_mgm', compact('m_quotation_master', 'm_quotation_approved_details'));
    }

    public function quotation_approved_massage($id)
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_approved_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.status', 2)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        return view('maintenance.mt_quotation_approved_details_mgm', compact('m_quotation_master', 'm_quotation_approved_details'));
    }

    public function mt_quotation_accept($id)
    {

        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update([
                'approved_mgm_id' => Auth::user()->emp_id,
                'status' => 3,
            ]);

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->update([
                'approved_mgm_id' => Auth::user()->emp_id,
                'status' => 3,
            ]);


        //Notification for our website
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();
        if ($m_quotation_master) {
            DB::table('pro_alart_massage')->where('refarence_id', "Q$id")->update(['valid' => 0]);
            $messages = "$m_quotation_master->quotation_master_id | Quotation Approved| Sub: $m_quotation_master->subject  | Date: $m_quotation_master->entry_date | 
                            Time: $m_quotation_master->entry_time";
            $link = route("mt_customer_quotation_approved_edit_url", $id);
            DB::table('pro_alart_massage')->insert([
                'massage' => $messages,
                'refarence_id' => "Q$m_quotation_master->quotation_id",
                'report_to' => $m_quotation_master->user_id,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:s"),
                'valid' => 1,
                'department_id' => 2,  //2 is maintenance
                'link' => $link,
                'color' => "maintenance_color"
            ]);
        }
        //End Notification for our website

        return redirect()->route('rpt_mt_quotation_view', $id);
    }


    public function mt_quotation_reject(Request $request, $id)
    {

        $rules = [
            'txt_comment' => 'required',
        ];
        $customMessages = [
            'txt_comment.required' => 'Reject Comment Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update([
                'approved_mgm_id' => Auth::user()->emp_id,
                'status' => 5,
                'reject_comment' => $request->txt_comment,
            ]);

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->update([
                'approved_mgm_id' => Auth::user()->emp_id,
                'status' => 1,
            ]);


        //Notification for our website
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();
        if ($m_quotation_master) {

            $messages = "$m_quotation_master->quotation_master_id | Quotation Reject| Sub: $m_quotation_master->subject  | Date: $m_quotation_master->entry_date | 
                        Time: $m_quotation_master->entry_time";
            $link = route("mt_quotation_details", $id);
            DB::table('pro_alart_massage')->where('refarence_id', "Q$id")->update(['valid' => 0]);
            DB::table('pro_alart_massage')->insert([
                'massage' => $messages,
                'refarence_id' => "Q$m_quotation_master->quotation_id",
                'report_to' => $m_quotation_master->user_id,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:s"),
                'valid' => 1,
                'department_id' => 2,  //2 is maintenance
                'link' => $link,
                'color' => "maintenance_color"
            ]);
        }
        //End Notification for our website
        return redirect()->route('mt_quotation_approved_mgm');
    }


    public function mt_quotation_customer_approved()
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('status', 3)
            ->where('customer_status', null)
            ->orderByDesc('quotation_id')
            ->get();

        $reject_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('customer_status', 3)
            ->orderByDesc('quotation_id')
            ->get();

        return view('maintenance.mt_quotation_customer_approved', compact('m_quotation_master', 'reject_quotation_master'));
    }

    public function mt_customer_quotation_approved_edit(Request $request)
    {
        $rules = [
            'cbo_quotation_id' => 'required',
        ];
        $customMessages = [
            'cbo_quotation_id.required' => 'Select Quotation.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $request->cbo_quotation_id)
            ->first();

        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $request->cbo_quotation_id)
            ->where('pro_maintenance_quotation_details.customer_status', null)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        $m_quotation_approved_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $request->cbo_quotation_id)
            ->where('pro_maintenance_quotation_details.customer_status', 1)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        return view('maintenance.mt_customer_quotation_approved_confirm', compact('m_quotation_master', 'm_quotation_details', 'm_quotation_approved_details'));
    }


    public function mt_customer_quotation_all_approved(Request $request)
    {
        $quotation_id = $request->txt_quotation_id_modal;

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $quotation_id)
            ->first();

        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $quotation_id)
            ->where('pro_maintenance_quotation_details.customer_status', null)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        if ($m_quotation_details->count() > 0) {
            foreach ($m_quotation_details as $row) {
                $data = array();
                $data['approved_qty'] = $row->qty;
                $data['approved_rate'] = $row->rate;
                $data['approved_total'] = ($row->qty * $row->rate);
                $data['approved_id'] = Auth::user()->emp_id;
                $data['customer_status'] = "1";

                DB::table('pro_maintenance_quotation_details')
                    ->where('quotation_details_id', $row->quotation_details_id)
                    ->where('customer_status', null)
                    ->where('valid', 1)
                    ->update($data);
            }

            return back()->with('success', 'All Approved Successfull!');
        } else {
            return back()->with('warning', 'Data Not Found!');
        }
    }

    public function mt_customer_quotation_approved_remove(Request $request)
    {
        $id = $request->txt_details;
        $data = array();
        $data['approved_qty'] = 0;
        $data['approved_rate'] = 0;
        $data['approved_total'] = 0;
        $data['valid'] = 0;
        $data['status'] = 1;
        $data['approved_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_details_id', $id)
            ->update($data);

        return back()->with('success', 'Remove Successfull!');
    }

    public function mt_customer_quotation_approved_edit_url($id)
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.customer_status', null)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        $m_quotation_approved_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.customer_status', 1)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        return view('maintenance.mt_customer_quotation_approved_confirm', compact('m_quotation_master', 'm_quotation_details', 'm_quotation_approved_details'));
    }


    public function mt_customer_quotation_approved_update(Request $request, $id)
    {
        $rules = [
            'txt_approved_rate' => 'required',
            'txt_approved_qty' => 'required',
        ];
        $customMessages = [
            'txt_approved_rate.required' => 'Rate is required.',
            'txt_approved_qty.required' => 'Quantity is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['approved_qty'] = $request->txt_approved_qty;
        $data['approved_rate'] = $request->txt_approved_rate;
        $data['approved_total'] = $request->txt_approved_rate * $request->txt_approved_qty;
        $data['approved_id'] = Auth::user()->emp_id;
        $data['customer_status'] = "1";

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_details_id', $id)
            ->where('valid', 1)
            ->update($data);

        return back()->with('success', 'Successfull !');
    }

    public function mt_customer_quotation_approved_final(Request $request, $id)
    {

        $discount_percent = $request->txt_dpp == null ? 0 : $request->txt_dpp;
        $vat_percent = $request->txt_vpp == null ? 0 : $request->txt_vpp;
        $ait_percent = $request->txt_tt == null ? 0 : $request->txt_tt;
        $other_percent = $request->txt_ot == null ? 0 : $request->txt_ot;

        //
        $vat = $request->txt_vat == null ? 0 : (int)$request->txt_vat;
        $ait = $request->txt_ait  == null ? 0 : (int)$request->txt_ait;
        $discount = $request->txt_discount == null ? 0 : (int)$request->txt_discount;
        $other = $request->txt_other == null ? 0 : (int)$request->txt_other;

        $data = array();
        $data['discount_percent'] = $discount_percent;
        $data['vat_percent'] = $vat_percent;
        $data['ait_percent'] = $ait_percent;
        $data['other_percent'] = $other_percent;

        $data['approved_vat'] = $vat;
        $data['approved_ait'] =   $ait;
        $data['approved_discount'] =  $discount;
        $data['approved_other'] =  $other;
        $data['approved_sub_total'] = $request->txt_subtotal;
        $data['approved_quotation_total'] = ($request->txt_subtotal + $vat + $ait + $other) - $discount;
        $data['customer_status'] = 1;
        $data['confirm_approved_id'] = Auth::user()->emp_id;
        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update($data);

        //Notification for our website
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();
        if ($m_quotation_master) {
            DB::table('pro_alart_massage')->where('refarence_id', "Q$id")->update(['valid' => 0]);
            $messages = "$m_quotation_master->quotation_master_id | Quotation Customer | Sub: $m_quotation_master->subject  | Date: $m_quotation_master->entry_date | 
                            Time: $m_quotation_master->entry_time";
            $report_to = ["00000104", "00000184", "00000185", "00000186"];
            $link = route("quotation_customer_approved_massage", $id);

            for ($i = 0; $i < count($report_to); $i++) {
                DB::table('pro_alart_massage')->insert([
                    'massage' => $messages,
                    'refarence_id' => "Q$m_quotation_master->quotation_id",
                    'report_to' => $report_to[$i],
                    'user_id' => Auth::user()->emp_id,
                    'entry_date' => date("Y-m-d"),
                    'entry_time' => date("h:i:s"),
                    'valid' => 1,
                    'department_id' => 2,  //2 is maintenance
                    'link' => $link,
                    'color' => "maintenance_color"
                ]);
            }
        }
        //End Notification for our website

        return redirect()->route('mt_quotation_customer_approved');
    }

    public function mt_quotation_customer_approved_mgm()
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('customer_status', 1)
            ->orderByDesc('quotation_id')
            ->get();
        return view('maintenance.mt_quotation_customer_approved_mgm', compact('m_quotation_master'));
    }

    public function mt_quotation_customer_approved_details_mgm(Request $request)
    {

        $rules = [
            'cbo_quotation_id' => 'required',
        ];
        $customMessages = [
            'cbo_quotation_id.required' => 'Select Quotation.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $request->cbo_quotation_id)
            ->first();

        $m_quotation_approved_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $request->cbo_quotation_id)
            ->where('pro_maintenance_quotation_details.customer_status', "1")
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        return view('maintenance.mt_quotation_customer_approved_details_mgm', compact('m_quotation_master', 'm_quotation_approved_details'));
    }

    public function quotation_customer_approved_massage($id)
    {

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_approved_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product_group', 'pro_maintenance_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_maintenance_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.customer_status', "1")
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();

        return view('maintenance.mt_quotation_customer_approved_details_mgm', compact('m_quotation_master', 'm_quotation_approved_details'));
    }

    public function mt_customer_quotation_accept($id)
    {

        //make requisition automatic
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->get();

        //1- warrenty 0- No warrenty
        $free_warrenty = '0';


        $m_user_id = Auth::user()->emp_id;
        $last_req_no = DB::table('pro_requisition_master')->orderByDesc("requisition_master_id")->first();
        if (isset($last_req_no)) {
            $mnum = str_replace("R", "", $last_req_no->req_no);
            $req_no =  date("Ym") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "R";
        } else {
            $req_no = date("Ym") . "00001R";
        }

        // master
        $data = array();
        $data['req_no'] = $req_no;
        $data['project_id'] = $m_quotation_master->project_id;
        $data['supplier_id'] = '0';
        $data['department_id'] = '2'; // 2-> maintenance
        $data['status'] = 3;
        $data['user_id'] = $m_quotation_master->user_id;
        $data['approved_id'] = $m_user_id;
        $data['approved_date'] = date("Y-m-d");
        $data['approved_time'] = date("h:i:s");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['free_warrenty'] = $free_warrenty;
        $data['valid'] = 1;
        $req_master_id = DB::table('pro_requisition_master')
            ->insertGetId($data);


        //deails
        foreach ($m_quotation_details as $row) {
            $data = array();
            $data['requisition_master_id'] =  $req_master_id;
            $data['req_no'] = $req_no;
            $data['project_id'] = $m_quotation_master->project_id;
            $data['department_id'] = '2';
            $data['pg_id'] = $row->pg_id;
            $data['pg_sub_id'] = $row->pg_sub_id;
            $data['product_id'] = $row->product_id;
            $data['product_qty'] = $row->approved_qty;
            $data['approved_qty'] = $row->approved_qty;
            $data['status'] = 3;
            $data['user_id'] = $row->user_id;;
            $data['approved_id'] = $m_user_id;
            $data['approved_date'] = date("Y-m-d");
            $data['approved_time'] = date("h:i:s");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            $data['valid'] = 1;
            DB::table('pro_requisition_details')->insert($data);
        }


        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update([
                'mgm_confirm_approved_id' => Auth::user()->emp_id,
                'customer_status' => 2,
                'requisition_master_id' => $req_master_id,
                'req_no' =>  $req_no,
            ]);

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->update([
                'mgm_confirm_approved_id' => Auth::user()->emp_id,
                'customer_status' => 2,
            ]);

        //Notification for our website
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();
        if ($m_quotation_master) {
            $messages = "$m_quotation_master->quotation_master_id |Customer Quotation Approved| Sub: $m_quotation_master->subject  | Date: $m_quotation_master->entry_date | 
                    Time: $m_quotation_master->entry_time";
            $link = route("rpt_mt_quotation_view", $id);
            DB::table('pro_alart_massage')->where('refarence_id', "Q$id")->update(['valid' => 0]);
            DB::table('pro_alart_massage')->insert([
                'massage' => $messages,
                'refarence_id' => "Q$m_quotation_master->quotation_id",
                'report_to' => $m_quotation_master->confirm_approved_id,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:s"),
                'valid' => 1,
                'department_id' => 2,  //2 is maintenance
                'link' => $link,
                'color' => "maintenance_color"
            ]);
        }
        //End Notification for our website


        return redirect()->route('rpt_mt_quotation_view', $id)->with('success', "Accept Successfully");
    }

    public function mt_customer_quotation_reject(Request $request, $id)
    {

        $rules = [
            'txt_comment' => 'required',
        ];
        $customMessages = [
            'txt_comment.required' => 'Reject Comment Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->update([
                'mgm_confirm_approved_id' => Auth::user()->emp_id,
                'customer_status' => 3,
                'reject_comment' => $request->txt_comment,
            ]);

        DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $id)
            ->where('valid', 1)
            ->update([
                'mgm_confirm_approved_id' => Auth::user()->emp_id,
                'customer_status' => NULL,
            ]);

        //Notification for our website
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $id)
            ->first();
        if ($m_quotation_master) {
            $messages = "$m_quotation_master->quotation_master_id |Customer Quotation Reject| Sub: $m_quotation_master->subject  | Date: $m_quotation_master->entry_date | 
                  Time: $m_quotation_master->entry_time";
            $link = route("mt_customer_quotation_approved_edit_url", $id);
            DB::table('pro_alart_massage')->where('refarence_id', "Q$id")->update(['valid' => 0]);
            DB::table('pro_alart_massage')->insert([
                'massage' => $messages,
                'refarence_id' => "Q$m_quotation_master->quotation_id",
                'report_to' => $m_quotation_master->confirm_approved_id,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:s"),
                'valid' => 1,
                'department_id' => 2,  //2 is maintenance
                'link' => $link,
                'color' => "maintenance_color"
            ]);
        }
        //End Notification for our website

        return redirect()->route('mt_quotation_approved_mgm')->with('success', "Reject Successfully");
    }

    //Ajax Quotation
    public function GetMtProductUnit($product_id)
    {
        $product = DB::table('pro_product')
            ->where('product_id', $product_id)
            ->where('valid', 1)
            ->first();
        $unit = DB::table('pro_units')->where('unit_id', $product->unit_id)->first();
        $unit_name = $unit == null ? '' : $unit->unit_name;
        return response()->json($unit_name);
    }

    public function GetCustomer()
    {
        $data = DB::table('pro_customers')
            ->orderByDesc('customer_id')
            ->get();
        return response()->json($data);
    }

    public function GetCustomerDetails($project_id)
    {
        $project = DB::table('pro_projects')->where('project_id', $project_id)->where('valid', 1)->first();
        $customer = DB::table('pro_customers')->where('customer_id', $project->customer_id)->where('valid', 1)->first();
        $customer == null ? '0' : $customer;
        return response()->json($customer);
    }

    public function GetApprovedQuotation($id)
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->leftJoin('pro_employee_info', 'pro_maintenance_quotation_master.approved_mgm_id', 'pro_employee_info.employee_id')
            ->select('pro_maintenance_quotation_master.*', 'pro_employee_info.employee_name')
            ->where('pro_maintenance_quotation_master.quotation_id', $id)
            ->first();
        return response()->json($m_quotation_master);
    }

    public function GetPrepareQuotation($id)
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->leftJoin('pro_employee_info', 'pro_maintenance_quotation_master.user_id', 'pro_employee_info.employee_id')
            ->select('pro_maintenance_quotation_master.*', 'pro_employee_info.employee_name')
            ->where('pro_maintenance_quotation_master.quotation_id', $id)
            ->first();
        return response()->json($m_quotation_master);
    }

    //RPT Quotation
    public function rpt_mt_quotation_list()
    {
        return view('maintenance.rpt_mt_quotation_list');
    }
    public function GetMtRptQuotationList()
    {
        $data = DB::table('pro_maintenance_quotation_master')
            // ->leftJoin('pro_customers', 'pro_maintenance_quotation_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_employee_info', 'pro_maintenance_quotation_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as mgm', 'pro_maintenance_quotation_master.approved_mgm_id', 'mgm.employee_id')
            ->select('pro_maintenance_quotation_master.*', 'pro_employee_info.employee_name as approved', 'mgm.employee_name as mgm_name')
            ->whereIn('pro_maintenance_quotation_master.status', ['3'])
            ->orderByDesc('quotation_id')
            ->get();
        return response()->json($data);
    }
    public function rpt_mt_quotation_view($id)
    {
        $m_mode_of_payment = DB::table('pro_mode_of_payment')->where('valid', 1)->get();
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')->where('quotation_id', $id)->first();
        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_units.unit_name'
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();
        return view('maintenance.rpt_quotation_view', compact('m_quotation_master', 'm_quotation_details', 'm_mode_of_payment'));
    }

    public function rpt_mt_quotation_print($id)
    {
        $m_mode_of_payment = DB::table('pro_mode_of_payment')->where('valid', 1)->get();
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')->where('quotation_id', $id)->first();
        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->leftJoin('pro_product', 'pro_maintenance_quotation_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
            ->select(
                'pro_maintenance_quotation_details.*',
                'pro_product.*',
                'pro_units.unit_name'
            )
            ->where('pro_maintenance_quotation_details.quotation_id', $id)
            ->where('pro_maintenance_quotation_details.valid', 1)
            ->get();
        return view('maintenance.rpt_quotation_print', compact('m_quotation_master', 'm_quotation_details', 'm_mode_of_payment'));
    }
    //End  quotation


    //Bill
    public function mt_bill()
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('customer_status', 2)
            ->where('bill_status', null)
            ->orderByDesc('quotation_id')
            ->get();
        return view('maintenance.mt_bill', compact('m_quotation_master'));
    }

    public function mt_bill_store(Request $request)
    {
        $rules = [
            'cbo_quotation_id' => 'required',
            'txt_subject' => 'required',
        ];
        $customMessages = [
            'cbo_quotation_id.required' => 'Select Quotation.',
            'txt_subject.required' => 'Subject is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $request->cbo_quotation_id)
            ->first();

        $m_bill = DB::table('pro_maintenance_bill_master')->orderByDesc("maintenance_bill_master_id")->first();
        if (isset($m_bill)) {
            $array = str_split("$m_bill->maintenance_bill_master_no");
            $old_year =  "$array[0]$array[1]";
            $current_year = date('y');
            if ($current_year > $old_year) {
                $maintenance_bill_master_no = date("ymd") . "00001MB";
            } else {
                $mnum = str_replace("MB", "", $m_bill->maintenance_bill_master_no);
                $maintenance_bill_master_no =  date("ymd") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "MB";
            }
        } else {
            $maintenance_bill_master_no = date("ymd") . "00001MB";
        }

        $data = array();
        $data['maintenance_bill_master_no'] = $maintenance_bill_master_no;
        $data['quotation_master_id'] = $m_quotation_master->quotation_master_id;
        $data['quotation_date'] = $m_quotation_master->quotation_date;
        $data['project_id'] = $m_quotation_master->project_id;
        $data['customer_id'] = $m_quotation_master->customer_id;
        $data['subject'] = $request->txt_subject;
        $data['discount'] = $m_quotation_master->approved_discount;
        $data['vat'] = $m_quotation_master->approved_vat;
        $data['ait'] = $m_quotation_master->approved_ait;
        $data['other'] = $m_quotation_master->approved_other;
        $data['grand_total'] = $m_quotation_master->approved_quotation_total;
        $data['status'] = 1;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['approved_id'] =  $m_quotation_master->mgm_confirm_approved_id;
        $data['repair_descrption'] =  $m_quotation_master->repair_descrption;
        $data['repair_qty'] =  $m_quotation_master->repair_qty;
        $data['repair_price'] =  $m_quotation_master->repair_price;
        //
        $data['discount_percent'] =  $m_quotation_master->discount_percent;
        $data['vat_percent'] =  $m_quotation_master->vat_percent;
        $data['ait_percent'] =  $m_quotation_master->ait_percent;
        $data['other_percent'] =  $m_quotation_master->other_percent;


        //previous due
        $data['due_description'] =  $request->txt_due_description;
        $data['previous_due'] =  $request->txt_due;

        $bill_master_id = DB::table('pro_maintenance_bill_master')->insertGetId($data);

        $m_quotation_details = DB::table('pro_maintenance_quotation_details')
            ->where('quotation_id', $request->cbo_quotation_id)
            ->where('valid', 1)
            ->get();


        foreach ($m_quotation_details as $row) {
            $data2 = array();
            $data2['maintenance_bill_master_id'] = $bill_master_id;
            $data2['maintenance_bill_master_no'] = $maintenance_bill_master_no;
            $data2['quotation_master_id'] = $m_quotation_master->quotation_master_id;
            $data2['quotation_date'] = $m_quotation_master->quotation_date;
            $data2['customer_id'] = $m_quotation_master->customer_id;
            $data2['project_id'] = $m_quotation_master->project_id;
            $data2['pg_id'] = $row->pg_id;
            $data2['pg_sub_id'] = $row->pg_sub_id;
            $data2['product_id'] = $row->product_id;
            $data2['qty'] = $row->approved_qty;
            $data2['rate'] = $row->approved_rate;
            $data2['sub_total'] = $row->approved_total;
            $data2['status'] = 1;
            $data2['user_id'] = Auth::user()->emp_id;
            $data2['entry_date'] = date('Y-m-d');
            $data2['entry_time'] = date("h:i:s");
            $data2['valid'] = 1;
            DB::table('pro_maintenance_bill_details')->insert($data2);
        }

        DB::table('pro_maintenance_quotation_master')
            ->where('quotation_id', $request->cbo_quotation_id)
            ->update(['bill_status' => 1]);

        return redirect()->route('rpt_mt_bill_view', $bill_master_id);
    }

    //bill update

    public function mt_bill_update_list()
    {
        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_employee_info', 'pro_maintenance_bill_master.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
                'pro_employee_info.employee_name as prefer',
            )
            ->where('pro_maintenance_bill_master.status', 1)
            ->orderByDesc('maintenance_bill_master_id')
            ->get();
        return view('maintenance.mt_bill_update_list', compact('m_bill_master'));
    }


    public function mt_bill_update_details($id)
    {

        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_employee_info', 'pro_maintenance_bill_master.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
                'pro_employee_info.employee_name as prefer_by',
            )
            ->where('pro_maintenance_bill_master.maintenance_bill_master_id', $id)
            ->first();

        $m_bill_details = DB::table('pro_maintenance_bill_details')
            ->leftJoin('pro_product', 'pro_maintenance_bill_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
            ->select(
                'pro_maintenance_bill_details.*',
                'pro_product.product_name',
                'pro_units.unit_name',
            )
            ->where('pro_maintenance_bill_details.maintenance_bill_master_id', $id)
            ->whereNull('pro_maintenance_bill_details.remove_status')
            ->where('pro_maintenance_bill_details.valid', 1)
            ->get();



        return view('maintenance.mt_bill_update_details', compact('m_bill_master', 'm_bill_details'));
    }

    public function mt_bill_update_store(Request $request)
    {
        $rules = [
            'txt_qty' => 'required',
            'txt_rate' => 'required',
        ];
        $customMessages = [
            'txt_qty.required' => 'Qty is Required.',
            'txt_rate.required' => 'Unit Price is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data2 = array();
        $data2['update_qty'] = $request->txt_qty;
        $data2['update_rate'] = $request->txt_rate;
        $data2['update_sub_total'] = $request->txt_qty * $request->txt_rate;
        $data2['update_id'] = Auth::user()->emp_id;
        $data2['update_date'] = date('Y-m-d');
        $data2['update_time'] = date("h:i:s");
        DB::table('pro_maintenance_bill_details')
            ->where('product_id', $request->txt_product_id)
            ->where('maintenance_bill_details_id', $request->txt_maintenance_bill_details_id)
            ->update($data2);
        return back()->with('success', "Update Successfully.");
    }

    public function mt_bill_update_remove(Request $request)
    {
        $id = $request->txt_details;
        $data2 = array();
        $data2['update_id'] = Auth::user()->emp_id;
        $data2['update_date'] = date('Y-m-d');
        $data2['update_time'] = date("h:i:s");
        $data2['remove_status'] = 1;
        DB::table('pro_maintenance_bill_details')
            ->where('maintenance_bill_details_id', $id)
            ->update($data2);
        return back()->with('success', "Remove Successfully.");
    }

    public function mt_bill_update_repair_store(Request $request)
    {
        $rules = [
            'txt_qty2' => 'required',
            'txt_repair_price' => 'required',
        ];
        $customMessages = [
            'txt_qty2.required' => 'Qty is Required.',
            'txt_repair_price.required' => 'Unit Price is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data2 = array();
        $data2['repair_descrption'] = $request->txt_description;
        $data2['repair_qty'] = $request->txt_qty2;
        $data2['repair_price'] = $request->txt_repair_price;
        $data2['update_id'] = Auth::user()->emp_id;
        $data2['update_date'] = date('Y-m-d');
        $data2['update_time'] = date("h:i:s");
        DB::table('pro_maintenance_bill_master')->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id3)->update($data2);
        return back()->with('success', "Update Successfully.");
    }

    public function mt_bill_update_due_description(Request $request)
    {
        $rules = [
            'txt_due_description' => 'required',
        ];
        $customMessages = [
            'txt_due_description.required' => 'Due description is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data2 = array();
        $data2['due_description'] = $request->txt_due_description;
        $data2['update_id'] = Auth::user()->emp_id;
        $data2['update_date'] = date('Y-m-d');
        $data2['update_time'] = date("h:i:s");
        DB::table('pro_maintenance_bill_master')->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id2)->update($data2);
        return back()->with('success', "Update Successfully.");
    }

    public function mt_bill_update_final(Request $request)
    {
        $vat = $request->txt_vat == null ? 0 : (int)$request->txt_vat;
        $ait = $request->txt_ait  == null ? 0 :  (int)$request->txt_ait;
        $discount = $request->txt_discount == null ? 0 :  (int)$request->txt_discount;
        $other = $request->txt_other == null ? 0 :  (int)$request->txt_other;
        $sub_total = DB::table('pro_maintenance_bill_details')->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)->where('valid', 1)->sum('sub_total');
        $data = array();
        $data['vat'] = $vat;
        $data['ait'] = $ait;
        $data['discount'] = $discount;
        $data['other'] = $other;
        $data['grand_total'] = ($sub_total + $vat + $ait + $other) - $discount;
        $data['update_id'] = Auth::user()->emp_id;
        $data['update_date'] = date('Y-m-d');
        $data['update_time'] = date("h:i:s");
        DB::table('pro_maintenance_bill_master')->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)->update($data);
        return redirect()->route('mt_bill_update_list')->with('success', "Update Final Successfully.");
    }


    //report bill

    public function rpt_mt_bill_list()
    {

        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_employee_info', 'pro_maintenance_bill_master.approved_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
                'pro_employee_info.employee_name as approved',
            )
            ->whereIn('pro_maintenance_bill_master.status', [1, 2, 3])
            ->orderByDesc('maintenance_bill_master_id')
            ->get();

        return view('maintenance.rpt_mt_bill_list', compact('m_bill_master'));
    }

    public function rpt_mt_bill_view($id)
    {

        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_employee_info', 'pro_maintenance_bill_master.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
                'pro_employee_info.employee_name as prefer_by',
            )
            ->where('pro_maintenance_bill_master.maintenance_bill_master_id', $id)
            ->first();

        $m_bill_details = DB::table('pro_maintenance_bill_details')
            ->leftJoin('pro_product', 'pro_maintenance_bill_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
            ->select(
                'pro_maintenance_bill_details.*',
                'pro_product.product_name',
                'pro_units.unit_name',
            )
            ->where('pro_maintenance_bill_details.maintenance_bill_master_id', $id)
            ->get();

        return view('maintenance.rpt_mt_bill_view', compact('m_bill_master', 'm_bill_details'));
    }

    public function rpt_mt_bill_print($id)
    {

        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_employee_info', 'pro_maintenance_bill_master.user_id', 'pro_employee_info.employee_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
                'pro_employee_info.employee_name as prefer_by',
            )
            ->where('pro_maintenance_bill_master.maintenance_bill_master_id', $id)
            ->first();

        $m_bill_details = DB::table('pro_maintenance_bill_details')
            ->leftJoin('pro_product', 'pro_maintenance_bill_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
            ->select(
                'pro_maintenance_bill_details.*',
                'pro_product.product_name',
                'pro_units.unit_name',
            )
            ->where('pro_maintenance_bill_details.maintenance_bill_master_id', $id)
            ->get();

        return view('maintenance.rpt_mt_bill_print', compact('m_bill_master', 'm_bill_details'));
    }


    //Ajx BILL
    public function GetBillCustomerQuotation($id)
    {
        $m_quotation_master = DB::table('pro_maintenance_quotation_master')
            ->leftJoin('pro_employee_info', 'pro_maintenance_quotation_master.mgm_confirm_approved_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as prefer', 'pro_maintenance_quotation_master.user_id', 'prefer.employee_id')
            ->leftJoin('pro_customers', 'pro_maintenance_quotation_master.customer_id', 'pro_customers.customer_id')
            ->select(
                'pro_maintenance_quotation_master.quotation_date',
                'pro_maintenance_quotation_master.project_id',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
                'pro_employee_info.employee_name as approved_by',
                'prefer.employee_name as prefer_by'
            )
            ->where('pro_maintenance_quotation_master.quotation_id', $id)
            ->first();


        //-------Previous Due
        $balance = 0;
        if ($m_quotation_master) {
            //opening bill
            $project_opening_balance = DB::table('pro_maintenance_opening_bill')->where('project_id', $m_quotation_master->project_id)->sum('amount');

            //bill with quotation
            $maintenance_bill_grand_total = DB::table('pro_maintenance_bill_master')
                ->where('project_id', $m_quotation_master->project_id)
                ->where('valid', 1)
                ->sum('grand_total');
            $maintenance_bill_repair_price = DB::table('pro_maintenance_bill_master')
                ->where('project_id', $m_quotation_master->project_id)
                ->where('valid', 1)
                ->sum('repair_price');

            //receiving
            $maintenance_bill_add_money = DB::table('pro_maintenance_money_receipt')->where('project_id', $m_quotation_master->project_id)->sum('paid_amount');
            $balance = ($project_opening_balance + $maintenance_bill_grand_total + $maintenance_bill_repair_price) - $maintenance_bill_add_money;
        }


        //-------End Previous Due
        return response()->json([$m_quotation_master, $balance]);
    }

    //Bill summery 

    public function rpt_mt_bill_summery()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');
        $m_project = DB::table('pro_projects')
            ->where('valid', 1)
            ->get();
        return view('maintenance.rpt_mt_bill_summery', compact('m_project', 'form', 'to'));
    }

    //opening bill
    public function opening_bill()
    {
        $m_project = DB::table('pro_projects')->where('valid', 1)->get();

        $opening_bill_list =  DB::table('pro_maintenance_opening_bill')
            ->leftJoin('pro_projects', "pro_maintenance_opening_bill.project_id", "pro_projects.project_id")
            ->select('pro_maintenance_opening_bill.*', "pro_projects.project_name")
            ->get();

        return view('maintenance.opening_bill', compact('m_project', 'opening_bill_list'));
    }

    public function opening_bill_store(Request $request)
    {
        $rules = [
            'cbo_projet_id' => 'required',
            'txt_balance' => 'required',
        ];
        $customMessages = [
            'cbo_projet_id.required' => 'Select Project',
            'txt_balance.required' => 'Balance is required!',
        ];
        $this->validate($request, $rules, $customMessages);


        $m_project = DB::table('pro_projects')->where('project_id', $request->cbo_projet_id)->first();
        $opening_bill_check =  DB::table('pro_maintenance_opening_bill')->where('project_id', $request->cbo_projet_id)->first();
        if ($opening_bill_check == null) {
            $data = array();
            $data['customer_id'] = $m_project->customer_id;
            $data['project_id'] = $m_project->project_id;
            $data['amount'] = $request->txt_balance;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:s");
            $data['valid'] = 1;
            DB::table('pro_maintenance_opening_bill')->insert($data);
            return back()->with('success', "Insert Successfully");
        } else {
            $data = array();
            $data['customer_id'] = $m_project->customer_id;
            $data['project_id'] = $m_project->project_id;
            $data['amount'] = $request->txt_balance;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:s");
            $data['valid'] = 1;
            DB::table('pro_maintenance_opening_bill')->where('project_id', $request->cbo_projet_id)->update($data);
            return back()->with('success', "Update Successfully");
        }
    }




    //Bill Assign
    public function mt_bill_assign()
    {
        $bill_assign_list = DB::table('pro_maintenance_bill_assign')
            ->whereIn('status', [1, 2])
            ->orderByDesc('mt_bill_assign_id')
            ->take('50')
            ->get();
        $maintenance_bill_master = DB::table('pro_maintenance_bill_master')
            ->whereIn('status', [1, 2, 3])
            ->orderByDesc('maintenance_bill_master_id')
            ->get();
        $m_employee = DB::table('pro_employee_info')
            ->where('leader_healper_status', 1)
            ->where('working_status', 1)
            ->get();
        return view('maintenance.mt_bill_assign', compact('maintenance_bill_master', 'm_employee', 'bill_assign_list'));
    }

    public function mt_bill_assign_store(Request $request)
    {
        $rules = [
            'cbo_maintenance_bill_master_no' => 'required',
            'cbo_employee_id' => 'required',
            'txt_remark' => 'required',
        ];

        $customMessages = [
            'cbo_maintenance_bill_master_no.required' => 'Select Bill No.',
            'cbo_employee_id.required' => 'Select Employee.',
            'txt_remark.required' => 'Remark is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $maintenance_bill_master = DB::table('pro_maintenance_bill_master')
            ->where('maintenance_bill_master_no', $request->cbo_maintenance_bill_master_no)
            ->first();

        $data = array();
        $data['maintenance_bill_master_id'] = $maintenance_bill_master->maintenance_bill_master_id;
        $data['maintenance_bill_master_no'] = $maintenance_bill_master->maintenance_bill_master_no;
        $data['quotation_master_id'] = $maintenance_bill_master->quotation_master_id;
        $data['quotation_date'] = $maintenance_bill_master->quotation_date;
        $data['customer_id'] = $maintenance_bill_master->customer_id;
        $data['project_id'] = $maintenance_bill_master->project_id;
        $data['employee_id'] = $request->cbo_employee_id;
        $data['colection_date'] = date("Y-m-d");
        $data['remarks'] = $request->txt_remark;
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_maintenance_bill_assign')->insert($data);

        return back()->with('success', "Assign Successfully");
    }

    //

    public function mt_bill_assign_list()
    {
        $bill_assign_list = DB::table('pro_maintenance_bill_assign')
            ->whereIn('status', [1, 2, 3])
            ->orderByDesc('mt_bill_assign_id')
            ->get();

        return view('maintenance.mt_bill_assign_list', compact('bill_assign_list'));
    }

    public function mtStartJourney(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        $bill_assign_list = DB::table('pro_maintenance_bill_assign')
            ->where('mt_bill_assign_id', $bill_assign_id)
            ->update([
                'start_journey_lat' => $request->latitude,
                'start_journey_long' => $request->longitude,
                'start_journey_date' => date("Y-m-d"),
                'start_journey_time' => date("H:i:s"),
                'status' => 2,
            ]);
        return back()->with('success', 'Start Journey Successfull!');
    }

    public function mtEndJourney(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        return view('maintenance.mt_bill_assign_journey', compact('bill_assign_id'));
    }

    public function mtEndJourneyStore(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        $bill_assign_list = DB::table('pro_maintenance_bill_assign')
            ->where('mt_bill_assign_id', $bill_assign_id)
            ->update([
                'reached_lat' => $request->latitude,
                'reached_long' => $request->longitude,
                'reached_date' => date("Y-m-d"),
                'reached_time' => date("H:i:s"),
                'reached_fare' => $request->txt_fare,
                'transport_type' => $request->cbo_transport_type,
                'status' => 3,
            ]);
        return redirect()->route('mt_bill_assign_list')->with('success', 'End Journey Successfull!');
    }

    public function mt_task_review(Request $request)
    {
        $bill_assign_id = $request->txt_bill_assign_id;
        return view('maintenance.mt_task_review', compact('bill_assign_id'));
    }

    public function mt_task_review_final(Request $request)
    {

        $rules = [
            'txt_remark' => 'required',
        ];
        $customMessages = [
            'txt_remark.required' => 'Description is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $bill_assign_id = $request->txt_bill_assign_id;
        DB::table('pro_maintenance_bill_assign')
            ->where('mt_bill_assign_id', $bill_assign_id)
            ->update([
                'status' => 4,
                'review' => $request->txt_remark,
            ]);
        return redirect()->route('mt_bill_assign_list')->with('success', 'Review Successfull!');
    }


    //

    //Bill Collection list
    public function mt_bill_collection_list()
    {
        $currentDate = date('Y-m-d');
        $oneMonthBack = date('Y-m-d', strtotime('-1 month', strtotime($currentDate)));
        $form = $oneMonthBack;
        $to = $currentDate;
        $customer = '';
        $project = '';

        $m_project = DB::table('pro_projects')->where('valid', 1)->get();
        $m_customer = DB::table('pro_customers')->where('valid', 1)->get();

        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_projects.project_name',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
            )
            ->whereBetween('pro_maintenance_bill_master.entry_date', [$form, $to])
            ->whereIn('pro_maintenance_bill_master.status', [1, 2, 3])
            ->orderByDesc('pro_maintenance_bill_master.maintenance_bill_master_id')
            ->get();
        return view('maintenance.mt_bill_collection_list', compact('m_bill_master', 'm_project', 'm_customer', 'form', 'to', 'customer', 'project'));
    }

    public function mt_bill_collection_info(Request $request)
    {

        $m_project = DB::table('pro_projects')->where('valid', 1)->get();
        $m_customer = DB::table('pro_customers')->where('valid', 1)->get();

        $customer = $request->cbo_customer_id;
        $project = $request->cbo_projet_id;

        if ($request->cbo_customer_id == "all") {
            $form = '';
            $to = '';
            $m_bill_master = DB::table('pro_maintenance_bill_master')
                ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
                ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
                ->select(
                    'pro_maintenance_bill_master.*',
                    'pro_projects.project_name',
                    'pro_customers.customer_name',
                    'pro_customers.customer_add',
                    'pro_customers.customer_phone',
                )
                ->whereIn('pro_maintenance_bill_master.status', [1, 2, 3])
                ->orderByDesc('pro_maintenance_bill_master.maintenance_bill_master_id')
                ->get();
            return view('maintenance.mt_bill_collection_list', compact('m_bill_master', 'm_project', 'm_customer', 'form', 'to', 'customer', 'project'));
        } else {

            //
            if ($request->txt_from_date && $request->txt_to_date) {
                $form = $request->txt_from_date;
                $to = $request->txt_to_date;
            } else {
                $form = "1990-01-01";
                $to = date("Y-m-d");
            }

            if ($request->cbo_customer_id && $request->cbo_projet_id == null) {
                $m_bill_master = DB::table('pro_maintenance_bill_master')
                    ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
                    ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
                    ->select(
                        'pro_maintenance_bill_master.*',
                        'pro_projects.project_name',
                        'pro_customers.customer_name',
                        'pro_customers.customer_add',
                        'pro_customers.customer_phone',
                    )
                    ->whereBetween('pro_maintenance_bill_master.entry_date', [$form, $to])
                    ->where('pro_maintenance_bill_master.customer_id', $request->cbo_customer_id)
                    ->whereIn('pro_maintenance_bill_master.status', [1, 2, 3])
                    ->orderByDesc('pro_maintenance_bill_master.maintenance_bill_master_id')
                    ->get();
            } elseif ($request->cbo_customer_id && $request->cbo_projet_id) {
                $m_bill_master = DB::table('pro_maintenance_bill_master')
                    ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
                    ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
                    ->select(
                        'pro_maintenance_bill_master.*',
                        'pro_projects.project_name',
                        'pro_customers.customer_name',
                        'pro_customers.customer_add',
                        'pro_customers.customer_phone',
                    )
                    ->whereBetween('pro_maintenance_bill_master.entry_date', [$form, $to])
                    ->where('pro_maintenance_bill_master.customer_id', $request->cbo_customer_id)
                    ->where('pro_maintenance_bill_master.project_id', $request->cbo_projet_id)
                    ->whereIn('pro_maintenance_bill_master.status', [1, 2, 3])
                    ->orderByDesc('pro_maintenance_bill_master.maintenance_bill_master_id')
                    ->get();
            } else {
                $m_bill_master = DB::table('pro_maintenance_bill_master')
                    ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
                    ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
                    ->select(
                        'pro_maintenance_bill_master.*',
                        'pro_projects.project_name',
                        'pro_customers.customer_name',
                        'pro_customers.customer_add',
                        'pro_customers.customer_phone',
                    )
                    ->whereBetween('pro_maintenance_bill_master.entry_date', [$form, $to])
                    ->whereIn('pro_maintenance_bill_master.status', [1, 2, 3])
                    ->orderByDesc('pro_maintenance_bill_master.maintenance_bill_master_id')
                    ->get();
            }

            return view('maintenance.mt_bill_collection_list', compact('m_bill_master', 'm_project', 'm_customer', 'form', 'to', 'customer', 'project'));
        }
    }

    public function maintenance_add_money($id)
    {
        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_projects.project_name',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
            )
            ->where('pro_maintenance_bill_master.maintenance_bill_master_id', $id)
            ->first();

        $m_money_receipt = DB::table('pro_maintenance_money_receipt')
            ->where('maintenance_bill_master_id', $id)
            ->get();

        return view('maintenance.maintenance_add_money', compact('m_bill_master', 'm_money_receipt'));
    }

    public function maintenance_store_money(Request $request)
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

        // 1->cash , 2->checq
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
        $mr = DB::table('pro_maintenance_money_receipt')->orderByDesc("receipt_no")->first();
        if ($mr != null) {
            $store = array();
            $number = str_split($mr->receipt_no);
            for ($i = 0; $i < 2; $i++) {
                $store[$i] = $number[$i];
            }
            $year = implode("", $store);
            $new_year = date("y");

            if ($year  == $new_year) {
                $money_receipt_no =  $mr->receipt_no + 1;
            } else {
                $money_receipt_no = date("ym") . "00001";
            }
        } else {
            $money_receipt_no = date("ym") . "00001";
        }

        //
        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)
            ->first();

        $data = array();
        $data['receipt_no'] = $money_receipt_no;
        $data['maintenance_bill_master_id'] = $m_bill_master->maintenance_bill_master_id;
        $data['customer_id'] = $m_bill_master->customer_id;
        $data['project_id'] = $m_bill_master->project_id;
        $data['collection_date'] = date("Y-m-d");
        $data['payment_type'] = $request->cbo_payment_type; // 1->cash , 2->checq
        $data['bank'] = $request->txt_bank;
        $data['chq_no'] = $request->txt_dd_no;
        $data['chq_date'] = $request->txt_dd_date;
        $data['paid_amount'] = $request->txt_amount;
        $data['amount_word'] = $request->txt_amount_word;
        $data['remark'] = $request->txt_remark;
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_maintenance_money_receipt')->insert($data);

        //status
        // repair and product price
        $maintenance_bill_grandtotal =  DB::table('pro_maintenance_bill_master')
            ->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)
            ->where('valid', 1)
            ->sum('grand_total');
        $maintenance_bill_repair_price =  DB::table('pro_maintenance_bill_master')
            ->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)
            ->where('valid', 1)
            ->sum('repair_price');

        //bill receive, without previous due
        $receive = DB::table('pro_maintenance_money_receipt')
            ->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)
            ->whereNull('due_status')
            ->sum('paid_amount');

        //bill issue
        $total_bill = ($maintenance_bill_grandtotal + $maintenance_bill_repair_price);

        if ($total_bill == $receive) {
            DB::table('pro_maintenance_bill_master')
                ->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)
                ->update(['bill_status' => 1]);
        }

        return back()->with('success', "Add Successfull");
    }

    //due bill
    public function maintenance_due_add_money($id)
    {
        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->leftJoin('pro_customers', 'pro_maintenance_bill_master.customer_id', 'pro_customers.customer_id')
            ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
            ->select(
                'pro_maintenance_bill_master.*',
                'pro_projects.project_name',
                'pro_customers.customer_name',
                'pro_customers.customer_add',
                'pro_customers.customer_phone',
            )
            ->where('pro_maintenance_bill_master.maintenance_bill_master_id', $id)
            ->first();

        $m_money_receipt = DB::table('pro_maintenance_money_receipt')
            ->where('maintenance_bill_master_id', $id)
            ->get();

        return view('maintenance.maintenance_due_add_money', compact('m_bill_master', 'm_money_receipt'));
    }

    public function maintenance_due_store_money(Request $request)
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

        // 1->cash , 2->checq
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
        $mr = DB::table('pro_maintenance_money_receipt')->orderByDesc("receipt_no")->first();
        if ($mr != null) {
            $store = array();
            $number = str_split($mr->receipt_no);
            for ($i = 0; $i < 2; $i++) {
                $store[$i] = $number[$i];
            }
            $year = implode("", $store);
            $new_year = date("y");

            if ($year  == $new_year) {
                $money_receipt_no =  $mr->receipt_no + 1;
            } else {
                $money_receipt_no = date("ym") . "00001";
            }
        } else {
            $money_receipt_no = date("ym") . "00001";
        }

        //
        $m_bill_master = DB::table('pro_maintenance_bill_master')
            ->where('maintenance_bill_master_id', $request->txt_maintenance_bill_master_id)
            ->first();

        $data = array();
        $data['receipt_no'] = $money_receipt_no;
        $data['maintenance_bill_master_id'] = $m_bill_master->maintenance_bill_master_id;
        $data['customer_id'] = $m_bill_master->customer_id;
        $data['project_id'] = $m_bill_master->project_id;
        $data['collection_date'] = date("Y-m-d");
        $data['payment_type'] = $request->cbo_payment_type; // 1->cash , 2->checq
        $data['bank'] = $request->txt_bank;
        $data['chq_no'] = $request->txt_dd_no;
        $data['chq_date'] = $request->txt_dd_date;
        $data['paid_amount'] = $request->txt_amount;
        $data['amount_word'] = $request->txt_amount_word;
        $data['remark'] = $request->txt_remark;
        $data['status'] = 2;
        $data['due_status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_maintenance_money_receipt')->insert($data);
        return back()->with('success', "Add Successfull");
    }


    public function maintenance_mr_list($id)
    {
        $m_money_receipt = DB::table('pro_maintenance_money_receipt')
            ->where('maintenance_bill_master_id', $id)
            ->get();

        return view('maintenance.maintenance_mr_list', compact('m_money_receipt'));
    }

    //Bill Confirm 
    public function mt_approved_bill_collection()
    {
        $m_money_receipt = DB::table('pro_maintenance_money_receipt')
            ->where('valid', 1)
            ->orderByDesc('mmr_id')
            ->get();
        return view('maintenance.mt_approved_bill_collection', compact('m_money_receipt'));
    }

    public function mt_approved_bill_collection_ok(Request $request)
    {
        DB::table('pro_maintenance_money_receipt')
            ->where('mmr_id', $request->txt_mmr_id)
            ->update([
                'approved_id' => Auth::user()->emp_id,
                'approved_status' => 1,
                'approved_date' => date("Y-m-d"),
                'approved_time' => date("h:i:s")
            ]);

        return back()->with('success', 'Approved Successfuly');
    }

    //End Bill


    //Report 


    //Task complain
    public function RPTTaskComplain()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $m_task_register = DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->leftJoin("pro_lifts", "pro_lifts.lift_id", "pro_complaint_register.lift_id")
            ->select("pro_complaint_register.*", "pro_customers.*", "pro_projects.*", "pro_lifts.*")
            ->where('pro_complaint_register.department_id', 2)
            ->where('pro_complaint_register.valid', '1')
            ->where('pro_complaint_register.entry_date', date('Y-m-d'))
            ->orderByDesc('pro_complaint_register.complaint_register_id')
            ->get();

        return view('maintenance.rpt_mt_task_complain', compact('m_task_register', 'form', 'to'));
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
            ->where('pro_complaint_register.department_id', 2)
            ->where('pro_complaint_register.valid', '1')
            ->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
            ->orderByDesc('pro_complaint_register.complaint_register_id')
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;

        return view('maintenance.rpt_mt_task_complain', compact('search_task_register', 'form', 'to'));
    }
    //end task complain


    //RPT Task All
    public function RPTTaskAll()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $mt_task_assigns = DB::table('pro_task_assign')
            ->where('entry_date', date('Y-m-d'))
            ->where('department_id', 2)
            ->where('valid', 1)
            ->orderByDesc('task_id')
            ->get();

        return view('maintenance.rpt_mt_task_all', compact('mt_task_assigns', 'form', 'to'));
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
            ->where('department_id', 2)
            ->where('valid', 1)
            ->orderByDesc('task_id')
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;


        return view('maintenance.rpt_mt_task_all', compact('search_task', 'form', 'to'));
    }


    //rpt task View
    public function RPTTaskView($task_id)
    {
        $mt_task_assign = DB::table('pro_task_assign')
            ->where('task_id', $task_id)
            ->where('valid', 1)
            ->first();
        return view('maintenance.rpt_task_view', compact('mt_task_assign'));
    }



    public function rpt_summery()
    {

        $form = "";
        $to = "";
        $employee_01 = "";
        $project_01 = "";

        return view('maintenance.rpt_summery', compact('form', 'to', 'employee_01', 'project_01'));
    }

    //RPT Task Search
    public function rpt_summery_search(Request $request)
    {

        $employee = $request->cbo_employee_id;
        $project = $request->cbo_projet_id;

        $data = DB::table('pro_complaint_register')
            ->leftJoin("pro_customers", "pro_customers.customer_id", "pro_complaint_register.customer_id")
            ->leftJoin("pro_projects", "pro_projects.project_id", "pro_complaint_register.project_id")
            ->select(
                "pro_complaint_register.*",
                "pro_customers.customer_name",
                "pro_projects.project_name",
            )
            ->where('pro_complaint_register.department_id', 2)
            ->where('pro_complaint_register.valid', '1');



        if ($employee && $project == null) {
            $rules = [
                'cbo_employee_id' => 'required',
            ];

            $customMessages = [
                'cbo_employee_id.required' => 'Employee is Required.',
            ];
            $this->validate($request, $rules, $customMessages);

            $employe_complain_id = DB::table('pro_task_assign')
                ->where('team_leader_id', $employee)
                ->where('pro_task_assign.department_id', 2)
                ->where('pro_task_assign.valid', '1')
                ->pluck('complain_id');

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
                $m_task_register = $data->whereIn('pro_complaint_register.complaint_register_id', $employe_complain_id)
                    ->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
                    ->orderByDesc('pro_complaint_register.complaint_register_id')
                    ->get();
            } //with date
            else {
                $m_task_register = $data->whereIn('pro_complaint_register.complaint_register_id', $employe_complain_id)
                    ->orderByDesc('pro_complaint_register.complaint_register_id')
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

                $m_task_register = $data->where('pro_complaint_register.project_id', $project)
                    ->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
                    ->orderByDesc('pro_complaint_register.complaint_register_id')
                    ->get();
            } //with date
            else {
                $m_task_register = $data->where('pro_complaint_register.project_id', $project)
                    ->orderByDesc('pro_complaint_register.complaint_register_id')
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

                $m_task_register = $data->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
                    ->orderByDesc('pro_complaint_register.complaint_register_id')
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

                $employe_complain_id = DB::table('pro_task_assign')
                    ->where('team_leader_id', $employee)
                    ->where('pro_task_assign.department_id', 2)
                    ->where('pro_task_assign.valid', '1')
                    ->pluck('complain_id');

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

                    $m_task_register = $data->whereIn('pro_complaint_register.complaint_register_id', $employe_complain_id)
                        ->where('pro_complaint_register.project_id', $project)
                        ->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
                        ->orderByDesc('pro_complaint_register.complaint_register_id')
                        ->get();
                } //with date
                else {
                    $m_task_register =  $data->whereIn('pro_complaint_register.complaint_register_id', $employe_complain_id)
                        ->where('pro_complaint_register.project_id', $project)
                        ->orderByDesc('pro_complaint_register.complaint_register_id')
                        ->get();
                } //witout date

            } //with employ and developer 


        } //default


        $employee_01 =  $employee == null ? "" : $employee;
        $project_01 =  $project == null ? "" : $project;
        $form = $request->txt_from == null ? "" : $request->txt_from;
        $to = $request->txt_to == null ? "" : $request->txt_to;

        return view('maintenance.rpt_summery', compact('m_task_register', 'form', 'to', 'employee_01', 'project_01'));
    }


    //All Report Summery
    public function rpt_all_report_summery()
    {
        $m_customer = DB::table('pro_customers')->where('valid', 1)->get();
        return view('maintenance.rpt_all_report_summery', compact('m_customer'));
    }
    public function RptGetProjectList($id)
    {
        $data = DB::table('pro_projects')->where('customer_id', $id)->where('valid', 1)->get();
        return response()->json($data);
    }

    public function rpt_all_report_summery_list(Request $request)
    {
        $rules = [
            'cbo_customer_id' => 'required',
        ];

        $customMessages = [
            'cbo_customer_id.required' => 'Employee is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->txt_from) {
            $rules = [
                'txt_to' => 'required',
            ];

            $customMessages = [
                'txt_to.required' => 'To is Required.',
            ];
            $this->validate($request, $rules, $customMessages);
        }

        $m_customer = DB::table('pro_customers')->where('valid', 1)->get();
        $form = $request->txt_from;
        $to = $request->txt_to;
        $customer_id = $request->cbo_customer_id;

        if ($form && $to) {
            $m_complaint = DB::table('pro_complaint_register')
                ->leftJoin('pro_projects', 'pro_complaint_register.project_id', 'pro_projects.project_id')
                ->leftJoin('pro_lifts', 'pro_complaint_register.lift_id', 'pro_lifts.lift_id')
                ->select(
                    'pro_complaint_register.complaint_register_id',
                    'pro_complaint_register.complaint_description',
                    'pro_complaint_register.entry_time',
                    'pro_complaint_register.entry_date',
                    'pro_projects.project_name',
                    'pro_lifts.lift_name',
                )
                ->where('pro_complaint_register.customer_id', $customer_id)
                ->whereBetween('pro_complaint_register.entry_date', [$request->txt_from, $request->txt_to])
                ->where('pro_complaint_register.valid', 1)
                ->get();

            $m_maintenance_quation = DB::table('pro_maintenance_quotation_master')
                ->leftJoin('pro_projects', 'pro_maintenance_quotation_master.project_id', 'pro_projects.project_id')
                ->leftJoin('pro_employee_info as mgm', 'pro_maintenance_quotation_master.approved_mgm_id', 'mgm.employee_id')
                ->select(
                    'pro_maintenance_quotation_master.*',
                    'pro_projects.project_name',
                    'mgm.employee_name as mgm_name'
                )
                ->where('pro_maintenance_quotation_master.customer_id', $customer_id)
                ->whereBetween('pro_maintenance_quotation_master.quotation_date', [$request->txt_from, $request->txt_to])
                ->whereIn('pro_maintenance_quotation_master.status', ['3'])
                ->get();


            $m_bill_master = DB::table('pro_maintenance_bill_master')
                ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
                ->select(
                    'pro_maintenance_bill_master.*',
                    'pro_projects.project_name',
                )
                ->where('pro_maintenance_bill_master.customer_id', $customer_id)
                ->whereBetween('pro_maintenance_bill_master.entry_date', [$request->txt_from, $request->txt_to])
                ->where('pro_maintenance_bill_master.valid', 1)
                ->get();
        } else {
            $m_complaint = DB::table('pro_complaint_register')
                ->leftJoin('pro_projects', 'pro_complaint_register.project_id', 'pro_projects.project_id')
                ->leftJoin('pro_lifts', 'pro_complaint_register.lift_id', 'pro_lifts.lift_id')
                ->select(
                    'pro_complaint_register.complaint_register_id',
                    'pro_complaint_register.complaint_description',
                    'pro_complaint_register.entry_time',
                    'pro_complaint_register.entry_date',
                    'pro_projects.project_name',
                    'pro_lifts.lift_name',
                )
                ->where('pro_complaint_register.customer_id', $customer_id)
                ->where('pro_complaint_register.valid', 1)
                ->get();

            $m_maintenance_quation = DB::table('pro_maintenance_quotation_master')
                ->leftJoin('pro_projects', 'pro_maintenance_quotation_master.project_id', 'pro_projects.project_id')
                ->leftJoin('pro_employee_info as mgm', 'pro_maintenance_quotation_master.approved_mgm_id', 'mgm.employee_id')
                ->select(
                    'pro_maintenance_quotation_master.*',
                    'pro_projects.project_name',
                    'mgm.employee_name as mgm_name'
                )
                ->where('pro_maintenance_quotation_master.customer_id', $customer_id)
                ->whereIn('pro_maintenance_quotation_master.status', ['3'])
                ->get();


            $m_bill_master = DB::table('pro_maintenance_bill_master')
                ->leftJoin('pro_projects', 'pro_maintenance_bill_master.project_id', 'pro_projects.project_id')
                ->select(
                    'pro_maintenance_bill_master.*',
                    'pro_projects.project_name',
                )
                ->where('pro_maintenance_bill_master.customer_id', $customer_id)
                ->where('pro_maintenance_bill_master.valid', 1)
                ->get();
        }

        return view('maintenance.rpt_all_report_summery_list', compact('m_customer', 'form', 'to', 'customer_id', 'm_complaint', 'm_maintenance_quation', 'm_bill_master'));
    }
}
