@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Type</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_leave_type))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="" >
            @csrf
            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control" id="txt_leave_type" name="txt_leave_type" placeholder="Leave Type" value="{{ $m_leave_type->leave_type }}">
                  @error('txt_leave_type')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
                
              </div>
              <div class="col-6">
                <input type="text" class="form-control" id="txt_leave_type_sname" name="txt_leave_type_sname" placeholder="Leave Short Name" value="{{ $m_leave_type->leave_type_sname }}">
                  @error('txt_leave_type_sname')
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
            <form action="{{ route('hrmbackleave_typestore') }}" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control" id="txt_leave_type" name="txt_leave_type" placeholder="Leave Type" value="{{ old('txt_leave_type') }}">
                  @error('txt_leave_type')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
                
              </div>
              <div class="col-6">
                <input type="text" class="form-control" id="txt_leave_type_sname" name="txt_leave_type_sname" placeholder="Leave Short Name" value="{{ old('txt_leave_type_sname') }}">
                  @error('txt_leave_type_sname')
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
@include('/hrm/leave_type_list')
&nbsp;
@endif
@endsection
