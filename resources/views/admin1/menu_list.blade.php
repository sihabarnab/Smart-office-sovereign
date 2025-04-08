@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Permission</h1>
            @php
            $m_employee = DB::table('pro_employee_info')
            ->where('employee_id', $employee)
            ->first();

            $m_module = DB::table('pro_module')
            ->where('module_id', $module)
            ->first();

            $m_main_mnu = DB::table('pro_main_mnu')
            ->where('main_mnu_id', $main_menu)
            ->first();
            @endphp

            {{ $employee }} {{ $m_employee->employee_name }}
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
                        <div align="left" class=""><h5>{{ $m_module->module_name }} -- {{ $m_main_mnu->main_mnu_title }}</h5></div>                        
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Sub Menu Title</th>
                                    <th>Add</th>
                                    <th>Edit</th>
                                    <th>view</th>
                                    <th>Valid</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub_menu as $key => $value)
                                    <tr>
                                        <form action="{{ route('sub_menu_user_store', $value->sub_mnu_id) }}" method="post">
                                            {{ method_field('POST') }}
                                            @csrf

                                            <input type="hidden" name="txt_employee_id" id="txt_employee_id"
                                                value="{{ $employee }}">
                                            <input type="hidden" name="txt_module_id" id="txt_module_id"
                                                value="{{ $module }}">
                                            <input type="hidden" name="txt_main_menu_id" id="txt_main_menu_id"
                                                value="{{ $main_menu }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @php
                                                    $user_sub_menu = DB::table('pro_sub_mnu_for_users')
                                                        ->where('emp_id', $employee)
                                                        ->where('module_id', $module)
                                                        ->where('main_mnu_id', $main_menu)
                                                        ->where('sub_mnu_id', $value->sub_mnu_id)
                                                        ->first();
                                                @endphp
                                                <p>
                                                    @if (isset($user_sub_menu->sub_mnu_id))
                                                        <input type="checkbox" name="txt_sub_menu_upd" id="txt_sub_menu_upd"
                                                            checked>
                                                    @else
                                                        <input type="checkbox" name="txt_sub_menu_upd"
                                                            id="txt_sub_menu_upd">
                                                    @endif
                                                    {{ $value->sub_mnu_title }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    @if (isset($user_sub_menu->select_opt))
                                                        @if ($user_sub_menu->select_opt == 1)
                                                            <input class="form-check-input" type="checkbox" name="txt_add"
                                                                id="txt_add" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="txt_add"
                                                                id="txt_add">
                                                        @endif
                                                    @else
                                                        <input class="form-check-input" type="checkbox" name="txt_add"
                                                            id="txt_add">
                                                    @endif
                                                    <label class="form-check-label" for="txt_add"> Add </label>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    @if (isset($user_sub_menu->edit_opt))
                                                        @if ($user_sub_menu->edit_opt == 1)
                                                            <input class="form-check-input" type="checkbox" name="txt_edit"
                                                                id="txt_edit" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="txt_edit"
                                                                id="txt_edit">
                                                        @endif
                                                    @else
                                                        <input class="form-check-input" type="checkbox" name="txt_edit"
                                                            id="txt_edit">
                                                    @endif
                                                    <label class="form-check-label" for="txt_edit">Edit </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    @if (isset($user_sub_menu->delete_opt))
                                                        @if ($user_sub_menu->delete_opt == 1)
                                                            <input class="form-check-input" type="checkbox" name="txt_view"
                                                                id="txt_view" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="txt_view"
                                                                id="txt_view">
                                                        @endif
                                                    @else
                                                        <input class="form-check-input" type="checkbox" name="txt_view"
                                                            id="txt_view">
                                                    @endif
                                                    <label class="form-check-label" for="txt_view">View</label>
                                                </div>
                                            </td>
                                            <td>
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

                                            <td>
                                                <button type="submit" class="btn bg-primary">Submit</button>
                                            </td>

                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
