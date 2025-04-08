@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Attendance Payroll Status</h1>
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
            <form name="" method="post" action="" >
            @csrf
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
            <form action="" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                
                <select name="sele_company_id" id="sele_company_id" class="from-control custom-select">
                    @php
                      $ci1_pro_company=DB::table('pro_company')->Where('company_id',old('sele_company_id'))->orderBy('company_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_company as $r_ci1_pro_company)
                    <option value="{{ $r_ci1_pro_company->company_id }}">{{ $r_ci1_pro_company->company_name }}</option>
                    @endforeach  

                  <option value="0">Select Company</option>
                    @php
                      $ci_pro_company=DB::table('pro_company')->Where('valid','1')->orderBy('company_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_company as $r_ci_pro_company)
                    <option value="{{ $r_ci_pro_company->company_id }}">{{ $r_ci_pro_company->company_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_company_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
              </div>
            </div>


            <div class="row mb-2">
              <div class="col-3">
                <label>Attendance Active</label>
              </div>
              <div class="col-3">
                <select name="sele_attn_active" id="sele_attn_active" class="from-control custom-select">
                    @php
                      $ci1_pro_yesno=DB::table('pro_yesno')->Where('yesno_id',old('sele_attn_active'))->orderBy('yesno_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_yesno as $r_ci1_pro_yesno)
                    <option value="{{ $r_ci1_pro_yesno->yesno_id }}">{{ $r_ci1_pro_yesno->yesno_name }}</option>
                    @endforeach  

                  <option value="0">Select</option>
                    @php
                      $ci_pro_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_name', 'desc')->get();
                    @endphp
                    @foreach($ci_pro_yesno as $r_ci_pro_yesno)
                    <option value="{{ $r_ci_pro_yesno->yesno_id }}">{{ $r_ci_pro_yesno->yesno_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_attn_active')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror

              </div>
              <div class="col-3">
                <label>Payroll Active</label>
              </div>
              <div class="col-3">
                <select name="sele_payroll_active" id="sele_payroll_active" class="from-control custom-select">
                    @php
                      $ci1_pro_yesno=DB::table('pro_yesno')->Where('yesno_id',old('sele_payroll_active'))->orderBy('yesno_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_yesno as $r_ci1_pro_yesno)
                    <option value="{{ $r_ci1_pro_yesno->yesno_id }}">{{ $r_ci1_pro_yesno->yesno_name }}</option>
                    @endforeach  

                  <option value="0">Select</option>
                    @php
                      $ci_pro_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_name', 'desc')->get();
                    @endphp
                    @foreach($ci_pro_yesno as $r_ci_pro_yesno)
                    <option value="{{ $r_ci_pro_yesno->yesno_id }}">{{ $r_ci_pro_yesno->yesno_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_payroll_active')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-9">
                <input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Remarks" value="{{ old('txt_remarks') }}">
                  @error('txt_remarks')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="date" class="form-control" id="txt_dob" name="txt_dob" value="{{ old('txt_dob') }}">
                  @error('txt_dob')
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
{{-- @include('/hrm/salary_info_list') --}}
&nbsp;
@endif
@endsection
