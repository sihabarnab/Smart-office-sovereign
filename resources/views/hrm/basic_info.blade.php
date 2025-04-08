@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Basic Information</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_basic_info))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('hrmbackbasic_infoupdate',$m_basic_info->employee_info_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-4">
                @php
                $m_company_id=$data->company_id;
                // dd($m_company_id);
                  $ci1_pro_company=DB::table('pro_company')->Where('company_id',$m_company_id)->first();
                @endphp
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control" id="sele_company_id" name="sele_company_id" placeholder="--Company--" readonly value="{{ $ci1_pro_company->company_name }}">
                  @error('sele_company_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror

              </div>
              <div class="col-2">
                <input type="text" class="form-control"mid="txt_emp_id" name="txt_emp_id" placeholder="Employee ID" readonly value="{{ $m_basic_info->employee_id }}">
                  @error('txt_emp_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control"mid="txt_emp_name" name="txt_emp_name" placeholder="Employee Name" value="{{ $m_basic_info->employee_name }}">
                  @error('txt_emp_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_report" id="sele_report" class="form-control">
                  <option value="00000000">Select Report</option>
                    @foreach($m_employee_info as $row_employee_info)
                      <option value="{{$row_employee_info->employee_id}}"  {{$row_employee_info->employee_id == $m_basic_info->report_to_id? 'selected':''}}>
                          {{$row_employee_info->employee_id}} | {{$row_employee_info->employee_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_report')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_desig" id="sele_desig" class="form-control">
                  <option value="">Select Desig</option>
                    @foreach($m_pro_desig as $row_desig)
                      <option value="{{$row_desig->desig_id}}"  {{$row_desig->desig_id == $m_basic_info->desig_id? 'selected':''}}>
                          {{$row_desig->desig_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_desig')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_department" id="sele_department" class="form-control">
                  <option value="">Select Department</option>
                    @foreach($m_pro_department as $row_department)
                      <option value="{{$row_department->department_id}}"  {{$row_department->department_id == $m_basic_info->department_id? 'selected':''}}>
                          {{$row_department->department_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_department')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_section" id="sele_section" class="form-control">
                  <option value="">Select Section</option>
                    @foreach($m_pro_section as $row_section)
                      <option value="{{$row_section->section_id}}"  {{$row_section->section_id == $m_basic_info->section_id? 'selected':''}}>
                          {{$row_section->section_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_section')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_placeofposting" id="sele_placeofposting" class="form-control">
                  <option value="">Select Place of Posting</option>
                    @foreach($m_pro_placeofposting as $row_placeofposting)
                      <option value="{{$row_placeofposting->placeofposting_id}}"  {{$row_placeofposting->placeofposting_id == $m_basic_info->placeofposting_id? 'selected':''}}>
                          {{$row_placeofposting->placeofposting_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_placeofposting')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_joining_date"
                    name="txt_joining_date" placeholder="Joinning Date"
                    value="{{ $m_basic_info->joinning_date }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_joining_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                  <option value="">Select Policy</option>
                    @foreach($m_pro_att_policy as $row_att_policy)
                      <option value="{{$row_att_policy->att_policy_id}}"  {{$row_att_policy->att_policy_id == $m_basic_info->att_policy_id? 'selected':''}}>
                          {{$row_att_policy->att_policy_name}} | {{$row_att_policy->in_time}} |  | {{$row_att_policy->out_time}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_att_policy')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="sele_gender_id" id="sele_gender_id" class="form-control">
                  <option value="">Select Gender</option>
                    @foreach($m_pro_gender as $row_gender)
                      <option value="{{$row_gender->gender_id}}"  {{$row_gender->gender_id == $m_basic_info->gender? 'selected':''}}>
                          {{$row_gender->gender_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_gender_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_emp_mobile" name="txt_emp_mobile" placeholder="Mobile No." value="{{ $m_basic_info->mobile }}">
                  @error('txt_emp_mobile')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="sele_blood" id="sele_blood" class="form-control">
                  <option value="">Select Blood</option>
                    @foreach($m_pro_blood as $row_blood)
                      <option value="{{$row_blood->blood_id}}"  {{$row_blood->blood_id == $m_basic_info->blood_group? 'selected':''}}>
                          {{$row_blood->blood_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_blood')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="txt_grade" name="txt_grade" placeholder="Grade" value="{{ $m_basic_info->grade }}">
                  @error('txt_grade')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_psm_id" name="txt_psm_id" placeholder="Staff ID" value="{{ $m_basic_info->staff_id }}">
                  @error('txt_psm_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
           
            <div class="col-4">
              <select name="cbo_healper_active" id="cbo_healper_active" class="form-control">
                <option value=""> Leader & Helper Status</option>
                <option value="1" {{$m_basic_info->leader_healper_status==1 ? "selected":"" }}>Yes</option>
                <option value="2" {{$m_basic_info->leader_healper_status== 2? "selected":"" }}>No</option>
              </select>
                @error('cbo_healper_active')
                 <div class="text-warning">{{ $message }}</div>
                @enderror
            </div>
          </div>

            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('hrmbackbasic_infostore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <select name="sele_company_id" id="sele_company_id" class="form-control">
                  <option value="">--Company--</option>
                  @foreach ($user_company as $company)
                      <option value="{{ $company->company_id }}">
                          {{ $company->company_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_company_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control"mid="txt_emp_id" name="txt_emp_id" placeholder="Employee ID" value="{{ old('txt_emp_id') }}">
                  @error('txt_emp_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control"mid="txt_emp_name" name="txt_emp_name" placeholder="Employee Name" value="{{ old('txt_emp_name') }}">
                  @error('txt_emp_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_report" id="sele_report" class="form-control">
                  <option value="00000000">--Select Report--</option>
                  @foreach ($data as $emp_info)
                      <option value="{{ $emp_info->employee_id }}">
                          {{ $emp_info->employee_id }} | {{ $emp_info->employee_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_report')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3">
                @php
                $data_pro_desig=DB::table('pro_desig')->Where('valid','1')->orderBy('desig_id','asc')->get(); //query builder
                @endphp
                <select name="sele_desig" id="sele_desig" class="form-control">
                  <option value="">--Select Designation--</option>
                  @foreach ($data_pro_desig as $emp_desig)
                      <option value="{{ $emp_desig->desig_id }}">
                          {{ $emp_desig->desig_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_desig')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                @php
                $data_pro_department=DB::table('pro_department')->Where('valid','1')->orderBy('department_id','asc')->get(); //query builder
                @endphp
                <select name="sele_department" id="sele_department" class="form-control">
                  <option value="">--Select Department--</option>
                  @foreach ($data_pro_department as $emp_department)
                      <option value="{{ $emp_department->department_id }}">
                          {{ $emp_department->department_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_department')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                @php
                $data_pro_section=DB::table('pro_section')->Where('valid','1')->orderBy('section_id','asc')->get(); //query builder
                @endphp
                <select name="sele_section" id="sele_section" class="form-control">
                  <option value="">--Select Section--</option>
                  @foreach ($data_pro_section as $emp_section)
                      <option value="{{ $emp_section->section_id }}">
                          {{ $emp_section->section_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_section')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                @php
                $data_pro_placeofposting=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_id','asc')->get(); //query builder
                @endphp
                <select name="sele_placeofposting" id="sele_placeofposting" class="form-control">
                  <option value="">Select Place of Posting</option>
                  @foreach ($data_pro_placeofposting as $emp_placeofposting)
                      <option value="{{ $emp_placeofposting->placeofposting_id }}">
                          {{ $emp_placeofposting->placeofposting_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_placeofposting')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_joining_date"
                    name="txt_joining_date" placeholder="Joining Date"
                    value="{{ old('txt_joining_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_joining_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                @php
                $data_pro_att_policy=DB::table('pro_att_policy')->Where('valid','1')->orderBy('att_policy_id','asc')->get(); //query builder
                @endphp
                <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                  <option value="">Select Policy</option>
                  @foreach ($data_pro_att_policy as $emp_att_policy)
                    <option value="{{ $emp_att_policy->att_policy_id }}">
                        {{ $emp_att_policy->att_policy_name }} | {{ $emp_att_policy->in_time }} | {{ $emp_att_policy->out_time }}
                    </option>
                  @endforeach
                </select>
                @error('sele_att_policy')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                @php
                $data_pro_gender=DB::table('pro_gender')->Where('valid','1')->orderBy('gender_id','asc')->get(); //query builder
                @endphp
                <select name="sele_gender_id" id="sele_gender_id" class="form-control">
                  <option value="">Select Gender</option>
                  @foreach ($data_pro_gender as $emp_gender)
                    <option value="{{ $emp_gender->gender_id }}">
                        {{ $emp_gender->gender_name }}
                    </option>
                  @endforeach
                </select>
                @error('sele_gender_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_emp_mobile" name="txt_emp_mobile" placeholder="Mobile No." value="{{ old('txt_emp_mobile') }}">
                  @error('txt_emp_mobile')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                @php
                $data_pro_blood=DB::table('pro_blood')->Where('valid','1')->orderBy('blood_id','asc')->get(); //query builder
                @endphp
                <select name="sele_blood" id="sele_blood" class="form-control">
                  <option value="">Select Blood</option>
                  @foreach ($data_pro_blood as $emp_blood)
                    <option value="{{ $emp_blood->blood_id }}">
                        {{ $emp_blood->blood_name }}
                    </option>
                  @endforeach
                </select>
                @error('sele_blood')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="txt_grade" name="txt_grade" placeholder="Grade" value="{{ old('txt_grade') }}">
                  @error('txt_grade')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_psm_id" name="txt_psm_id" placeholder="Staff ID" value="{{ old('txt_psm_id') }}">
                  @error('txt_psm_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="cbo_healper_active" id="cbo_healper_active" class="form-control">
                  <option value=""> Leader & Helper Status</option>
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
                  @error('cbo_healper_active')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Submit</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@include('/hrm/basic_info_list')
{{-- @include('/hrm/basic_info_face_list') --}}
&nbsp;
@endif
  @section('script')
  <script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  

  @endsection
@endsection
