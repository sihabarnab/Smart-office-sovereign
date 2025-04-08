@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Configuration</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_leave_config))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('hrmbackleave_configupdate',$m_leave_config->leave_config_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <select name="sele_leave_type" id="sele_leave_type" class="from-control custom-select">
                    @php
                      $ci1_pro_leave_type=DB::table('pro_leave_type')->Where('leave_type_id',$m_leave_config->leave_type_id)->orderBy('leave_type','asc')->get();
                    @endphp

                    @foreach($ci1_pro_leave_type as $r_ci1_pro_leave_type)
                    <option value="{{ $r_ci1_pro_leave_type->leave_type_id }}">{{ $r_ci1_pro_leave_type->leave_type }}</option>
                    @endforeach  

                  {{-- <option value="0">Select Leave Type</option>
                    @php
                      $ci_pro_leave_type=DB::table('pro_leave_type')->Where('valid','1')->orderBy('leave_type', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_leave_type as $r_ci_pro_leave_type)
                    <option value="{{ $r_ci_pro_leave_type->leave_type_id }}">{{ $r_ci_pro_leave_type->leave_type }}</option>
                    @endforeach   --}}  
                </select>
                  {{-- @error('sele_leave_type')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror --}}
                </div>
              <div class="col-6">
                <input type="text" class="form-control"mid="txt_leave_days" name="txt_leave_days" placeholder="Employee ID" value="{{ $m_leave_config->leave_days }}">
                  @error('txt_leave_days')
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
            <form action="{{ route('hrmbackleave_configstore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <select name="sele_leave_type" id="sele_leave_type" class="from-control custom-select">
                    @php
                      $ci1_pro_leave_type=DB::table('pro_leave_type')->Where('leave_type_id',old('sele_leave_type_id'))->orderBy('leave_type','asc')->get();
                    @endphp

                    @foreach($ci1_pro_leave_type as $r_ci1_pro_leave_type)
                    <option value="{{ $r_ci1_pro_leave_type->leave_type_id }}">{{ $r_ci1_pro_leave_type->leave_type }}</option>
                    @endforeach  

                  <option value="0">Select Leave Type</option>
                    @php
                      $ci_pro_leave_type=DB::table('pro_leave_type')->Where('valid','1')->orderBy('leave_type', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_leave_type as $r_ci_pro_leave_type)
                    <option value="{{ $r_ci_pro_leave_type->leave_type_id }}">{{ $r_ci_pro_leave_type->leave_type }}</option>
                    @endforeach    
                </select>
                  @error('sele_leave_type')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control"mid="txt_leave_days" name="txt_leave_days" placeholder="Leave Days" value="{{ old('txt_leave_days') }}">
                  @error('txt_leave_days')
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
@include('/hrm/leave_config_list')
&nbsp;
@endif
@endsection
