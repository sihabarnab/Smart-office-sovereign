<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/home');
    }

    //Company
    public function admincuser()
    {
        $data = DB::table('users')->Where('valid', '1')->orderBy('id', 'asc')->get(); //query builder

        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();
        return view('admin.create_user', compact('data', 'companies'));
    }

    public function admincuserstore(Request $request)
    {
        $rules = [
            // 'cbo_employee_id' => 'required|integer|between:1,99999999',
            'txt_password' => 'required|min:8|max:20',
        ];

        $customMessages = [
            // 'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'txt_password.required' => 'Password is required.',
            'txt_password.min' => 'Password must be at least 8 characters.',
            'txt_password.max' => 'Password not more 20 characters.',
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('users')->where('emp_id', $request->cbo_employee_id)->first();
        //dd($abcd);

        if ($abcd === null) {

            $ci_employee_info = DB::table('pro_employee_info')->Where('employee_id', $request->cbo_employee_id)->first();
            $txt_employee_name = $ci_employee_info->employee_name;

            $m_valid = '1';
            $m_user_status = '1';

            $data = array();
            $data['emp_id'] = $request->cbo_employee_id;
            $data['password'] = Hash::make($request->txt_password);
            $data['user_status'] = $m_user_status;
            $data['admin_id'] = $request->txt_user_id;
            $data['full_name'] = $txt_employee_name;
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');
            // dd($data);
            DB::table('users')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }


    public function admincuseredit($id)
    {

        $m_user = DB::table('users')->where('emp_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('users')->Where('valid', '1')->orderBy('emp_id', 'desc')->get();
        return view('admin.create_user', compact('data', 'm_user'));
    }

    public function admincuserupdate(Request $request, $update)
    {

        $rules = [
            'sele_employee_id' => 'required|integer|between:1,99999999',
            'txt_password' => 'required|max:20|min:8',
        ];

        $customMessages = [

            'sele_employee_id.required' => 'Select Employee.',
            'sele_employee_id.integer' => 'Select Employee.',
            'sele_employee_id.between' => 'Chose Employee.',

            'txt_password.required' => 'Password is required.',
            'txt_password.min' => 'Password must be at least 8 characters.',
            'txt_password.max' => 'Password not more 20 characters.',

        ];

        $this->validate($request, $rules, $customMessages);

        DB::table('users')->where('emp_id', $update)->update([
            'password' => Hash::make($request->txt_password),
            'valid' => $request->sele_valid,
            'updated_at' => date('Y-m-d H:i:s'),

        ]);

        return redirect(route('create_user'))->with('success', 'Data Updated Successfully!');
    }

    // public function admincuser_permission($id)
    // {

    //     $m_user_permission=DB::table('users')->where('emp_id',$id)->first();
    //     // return response()->json($data);
    //     $data=DB::table('pro_sub_mnu_for_users')->Where('valid','1')->Where('emp_id',$m_user_permission->emp_id)->orderBy('sl_no', 'asc')->get();
    //     return view('admin.user_permission',compact('data','m_user_permission'));
    // }

    // public function moduleMainMenu(Request $request, $id)
    // {
    //     $data = DB::table('pro_main_mnu')->where('module_id',$id)->where('valid',1)->get();
    //     return response()->json(['data' => $data]);
    // }


    //New Module and Company
    public function UserModuleCompany()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();

        $employees = DB::table('pro_employee_info')->get();
        return view('admin.user_module_and_company', compact('employees', 'companies'));
    }

    public function user_mc_list(Request $request)
    {
        $rules = [
            'cbo_employee_id' => 'required',
            'cbo_blade' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_blade.required' => 'Select Blade',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->cbo_blade == 1) {
            return redirect()->route('user_module_edit', $request->cbo_employee_id);
        } elseif ($request->cbo_blade == 2) {
            return redirect()->route('user_company_edit', $request->cbo_employee_id);
        }
    }

    //Module
    public function user_module_edit($emp_id)
    {

        // $m_module = DB::table('pro_module_user')
        // ->where('pro_module_user.emp_id', $emp_id)
        // ->where('pro_module_user.valid', 1)
        // ->join('pro_module','pro_module_user.module_id','pro_module.module_id')
        // ->select('pro_module.*')
        // ->get();
        $m_module = DB::table('pro_module')->where('valid', 1)->get();
        return view('admin.user_module_list', compact('m_module', 'emp_id'));
    }
    public function user_module_update(Request $request, $id)
    {

        $check_module = DB::table('pro_module_user')
            ->where('emp_id', $id)
            ->where('module_id', $request->txt_module_id)
            ->first();

        if (isset($check_module)) {
            if ($request->txt_valid == "on") {
                DB::table('pro_module_user')
                    ->where('emp_id', $id)
                    ->where('module_id', $request->txt_module_id)
                    ->update(['valid' => 1]);
            } else {
                DB::table('pro_module_user')
                    ->where('emp_id', $id)
                    ->where('module_id', $request->txt_module_id)
                    ->update(['valid' => 0]);
            }
            return back()->with('success', 'Successfull Updated');
        } else {
            $data = array();
            $data['emp_id'] = $request->txt_employee_id;
            $data['module_id'] = $request->txt_module_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table('pro_module_user')->insert($data);
            return back()->with('success', 'Successfull Inserted');
        }
    }

    //comapny
    public function user_company_edit($emp_id)
    {
        $m_company = DB::table('pro_company')->where('valid', 1)->get();
        return view('admin.user_company_list', compact('m_company', 'emp_id'));
    }
    public function user_company_update(Request $request, $id)
    {
        $check_company = DB::table('pro_user_company')
            ->where('employee_id', $id)
            ->where('company_id', $request->txt_company_id)
            ->first();

        if (isset($check_company)) {
            if ($request->txt_valid == "on") {
                DB::table('pro_user_company')
                    ->where('employee_id', $id)
                    ->where('company_id', $request->txt_company_id)
                    ->update(['valid' => 1]);
            } else {
                DB::table('pro_user_company')
                    ->where('employee_id', $id)
                    ->where('company_id', $request->txt_company_id)
                    ->update(['valid' => 0]);
            }
            return back()->with('success', 'Successfull Updated');
        } else {
            $data = array();
            $data['employee_id'] = $request->txt_employee_id;
            $data['company_id'] = $request->txt_company_id;
            // $data['entry_date'] = date("Y-m-d");
            // $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table('pro_user_company')->insert($data);
            return back()->with('success', 'Successfull Inserted');
        }
    }



    //sub menu permission
    public function user_menu_permission()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();
        $modules = DB::table('pro_module')->get();
        return view('admin.user_menu_permission', compact('companies', 'modules'));
    }

    public function user_menu_permission_list(Request $request)
    {
        $rules = [
            'cbo_employee_id' => 'required',
            'cbo_company_id' => 'required',
            'cbo_module_id' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_company_id.required' => 'Select Company',
            'cbo_module_id.required' => 'Select Module',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_company = DB::table('pro_company')
            ->where('company_id', $request->cbo_company_id)
            ->first();
        $m_employee = DB::table('pro_employee_info')
            ->where('employee_id', $request->cbo_employee_id)
            // ->where('valid', 1)
            ->first();
        $m_modules = DB::table('pro_module')
            ->where('module_id', $request->cbo_module_id)
            ->first();
        $m_main_mnu = DB::table('pro_main_mnu')
            ->where('module_id', $request->cbo_module_id)
            ->get();
        return view('admin.user_menu_permission_list', compact('m_company', 'm_modules', 'm_employee', 'm_main_mnu'));
    }

    public function module_all_menu_permission(Request $request)
    {

        $m_submenu = DB::table('pro_sub_mnu')
            ->where('module_id', $request->txt_module_id)
            ->get();

        foreach ($m_submenu as $row) {

            if ($request->txt_valid_all == 'on') {
                $valid = '1';
            } else {
                $valid = '0';
            }

            $check = DB::table('pro_sub_mnu_for_users')
                ->where('emp_id', $request->txt_employee_id)
                ->where('module_id', $request->txt_module_id)
                ->where('main_mnu_id', $row->main_mnu_id)
                ->where('sub_mnu_id', $row->sub_mnu_id)
                ->first();

            if ($check) {
                DB::table('pro_sub_mnu_for_users')
                    ->where('emp_id', $request->txt_employee_id)
                    ->where('module_id', $request->txt_module_id)
                    ->where('main_mnu_id', $row->main_mnu_id)
                    ->where('sub_mnu_id', $row->sub_mnu_id)
                    ->update(['valid' => $valid]);
            } else {
                $data = array();
                $data['emp_id'] = $request->txt_employee_id;
                $data['module_id'] = $request->txt_module_id;
                $data['main_mnu_id'] = $row->main_mnu_id;
                $data['sub_mnu_id'] =  $row->sub_mnu_id;
                $data['valid'] = $valid;
                DB::table('pro_sub_mnu_for_users')->insert($data);
            }
            //  if ($check) { update
        }
        // foreach ($m_submenu as $value){
        return back()->with('success', "Module Wise add Successfull!");
    }

    public function main_menu_all_permission(Request $request)
    {

        $m_submenu = DB::table('pro_sub_mnu')
            ->where('module_id', $request->txt_module_id)
            ->where('main_mnu_id', $request->txt_main_menu_id)
            ->get();

        foreach ($m_submenu as $row) {

            if ($request->txt_mark_all == 'on') {
                $valid = '1';
            } else {
                $valid = '0';
            }

            $check = DB::table('pro_sub_mnu_for_users')
                ->where('emp_id', $request->txt_employee_id)
                ->where('module_id', $request->txt_module_id)
                ->where('main_mnu_id', $request->txt_main_menu_id)
                ->where('sub_mnu_id', $row->sub_mnu_id)
                ->first();

            if ($check) {
                DB::table('pro_sub_mnu_for_users')
                    ->where('emp_id', $request->txt_employee_id)
                    ->where('module_id', $request->txt_module_id)
                    ->where('main_mnu_id', $request->txt_main_menu_id)
                    ->where('sub_mnu_id', $row->sub_mnu_id)
                    ->update(['valid' => $valid]);
            } else {
                $data = array();
                $data['emp_id'] = $request->txt_employee_id;
                $data['module_id'] = $request->txt_module_id;
                $data['main_mnu_id'] = $request->txt_main_menu_id;
                $data['sub_mnu_id'] =  $row->sub_mnu_id;
                $data['valid'] = $valid;
                DB::table('pro_sub_mnu_for_users')->insert($data);
            }
            //  if ($check) { update
        }
        // foreach ($m_submenu as $value){
        return back()->with('success', " Main menu wise add Successfull!");
    }

    public function sub_menu_wise_permission(Request $request)
    {
        if ($request->txt_valid == 'on') {
            $valid = '1';
        } else {
            $valid = '0';
        }

        $check = DB::table('pro_sub_mnu_for_users')
            ->where('emp_id', $request->txt_employee_id)
            ->where('module_id', $request->txt_module_id)
            ->where('main_mnu_id', $request->txt_main_menu_id)
            ->where('sub_mnu_id', $request->txt_sub_menu_id)
            ->first();

        if ($check) {
            DB::table('pro_sub_mnu_for_users')
                ->where('emp_id', $request->txt_employee_id)
                ->where('module_id', $request->txt_module_id)
                ->where('main_mnu_id', $request->txt_main_menu_id)
                ->where('sub_mnu_id', $request->txt_sub_menu_id)
                ->update(['valid' => $valid]);
        } else {
            $data = array();
            $data['emp_id'] = $request->txt_employee_id;
            $data['module_id'] = $request->txt_module_id;
            $data['main_mnu_id'] = $request->txt_main_menu_id;
            $data['sub_mnu_id'] =   $request->txt_sub_menu_id;
            $data['valid'] = $valid;
            DB::table('pro_sub_mnu_for_users')->insert($data);
        }
        //  if ($check) { update
        return back()->with('success', "Sub mneu wise add Successfull!");
    }




    public function user_menu_create()
    {
        if (Auth::user()->emp_id == "00000101") {
            $m_modules = DB::table('pro_module')->where('valid', 1)->get();
            $m_sub_menu = DB::table('pro_sub_mnu')->where('valid', 1)->orderByDesc('sub_mnu_id')->get();
            return view('admin.user_menu_create', compact('m_modules', 'm_sub_menu'));
        } else {
            return back()->with('warning', "Data Not Found");
        }
    }
    public function user_menu_store(Request $request)
    {
        $rules = [
            'cbo_module_id' => 'required',
            'cbo_main_menu_id' => 'required',
            'txt_sub_menu_title' => 'required',
            'txt_sub_menu_link' => 'required',
            'txt_menu_serial' => 'required',
        ];

        $customMessages = [
            'cbo_module_id.required' => 'Select Module.',
            'cbo_main_menu_id.required' => 'Select Main Menu.',
            'txt_sub_menu_title.required' => 'Title is required.',
            'txt_sub_menu_link.required' => 'Link is required ',
            'txt_menu_serial.required' => 'Valid is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        if (Auth::user()->emp_id == "00000101") {
            DB::table('pro_sub_mnu')->insert([
                'module_id' => $request->cbo_module_id,
                'main_mnu_id' => $request->cbo_main_menu_id,
                'sub_mnu_title' => $request->txt_sub_menu_title,
                'sub_mnu_link' => $request->txt_sub_menu_link,
                'sub_mnu_gr' => 1,
                'menu_sl' => $request->txt_menu_serial,
                'valid' => 1,
            ]);
            return back()->with('success', "Sub mneu  Create Successfull!");
        } else {
            return back()->with('warning', "Data Not Found");
        }
    }


    public function user_menu_edit($id)
    {
        $m_sub_menu_edit = DB::table('pro_sub_mnu')->where('sub_mnu_id', $id)->first();
        $m_module = DB::table('pro_module')
            ->where('module_id', $m_sub_menu_edit->module_id)
            ->first();
        $m_main_menu = DB::table('pro_main_mnu')
            ->where('main_mnu_id', $m_sub_menu_edit->main_mnu_id)
            ->first();
        return view('admin.user_menu_edit', compact('m_module', 'm_sub_menu_edit', 'm_main_menu'));
    }

    public function user_menu_update(Request $request, $id)
    {
        DB::table('pro_sub_mnu')->where('sub_mnu_id', $id)->update([
            'sub_mnu_title' => $request->txt_sub_menu_title,
            'sub_mnu_link' => $request->txt_sub_menu_link,
            'menu_sl' => $request->txt_menu_serial,
        ]);
        return redirect()->route('user_menu_create')->with('success', "Sub mneu  Create Successfull!");
    }


        //user paassword reset
    public function user_password_reset()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();
        return view('admin.user_password_reset', compact('companies'));
    }
    public function user_password_update(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_employee_id' => 'required',
            'txt_new_pass' => [
                'required',
                'string',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'password_confirmation' => 'required|same:txt_new_pass'
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_employee_id.required' => 'Select Employee.',
            'txt_new_pass.required' => 'Password is Required.',
            'txt_new_pass.string' => 'Password must contain a string.',
            'txt_new_pass.regex' => 'Password at least one lowercase ,  one uppercase , one digit and chracter Ex- Pr@120#p ',
            'txt_new_pass.min' => 'Password must be at least 8 characters in length.',
            'password_confirmation.required' => 'Confirmed Password is Required.',
            'password_confirmation.same' => 'Password Confirmation should match the Password.',
        ];
        $this->validate($request, $rules, $customMessages);

        $newPassword = password_hash($request->txt_new_pass, PASSWORD_DEFAULT);

        DB::table("users")->where('emp_id', $request->cbo_employee_id)->update(['password' => $newPassword]);

        return back()->with('success', 'User Reset Password Successfully.');
    }


    // Ajax Sub Menu For User Store

    public function GetEmployee1($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('working_status', '1')
            // ->where('ss', '1')
            ->where('company_id', $id)
            ->orderBy('employee_id', 'asc')
            ->get();
        return json_encode($data);
    }

    public function GetCompany($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('company_id', $id)
            ->where('valid', '1')
            ->orderBy('employee_id', 'asc')
            ->get();
        return response()->json($data);
    }
    public function GetMainMenu($id)
    {
        $data = DB::table('pro_main_mnu')
            ->where('module_id', $id)
            ->get();
        return response()->json($data);
    }
}
