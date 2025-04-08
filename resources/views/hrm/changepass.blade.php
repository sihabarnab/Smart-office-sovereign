@extends('layouts.app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Change Password</h1>
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
          {{-- <div align="left" class=""><h5>{{ "PASS" }}</h5></div> --}}
            <form action="{{ route('ResetPassstore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_emp_id" name="txt_emp_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_old_pass" name="txt_old_pass" placeholder="Old Password" value="{{ old('txt_old_pass') }}">
                  @error('txt_old_pass')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_new_pass" name="txt_new_pass" placeholder="New Password" value="{{ old('txt_new_pass') }}">
                  @error('txt_new_pass')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_conf_pass" name="txt_conf_pass" placeholder="Confirm Password" value="{{ old('txt_conf_pass') }}">
                  @error('txt_conf_pass')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Change</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
&nbsp;
@endsection
