<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;

class ChangePassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('changepass');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
                return redirect(route('changepass.index'))->with('success','Password Change Successfully!');

            } else {
                return redirect()->back()->withInput()->with('warning' , 'New password and Confirm Password mismatch!!');

            }//if ($m_new_pass == $m_conf_pass)


        } //if( \Illuminate\Support\Facades\Hash::check( $request->txt_old_pass, $abcd->password) == false)
    }
}
