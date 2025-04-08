@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Experience (if any)</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>
    @php
    $m_employee_info = DB::table("pro_employee_info")
    ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
    ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
    ->select("pro_employee_info.*", "pro_company.*", "pro_desig.*")

    ->where('employee_id',$emp_id)
    ->first();

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('experience_store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_company_name" name="txt_company_name"
                                        readonly value="{{ $m_employee_info->company_name}}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_employ_id" name="txt_employ_id"
                                        readonly value="{{$emp_id}}">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_employ_name" name="txt_employ_name"
                                        readonly value="{{ $m_employee_info->employee_name}}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_desig_name" name="txt_desig_name"
                                        readonly value="{{ $m_employee_info->desig_name}}">
                                </div>

                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_organization" name="txt_organization"
                                        value="{{ old('txt_organization') }}" placeholder="Organization">
                                    @error('txt_organization')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_address" name="txt_address"
                                        value="{{ old('txt_address') }}" placeholder="Address">
                                    @error('txt_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_designation" name="txt_designation"
                                        value="{{ old('txt_designation') }}" placeholder="Designation">
                                    @error('txt_designation')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_responsibilities"
                                        name="txt_responsibilities" value="{{ old('txt_responsibilities') }}"
                                        placeholder="Key Job Responsibilities">
                                    @error('txt_responsibilities')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_start_date" name="txt_start_date"
                                        value="{{ old('txt_start_date') }}" placeholder="Start Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_start_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_end_date" name="txt_end_date"
                                        value="{{ old('txt_end_date') }}" placeholder="End Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_end_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-1">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Add</button>
                                </div>
                                <div class="col-1">
                                    <a href="{{ route('bio_data') }}"
                                        class="btn btn-primary btn-block">Close</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('/hrm/experiance_info_list')
@endsection
