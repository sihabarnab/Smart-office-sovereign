@extends('layouts.mechanical_app')
@section('content')


    <div class="container-fluid mt-2">
        @include('flash-message')
    </div>

    @if (isset($edit_helper))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('mech_update_helper', $edit_helper->id) }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                            <option value="">--Select Helper--</option>
                                            @foreach ($helper as $row)
                                                <option value="{{ $row->employee_id }}"
                                                    {{ $row->employee_id == $edit_helper->helper_id ? 'selected' : '' }}>
                                                    {{ $row->employee_id }}|{{ $row->employee_name }}({{ $row->department_name }}) </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_employee_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-10 col-md-6 col-sm-3 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-9 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block float-right">Update
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @php
            $ci_customers = DB::table('pro_customers')
                ->Where('customer_id', $mt_task_assign->customer_id)
                ->first();
            $txt_customer_name = $ci_customers->customer_name;

            $ci_projects = DB::table('pro_projects')
                ->Where('project_id', $mt_task_assign->project_id)
                ->first();
            $txt_project_name = $ci_projects->project_name;

            $ci_complain = DB::table('pro_complaint_register')
                ->Where('complaint_register_id', $mt_task_assign->complain_id)
                ->first();

            $ci_lifts = DB::table('pro_lifts')
                ->Where('lift_id', $mt_task_assign->lift_id)
                ->first();
            $txt_lift_name = $ci_lifts->lift_name;
            $txt_lift_remark = $ci_lifts->remark;

            $ci_employee_info = DB::table('pro_employee_info')
                ->Where('employee_id', $mt_task_assign->team_leader_id)
                ->first();
            $txt_team_leader_name = $ci_employee_info->employee_name;
        @endphp

        <div class="content-header">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-3">Project</div>
                            <div class="col-3">Complain</div>
                            <div class="col-3">Client</div>
                            <div class="col-3">Team</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">{{ $txt_project_name }}</div>
                            <div class="col-3">
                                {{ $ci_complain->complaint_description ? $ci_complain->complaint_description : '' }} |
                                {{ $txt_lift_name }}</div>
                            <div class="col-3">{{ $txt_customer_name }}</div>
                            <div class="col-3"> {{ $txt_team_leader_name }}</div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('mech_add_helper', $mt_task_assign->task_id) }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                            <option value="">--Select Helper--</option>
                                            @foreach ($helper as $row)
                                                <option value="{{ $row->employee_id }}">
                                                    {{ $row->employee_id }}|{{ $row->employee_name }} </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_employee_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-12 col-sm-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block float-right">Add
                                            More</button>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        @php
                                            $check = DB::table('pro_helpers')
                                                ->where('task_id', $mt_task_assign->task_id)
                                                ->first();
                                        @endphp
                                        @if ($check)
                                            <a href="{{ route('mech_task_assign_final') }}"
                                                class="btn btn-primary btn-block float-right">Final</a>
                                        @else
                                            <button class="btn btn-primary btn-block float-right" disabled>Final</button>
                                        @endif
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">

                                        <a href="{{ route('mech_task_assign') }}"
                                            class="btn btn-primary btn-block float-right">Skip</a>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('mechanical.helper_list')
    @endif
@endsection
