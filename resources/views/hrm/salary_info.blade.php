@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Salary Information</h1>
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
                <input type="text" class="form-control" id="txt_gross_salary" name="txt_gross_salary" placeholder="Gross Salary" value="{{ old('txt_gross_salary') }}">
                  @error('txt_gross_salary')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
              </div>
              <div class="col-3">
              </div>
              <div class="col-3">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_bank_payment" name="txt_bank_payment" placeholder="Bank Payment" value="{{ old('txt_bank_payment') }}">
                  @error('txt_bank_payment')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_ait" name="txt_ait" placeholder="AIT" value="{{ old('txt_ait') }}">
                  @error('txt_ait')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_pf_insurance" name="txt_pf_insurance" placeholder="PF/Insurance" value="{{ old('txt_pf_insurance') }}">
                  @error('txt_pf_insurance')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_sl_view" name="txt_sl_view" placeholder="View Serial" value="{{ old('txt_sl_view') }}">
                  @error('txt_sl_view')
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
@include('/hrm/salary_info_list')
&nbsp;
@endif
@endsection
