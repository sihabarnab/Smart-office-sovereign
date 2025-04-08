@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Profile</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>

@php
if($m_employee_biodata->emp_pic===null){
  $txt_emp_pic="avatar.png";
} else {
  $txt_emp_pic=$m_employee_biodata->emp_pic;
}

$ci_report=DB::table('pro_employee_info')->Where('employee_id',$m_employee_info->report_to_id)->first();
$txt_report=$ci_report->employee_name;


@endphp
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <img align="right" style="margin-right: 10%;" src="{{ asset("$m_employee_biodata->emp_pic") }}" alt="Pic" width="150" height="150">

              <div align="left" class="card">
                <div class="card-body" style="height: 150px;">
                  <h1 class="">{{ $m_employee_biodata->employee_name }}</h1>
                  <h5 class="card-text">{{ $m_employee_biodata->employee_id }}|{{ $m_employee_info->desig_name }}</h5>
                 </div>
              </div>
        </div>

        <div class="card-body">
          <h4>Job Details :</h4>
            <table class="table-bordered" id="" align="center" width="70%" cellspacing="0">
              <tr>
                <td width="35%">Company Name</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_info->company_name }}</td>
              </tr>
              <tr>
                <td width="35%">Joining Date</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_info->joinning_date }}</td>
              </tr>
              <tr>
                <td width="35%">Report To</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $txt_report }}({{ $m_employee_info->report_to_id }})</td>
              </tr>
              <tr>
                <td width="35%">Mobile No.</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_info->mobile }}</td>
              </tr>
              <tr>
                <td width="35%">E-mail(Company)</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->email_office }}</td>
              </tr>
              <tr>
                <td width="35%">E-mail(Personal)</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->email_personal }}</td>
              </tr>
            </table>
        </div>
        <div class="card-body">
          <h4>Personal Details :</h4>
            <table class="table-bordered" id="" align="center" width="70%" cellspacing="0">
              <tr>
                <td width="35%">Father's Name</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->father_name }}</td>
              </tr>
              <tr>
                <td width="35%">Mother's Name</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->mother_name }}</td>
              </tr>
              <tr>
                <td width="35%">Spouse's Name</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->spouse_name }}</td>
              </tr>
              <tr>
                <td width="35%">Residance Contact</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->res_contact }}</td>
              </tr>
              <tr>
                <td width="35%">NID No.</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->national_id_no }}</td>
              </tr>
              <tr>
                <td width="35%" valign="top">Present Address</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->present_add }}</td>
              </tr>
              <tr>
                <td width="35%" valign="top">Parmanent Address</td>
                <td width="5%" align="center">:</td>
                <td width="60%">&nbsp;{{ $m_employee_biodata->permanent_add }}</td>
              </tr>

            </table>
          </div>

      </div>
    </div>
  </div>
</div>



@endsection
