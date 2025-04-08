@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upload Picture</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_employee_info = DB::table('pro_employee_info')
            ->join('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
            ->join('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->select('pro_employee_info.*', 'pro_company.*', 'pro_desig.*')
        
            ->where('employee_id', $emp_id)
            ->first();
        
        $m_employee_biodata = DB::table('pro_employee_biodata')
            ->where('employee_id', $emp_id)
            ->first();
        
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body mt-5">
                        {{-- <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div> --}}
                        <form action="{{ route('biodata_file_store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_company_name" name="txt_company_name"
                                        readonly value="{{ $m_employee_info->company_name }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_employ_id" name="txt_employ_id"
                                        readonly value="{{ $emp_id }}">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_employ_name" name="txt_employ_name"
                                        readonly value="{{ $m_employee_info->employee_name }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_desig_name" name="txt_desig_name"
                                        readonly value="{{ $m_employee_info->desig_name }}">
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" accept=".jpg" class="form-control" id="txt_profile_img"
                                        value="{{ old('txt_profile_img') }}" name="txt_profile_img"
                                        placeholder="Upload Picture(300X400)." onfocus="(this.type='file')">
                                    @error('txt_profile_img')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                    @if(session()->has('profile'))
                                        <p class="text-warning">{{ session('profile') }}</p>
                                    @endif
                                </div>
                                <div class="col-4">
                                    <input type="text" accept=".jpg" class="form-control" id="txt_nid_front_img"
                                        name="txt_nid_front_img" value="{{ old('txt_nid_front_img') }}"
                                        placeholder="Upload NID front part(300X250)." onfocus="(this.type='file')">
                                    @error('txt_nid_front_img')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" accept=".jpg" class="form-control" id="txt_nid_back_img"
                                        name="txt_nid_back_img" value="{{ old('txt_nid_back_img') }}"
                                        placeholder="Upload NID back part(300X250)." onfocus="(this.type='file')">
                                    @error('txt_nid_back_img')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" accept=".jpg" class="form-control" id="txt_bc_img"
                                        value="{{ old('txt_bc_img') }}" name="txt_bc_img"
                                        placeholder="Upload Birth certificate(A4 Size)." onfocus="(this.type='file')">
                                    @error('txt_bc_img')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                @if ($m_employee_biodata->emp_pic)
                                    <div class="col-8">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Add</button>
                                    </div>
                                    <div class="col-2">
                                        <a href="{{ route('educational_qualification', $emp_id) }}"
                                            class="btn btn-primary btn-block">Skip</a>
                                    </div>
                                @else
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Next</button>
                                    </div>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($m_employee_biodata->emp_pic)
        @include('/hrm/biodata_file_list')
    @else
    @endif
@endsection
