@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Summary Attendance Process</h1>
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
          <div align="left" class=""></div>
            <form action="{{ route('hrmbacksummary_processstore') }}" method="Post">
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
              <div class="col-3">
                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date" placeholder="Start Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_from_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date" placeholder="End Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_to_date')
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
&nbsp;
@endsection
