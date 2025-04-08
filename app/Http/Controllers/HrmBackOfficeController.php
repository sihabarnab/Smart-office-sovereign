<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use sqlsrv;
// use Illuminate\Http\Request;
// use DB;

class HrmBackOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

// private $m_user_id=Auth::user()->emp_id;
// public $m_user_id=33;

//Company
    public function hrmbackcompany()
    {
        $data=DB::table('pro_company')->Where('valid','1')->orderBy('company_id', 'asc')->get(); //query builder
        return view('hrm.company',compact('data'));

        // return view('hrm.company');
    }

    public function hrmbackcompanystore(Request $request)
    {
        $rules = [
            'txt_company_name' => 'required',
            'txt_company_address' => 'required',
            'txt_company_zip' => 'required',
            'txt_company_city' => 'required',
            'txt_company_country' => 'required',
            'txt_company_phone' => 'required',
            'txt_company_mobile' => 'required',
            'txt_company_email' => 'required',
            'txt_company_url' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_company_name.required' => 'Company Name is required.',
            'txt_company_address.required' => 'Address is required.',
            'txt_company_zip.required' => 'Zip is required.',
            'txt_company_city.required' => 'City is required.',
            'txt_company_country.required' => 'Country is required.',
            'txt_company_phone.required' => 'Phone is required.',
            'txt_company_mobile.required' => 'Mobile is required.',
            'txt_company_email.required' => 'E-mail is required.',
            'txt_company_url.required' => 'URL is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_company')->where('company_name', $request->txt_company_name)->first();
        //dd($abcd);

        
        
        if ($abcd === null)
        {
        $m_valid='1';

        $data=array();
        $data['company_name']=$request->txt_company_name;
        $data['company_add']=$request->txt_company_address;
        $data['company_zip']=$request->txt_company_zip;
        $data['company_city']=$request->txt_company_city;
        $data['company_country']=$request->txt_company_country;
        $data['company_phone']=$request->txt_company_phone;
        $data['company_mobile']=$request->txt_company_mobile;
        $data['company_email']=$request->txt_company_email;
        $data['company_url']=$request->txt_company_url;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_company')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function hrmbackcompanyedit($id)
    {
        
        $m_company=DB::table('pro_company')->where('company_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_company')->Where('valid','1')->orderBy('company_id', 'desc')->get();
        return view('hrm.company',compact('data','m_company'));
    }

public function hrmbackcompanyupdate(Request $request)
    {      
        DB::table('pro_company')->where('company_id',$request->txt_company_id)->update([
            'company_name'=>$request->txt_company_name,
            'company_add'=>$request->txt_company_address,
            'company_zip'=>$request->txt_company_zip,
            'company_city'=>$request->txt_company_city,
            'company_country'=>$request->txt_company_country,
            'company_phone'=>$request->txt_company_phone,
            'company_mobile'=>$request->txt_company_mobile,
            'company_email'=>$request->txt_company_email,
            'company_url'=>$request->txt_company_url,
            'last_entry_date'=>date('Y-m-d'),
            'last_entry_time'=>date('H:i:s')
        ]);
        return redirect(route('company'))->with('success','Data Updated Successfully!');
    }


//Designation
        public function hrmbackdesignation()
    {
        $data=DB::table('pro_desig')->Where('valid','1')->orderBy('desig_id', 'desc')->get(); //query builder
        return view('hrm.designation',compact('data'));
    }

    public function hrmbackdesignationstore(Request $request)
    {
        $rules = [
            'txt_desig_name' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_desig_name.required' => 'Designation Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_desig')->where('desig_name', $request->txt_desig_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['desig_name']=$request->txt_desig_name;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_desig')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function hrmbackdesignationedit($id)
    {
        
        $m_desig=DB::table('pro_desig')->where('desig_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_desig')->Where('valid','1')->orderBy('desig_id', 'desc')->get();
        return view('hrm.designation',compact('data','m_desig'));
    }

public function hrmbackdesignationupdate(Request $request)
    {      
        DB::table('pro_desig')->where('desig_id',$request->txt_desig_id)->update([
            'desig_name'=>$request->txt_desig_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('designation'))->with('success','Data Updated Successfully!');
    }



//department

    public function hrmbackdepartment()
    {
    $data=DB::table('pro_department')->Where('valid','1')->orderBy('department_id', 'desc')->get(); //query builder
        return view('hrm.department',compact('data'));
    }
    public function hrmbackdepartmentstore(Request $request)
    {
        $rules = [
            'txt_department_name' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_department_name.required' => 'Department Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_department')->where('department_name', $request->txt_department_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['department_name']=$request->txt_department_name;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_department')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function hrmbackdepartmentedit($id)
    { 
        $m_dept=DB::table('pro_department')->where('department_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_department')->Where('valid','1')->orderBy('department_id', 'desc')->get();
        return view('hrm.department',compact('data','m_dept'));
    }

public function hrmbackdepartmentupdate(Request $request)
    {      
        DB::table('pro_department')->where('department_id',$request->txt_department_id)->update([
            'department_name'=>$request->txt_department_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('department'))->with('success','Data Updated Successfully!');
    }

//section

    public function hrmbacksection()
    {
        $data=DB::table('pro_section')->Where('valid','1')->orderBy('section_id', 'desc')->get(); //query builder
        return view('hrm.section',compact('data'));
        // return view('hrm.section');
    }
    public function hrmbacksectionstore(Request $request)
    {
        $rules = [
            'txt_section_name' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_section_name.required' => 'Section Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_section')->where('section_name', $request->txt_section_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['section_name']=$request->txt_section_name;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_section')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }
    public function hrmbacksectionedit($id)
    { 
        $m_sec=DB::table('pro_section')->where('section_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_section')->Where('valid','1')->orderBy('section_id', 'desc')->get();
        return view('hrm.section',compact('data','m_sec'));
    }
    public function hrmbacksectionupdate(Request $request)
    {      
        DB::table('pro_section')->where('section_id',$request->txt_section_id)->update([
            'section_name'=>$request->txt_section_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('section'))->with('success','Data Updated Successfully!');
    }

//place of posting

    public function hrmbackplaceposting()
    {
        $data=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_id', 'desc')->get(); //query builder
        return view('hrm.placeposting',compact('data'));

        // return view('hrm.placeposting');

    }
    public function hrmbackplace_postingstore(Request $request)
    {
        $rules = [
            'txt_placeofposting_name' => 'required'
                ];
        $customMessages = [
            'required' => 'Place of Posting Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_placeofposting')->where('placeofposting_name', $request->txt_placeofposting_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['placeofposting_name']=$request->txt_placeofposting_name;
        $data['emp_id']=$request->txt_user_id;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_placeofposting')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }
    public function hrmbackplace_postingedit($id)
    { 
        $m_placeofposting=DB::table('pro_placeofposting')->where('placeofposting_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_id', 'desc')->get();
        return view('hrm.placeposting',compact('data','m_placeofposting'));
    }

    public function hrmbackplace_postingupdate(Request $request,$update)
    {      
        DB::table('pro_placeofposting')->where('placeofposting_id',$update)->update([
            'placeofposting_name'=>$request->txt_placeofposting_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('placeposting'))->with('success','Data Updated Successfully!');
    }

//bio device
    public function hrmbackbio_device()
    {
        $data=DB::table('pro_biodevice')->Where('valid','1')->orderBy('biodevice_id', 'desc')->get(); //query builder
        return view('hrm.biodevice',compact('data'));
    }

    public function hrmbackbio_devicestore(Request $request)
    {
        $rules = [
            'txt_biodevice_name' => 'required',
            'sele_placeofposting_id' => 'required|integer|between:1,10000',
                ];
        $customMessages = [
            'txt_biodevice_name.required' => 'Bio Device ID / Terminal ID is required.',

            'sele_placeofposting_id.required' => 'Select Place/Branch.',
            'sele_placeofposting_id.integer' => 'Select Place/Branch.',
            'sele_placeofposting_id.between' => 'Chose Place/Branch.',

        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_biodevice')->where('biodevice_name', $request->txt_biodevice_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['biodevice_name']=$request->txt_biodevice_name;
        $data['placeofposting_id']=$request->sele_placeofposting_id;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_biodevice')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function hrmbackbio_deviceedit($id)
    {
        $m_biodevice=DB::table('pro_biodevice')->where('biodevice_id',$id)->first();
        $data=DB::table('pro_biodevice')->where('valid','1')->get();
        return view('hrm.biodevice',compact('data','m_biodevice'));
    }

    public function hrmbackbio_deviceupdate(Request $request,$update)
    {

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
      
        DB::table('pro_biodevice')->where('biodevice_id',$update)->update([
            'biodevice_name'=>$request->txt_biodevice_name,
            'placeofposting_id'=>$request->sele_placeofposting_id,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('biodevice'))->with('success','Data Updated Successfully!');
    }

//policy

    public function hrmbackpolicy()
    {
        $data=DB::table('pro_att_policy')->Where('valid','1')->orderBy('att_policy_id', 'desc')->get(); //query builder
        return view('hrm.policy',compact('data'));

    }

    public function hrmbackpolicystore(Request $request)
    {
        $rules = [
            'txt_att_policy_name' => 'required',
            'txt_in_time' => 'required',
            'txt_out_time' => 'required',
            'txt_grace_time' => 'required',
            'txt_lunch_time' => 'required',
            'txt_lunch_break' => 'required',
            'sele_weekly_holiday1' => 'required|integer|between:1,7',
            'sele_ot_elgble' => 'required|integer|between:1,2',
                ];
        $customMessages = [
            'txt_att_policy_name.required' => 'Policy / Shift Name is required.',
            'txt_in_time.required' => 'In Time is required.',
            'txt_out_time.required' => 'Out Time is required.',
            'txt_grace_time.required' => 'Grace Time is required.',
            'txt_lunch_time.required' => 'Lunch Time is required.',
            'txt_lunch_break.required' => 'Lunch Break minute is required.',

            'sele_weekly_holiday1.required' => 'Select Weekly Holiday.',
            'sele_weekly_holiday1.integer' => 'Select Weekly Holiday.',
            'sele_weekly_holiday1.between' => 'Chose Weekly Holiday.',

            'sele_ot_elgble.required' => 'Select Yes / No.',
            'sele_ot_elgble.integer' => 'Select Yes / No.',
            'sele_ot_elgble.between' => 'Chose Yes / No.',

        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_att_policy')->where('att_policy_name', $request->txt_att_policy_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_txt_in_time=$request->txt_in_time;
        $aa=strtotime($m_txt_in_time);
        $m_txt_grace_time=$request->txt_grace_time;
        $ab=$m_txt_grace_time*60;
        $txt_grace_time_cal=$aa+$ab;
        $graced_in_time=date('h:i:s',$txt_grace_time_cal);

        if ($request->sele_weekly_holiday1==1){
        $txt_holiday1='Saturday';  
        } else if ($request->sele_weekly_holiday1==2){
        $txt_holiday1='Sunday';  
        } else if ($request->sele_weekly_holiday1==3){
        $txt_holiday1='Monday';  
        } else if ($request->sele_weekly_holiday1==4){
        $txt_holiday1='Tuesday';  
        } else if ($request->sele_weekly_holiday1==5){
        $txt_holiday1='Wednesday';  
        } else if ($request->sele_weekly_holiday1==6){
        $txt_holiday1='Thursday';  
        } else if ($request->sele_weekly_holiday1==7){
        $txt_holiday1='Friday';  
        }

        if ($request->sele_weekly_holiday2==0){
        $txt_holiday2='N/A';  
        } else if ($request->sele_weekly_holiday2==1){
        $txt_holiday2='Saturday';  
        } else if ($request->sele_weekly_holiday2==2){
        $txt_holiday2='Sunday';  
        } else if ($request->sele_weekly_holiday2==3){
        $txt_holiday2='Monday';  
        } else if ($request->sele_weekly_holiday2==4){
        $txt_holiday2='Tuesday';  
        } else if ($request->sele_weekly_holiday2==5){
        $txt_holiday2='Wednesday';  
        } else if ($request->sele_weekly_holiday2==6){
        $txt_holiday2='Thursday';  
        } else if ($request->sele_weekly_holiday2==7){
        $txt_holiday2='Friday';  
        }


        $data=array();
        $data['att_policy_name']=$request->txt_att_policy_name;
        $data['in_time']=$request->txt_in_time;
        $data['out_time']=$request->txt_out_time;
        $data['grace_time']=$request->txt_grace_time;
        $data['in_time_graced']=$graced_in_time;
        $data['lunch_time']=$request->txt_lunch_time;
        $data['lunch_break']=$request->txt_lunch_break;
        $data['weekly_holiday1']=$txt_holiday1;
        $data['weekly_holiday2']=$txt_holiday2;
        $data['ot_elgble']=$request->sele_ot_elgble;
        $data['user_info_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_att_policy')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function hrmbackpolicyedit($id)
    {
        $m_att_policy=DB::table('pro_att_policy')->where('att_policy_id',$id)->first();
        $data=DB::table('pro_att_policy')->where('valid','1')->get();
        return view('hrm.policy',compact('data','m_att_policy'));
    }

    public function hrmbackpolicyupdate(Request $request,$update)
    {

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_txt_in_time=$request->txt_in_time;
        $aa=strtotime($m_txt_in_time);
        $m_txt_grace_time=$request->txt_grace_time;
        $ab=$m_txt_grace_time*60;
        $txt_grace_time_cal=$aa+$ab;
        $graced_in_time=date('h:i:s',$txt_grace_time_cal);

        if ($request->sele_weekly_holiday1==1){
        $txt_holiday1='Saturday';  
        } else if ($request->sele_weekly_holiday1==2){
        $txt_holiday1='Sunday';  
        } else if ($request->sele_weekly_holiday1==3){
        $txt_holiday1='Monday';  
        } else if ($request->sele_weekly_holiday1==4){
        $txt_holiday1='Tuesday';  
        } else if ($request->sele_weekly_holiday1==5){
        $txt_holiday1='Wednesday';  
        } else if ($request->sele_weekly_holiday1==6){
        $txt_holiday1='Thursday';  
        } else if ($request->sele_weekly_holiday1==7){
        $txt_holiday1='Friday';  
        }

        if ($request->sele_weekly_holiday2==0){
        $txt_holiday2='N/A';  
        } else if ($request->sele_weekly_holiday2==1){
        $txt_holiday2='Saturday';  
        } else if ($request->sele_weekly_holiday2==2){
        $txt_holiday2='Sunday';  
        } else if ($request->sele_weekly_holiday2==3){
        $txt_holiday2='Monday';  
        } else if ($request->sele_weekly_holiday2==4){
        $txt_holiday2='Tuesday';  
        } else if ($request->sele_weekly_holiday2==5){
        $txt_holiday2='Wednesday';  
        } else if ($request->sele_weekly_holiday2==6){
        $txt_holiday2='Thursday';  
        } else if ($request->sele_weekly_holiday2==7){
        $txt_holiday2='Friday';  
        }


        DB::table('pro_att_policy')->where('att_policy_id',$update)->update([
            'att_policy_name'=>$request->txt_att_policy_name,
            'in_time'=>$request->txt_in_time,
            'out_time'=>$request->txt_out_time,
            'grace_time'=>$request->txt_grace_time,
            'in_time_graced'=>$graced_in_time,
            'lunch_time'=>$request->txt_lunch_time,
            'lunch_break'=>$request->txt_lunch_break,
            'weekly_holiday1'=>$txt_holiday1,
            'weekly_holiday2'=>$txt_holiday2,
            'ot_elgble'=>$request->sele_ot_elgble,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('policy'))->with('success','Data Updated Successfully!');
    }

//holiday

    public function hrmbackholiday()
    {

        $mentrydate=time();
        $m_holiday_year=date("Y",$mentrydate);
       
        $data=DB::table('pro_holiday')->Where('valid','1')->where('holiday_year',$m_holiday_year)->orderBy('holiday_id', 'desc')->get(); //query builder
        return view('hrm.holiday',compact('data'));
    }

    public function hrmbackholidaystore(Request $request)
    {
        $rules = [
            'txt_holiday_name' => 'required',
            'txt_holiday_date' => 'required',
                ];
        $customMessages = [
            'txt_holiday_name.required' => 'Holiday Name is required.',
            'txt_holiday_date.required' => 'Holiday Date is required.',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_holiday_date=$request->txt_holiday_date;
        $m_holiday_year=substr($m_holiday_date,0,4);

        $abcd = DB::table('pro_holiday')->where('holiday_name', $request->txt_holiday_name)->where('holiday_year', $m_holiday_year)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);


        $data=array();
        $data['holiday_name']=$request->txt_holiday_name;
        $data['holiday_year']=$m_holiday_year;
        $data['holiday_date']=$request->txt_holiday_date;
        $data['user_info_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_holiday')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function hrmbackholidayedit($id)
    {
        $m_holiday=DB::table('pro_holiday')->where('holiday_id',$id)->first();
        $data=DB::table('pro_holiday')->where('valid','1')->get();
        return view('hrm.holiday',compact('data','m_holiday'));
    }

    public function hrmbackholidayupdate(Request $request,$update)
    {

        $m_holiday_date=$request->txt_holiday_date;
        $m_holiday_year=substr($m_holiday_date,0,4);

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        DB::table('pro_holiday')->where('holiday_id',$update)->update([
            'holiday_name'=>$request->txt_holiday_name,
            'holiday_year'=>$m_holiday_year,
            'holiday_date'=>$request->txt_holiday_date,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('holiday'))->with('success','Data Updated Successfully!');
    }


//Basic Info

    public function hrmbackbasic_info()
    {
        $data=DB::table('pro_employee_info')->Where('valid','1')->Where('working_status','1')->orderBy('employee_id','asc')->get(); //query builder

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.basic_info',compact('data','user_company'));

    }

    //Basic Info insert
    public function hrmbackbasic_infostore(Request $request)
    {
    $rules = [
            'sele_company_id' => 'required|integer|between:1,10000',
            'txt_emp_id' => 'required|max:8|min:8',
            'txt_emp_name' => 'required|max:50|min:4',
            // 'sele_report' => 'required|integer|between:1,10000',
            'sele_desig' => 'required|integer|between:1,10000',
            'sele_department' => 'required|integer|between:1,10000',
            'sele_section' => 'required|integer|between:1,10000',
            'sele_placeofposting' => 'required|integer|between:1,10000',
            'txt_joining_date' => 'required',
            'sele_att_policy' => 'required|integer|between:1,10000',
            'sele_gender_id' => 'required|integer|between:1,10000',
            'txt_emp_mobile' => 'required',
            'sele_blood' => 'required|integer|between:1,10000',
            'cbo_healper_active' => 'required',
        ];

        $customMessages = [

            'sele_company_id.required' => 'Select Company.',
            'sele_company_id.integer' => 'Select Company.',
            'sele_company_id.between' => 'Chose Company.',

            'txt_emp_id.required' => 'Employee ID is required.',
            'txt_emp_id.min' => 'Employee ID must be at least 3 characters.',
            'txt_emp_id.max' => 'Employee ID less then 20 characters.',

            'txt_emp_name.required' => 'Employee Name is required.',
            'txt_emp_name.min' => 'Employee Name must be at least 4 characters.',
            'txt_emp_name.max' => 'Employee Name less then 50 characters.',

            // 'sele_report.required' => 'Select Report To.',
            // 'sele_report.integer' => 'Select Report To.',
            // 'sele_report.between' => 'Chose Report To.',

            'sele_desig.required' => 'Chose Designation.',
            'sele_desig.integer' => 'Chose Designation.',
            'sele_desig.between' => 'Chose Designation.',

            'sele_department.required' => 'Chose Department.',
            'sele_department.integer' => 'Chose Department.',
            'sele_department.between' => 'Chose Department.',

            'sele_section.required' => 'Chose Section.',
            'sele_section.integer' => 'Chose Section.',
            'sele_section.between' => 'Chose Section.',

            'sele_placeofposting.required' => 'Chose Place of Posting.',
            'sele_placeofposting.integer' => 'Chose Place of Posting.',
            'sele_placeofposting.between' => 'Chose Place of Posting.',

            'txt_joining_date.required' => 'Joining Date is required.',

            'sele_att_policy.required' => 'Chose Attendance Policy.',
            'sele_att_policy.integer' => 'Chose Attendance Policy.',
            'sele_att_policy.between' => 'Chose Attendance Policy.',

            'sele_gender_id.required' => 'Chose Gender.',
            'sele_gender_id.integer' => 'Chose Gender.',
            'sele_gender_id.between' => 'Chose Gender.',

            'txt_emp_mobile.required' => 'Employee Mobile Number required.',

            'sele_blood.required' => 'Select Blood Group.',
            'sele_blood.integer' => 'Select Blood Group.',
            'sele_blood.between' => 'Select Blood Group.',
            'cbo_healper_active.required' => 'Select Leader & Healper.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $ci_employee_info = DB::table('pro_employee_info')->where('employee_id', $request->txt_emp_id)->first();
        //dd($abcd);
        
        if ($ci_employee_info === null)
        {

        $m_valid='1';
        $m_ss='1';
        $m_working_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['company_id']=$request->sele_company_id;
        $data['employee_id']=$request->txt_emp_id;
        $data['employee_name']=$request->txt_emp_name;
        $data['report_to_id']=$request->sele_report;
        $data['desig_id']=$request->sele_desig;
        $data['department_id']=$request->sele_department;
        $data['section_id']=$request->sele_section;
        $data['placeofposting_id']=$request->sele_placeofposting;
        $data['joinning_date']=$request->txt_joining_date;
        $data['att_policy_id']=$request->sele_att_policy;
        $data['gender']=$request->sele_gender_id;
        $data['mobile']=$request->txt_emp_mobile;
        $data['blood_group']=$request->sele_blood;
        $data['grade']=$request->txt_grade;
        $data['working_status']=$m_working_status;
        $data['ss']=$m_ss;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        $data['staff_id']=$request->txt_psm_id;
        $data['leader_healper_status']=$request->cbo_healper_active;

        //dd($data);
        DB::table('pro_employee_info')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
        return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }

    }

    public function hrmbackbasic_infoedit($id)
    {
        $m_basic_info=DB::table('pro_employee_info')->where('employee_info_id',$id)->first();
        $data=DB::table('pro_employee_info')->where('valid','1')->where('employee_info_id',$m_basic_info->employee_info_id)->first();
        $m_employee_info = DB::table('pro_employee_info')->Where('valid','1')->get();
        $m_pro_desig = DB::table('pro_desig')->Where('valid','1')->get();
        $m_pro_department = DB::table('pro_department')->Where('valid','1')->get();
        $m_pro_section = DB::table('pro_section')->Where('valid','1')->get();
        $m_pro_placeofposting = DB::table('pro_placeofposting')->Where('valid','1')->get();
        $m_pro_att_policy = DB::table('pro_att_policy')->Where('valid','1')->get();
        $m_pro_gender = DB::table('pro_gender')->Where('valid','1')->get();
        $m_pro_blood = DB::table('pro_blood')->Where('valid','1')->get();

        // dd($data->company_id);
        return view('hrm.basic_info',compact('data','m_basic_info','m_employee_info','m_pro_desig','m_pro_department','m_pro_section','m_pro_placeofposting','m_pro_att_policy','m_pro_gender','m_pro_blood'));
    }

    public function hrmbackbasic_infoupdate(Request $request,$update)
    {

    $rules = [
            // 'sele_company_id' => 'required|integer|between:1,10000',
            // 'txt_emp_id' => 'required|max:20|min:3',
            'txt_emp_name' => 'required|max:50|min:4',
            // 'sele_report' => 'required|integer|between:1,10000',
            'sele_desig' => 'required|integer|between:1,10000',
            'sele_department' => 'required|integer|between:1,10000',
            'sele_section' => 'required|integer|between:1,10000',
            'sele_placeofposting' => 'required|integer|between:1,10000',
            'txt_joining_date' => 'required',
            'sele_att_policy' => 'required|integer|between:1,10000',
            'sele_gender_id' => 'required|integer|between:1,10000',
            'txt_emp_mobile' => 'required',
            'sele_blood' => 'required|integer|between:1,10000',
            'cbo_healper_active' => 'required',
        ];

        $customMessages = [

            // 'sele_company_id.required' => 'Select Company.',
            // 'sele_company_id.integer' => 'Select Company.',
            // 'sele_company_id.between' => 'Chose Company.',

            // 'txt_emp_id.required' => 'Employee ID is required.',
            // 'txt_emp_id.min' => 'Employee ID must be at least 3 characters.',
            // 'txt_emp_id.max' => 'Employee ID less then 20 characters.',

            'txt_emp_name.required' => 'Employee Name is required.',
            'txt_emp_name.min' => 'Employee Name must be at least 4 characters.',
            'txt_emp_name.max' => 'Employee Name less then 50 characters.',

            // 'sele_report.required' => 'Select Report To.',
            // 'sele_report.integer' => 'Select Report To.',
            // 'sele_report.between' => 'Chose Report To.',

            'sele_desig.required' => 'Chose Designation.',
            'sele_desig.integer' => 'Chose Designation.',
            'sele_desig.between' => 'Chose Designation.',

            'sele_department.required' => 'Chose Department.',
            'sele_department.integer' => 'Chose Department.',
            'sele_department.between' => 'Chose Department.',

            'sele_section.required' => 'Chose Section.',
            'sele_section.integer' => 'Chose Section.',
            'sele_section.between' => 'Chose Section.',

            'sele_placeofposting.required' => 'Chose Place of Posting.',
            'sele_placeofposting.integer' => 'Chose Place of Posting.',
            'sele_placeofposting.between' => 'Chose Place of Posting.',

            'txt_joining_date.required' => 'Joining Date is required.',

            'sele_att_policy.required' => 'Chose Attendance Policy.',
            'sele_att_policy.integer' => 'Chose Attendance Policy.',
            'sele_att_policy.between' => 'Chose Attendance Policy.',

            'sele_gender_id.required' => 'Chose Gender.',
            'sele_gender_id.integer' => 'Chose Gender.',
            'sele_gender_id.between' => 'Chose Gender.',

            'txt_emp_mobile.required' => 'Employee Mobile Number required.',

            'sele_blood.required' => 'Select Blood Group.',
            'sele_blood.integer' => 'Select Blood Group.',
            'sele_blood.between' => 'Select Blood Group.',
            
            'cbo_healper_active.required' => 'Select Leader & Healper.',
        ];        

        $this->validate($request, $rules, $customMessages);

        $ci_employee_info = DB::table('pro_employee_info')->where('employee_id', $request->txt_emp_id)->where('employee_info_id','<>',$update)->first();
        //dd($abcd);
        
        if ($ci_employee_info === null)
        {

        DB::table('pro_employee_info')->where('employee_info_id',$update)->update([
            // 'company_id'=>$request->sele_company_id,
            // 'employee_id'=>$request->txt_emp_id,
            'employee_name'=>$request->txt_emp_name,
            'report_to_id'=>$request->sele_report,
            'desig_id'=>$request->sele_desig,
            'department_id'=>$request->sele_department,
            'section_id'=>$request->sele_section,
            'placeofposting_id'=>$request->sele_placeofposting,
            'joinning_date'=>$request->txt_joining_date,
            'att_policy_id'=>$request->sele_att_policy,
            'gender'=>$request->sele_gender_id,
            'mobile'=>$request->txt_emp_mobile,
            'blood_group'=>$request->sele_blood,
            'grade'=>$request->txt_grade,
            'staff_id'=>$request->txt_psm_id,
            'leader_healper_status'=>$request->cbo_healper_active,

            ]);

        return redirect(route('basic_info'))->with('success','Data Updated Successfully!');
        } else {
        return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }

    }


//bio_data
    
    public function hrmbackbio_data()
    {
        $m_user_id=Auth::user()->emp_id;
        // $ci_biodata=DB::table('pro_employee_biodata')->Where('valid','1')->Where('valid','1')->orderBy('employee_id','asc')->get(); //query builder
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        // $company = DB::table('pro_company')->Where('valid','1')->get();
        $marital_status = DB::table('pro_marital_status')->Where('valid','1')->get();

        return view('hrm.bio_data',compact('user_company','marital_status'));
        // return view('hrm.bio_data',compact('ci_biodata'));

    }

    public function companyEmployee(Request $request, $id)
    {
        $data = DB::table('pro_employee_info')->where('company_id',$id)->get();
        return response()->json(['data' => $data]);
    }

    //Bio Data insert
    public function hrmbio_datastore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,30',
            'cbo_employee_id' => 'required',
            'txt_father_name' => 'required|min:4|max:50',
            'txt_mother_name' => 'required|min:4|max:50',
            'txt_dob' => 'required',
            'cbo_marital_status' => 'required|integer|between:1,10',
            // 'txt_spouse_name' => 'required|min:4|max:50',
            'txt_res_contact' => 'required|max:25',
            'txt_nationality' => 'required|max:20',
            'txt_national_id_no' => 'required|max:20',
            'txt_present_add' => 'required',
            'txt_permanent_add' => 'required',
            // 'txt_email_personal' => 'required',
            // 'txt_email_office' => 'required',
        ];

        $customMessages = [


            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Chose Company.',

            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_employee_id.integer' => 'Select Employee.',
            'cbo_employee_id.between' => 'Chose Employee.',

            'txt_father_name.required' => 'Father Name is required.',
            'txt_father_name.min' => 'Father Name must be at least 4 characters.',
            'txt_father_name.max' => 'Father Name less then 50 characters.',

            'txt_mother_name.required' => 'Mother Name is required.',
            'txt_mother_name.min' => 'Mother Name must be at least 4 characters.',
            'txt_mother_name.max' => 'Mother Name less then 50 characters.',

            'txt_dob.required' => 'Date of Birth is required.',

            'cbo_marital_status.required' => 'Select Marital Status.',
            'cbo_marital_status.integer' => 'Select Marital Status.',
            'cbo_marital_status.between' => 'Chose Marital Status.',

            // 'txt_spouse_name.required' => 'Spouse Name is required.',
            // 'txt_spouse_name.min' => 'Spouse Name must be at least 4 characters.',
            // 'txt_spouse_name.max' => 'Spouse Name less then 50 characters.',

            'txt_res_contact.required' => 'Residential Contact number is required.',
            'txt_res_contact.max' => 'Residential Contact number less then 50 characters.',

            'txt_nationality.required' => 'Nationality is required.',
            'txt_nationality.max' => 'Nationality less then 20 characters.',

            'txt_national_id_no.required' => 'NID is required.',
            'txt_national_id_no.max' => 'NID less then 50 characters.',

            'txt_present_add.required' => 'Present address is required.',
            'txt_permanent_add.required' => 'Permanent address is required.',
            // 'txt_email_personal.required' => 'Personal E-mail is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        // $mentrydate=time();
        // $m_entry_date=date("Y-m-d",$mentrydate);
        // $m_entry_time=date("H:i:s",$mentrydate);
        $m_bio_status='2';


        $ci_emp_info=DB::table('pro_employee_info')->Where('employee_id',$request->cbo_employee_id)->first();
        $txt_employee_info_id=$ci_emp_info->employee_info_id;
        $txt_employee_name=$ci_emp_info->employee_name;


        $data=array();
        $data['employee_info_id']=$txt_employee_info_id;
        $data['company_id']=$request->cbo_company_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['employee_name']=$txt_employee_name;
        $data['father_name']=$request->txt_father_name;
        $data['mother_name']=$request->txt_mother_name;
        $data['dob']=$request->txt_dob;
        $data['marital_status_id']=$request->cbo_marital_status;
        $data['spouse_name']=$request->txt_spouse_name;
        $data['res_contact']=$request->txt_res_contact;
        $data['nationality']=$request->txt_nationality;
        $data['national_id_no']=$request->txt_national_id_no;
        $data['height']=$request->txt_height;
        $data['present_add']=$request->txt_present_add;
        $data['permanent_add']=$request->txt_permanent_add;
        $data['email_personal']=$request->txt_email_personal;
        $data['email_office']=$request->txt_email_office;
        $data['user_id']=$request->txt_emp_id;
        
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        $data['valid']=$m_valid;

        // dd($data);
        DB::table('pro_employee_biodata')->insert($data);

        DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->update([
            'bio_status'=>$m_bio_status,
            ]);
        return redirect()->back()->with('success','Data Inserted Successfully!');
    }

    public function hrmbio_dataedit($id)
    {
        $m_employee_biodata=DB::table('pro_employee_biodata')
            ->join("pro_company", "pro_employee_biodata.company_id", "pro_company.company_id")


        ->where('biodata_id',$id)->first();
        $data=DB::table('pro_employee_biodata')->where('valid','1')->get();
        $company = DB::table('pro_company')->Where('valid','1')->get();
        $marital_status = DB::table('pro_marital_status')->Where('valid','1')->get();
        return view('hrm.bio_data',compact('data','m_employee_biodata','company','marital_status'));
    }


    public function hrmbio_dataupdate(Request $request,$update)
    {

    $rules = [
            'txt_father_name' => 'required',
            'txt_mother_name' => 'required',
            'txt_dob' => 'required',
            'cbo_marital_status' => 'required|integer|between:1,10',
            // 'txt_spouse_name' => 'required',
            'txt_res_contact' => 'required',
            'txt_nationality' => 'required',
            'txt_national_id_no' => 'required',
            'txt_present_add' => 'required',
            'txt_permanent_add' => 'required',
            'txt_email_personal' => 'required',
        ];

        $customMessages = [

            'txt_father_name.required' => 'Father Name is required.',
            'txt_mother_name.required' => 'Mother Name is required.',
            'txt_dob.required' => 'DOB is required.',

            'cbo_marital_status.required' => 'Marital Status.',
            'cbo_marital_status.integer' => 'Marital Status.',
            'cbo_marital_status.between' => 'Marital Status.',

            // 'txt_spouse_name.required' => 'Spouse Name is required.',
            'txt_res_contact.required' => 'Res. Contact is required.',
            'txt_nationality.required' => 'Nationality is required.',
            'txt_national_id_no.required' => 'NID is required.',
            'txt_present_add.required' => 'Present Add is required.',
            'txt_permanent_add.required' => 'Permanent Add is required.',
            'txt_email_personal.required' => 'Email Personal is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $ci_employee_biodata = DB::table('pro_employee_biodata')->where('employee_id', $request->sele_emp_id)->where('biodata_id','<>',$update)->first();
        // dd($ci_employee_biodata);
        
        if ($ci_employee_biodata === null)
        {

        DB::table('pro_employee_biodata')->where('biodata_id',$update)->update([
            'father_name'=>$request->txt_father_name,
            'mother_name'=>$request->txt_mother_name,
            'dob'=>$request->txt_dob,
            'marital_status_id'=>$request->cbo_marital_status,
            'spouse_name'=>$request->txt_spouse_name,
            'res_contact'=>$request->txt_res_contact,
            'nationality'=>$request->txt_nationality,
            'national_id_no'=>$request->txt_national_id_no,
            'height'=>$request->txt_height,
            'present_add'=>$request->txt_present_add,
            'permanent_add'=>$request->txt_permanent_add,
            'email_personal'=>$request->txt_email_personal,
            'email_office'=>$request->txt_email_office,

            ]);

        return redirect(route('bio_data'))->with('success','Data Updated Successfully!');
        } else {
        return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }

    }


    public function biodata_file($emp_id)
    {
        return view('hrm.biodata_file',compact('emp_id'));
    }

    public function biodata_file_store(Request $request)
    {


        $m_pic_check = DB::table('pro_employee_biodata')->where("employee_id", $request->txt_employ_id)->first();

        if ($m_pic_check->emp_pic == NULL && $request->hasFile('txt_profile_img') == NULL) {
            return back()->with('profile', 'Profile Picture recuired');
        }


        else if 
        ($request->txt_profile_img == NULL&& 
        $request->txt_nid_front_img == NULL && 
        $request->txt_nid_back_img == NULL && 
        $request->txt_bc_img == NULL)
        {
          return back()->with('warning', 'If you do not update any image please skip');
        }

        if ($request->hasFile('txt_profile_img')) {
            $rules = [
                'txt_profile_img' => 'required|mimes:jpg',
            ];

            $customMessages = [
                'txt_profile_img.required' => 'Profile Picture is required.',
                'txt_profile_img.mimes' => 'Only .jpg',

            ];
            $this->validate($request, $rules, $customMessages);
        }

        $data = array();
        //Profile
        $profile = $request->file('txt_profile_img');
        if ($request->hasFile('txt_profile_img')) {
            $m_profile_hw = getimagesize($profile);
            $m_profile_size = filesize($profile);
            if ($m_profile_size <= 154800 && $m_profile_hw[0] < 301 && $m_profile_hw[1] < 401) {
                //delete previous file
                if ($m_pic_check->emp_pic && $request->hasFile('txt_profile_img')) {
                    unlink($m_pic_check->emp_pic);
                }
                $filename = $request->txt_employ_id . '.' . $request->file('txt_profile_img')->getClientOriginalExtension();
                $upload_path = "public/image/profile/";
                $image_url = $upload_path . $filename;
                $profile->move($upload_path, $filename);
                $data['emp_pic'] = $image_url;
            } else {
                return redirect()->back()->withInput()->with('warning', 'Max Picture Size 150KB and Dimension 300X400');
            }
        }

        //NID Front
        $nid_front = $request->file('txt_nid_front_img');
        if ($request->hasFile('txt_nid_front_img')) {
            $m_nid_front_hw = getimagesize($nid_front);
            $m_nid_front_size = filesize($nid_front);
            if ($m_nid_front_size <= 154800 && $m_nid_front_hw[0] < 301 && $m_nid_front_hw[1] < 251) {
                if ($m_pic_check->nid_front && $request->hasFile('txt_nid_front_img')) {
                    unlink($m_pic_check->nid_front);
                }
                $filename = "$request->txt_employ_id" . '.' . $request->file('txt_nid_front_img')->getClientOriginalExtension();
                $upload_path = "public/image/nid_front/";
                $image_url = $upload_path . $filename;
                $nid_front->move($upload_path, $filename);
                $data['nid_front'] = $image_url;
            } else {
                return redirect()->back()->withInput()->with('warning', 'Max file Size 150KB and Dimension 300X250');
            }
        }

        //NID Back
        $nid_back = $request->file('txt_nid_back_img');
        if ($request->hasFile('txt_nid_back_img')) {
            $m_nid_back_hw = getimagesize($nid_back);
            $m_nid_back_size = filesize($nid_back);
            if ($m_nid_back_size <= 154800 && $m_nid_back_hw[0] < 301 && $m_nid_back_hw[1] < 251) {
                if ($m_pic_check->nid_back && $request->hasFile('txt_nid_back_img')) {
                    unlink($m_pic_check->nid_back);
                }
                $filename = "$request->txt_employ_id" . '.' . $request->file('txt_nid_back_img')->getClientOriginalExtension();
                $upload_path = "public/image/nid_back/";
                $image_url = $upload_path . $filename;
                $nid_back->move($upload_path, $filename);
                $data['nid_back'] = $image_url;
            } else {
                return redirect()->back()->withInput()->with('warning', 'Max file Size 150KB and Dimension 300X250');
            }
        }

        //birth_certificate image
        $bc_img = $request->file('txt_bc_img');
        if ($request->hasFile('txt_bc_img')) {
            if ($m_pic_check->bc_img && $request->hasFile('txt_bc_img')) {
                unlink($m_pic_check->bc_img);
            }
            $filename = "$request->txt_employ_id" . '.' . $request->file('txt_bc_img')->getClientOriginalExtension();
            $upload_path = "public/image/birth_certificate/";
            $image_url = $upload_path . $filename;
            $bc_img->move($upload_path, $filename);
            $data['bc_img'] = $image_url;
        }
        // return $data;
        DB::table('pro_employee_biodata')->where("employee_id", $request->txt_employ_id)->update($data);
        return redirect()->route('educational_qualification', $request->txt_employ_id);
    }

    public function educational_qualification($emp_id)
    {
       return view('hrm.educational_qualification',compact('emp_id'));
    }

    public function educational_qualification_store( Request $request)
    {
        $rules = [
            'txt_institute' => 'required',
            'txt_exame_title' => 'required',
            'txt_group' => 'required',
            'txt_result' => 'required',
            'txt_passing_year' => 'required',
        ];

        $customMessages = [
            'txt_institute.required' => 'Institute required.',
            'txt_exame_title.required' => 'Exame Title required.',
            'txt_group.required' => 'Group required.',
            'txt_result.required' => 'Result required.',
            'txt_passing_year.required' => 'Passing Year required.',
        ];
        $this->validate($request, $rules, $customMessages);
        
        $m_user_id=Auth::user()->emp_id;
        $data=array();
        $data['employee_id']=$request->txt_employ_id;
        $data['institute']=$request->txt_institute;
        $data['exame_title']=$request->txt_exame_title;
        $data['edu_group']=$request->txt_group;
        $data['result']=$request->txt_result;
        $data['passing_year']=$request->txt_passing_year;
        $data['status']='1';
        $data['user_id']=$m_user_id;
        $data['valid']='1';
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table('pro_employee_edu')->insert($data);
        return back()->with('success','Successfull Inserted.');
    }

    public function professional_training($emp_id)
    {
       return view('hrm.training',compact('emp_id'));
    }

    public function professional_training_store(Request $request)
    {
        $rules = [
            'txt_institute' => 'required',
            'txt_traning_titel' => 'required',
            'txt_start_date' => 'required',
            'txt_end_date' => 'required',
        ];

        $customMessages = [
            'txt_institute.required' => 'Institute required.',
            'txt_traning_titel.required' => 'Traning Title required.',
            'txt_start_date.required' => 'Start date required.',
            'txt_end_date.required' => 'End date required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        $data=array();
        $data['employee_id']=$request->txt_employ_id;
        $data['institute']=$request->txt_institute;
        $data['address']=$request->txt_address;
        $data['traning_title']=$request->txt_traning_titel;
        $data['start_date']=$request->txt_start_date;
        $data['end_date']=$request->txt_end_date;
        $data['status']='1';
        $data['user_id']=$m_user_id;
        $data['valid']='1';
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table('pro_employee_training')->insert($data);
        return back()->with('success','Successfull Inserted.');
    }

    public function experience($emp_id)
    {
       return view('hrm.experience',compact('emp_id'));
    }
    public function experience_store(Request $request)
    {

        $m_user_id=Auth::user()->emp_id;
        $data=array();
        $data['employee_id']=$request->txt_employ_id;
        $data['organization']=$request->txt_organization;
        $data['address']=$request->txt_address;
        $data['designation']=$request->txt_designation;
        $data['responsibilities']=$request->txt_responsibilities;
        $data['start_date']=$request->txt_start_date;
        $data['end_date']=$request->txt_end_date;
        $data['status']='1';
        $data['user_id']=$m_user_id;
        $data['valid']='1';
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table('pro_employee_experiance')->insert($data);
        return back()->with('success','Successfull Inserted.');  
    }

public function biodata($employee_id)
    {
        // $employee_id=00000472
        $e_biodata = DB::table('pro_employee_biodata')->where('employee_id',$employee_id)->where('valid',1)->first();
        $employee_info = DB::table('pro_employee_info')->where('employee_id',$employee_id)->first();
        $e_edu = DB::table('pro_employee_edu')->where('employee_id',$employee_id)->where('valid',1)->get();
        $e_experiance = DB::table('pro_employee_experiance')->where('employee_id',$employee_id)->where('valid',1)->get();
        $e_training = DB::table('pro_employee_training')->where('employee_id',$employee_id)->where('valid',1)->get();
        return view('hrm.biodata_print', compact('e_biodata','employee_info','e_edu','e_experiance','e_training'));
    }


//salary_info

    public function hrmbacksalary_info()
    {

        $ci_salary=DB::table('pro_salary')->Where('valid','1')->orderBy('employee_id','asc')->get(); //query builder
        return view('hrm.salary_info',compact('ci_salary'));

    }

//employee_clossing

    public function hrmbackemployee_clossing()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder

        return view('hrm.employee_clossing',compact('user_company','m_yesno'));

    }

    //Employee Closing insert
    public function hrmemp_closingstore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,30',
            'cbo_employee_id' => 'required',
            'cbo_yesno_id' => 'required|integer|between:1,2',
            'txt_remarks' => 'required',
            'txt_closing_date' => 'required',
        ];

        $customMessages = [


            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Select Employee.',

            'cbo_yesno_id.required' => 'Select Working Status.',
            'cbo_yesno_id.integer' => 'Select Working Status.',
            'cbo_yesno_id.between' => 'Select Working Status.',

            'txt_remarks.required' => 'Description required.',

            'txt_closing_date.required' => 'Closing Date is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $ci_emp_info=DB::table('pro_employee_info')->Where('employee_id',$request->cbo_employee_id)->first();
        $txt_employee_info_id=$ci_emp_info->employee_info_id;
        $txt_employee_name=$ci_emp_info->employee_name;

        $data=array();
        $data['company_id']=$request->cbo_company_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['employee_name']=$txt_employee_name;
        $data['working_status']=$request->cbo_yesno_id;
        $data['description']=$request->txt_remarks;
        $data['closing_date']=$request->txt_closing_date;
        $data['user_id']=$request->txt_emp_id;
        
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");

        // dd($data);
        DB::table('pro_emp_close')->insert($data);

        DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->update([
            'working_status'=>$request->cbo_yesno_id,
            ]);
        return redirect()->back()->with('success','Data Inserted Successfully!');
    }

//attn_payroll_status

    public function hrmbackattn_payroll_status()
    {

        return view('hrm.attn_payroll_status');

    }

    public function EmpProfile()
    {
        $m_user_id=Auth::user()->emp_id;

        $m_employee_info = DB::table("pro_employee_info")
        ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->select("pro_employee_info.*", "pro_company.*", "pro_desig.*")

        ->where('employee_id',$m_user_id)
        ->first();
        
        $m_employee_biodata = DB::table("pro_employee_biodata")
        ->where('employee_id',$m_user_id)
        ->first();

        if ($m_employee_biodata === null)
        {
            return redirect()->back()->withInput()->with('warning' , 'Biodata Not exists!!');  

        } else {
            return view('hrm.profile',compact('m_employee_biodata','m_employee_info'));
        // return view('hrm.profile');
        }//if ($m_employee_biodata === null)
    }

    public function ResetPass()
    {

        return view('hrm.changepass');

    }
    public function ResetPassstore(Request $request)
    {
        $rules = [
            'txt_old_pass' => 'required|min:8|max:20',
            'txt_new_pass' => 'required|min:8|max:20',
            'txt_conf_pass' => 'required|min:8|max:20',
               ];

        $customMessages1 = [
            'txt_old_pass.required' => 'Old Password is required.',
            'txt_old_pass.min' => 'Old Password must be at least 8 characters.',
            'txt_old_pass.max' => 'Old Password not more 20 characters.',
            'txt_new_pass.required' => 'New Password is required.',
            'txt_new_pass.min' => 'New Password must be at least 8 characters.',
            'txt_new_pass.max' => 'New Password not more 20 characters.',
            'txt_conf_pass.required' => 'Confirm Password is required.',
            'txt_conf_pass.min' => 'Confirm Password must be at least 8 characters.',
            'txt_conf_pass.max' => 'Confirm Password not more 20 characters.',

        ];        

        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('users')->where('emp_id', $request->txt_emp_id)->first();


        if( \Illuminate\Support\Facades\Hash::check( $request->txt_old_pass, $abcd->password) == false)
        {
            //dd('Password is not matching');
            return redirect()->back()->withInput()->with('warning' , 'Sorry old password mismatch!!');
        } else {
            $m_emp_id=$request->txt_emp_id;
            $m_new_pass=$request->txt_new_pass;
            $m_conf_pass=$request->txt_conf_pass;

            if ($m_new_pass == $m_conf_pass)
            {
                DB::table('users')->where('emp_id',$m_emp_id)->update([
                'password'=>Hash::make($m_new_pass),
                'updated_at'=>date('Y-m-d H:i:s')
                ]);
                return redirect(route('changepass'))->with('success','Password Change Successfully!');

            } else {
                return redirect()->back()->withInput()->with('warning' , 'New password and Confirm Password mismatch!!');

            }//if ($m_new_pass == $m_conf_pass)


        } //if( \Illuminate\Support\Facades\Hash::check( $request->txt_old_pass, $abcd->password) == false)
    }



//leave_type

    public function hrmbackleave_type()
    {

        $ci_leave_type=DB::table('pro_leave_type')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder
        return view('hrm.leave_type',compact('ci_leave_type'));

    }

    //Leave Type insert
    public function hrmbackleave_typestore(Request $request)
    {
    $rules = [
            'txt_leave_type' => 'required|max:25|min:4',
            'txt_leave_type_sname' => 'required|max:5|min:2',
        ];

        $customMessages = [

            'txt_leave_type.required' => 'Leave Type is required.',
            'txt_leave_type.min' => 'Leave Type must be at least 4 characters.',
            'txt_leave_type.max' => 'Leave Type less then 25 characters.',

            'txt_leave_type_sname.required' => 'Short Name is required.',
            'txt_leave_type_sname.min' => 'Short Name must be at least 2 characters.',
            'txt_leave_type_sname.max' => 'Short Name less then 5 characters.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['leave_type']=$request->txt_leave_type;
        $data['leave_type_sname']=$request->txt_leave_type_sname;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;

        //dd($data);
        DB::table('pro_leave_type')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
    }


    public function hrmbackleave_typeedit($id)
    {
        $m_leave_type=DB::table('pro_leave_type')->where('leave_type_id',$id)->first();
        $data=DB::table('pro_leave_type')->where('valid','1')->get();
        return view('hrm.leave_type',compact('data','m_leave_type'));
    }

    public function hrmbackleave_typeupdate(Request $request,$update)
    {

    $rules = [
            'txt_leave_type' => 'required|max:25|min:4',
            'txt_leave_type_sname' => 'required|max:5|min:2',
        ];

        $customMessages = [

            'txt_leave_type.required' => 'Leave Type is required.',
            'txt_leave_type.min' => 'Leave Type must be at least 4 characters.',
            'txt_leave_type.max' => 'Leave Type less then 25 characters.',

            'txt_leave_type_sname.required' => 'Short Name is required.',
            'txt_leave_type_sname.min' => 'Short Name must be at least 2 characters.',
            'txt_leave_type_sname.max' => 'Short Name less then 5 characters.',
        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_leave_type')->where('leave_type_id',$update)->update([
            'leave_type'=>$request->txt_leave_type,
            'leave_type_sname'=>$request->txt_leave_type_sname,
            ]);

        return redirect(route('leave_type'))->with('success','Data Updated Successfully!');
    }



//leave_config

    public function hrmbackleave_config()
    {

        $ci_leave_config=DB::table('pro_leave_config')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder
        return view('hrm.leave_config',compact('ci_leave_config'));

    }

    //Leave Config insert
    public function hrmbackleave_configstore(Request $request)
    {
    $rules = [
            
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_leave_days' => 'required|numeric|min:1',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Select Leave Type.',

            'txt_leave_days.required' => 'Leave Day is required.',
            'txt_leave_days.min' => 'Leave Day must be at least 1 characters.',
            'txt_leave_days.numeric' => 'Leave Day Numeric.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['leave_type_id']=$request->sele_leave_type;
        $data['leave_days']=$request->txt_leave_days;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;

        //dd($data);
        DB::table('pro_leave_config')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');

    }

    public function hrmbackleave_configedit($id)
    {
        $m_leave_config=DB::table('pro_leave_config')->where('leave_config_id',$id)->first();
        $data=DB::table('pro_leave_config')->where('valid','1')->get();
        return view('hrm.leave_config',compact('data','m_leave_config'));
    }

    public function hrmbackleave_configupdate(Request $request,$update)
    {

    $rules = [
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_leave_days' => 'required|numeric|min:1',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Select Leave Type.',

            'txt_leave_days.required' => 'Leave Day is required.',
            'txt_leave_days.min' => 'Leave Day must be at least 1 characters.',
            'txt_leave_days.numeric' => 'Leave Day Numeric.',
        ];        

        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_leave_config')->where('leave_type_id', $request->sele_leave_type)->first();
                
        DB::table('pro_leave_config')->where('leave_config_id',$update)->update([
            'leave_days'=>$request->txt_leave_days,
            ]);

        return redirect(route('leave_config'))->with('success','Data Updated Successfully!');

    }


//leave_application

    public function hrmbackleave_application()
    {

        $ci_leave_config_01=DB::table('pro_leave_config')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder
        return view('hrm.leave_application',compact('ci_leave_config_01'));

    }

    //Leave Application insert
    public function hrmbackleave_applicationstore(Request $request)
    {
    $rules = [
            
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_purpose_leave' => 'required',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_from_date.required' => 'Leave Start Date is required.',
            'txt_to_date.required' => 'Leave End Date is required.',
            'txt_purpose_leave.required' => 'Leave Purpose is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';
        $m_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $txt_from_date=$request->txt_from_date;
        $txt_from_date1=date("m-d",strtotime($txt_from_date));
        $txt_to_date=$request->txt_to_date;
        $txt_to_date1=date("m-d",strtotime($txt_to_date));

        $c_year=date("Y",$mentrydate);
        //$c_year="2021";
        // $m_date=date("m-d",$mentrydate);
        $form_year=substr($txt_from_date,0,4);
        $to_year=substr($txt_to_date,0,4);

        // $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        // $txt_total_days = floor($diff / (1*60*60*24)+1);
        $txt_total_days = $request->txt_total;
        // //dd($txt_total_days);
        $txt_leave_type=$request->sele_leave_type;
        // dd("$request->txt_total");
        if ($form_year!=$to_year)
        {

            return redirect()->back()->withInput()->with('warning' , 'year mismatch!!');

        } else {
            if ($form_year!=$c_year)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
            } else {

            $ci_pro_leave_config=DB::table('pro_leave_config')->Where('leave_type_id',$request->sele_leave_type)->first();
            $txt_app_day=$ci_pro_leave_config->app_day;

                if ($txt_total_days>$txt_app_day)
                {
                return redirect()->back()->withInput()->with('warning',"You Choose more than $txt_app_day Days");
                } else {

                $ci_pro_cl_policy=DB::table('pro_cl_policy')->Where('cl_start','<=',$txt_from_date1)->Where('cl_end','>=',$txt_to_date1)->where('leave_type_id',$request->sele_leave_type)->first();
                // dd($ci_pro_cl_policy);
                if ($ci_pro_cl_policy)
                {

                    $ci_leave_info_master=DB::table('pro_leave_info_master')->Where('employee_id',$request->txt_user_id)->whereBetween('leave_form',[$txt_from_date,$txt_to_date])->first();
                    // $txt_employee_id=$ci_emp_info->employee_id;
                    // $txt_employee_name=$ci_emp_info->employee_name;
                    // dd($ci_leave_info_master);
                    if ($ci_leave_info_master===null)
                    {
                        
                        // $ci_leave_config=DB::table('pro_leave_config')->Where('leave_type_id',$txt_leave_type)->first();
                        // $txt_leave_days=$ci_leave_config->leave_days;
                        $txt_leave_days=$ci_pro_leave_config->leave_days;

                        $ci_leave_info_master=DB::table('pro_leave_info_master')->Where('leave_type_id',$txt_leave_type)->where('employee_id',$request->txt_user_id)->where('valid',1)->where('leave_year',$c_year)->orderby('leave_type_id')->get();

                        $m_avail_day = collect($ci_leave_info_master)->sum('g_leave_total'); // 60
                            // dd($sum);
                        $m_available=$txt_leave_days-$m_avail_day;
                        
                        if ($m_available>$txt_total_days)
                        {

                        $data=array();
                        $data['employee_id']=$request->txt_user_id;
                        $data['company_id']=$request->txt_company_id;
                        $data['desig_id']=$request->txt_desig_id;
                        $data['leave_type_id']=$request->sele_leave_type;
                        $data['leave_form']=$request->txt_from_date;
                        $data['leave_to']=$request->txt_to_date;
                        $data['leave_year']=$c_year;
                        $data['total']=$txt_total_days;
                        $data['purpose_leave']=$request->txt_purpose_leave;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['status']=$m_status;
                        $data['valid']=$m_valid;

                        //dd($data);
                        DB::table('pro_leave_info_master')->insert($data);
                        return redirect()->back()->with('success','Data Inserted Successfully!');

                        } else {
                        return redirect()->back()->withInput()->with('warning','Sorry selected leave type not available');    
                        } //if ($m_available>$txt_total_days)

                    } else {
                        return redirect()->back()->withInput()->with('warning','Allready Applied');
                    } //if ($ci_leave_info_master===null)
                } else {
                    return redirect()->back()->withInput()->with('warning',"You Choose more no wwwww");
                } //if ($ci_pro_cl_policy)


                } //if ($txt_total_days>$txt_app_day)
            } //if ($form_year!=$c_year)

        } //if ($form_year!=$to_year)

    }

//leave_approval
// $m_user_id=Auth::user()->emp_id;
    public function hrmbackleave_approval()
    {
        $m_user_id=Auth::user()->emp_id;
        $ci_report = DB::table("pro_employee_info")
            ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
            ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
            ->join("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
            ->Where('report_to_id',$m_user_id)
            ->get();
        

        return view('hrm.leave_approval',compact('ci_report'));

        // return view('hrm.leave_approval');

    }

    public function hrmleave_app_approval($id)
    {
        $m_leave_info_master=DB::table('pro_leave_info_master')->where('leave_info_master_id',$id)->first();
        // $data=DB::table('pro_leave_info_master')->where('valid','1')->get();
        $m_yesno=DB::table('pro_yesno')->where('valid','1')->get();
        return view('hrm.leave_app_for_approval',compact('m_leave_info_master','m_yesno'));
    }

    public function hrmleave_appupdate(Request $request,$update)
    {

    $rules = [
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'cbo_approved_status' => 'required|integer|between:1,10',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_from_date.required' => 'From Date is required.',
            'txt_to_date.required' => 'To Date is required.',

            'cbo_approved_status.required' => 'Select Approved Status.',
            'cbo_approved_status.integer' => 'Select Approved Status.',
            'cbo_approved_status.between' => 'Select Approved Status.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // $txt_leave_status='1';
        $m_user_id=Auth::user()->emp_id;

        $m_valid=1;

        if($request->cbo_approved_status=='1')
        {
            $m_status=2;
            for($d=0; $d<$request->txt_total; $d++)
            {
            
            $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

            $data=array();
            $data['leave_info_master_id']=$request->txt_leave_info_master_id;
            $data['employee_id']=$request->txt_employee_id;
            $data['company_id']=$request->txt_company_id;
            $data['desig_id']=$request->txt_desig_id;
            $data['leave_type_id']=$request->sele_leave_type;
            $data['leave_date']=$atdate;
            $data['total']=$request->txt_total;
            $data['approved_id']=$request->txt_user_id;
            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid']=$m_valid;

            //dd($data);
            DB::table('pro_leave_info_details')->insert($data);
            
            }//for($d==1; $d<=txt_total_days; $d++)

            DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
            'status'=>$m_status,
            'g_leave_form'=>$request->txt_from_date,
            'g_leave_to'=>$request->txt_to_date,
            'g_leave_total'=>$request->txt_total,
            'leave_approved'=>$m_user_id,
            // date_default_timezone_set("Asia/Dhaka");
            'approved_date'=>date("Y-m-d"),
            ]);

            return redirect(route('leave_approval'))->with('success','Leave Application  Approved');
        } else {
            $m_status=3;

            DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
            'status'=>$m_status,
            'leave_approved'=>$m_user_id,
            // date_default_timezone_set("Asia/Dhaka");
            'approved_date'=>date("Y-m-d"),
            ]);

            return redirect(route('leave_approval'))->with('success','Leave Application Cancel');

        }
    }


//movement

    public function hrmbackmovement()
    {

        $m_user_id=Auth::user()->emp_id;
        // $this->m_user_id;
        // $user_company = DB::table("pro_user_company")
        //     ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        //     ->select("pro_user_company.*", "pro_company.company_id","pro_company.company_name")
        //     ->Where('employee_id',$m_user_id)
        //     ->get();

        $ci_late_inform_master=DB::table('pro_late_inform_master')->Where('employee_id',$m_user_id)->Where('valid','1')->orderBy('late_inform_master_id','asc')->get(); //query builder
        return view('hrm.movement',compact('ci_late_inform_master'));
        // return view('hrm.movement');
    }

    //Movement Application insert
    public function hrmlate_applicationstore(Request $request)
    {
    $rules = [
            
            'sele_late_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_purpose_late' => 'required',
        ];

        $customMessages = [

            'sele_late_type.required' => 'Select Late Type.',
            'sele_late_type.integer' => 'Select Late Type.',
            'sele_late_type.between' => 'Select  Late Type.',

            'txt_from_date.required' => 'Late Start Date is required.',
            'txt_to_date.required' => 'Late End Date is required.',
            'txt_purpose_late.required' => 'Late Purpose is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';
        $m_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $txt_from_date=$request->txt_from_date;
        // $txt_from_date1=date("m-d",strtotime($txt_from_date));
        $txt_to_date=$request->txt_to_date;
        // $txt_to_date1=date("m-d",strtotime($txt_to_date));

        $c_year=date("Y",$mentrydate);
        $form_year=substr($txt_from_date,0,4);
        $to_year=substr($txt_to_date,0,4);

        $txt_total_days = $request->txt_total;
        $txt_leave_type=$request->sele_leave_type;
        if ($form_year!=$to_year)
        {

            return redirect()->back()->withInput()->with('warning' , 'year mismatch!!');

        } else {
            if ($form_year!=$c_year)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
            } else {

            $ci_late_type=DB::table('pro_late_type')->Where('late_type_id',$request->sele_late_type)->first();
            $txt_late_day=$ci_late_type->late_day;

                if ($txt_total_days>$txt_late_day)
                {
                return redirect()->back()->withInput()->with('warning',"You Choose more than $txt_late_day Days");
                } else {


                    $ci_late_inform_master=DB::table('pro_late_inform_master')->Where('employee_id',$request->txt_user_id)->whereBetween('late_form',[$txt_from_date,$txt_to_date])->first();

                    if ($ci_late_inform_master===null)
                    {
                        
                        $data=array();
                        $data['employee_id']=$request->txt_user_id;
                        $data['report_to_id']=$request->txt_report_to_id;
                        $data['company_id']=$request->txt_company_id;
                        $data['desig_id']=$request->txt_desig_id;
                        $data['department_id']=$request->txt_department_id;
                        $data['section_id']=$request->txt_section_id;
                        $data['placeofposting_id']=$request->txt_placeofposting_id;
                        $data['late_type_id']=$request->sele_late_type;
                        $data['late_form']=$request->txt_from_date;
                        $data['late_to']=$request->txt_to_date;
                        $data['late_year']=$c_year;
                        $data['late_total']=$txt_total_days;
                        $data['purpose_late']=$request->txt_purpose_late;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['status']=$m_status;
                        $data['valid']=$m_valid;

                        //dd($data);
                        DB::table('pro_late_inform_master')->insert($data);
                        return redirect()->back()->with('success','Data Inserted Successfully!');

                    } else {
                        return redirect()->back()->withInput()->with('warning','Allready Applied');
                    } //if ($ci_late_inform_master===null)


                } //if ($txt_total_days>$txt_app_day)
            } //if ($form_year!=$c_year)

        } //if ($form_year!=$to_year)

    }

//movement_approval

    public function hrmmovement_approval()
    {
        $m_user_id=Auth::user()->emp_id;
        $ci_report = DB::table("pro_employee_info")
            ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
            ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
            ->join("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
            ->Where('report_to_id',$m_user_id)
            ->get();
       

        return view('hrm.movement_approval',compact('ci_report'));
    }

    public function hrmmove_app_approval($id)
    {
        $m_late_info_master=DB::table('pro_late_inform_master')->where('late_inform_master_id',$id)->first();
        $m_yesno=DB::table('pro_yesno')->where('valid','1')->get();
        return view('hrm.move_app_for_approval',compact('m_late_info_master','m_yesno'));
    }

    public function hrmmove_appupdate(Request $request,$update)
    {

    $rules = [
            'sele_late_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'cbo_approved_status' => 'required|integer|between:1,10',
        ];

        $customMessages = [

            'sele_late_type.required' => 'Select Leave Type.',
            'sele_late_type.integer' => 'Select Leave Type.',
            'sele_late_type.between' => 'Select  Leave Type.',

            'txt_from_date.required' => 'From Date is required.',
            'txt_to_date.required' => 'To Date is required.',

            'cbo_approved_status.required' => 'Select Approved Status.',
            'cbo_approved_status.integer' => 'Select Approved Status.',
            'cbo_approved_status.between' => 'Select Approved Status.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // $txt_leave_status='1';
        $m_user_id=Auth::user()->emp_id;

        $m_valid=1;

        if($request->cbo_approved_status=='1')
        {
            $m_status=2;
            for($d=0; $d<$request->txt_total; $d++)
            {
            
            $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

            $data=array();
            $data['late_inform_master_id']=$request->txt_late_info_master_id;
            $data['employee_id']=$request->txt_employee_id;
            $data['company_id']=$request->txt_company_id;
            $data['desig_id']=$request->txt_desig_id;
            $data['late_type_id']=$request->sele_late_type;
            $data['late_date']=$atdate;
            $data['late_total']=$request->txt_total;
            $data['approved_id']=$request->txt_user_id;
            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid']=$m_valid;

            //dd($data);
            DB::table('pro_late_inform_details')->insert($data);
            
            }//for($d==1; $d<=txt_total_days; $d++)

            DB::table('pro_late_inform_master')->where('late_inform_master_id',$update)->update([
            'status'=>$m_status,
            'g_late_form'=>$request->txt_from_date,
            'g_late_to'=>$request->txt_to_date,
            'g_late_total'=>$request->txt_total,
            'late_approved'=>$m_user_id,
            // date_default_timezone_set("Asia/Dhaka");
            'approved_date'=>date("Y-m-d"),
            ]);

            return redirect(route('movement_approval'))->with('success','Movement Application  Approved');
        } else {
            $m_status=3;

            DB::table('pro_late_inform_master')->where('late_inform_master_id',$update)->update([
            'status'=>$m_status,
            'late_approved'=>$m_user_id,
            // date_default_timezone_set("Asia/Dhaka");
            'approved_date'=>date("Y-m-d"),
            ]);

            return redirect(route('movement_approval'))->with('success','Leave Application Cancel');

        }
    }

//data_sync

    public function hrmbackdata_sync()
    {

        return view('hrm.data_sync');

    }

    //Data Synchronization
    public function hrmbackdata_syncstore(Request $request)
    {
    $rules = [
            'txt_sync_date' => 'required',
        ];

        $customMessages = [

            'txt_sync_date.required' => 'Synchronization Date is required.',
        ];        

        $this->validate($request, $rules, $customMessages);
        $m_sync_date=$request->txt_sync_date;

        $m_valid='1';

        $ci_tmp_log=DB::table('pro_tmp_log')->where('logdate',$m_sync_date)->where('is_read',1)->count();
        // dd($ci_tmp_log);
        if ($ci_tmp_log>0)
        {
          return redirect()->back()->withInput()->with('warning','Data allready Synchronized');  
        } else {
          // dd($ci_tmp_log);
            // $serverName = "192.168.112.6,1433"; //serverName\instanceName
            // $connectionInfo = array( "Database"=>"NitgenAccessManager", "UID"=>"sa", "PWD"=>"bANGLA1");
            // $conn = sqlsrv_connect( $serverName, $connectionInfo);
            // protected $connection = "sqlsrv";
        // $ci_NGAC_AUTHLOG=DB::connection('sqlsrv')->select('NGAC_AUTHLOG')
        


        $ci_NGAC_AUTHLOG=DB::connection('abcd')->table('NGAC_AUTHLOG')
        // ->where('AuthResult','0')
        // // ->whereBetween('TransactionTime',[$txt_frist_date,$txt_last_date])
        // ->where('TransactionTime',$m_sync_date)
        // ->where('is_read',1)
         ->get();
        dd($ci_NGAC_AUTHLOG);
            if($ci_NGAC_AUTHLOG ) 
            {
                echo "aaa";
            } else {
                echo "No";
                die();
                exit();
            }



        }

    }

//attendance_process

    public function hrmbackattendance_process()
    {

        $ci_attendance=DB::table('pro_attendance')->Where('valid','1')->orderBy('attendance_id','asc')->get(); //query builder
        return view('hrm.attendance_process',compact('ci_attendance'));

    }
    //Basic Info insert
    public function hrmbackattendance_processstore(Request $request)
    {
    $rules = [
            'txt_atten_date' => 'required',
        ];

        $customMessages = [

            'txt_atten_date.required' => 'Attendance Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $m_atten_date=$request->txt_atten_date;

        // $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        // $tot_days = floor($diff / (1*60*60*24)+1);

        $ci_attendance=DB::table('pro_attendance')->where('attn_date',$m_atten_date)->where('valid','1')->count();
        
        if ($ci_attendance>0)
        {
            return redirect()->back()->withInput()->with('warning','Attendance Process Allready Done');
        } else {

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);




        $m_employee_info = DB::table('pro_employee_info')->where('valid',1)->where('working_status',1)->where('ss',1)->orderBy('employee_id','asc')->get();

        foreach ($m_employee_info as $row_emp_info){

            $m_employee_id=$row_emp_info->employee_id;
            $m_company_id=$row_emp_info->company_id;
            $m_placeofposting_id=$row_emp_info->placeofposting_id;
            $m_desig_id=$row_emp_info->desig_id;
            $m_department_id=$row_emp_info->department_id;
            $m_att_policy_id=$row_emp_info->att_policy_id;
            $m_psm_id=$row_emp_info->psm_id;

            $prweekday = date('l', strtotime($m_atten_date));
            $m_process_status='1';
            $m_valid='1';

            $m_user_id=Auth::user()->emp_id;

              
                $data=array();
                $data['company_id']=$m_company_id;
                $data['employee_id']=$m_employee_id;
                $data['desig_id']=$m_desig_id;
                $data['department_id']=$m_department_id;
                $data['placeofposting_id']=$m_placeofposting_id;
                $data['att_policy_id']=$m_att_policy_id;
                $data['attn_date']=$m_atten_date;
                $data['day_name']=$prweekday;
                $data['process_status']=$m_process_status;
                $data['user_id']=$request->txt_user_id;
                $data['entry_date']=$m_entry_date;
                $data['entry_time']=$m_entry_time;
                $data['valid']=$m_valid;
                $data['psm_id']=$m_psm_id;

                DB::table('pro_attendance')->insert($data);

           
        } //foreach ($m_employee_info as $row_emp_info){
        
        // step 2
        $m_attn_employee = DB::table('pro_attendance')
        ->where('process_status',1)
        ->where('attn_date',$m_atten_date)
        ->orderBy('attendance_id','asc')->get();

        foreach ($m_attn_employee as $row_attn_employee){

            $m_employee_id=$row_attn_employee->employee_id;
            $m_att_policy_id=$row_attn_employee->att_policy_id;
            $m_attn_date=$row_attn_employee->attn_date;
            $prweekday=date('l', strtotime($m_attn_date));

            // echo "$m_attn_date $prweekday1";
            // echo "<br>";

            $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
            
            $m_in_time=$m_att_policy->in_time;
            $m_in_time_graced=$m_att_policy->in_time_graced;
            $m_out_time=$m_att_policy->out_time;
            $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
            $m_weekly_holiday2=$m_att_policy->weekly_holiday2;


            // Govt Holi checking here
            $m_holiday=DB::table('pro_holiday')->Where('holiday_date',$m_attn_date)->first();
            // $m_holiday_date=$m_holiday->holiday_date;

            if ($m_holiday===null)
            {
            $daysts="R";
            $sts="A";
            }
            else
            {
            $daysts="H";
            $sts="H";
            }

            //Weekly Holiday Checki here if not Govt Holidy
            if ($daysts!="H")
            {
            if ($prweekday==$m_weekly_holiday1)
            {
            $daysts="W";
            $sts="W";
            }
            else if ($prweekday==$m_weekly_holiday2)
            {
            $daysts="W";
            $sts="W";
            }
            else
            {
            $daysts="R";
            $sts="A";
            }
            }//if ($daysts!="H")*/
            $m_process_status=2;

            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$m_attn_date)->update([
            'r_in_time'=>$m_in_time,
            'p_in_time'=>$m_in_time_graced,
            'p_out_time'=>$m_out_time,
            'day_status'=>$daysts,
            'status'=>$sts,
            'process_status'=>$m_process_status,
            ]);


        } // foreach ($m_attn_employee as $row_attn_employee){
//end of step 2
// step 3

        $m_attn_employee_03 = DB::table('pro_attendance')
        ->where('process_status',2)
        ->where('attn_date',$m_atten_date)
        ->orderBy('attendance_id','asc')->get();

        // $latetime='0';
        // $questionable='0';

        foreach ($m_attn_employee_03 as $row_attn_employee_03){

            $latetime='0';
            $questionable='0';
        
            $m_employee_id=$row_attn_employee_03->employee_id;
            $m_attn_date=$row_attn_employee_03->attn_date;
            $m_r_in_time=$row_attn_employee_03->r_in_time;
            $m_p_in_time=$row_attn_employee_03->p_in_time;
            $m_att_policy_id=$row_attn_employee_03->att_policy_id;
            $m_status=$row_attn_employee_03->status;

            $m_att_policy_03=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
            
            $m_grace_time=$m_att_policy_03->grace_time;

            $m_tmp_log_min = DB::table('pro_tmp_log')
            ->where('emp_id',$m_employee_id)
            ->where('logdate',$m_attn_date)
            ->min('logtime');

            $m_tmp_log_max = DB::table('pro_tmp_log')
            ->where('emp_id',$m_employee_id)
            ->where('logdate',$m_attn_date)
            ->max('logtime');


            if ($m_tmp_log_min === null)
            {
                $m_in_time='00:00:00';
            } else {
                $m_in_time=$m_tmp_log_min;
            }

            if ($m_tmp_log_max === null)
            {
                $m_out_time='00:00:00';
            } else {
                $m_out_time=$m_tmp_log_max;
            }

            $tot_minuts = (strtotime($m_in_time) - strtotime($m_p_in_time));
            $timeDiffin = floor($tot_minuts / 60);

            if ($m_in_time == '00:00:00')
            {
                if ($m_status!="H")
                {
                    if ($m_status!="W")
                    {
                        if ($m_status!="L")
                        {
                        $m_status="A";  
                        }
                    }
                }

            } else {
                if ($timeDiffin>0)
                {
                    $latetime=$timeDiffin+$m_grace_time;
                    $m_status="D";
                } else {
                    $latetime=0;
                    $m_status="P";
                } //if ($timeDiffin>0)
                
                if ($m_in_time==$m_out_time)
                {
                    $questionable=1;
                } else {
                    $questionable=0;
                } //if ($m_in_time==$m_out_time)
            }//if ($m_in_time == '00:00:00')

            $m_process_status=3;

            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$m_attn_date)->update([
            'in_time'=>$m_in_time,
            'out_time'=>$m_out_time,
            'late_min'=>$latetime,
            'status'=>$m_status,
            'is_quesitonable'=>$questionable,
            'process_status'=>$m_process_status,
            ]);

        } //foreach ($m_attn_employee_03 as $row_attn_employee_03){

// step 4
        // $m_atten_date=$request->txt_atten_date;
        $m_attn_employee_04 = DB::table('pro_attendance')
        ->where('process_status',3)
        ->where('attn_date',$m_atten_date)
        ->orderBy('employee_id','asc')->get();

        foreach ($m_attn_employee_04 as $row_attn_employee_04){
            $m_employee_id=$row_attn_employee_04->employee_id;
            $m_attn_date_01=$row_attn_employee_04->attn_date;
            $m_in_time=$row_attn_employee_04->in_time;
            $m_out_time=$row_attn_employee_04->out_time;
            $m_process_status='4';

            if($m_in_time=='00:00:00')
            {
                $m_nodeid_in='0';
            }
            else
            {
                $m_tmp_log_in = DB::table('pro_tmp_log')
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$m_attn_date_01)
                ->where('logtime',$m_in_time)
                ->first();
                $m_nodeid_in=$m_tmp_log_in->nodeid;
            }

            if($m_out_time=='00:00:00')
            {
                $m_nodeid_out='0';
            }
            else
            {
                $m_tmp_log_out = DB::table('pro_tmp_log')
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$m_attn_date_01)
                ->where('logtime',$m_out_time)
                ->orderBy('tmp_login_id','asc')
                ->first();
                $m_nodeid_out=$m_tmp_log_out->nodeid;
            }


            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$m_attn_date_01)->update([
            'nodeid_in'=>$m_nodeid_in,
            'nodeid_out'=>$m_nodeid_out,
            'process_status'=>$m_process_status,
            ]);

        }//foreach ($m_attn_employee_04 as $row_attn_employee_04){

//step 5

        $m_attn_employee_05 = DB::table('pro_attendance')
        ->where('process_status',4)
        ->where('attn_date',$m_atten_date)
        ->where('day_status','R')
        ->orderBy('employee_id','asc')->get();

        foreach ($m_attn_employee_05 as $row_attn_employee_05){
            $timeDiffin_out='0';
            $m_employee_id=$row_attn_employee_05->employee_id;
            $m_attn_date_05=$row_attn_employee_05->attn_date;
            $m_p_out_time=$row_attn_employee_05->p_out_time;
            $m_out_time=$row_attn_employee_05->out_time;
            $m_status=$row_attn_employee_05->status;
            $m_process_status='5';
            $m_early_grace_time='10';

            if($m_status=='A')
            {
                $timeDiffin_out = '0';
            } else {
            $tot_early_minuts = (strtotime($m_out_time) - strtotime($m_p_out_time));
            $timeDiffin_out = floor($tot_early_minuts / 60);
            }

            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$m_attn_date_05)->update([
            'early_min'=>$timeDiffin_out,
            'process_status'=>$m_process_status,
            ]);

        }//foreach ($m_attn_employee_05 as $row_attn_employee_05){

        return redirect()->back()->with('success','Data Process Successfully!');
       
        } //if ($ci_attendance>1)
    }

//leave_process

    public function hrmbackleave_process()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.leave_process',compact('user_company'));

    }
    public function hrm_leave_process(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $ci_pro_attendance=DB::table('pro_attendance')
        ->Where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->Where('process_status','>','4')
        ->groupBy('company_id')
        ->first(); //query builder
// dd($ci_pro_attendance);
        if ($ci_pro_attendance===null)
        {
            return redirect()->back()->withInput()->with('warning','Data Not Found');  

        } else {

            $m_leave_sql_01=DB::table('pro_leave_info_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('leave_date',[$txt_frist_date,$txt_last_date])
            ->Where('valid','1')
            ->orderBy('leave_info_details_id','asc')
            ->count();

            if ($m_leave_sql_01=='0')
            {
              return redirect()->back()->withInput()->with('warning','Data Not Found');  

            } else {

            $m_leave_sql=DB::table('pro_leave_info_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('leave_date',[$txt_frist_date,$txt_last_date])
            ->Where('valid','1')
            ->orderBy('leave_info_details_id','asc')
            ->get();

            foreach($m_leave_sql as $key=>$row_leave_sql)

            $m_employee_id=$row_leave_sql->employee_id;
            $m_leave_date=$row_leave_sql->leave_date;
            $m_process_status='6';
            $m_status="L";

            DB::table('pro_attendance')
            ->where('employee_id',$m_employee_id)
            ->where('attn_date',$m_leave_date)
            ->update([
                'status'=>$m_status,
                'process_status'=>$m_process_status,
            ]);

              return redirect()->back()->withInput()->with('success','Leave Process');  
            }//if ($m_leave_sql===null)
        }//if ($ci_pro_attendance===null)

    }

//movement_process

    public function hrmbackmovement_process()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.movement_process',compact('user_company'));

    }

    public function hrm_movement_process(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $ci_pro_attendance=DB::table('pro_attendance')
        ->Where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->Where('process_status','>','4')
        ->groupBy('company_id')
        ->first(); //query builder

        if ($ci_pro_attendance===null)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  

        } else {
        // DD($ci_pro_attendance->company_id);

            $m_move_sql_01=DB::table('pro_late_inform_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('late_date',[$txt_frist_date,$txt_last_date])
            ->Where('valid','1')
            ->orderBy('late_info_details_id','asc')
            ->count();

            if ($m_move_sql_01=='0')
            {
              return redirect()->back()->withInput()->with('warning','Data Not Found');  

            } else {

                $m_move_sql=DB::table('pro_late_inform_details')
                ->Where('company_id',$request->cbo_company_id)
                ->whereBetween('late_date',[$txt_frist_date,$txt_last_date])
                ->Where('valid','1')
                ->orderBy('late_info_details_id','asc')
                ->get();

                foreach($m_move_sql as $key=>$row_move_sql)
                {
                $m_employee_id=$row_move_sql->employee_id;
                $m_move_date=$row_move_sql->late_date;
                $m_process_status='6';
                $m_status="P";

                DB::table('pro_attendance')
                ->where('employee_id',$m_employee_id)
                ->where('attn_date',$m_move_date)
                ->update([
                    'status'=>$m_status,
                    'process_status'=>$m_process_status,
                ]);

                  return redirect()->back()->withInput()->with('success','Movement Process');  
                }//foreach($m_move_sql as $key=>$row_move_sql)
            }//if ($m_move_sql_01=='0')
        }//if ($ci_pro_attendance===null)

    }

//summary_process

    public function hrmbacksummary_process()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        // return view('hrm.employee_attendance',compact('user_company'));

        $ci_summ_attn_master=DB::table('pro_summ_attn_master')->Where('valid','1')->orderBy('summ_attn_master_id','asc')->get(); //query builder
        return view('hrm.summary_process',compact('user_company','ci_summ_attn_master'));

    }

    public function hrmbacksummary_processstore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);
        $m_user_id=Auth::user()->emp_id;
        $m_valid='1';
        $m_status='1';

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_summ_attn_master=DB::table('pro_summ_attn_master')
        ->Where('company_id',$request->cbo_company_id)
        ->Where('month',$month_number)
        ->Where('year',$txt_year)
        ->Where('valid','1')
        ->orderby('company_id')
        ->first(); //query builder

        if ($m_summ_attn_master===null)
        {
            // dd($this->m_user_id);

            $data=array();
            $data['company_id']=$request->cbo_company_id;
            $data['month']=$txt_month1;
            $data['year']=$txt_year;
            $data['prepare_id']=$m_user_id;
            $data['status']=$m_status;
            $data['entry_date']=date('Y-m-d');
            $data['entry_time']=date('H:i:s');
            $data['valid']=$m_valid;

            DB::table('pro_summ_attn_master')->insert($data);

            $m_summ_attn_master = DB::table('pro_summ_attn_master')
            ->where('month',$txt_month1)
            ->where('year',$txt_year)
            ->max('summ_attn_master_id');

            $m_attn_employee = DB::table('pro_attendance')
            ->where('company_id',$request->cbo_company_id)
            ->where('process_status','>','3')
            ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
            ->where('valid','1')
            ->groupBy('employee_id')->get();

            foreach ($m_attn_employee as $row_attn_employee)
            {
                $m_employee_id=$row_attn_employee->employee_id;
                $m_desig_id=$row_attn_employee->desig_id;
                $m_department_id=$row_attn_employee->department_id;
                $m_placeofposting_id=$row_attn_employee->placeofposting_id;

                //company Info
                $m_company=DB::table('pro_company')
                ->Where('company_id',$request->cbo_company_id)
                ->Where('valid',1)
                ->first();
                $mm_company=$m_company->company_name;

                //Employee Info
                $m_employee_info=DB::table('pro_employee_info')
                ->Where('employee_id',$m_employee_id)
                ->Where('valid',1)
                ->first();
                $mm_employee_name=$m_employee_info->employee_name;

                //desig Info
                $m_desig=DB::table('pro_desig')
                ->Where('desig_id',$m_desig_id)
                ->Where('valid',1)
                ->first();
                $mm_desig=$m_desig->desig_name;

                //department Info
                $m_department_info=DB::table('pro_department')
                ->Where('department_id',$m_department_id)
                ->Where('valid',1)
                ->first();
                $mm_department_name=$m_department_info->department_name;

                //placeofposting Info
                $m_placeofposting_info=DB::table('pro_placeofposting')
                ->Where('placeofposting_id',$m_placeofposting_id)
                ->Where('valid',1)
                ->first();
                $mm_placeofposting_name=$m_placeofposting_info->placeofposting_name;

                $m_working_day=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','R')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_twd=$m_working_day;

                $m_weekend=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','W')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_w=$m_weekend;

                $m_holiday=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','H')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_h=$m_holiday;

                $m_leave=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','L')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_l=$m_leave;

                $m_present=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','P')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_present=$m_present;

                $m_absent=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','A')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_absent=$m_absent;

                $m_late=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','D')
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_late=$m_late;

                $m_early=DB::table('pro_attendance')
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('early_min','<', 0)
                ->where('employee_id',$m_employee_id)
                ->count();
                $m_early=$m_early;

                // dd("$m_summ_attn_master -- $mm_company -- $m_employee_id -- $m_desig_id -- $m_department_id -- $m_placeofposting_id");

                $data=array();
                $data['summ_attn_master_id']=$m_summ_attn_master;
                $data['company_id']=$request->cbo_company_id;
                $data['company_name']=$mm_company;
                $data['employee_id']=$m_employee_id;
                $data['employee_name']=$mm_employee_name;
                $data['desig_id']=$m_desig_id;
                $data['desig_name']=$mm_desig;
                $data['department_id']=$m_department_id;
                $data['department_name']=$mm_department_name;
                $data['placeofposting_id']=$m_placeofposting_id;
                $data['placeofposting_name']=$mm_placeofposting_name;
                $data['working_day']=$m_twd;
                $data['weekend']=$m_w;
                $data['holiday']=$m_h;
                $data['total_leave']=$m_l;
                $data['present']=$m_present;
                $data['absent']=$m_absent;
                $data['late']=$m_late;
                $data['early_out']=$m_early;
                $data['user_id']=$m_user_id;
                $data['entry_date']=date('Y-m-d');
                $data['entry_time']=date('H:i:s');
                $data['valid']=$m_valid;

                DB::table('pro_summ_attn_details')->insert($data);



            }//foreach ($m_attn_employee as $row_attn_employee)
          return redirect()->back()->withInput()->with('success','Summery Process Completed');  

        } else {

          return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }//if ($m_summ_attn_master===null)

    }




//payroll_process

    public function hrmbackpayroll_process()
    {

        return view('hrm.payroll_process');

    }

    public function atten_re_process()
    {

        $ci_attn_re=DB::table('pro_employee_info')->Where('valid','1')->orderBy('employee_info_id','asc')->get(); //query builder
        return view('hrm.emp_atten_re_process',compact('ci_attn_re'));

    }

//summery_attendance report

    public function hrmbacksummary_attendance()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        // $ci_summ_attn_master=DB::table('pro_summ_attn_master')->Where('valid','1')->orderBy('summ_attn_master_id','asc')->get(); //query builder
        return view('hrm.summary_attendance',compact('user_company'));

        // return view('hrm.summary_attendance');

    }

    public function hrmbacksummary_attendance_report(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'txt_month.required' => 'Month is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_summ_attn_master=DB::table('pro_summ_attn_master')
        ->Where('company_id',$request->cbo_company_id)
        ->Where('month',$txt_month1)
        ->Where('year',$txt_year)
        ->first();

        if ($m_summ_attn_master === null)
        {
            return redirect()->back()->withInput()->with('warning','Sorry Data not found !!!!!!');
        } else {

            if($request->sele_placeofposting=='0')
            {
                $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

                $ci_summ_attn_report=DB::table('pro_summ_attn_details')
                ->Where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->Where('valid','1')
                ->orderBy('summ_attn_details_id','asc')
                ->get(); //query builder
                return view('hrm.summary_attendance_report',compact('ci_summ_attn_report'));
            } else {

                $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

                $ci_summ_attn_report=DB::table('pro_summ_attn_details')
                ->Where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->Where('placeofposting_id',$request->sele_placeofposting)
                ->Where('valid','1')
                ->orderBy('summ_attn_details_id','asc')
                ->get(); //query builder
                return view('hrm.summary_attendance_report',compact('ci_summ_attn_report'));
            }//if($request->sele_placeofposting=='0')

        }//if ($m_summ_attn_master === null)


    }

    public function postingEmployee(Request $request, $id)
    {
        $data = DB::table('pro_employee_info')->where('placeofposting_id',$id)->where('valid',1)->get();
        return response()->json(['data' => $data]);
    }

//attendance report

    public function hrmattenind()
    {

        return view('hrm.rpt_atten_ind');

    }

    public function hrmattenindrpt(Request $request)
    {
    $rules = [
            'txt_month' => 'required',
        ];

        $customMessages = [

            'txt_month.required' => 'Select Year Month.',
        ];        

        $this->validate($request, $rules, $customMessages);
        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        // dd("$txt_month -- $txt_frist_date -- $txt_last_date -- $month_number -- $month_name -- $txt_year");


        $m_attendance=DB::table('pro_attendance')
        ->Where('employee_id',$request->txt_user_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->orderBy('attendance_id','asc')
        ->get(); //query builder
        return view('hrm.rpt_atten_ind_show',compact('m_attendance'));

        // return view('hrm.rpt_atten_ind');

    }

//employee_attendance report

    public function hrmbackemployee_attendance()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.employee_attendance',compact('user_company'));

        // return view('hrm.employee_attendance');

    }

    public function hrmbackemp_attn_report(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'cbo_employee_id' => 'required',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_pro_attendance=DB::table('pro_attendance')
        ->Where('employee_id',$request->cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->count(); //query builder

        if ($m_pro_attendance<1)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  
        } else {

        $ci_pro_attendance=DB::table('pro_attendance')
        ->Where('employee_id',$request->cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->orderBy('attendance_id','asc')
        ->get(); //query builder
          return view('hrm.emp_attn_report',compact('ci_pro_attendance'));
        }
    }

//Daily Punch report

    public function hrmbackdaily_punch()
    {

        // $ci_tmp_log=DB::table('pro_tmp_log')->Where('valid','1')->orderBy('tmp_login_id','asc')->get(); //query builder
        // return view('hrm.daily_punch',compact('ci_tmp_log'));

        return view('hrm.daily_punch');

    }

    public function hrmbackdaily_punch_report(Request $request)
    {
    $rules = [
            'sele_placeofposting' => 'required|integer|between:1,10000',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];

        $customMessages = [

            'sele_placeofposting.required' => 'Select Place of Posting.',
            'sele_placeofposting.integer' => 'Select Place of Posting.',
            'sele_placeofposting.between' => 'Chose Place of Posting.',

            'txt_from_date.required' => 'Start Date is required.',
            'txt_to_date.required' => 'End Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';
        $txt_from_date=$request->txt_from_date;
        $txt_to_date=$request->txt_to_date;
        $txt_placeofposting_id=$request->sele_placeofposting;
        $txt_employee_id=$request->sele_emp_id;
        // $txt_employee_id=104;

        $m_from_date = DB::table('pro_tmp_log')->where('logdate', $txt_from_date)->first();

        if ($m_from_date === null)
        {
          return redirect()->back()->withInput()->with('warning' , 'Data Not Found!!');  

        } else {

        $m_to_date = DB::table('pro_tmp_log')->where('logdate', $txt_to_date)->first();
            if ($m_to_date === null)
            {
              return redirect()->back()->withInput()->with('warning' , 'Data Not Found!!');  
            } else {
                $ci_biodevice=DB::table('pro_biodevice')->Where('placeofposting_id',$txt_placeofposting_id)->first();
                $txt_biodevice_name=$ci_biodevice->biodevice_name;

                if ($txt_employee_id=='0')
                {
                    $ci_tmp_log=DB::table('pro_tmp_log')->whereBetween('logdate',[$txt_from_date,$txt_to_date])->Where('nodeid',$txt_biodevice_name)->Where('valid','1')->orderBy('tmp_login_id','asc')->get(); //query builder
                    return view('hrm.emp_punch_report',compact('ci_tmp_log'));

                } else {
                    $ci_tmp_log=DB::table('pro_tmp_log')->whereBetween('logdate',[$txt_from_date,$txt_to_date])->Where('nodeid',$txt_biodevice_name)->Where('emp_id',$txt_employee_id)->Where('valid','1')->orderBy('tmp_login_id','asc')->get(); //query builder
                    return view('hrm.emp_punch_report',compact('ci_tmp_log'));

                }
            }//if ($m_to_date === null)
        }//if ($m_from_date === null)
    }


//leave_application_list

    public function hrmbackleave_application_list()
    {

        $m_user_id=Auth::user()->emp_id;
        
        // $user_company = DB::table("pro_user_company")
        //     ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        //     ->select("pro_user_company.*", "pro_company.company_name")
        //     ->Where('employee_id',$m_user_id)
        //     ->get();

        $m_leave_info_master = DB::table('pro_leave_info_master')->Where('employee_id',$m_user_id)->Where('valid','1')->get();

        return view('hrm.leave_application_list',compact('m_leave_info_master'));
        // return view('hrm.leave_application_list');

    }

    public function RptEmpList()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $data=DB::table('pro_employee_info')->Where('valid','1')->Where('working_status','1')->orderBy('employee_id','asc')->get(); //query builder

        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.rpt_basic_info_list',compact('data','user_company'));

    }



    //Ajax call get- Employee
    public function GetEmployee($id)
    {
        $data = DB::table('pro_employee_info')
        ->where('working_status', '1')
        ->where('ss', '1')
        ->where('company_id', $id)
        ->get();
        return json_encode($data);
    }

}
