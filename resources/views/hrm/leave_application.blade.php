@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Application</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('hrmbackleave_applicationstore') }}" method="Post">
            @csrf
            @php
              $txt_emp_id=Auth::user()->emp_id;
              $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$txt_emp_id)->first();

              $txt_company_id=$ci_employee_info->company_id;
              $txt_employee_name=$ci_employee_info->employee_name;
              $txt_desig_id=$ci_employee_info->desig_id;

              $ci_company=DB::table('pro_company')->Where('company_id',$txt_company_id)->first();
              $txt_company=$ci_company->company_name;

              $ci_desig=DB::table('pro_desig')->Where('desig_id',$txt_desig_id)->first();
              $txt_desig=$ci_desig->desig_name;

            @endphp

            <div class="row mb-2">
              <div class="col-2">
                <input type="text" class="form-control" id="txt_user_id" name="txt_user_id" readonly value="{{ Auth::user()->emp_id }}">
              </div>
              <div class="col-4">
                <input type="hidden" class="form-control" id="txt_company_id" name="txt_company_id" readonly value="{{ $txt_company_id }}">
                <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" readonly value="{{ $txt_company }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_employee_name" name="txt_employee_name" readonly value="{{ $txt_employee_name }}">
              </div>
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_desig_id" name="txt_desig_id" readonly value="{{ $txt_desig_id }}">
                <input type="text" class="form-control" id="txt_desig_name" name="txt_desig_name" readonly value="{{ $txt_desig }}">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3">
                @php
                  $ci_pro_leave_type=DB::table('pro_leave_type')->Where('valid','1')->orderBy('leave_type', 'asc')->get();
                @endphp

                <select name="sele_leave_type" id="sele_leave_type" class="form-control">
                  <option value="0">Select Leave Type</option>
                  @foreach ($ci_pro_leave_type as $r_leave_type)
                      <option value="{{ $r_leave_type->leave_type_id }}">
                          {{ $r_leave_type->leave_type }}
                      </option>
                  @endforeach
                </select>
                @error('sele_leave_type')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_from_date"
                    name="txt_from_date" placeholder="From Date"
                    value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_from_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_to_date"
                    name="txt_to_date" placeholder="To Date"
                    value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}" onchange="DateDiff(this.value)">

                @error('txt_to_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_total" name="txt_total" value="{{ old('txt_total') }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_purpose_leave" name="txt_purpose_leave" placeholder="Purpose Of Leave" value="{{ old('txt_purpose_leave') }}">
                  @error('txt_purpose_leave')
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
@include('/hrm/leave_status')
&nbsp;
  @section('script')
  <script>
          function DateDiff(val) {
           var date1 = new Date(document.getElementById("txt_from_date").value)
           var date2 = new Date(val);
           var Difference_In_Time = date2.getTime() - date1.getTime();
           var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
           document.getElementById("txt_total").value=Difference_In_Days+1;
          }
      </script>
  @endsection
@endsection