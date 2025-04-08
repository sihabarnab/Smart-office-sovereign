@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Attendance Report</h1>
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
          
            <form action="{{ route('hrmattenindrpt') }}" method="Post">
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
              	<div class="input-group date" id="sedate3" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" id="txt_month"
                    name="txt_month" placeholder="Year Month"
                    value="{{ old('txt_month') }}" data-target="#sedate3">
                    <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div>
                </div>
                @error('txt_month')
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

  @section('script')
  <script>
    $('#sedate3').datetimepicker({
         format: 'YYYY-MM'
     });
  </script>  
  @endsection




@endsection

