@extends('layouts.admin_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create User</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_user))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('admincuserupdate',$m_user->emp_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-5">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                <select name="sele_employee_id" id="sele_employee_id" class="from-control custom-select">
                    @php
                      $ci1_pro_employee_info=DB::table('pro_employee_info')->Where('employee_id',$m_user->emp_id)->orderBy('employee_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_employee_info as $r_ci1_pro_employee_info)
                    <option value="{{ $r_ci1_pro_employee_info->employee_id }}">{{ $r_ci1_pro_employee_info->employee_name }} | {{ $r_ci1_pro_employee_info->employee_id }}</option>
                    @endforeach  

                  <option value="0">Select Employee</option>
                    @php
                      $ci_pro_employee_info=DB::table('pro_employee_info')->Where('valid','1')->orderBy('employee_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_employee_info as $r_ci_pro_employee_info)
                    <option value="{{ $r_ci_pro_employee_info->employee_id }}">{{ $r_ci_pro_employee_info->employee_name }} | {{ $r_ci_pro_employee_info->employee_id }}</option>
                    @endforeach    
                </select>
                  @error('sele_employee_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-7">
                  <input type="text" class="form-control" id="txt_password" name="txt_password" placeholder="Password" value="{{ old('txt_password') }}">
                  @error('txt_password')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_valid" id="sele_valid" class="from-control custom-select">
                    @php
                      $ci1_pro_yesno=DB::table('pro_yesno')->Where('yesno_id',$m_user->valid)->orderBy('yesno_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_yesno as $r_ci1_pro_yesno)
                    <option value="{{ $r_ci1_pro_yesno->yesno_id }}">{{ $r_ci1_pro_yesno->yesno_name }}</option>
                    @endforeach  

                  <option value="0">Select Valid</option>
                    @php
                      $ci_pro_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_yesno as $r_ci_pro_yesno)
                    <option value="{{ $r_ci_pro_yesno->yesno_id }}">{{ $r_ci_pro_yesno->yesno_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_valid')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-7">
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
            <form action="{{ route('admincuserstore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-5">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <select name="sele_employee_id" id="sele_employee_id" class="from-control custom-select">
                    @php
                      $ci1_pro_employee_info=DB::table('pro_employee_info')->Where('employee_id',old('sele_employee_id'))->orderBy('employee_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_employee_info as $r_ci1_pro_employee_info)
                    <option value="{{ $r_ci1_pro_employee_info->employee_id }}">{{ $r_ci1_pro_employee_info->employee_name }}</option>
                    @endforeach  

                  <option value="0">Select Employee</option>
                    @php
                      $ci_pro_employee_info=DB::table('pro_employee_info')->Where('valid','1')->orderBy('employee_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_employee_info as $r_ci_pro_employee_info)
                    <option value="{{ $r_ci_pro_employee_info->employee_id }}">{{ $r_ci_pro_employee_info->employee_name }} | {{ $r_ci_pro_employee_info->employee_id }}</option>
                    @endforeach    
                </select>
                  @error('sele_employee_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-7">
                  <input type="text" class="form-control" id="txt_password" name="txt_password" placeholder="Password" value="{{ old('txt_password') }}">
                  @error('txt_password')
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
@include('/admin/user_list')
&nbsp;
@endif
@endsection
