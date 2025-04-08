@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Educational Information</h1>
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
                        <form action="{{ route('educational_qualification_store') }}" method="post">
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
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_institute"
                                        value="{{ old('txt_institute') }}" name="txt_institute"
                                        placeholder="Institute Name.">
                                    @error('txt_institute')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_exame_title"
                                        value="{{ old('txt_exame_title') }}" name="txt_exame_title"
                                        placeholder="Exam/Degree Title.">
                                    @error('txt_exame_title')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_group" value="{{ old('txt_group') }}"
                                        name="txt_group" placeholder="Concentration/Major/Group.">
                                    @error('txt_group')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_result"
                                        value="{{ old('txt_result') }}" name="txt_result"
                                        placeholder="Result/CGPA.">
                                    @error('txt_result')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_passing_year"
                                        value="{{ old('txt_passing_year') }}" name="txt_passing_year"
                                        placeholder="Passing Year.">
                                    @error('txt_passing_year')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-1">
                                    <button type="Submit" class="btn btn-primary btn-block">Add</button>
                                </div>
                                <div class="col-1">
                                    <a href="{{ route('professional_training',$emp_id) }}"
                                        class="btn btn-primary btn-block">Skip</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('/hrm/edu_info_list')
@endsection
