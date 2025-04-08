@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $m_company->company_name }} <br>
                        {{ $m_employee->employee_name }} <br> 
                        {{ $m_employee->employee_id }}
                    </h1>
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="btn-primary">
                                    <form action="{{ route('module_all_menu_permission') }}" method="get">
                                    @csrf
                                    {{-- //hidden --}}
                                    <input type="hidden" name="txt_company_id" value="{{ $m_company->company_id }}">
                                    <input type="hidden" name="txt_employee_id" value="{{ $m_employee->employee_id }}">
                                    <input type="hidden" name="txt_module_id" value="{{ $m_modules->module_id }}">

                                    <th class="text-left align-top" colspan="3">{{ $m_modules->module_name}}</th>
                                    <th class="text-left align-top ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="txt_valid_all"
                                                id="txt_valid_all">
                                            <label class="form-check-label" for="txt_valid_all">
                                                Valid All
                                            </label>
                                        </div>
                                    </th>
                                    <th class="text-left align-top">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Add</button>
                                    </th>
                                    </form>
                                </tr>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Sub Menu Title</th>
                                    <th>Sub Menu Link</th>
                                    <th>Valid</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach ($m_main_mnu as $row)
                                  <tr>
                                    <form action="{{ route('main_menu_all_permission') }}" method="get">
                                    @csrf
                                    {{-- //hidden --}}
                                    <input type="hidden" name="txt_company_id" value="{{ $m_company->company_id }}">
                                    <input type="hidden" name="txt_employee_id" value="{{ $m_employee->employee_id }}">
                                    <input type="hidden" name="txt_module_id" value="{{ $row->module_id }}">
                                    <input type="hidden" name="txt_main_menu_id" value="{{ $row->main_mnu_id }}">

                                    <th class="text-center align-top" colspan="3">{{ $row->main_mnu_title}}</th>
                                    <th class="text-left align-top ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="txt_mark_all"
                                                id="txt_mark_all">
                                            <label class="form-check-label" for="txt_mark_all">
                                                Valid All
                                            </label>
                                        </div>
                                    </th>
                                    <th class="text-left align-top">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Add</button>
                                    </th>
                                    </form>
                                </tr>

                                {{-- //Submenu List  --}}
                                @php
                                    $m_submenu = DB::table('pro_sub_mnu')
                                    ->where('module_id',$row->module_id)
                                    ->where('main_mnu_id',$row->main_mnu_id)
                                    ->get();
                                @endphp

                                @foreach ($m_submenu as $key=>$value)
                                    <tr>
                                        <form action="{{ route('sub_menu_wise_permission') }}" method="get">
                                            @csrf
                                            {{-- //hidden --}}
                                            <input type="hidden" name="txt_company_id" value="{{ $m_company->company_id }}">
                                            <input type="hidden" name="txt_employee_id" value="{{ $m_employee->employee_id }}">
                                            <input type="hidden" name="txt_module_id" value="{{ $value->module_id }}">
                                            <input type="hidden" name="txt_main_menu_id" value="{{ $value->main_mnu_id }}">
                                            <input type="hidden" name="txt_sub_menu_id" value="{{ $value->sub_mnu_id }}">

                                            <td>{{$key+1}}</td>
                                            <td>{{$value->sub_mnu_title}}</td>
                                            <td>{{$value->sub_mnu_link}}</td>
                                            <td>
                                                @php
                                                     $user_sub_menu = DB::table('pro_sub_mnu_for_users')
                                                        ->where('emp_id', $m_employee->employee_id)
                                                        ->where('module_id', $value->module_id)
                                                        ->where('main_mnu_id', $value->main_mnu_id )
                                                        ->where('sub_mnu_id', $value->sub_mnu_id)
                                                        ->first();
                                                @endphp
                                                <div class="form-check">
                                                    @if (isset($user_sub_menu->valid))
                                                        @if ($user_sub_menu->valid == 1)
                                                            <input class="form-check-input" type="checkbox" name="txt_valid"
                                                                id="txt_valid" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="txt_valid"
                                                                id="txt_valid">
                                                        @endif
                                                    @else
                                                        <input class="form-check-input" type="checkbox" name="txt_valid"
                                                            id="txt_valid">
                                                    @endif
                                                    <label class="form-check-label" for="txt_valid">Valid</label>
                                                </div>
                                            </td>
                                            <td class="text-left align-top">
                                                <button type="Submit" id="save_event"
                                                class="btn btn-primary btn-block">Add</button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                                   {{-- //  @foreach ($m_submenu as $value) --}}
   

                                  @endforeach
                                  {{-- // @foreach ($m_main_mnu as $row) --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
