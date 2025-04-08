@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task Re-Assign</h1>
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
                        {{-- <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div> --}}
                        <form action="{{ route('mt_task_assign_update', $mt_task_assigns->task_id) }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_complain_id" id="cbo_complain_id" class="form-control">
                                        @php
                                            $row_complaint_register = DB::table('pro_complaint_register')
                                                ->leftJoin(
                                                    'pro_customers',
                                                    'pro_customers.customer_id',
                                                    'pro_complaint_register.customer_id',
                                                )
                                                ->leftJoin(
                                                    'pro_projects',
                                                    'pro_projects.project_id',
                                                    'pro_complaint_register.project_id',
                                                )
                                                ->leftJoin(
                                                    'pro_lifts',
                                                    'pro_lifts.lift_id',
                                                    'pro_complaint_register.lift_id',
                                                )
                                                ->select(
                                                    'pro_complaint_register.*',
                                                    'pro_customers.customer_name',
                                                    'pro_projects.project_name',
                                                    'pro_lifts.lift_name',
                                                )
                                                
                                                ->where('pro_complaint_register.complaint_register_id',$mt_task_assigns->complain_id)
                                                ->first();
                                        @endphp
                                            <option value="{{ $row_complaint_register->complaint_register_id }}">
                                                {{ $row_complaint_register->complaint_register_id }}|
                                                {{ $row_complaint_register->lift_name }} |
                                                {{ $row_complaint_register->project_name }} |
                                                {{ $row_complaint_register->customer_name }} |
                                                {{ $row_complaint_register->complaint_description }} | Date:
                                                {{ $row_complaint_register->entry_date }} |
                                                Time: {{ $row_complaint_register->entry_time }}
                                            </option>
                                    </select>
                                    @error('cbo_complain_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_team_id" id="cbo_team_id" class="form-control">
                                        <option value="0">--Select Team--</option>
                                        @php
                                            $m_teams = DB::table('pro_teams')
                                                ->leftJoin(
                                                    'pro_employee_info',
                                                    'pro_teams.team_leader_id',
                                                    'pro_employee_info.employee_id',
                                                )
                                                ->leftJoin(
                                                    'pro_department',
                                                    'pro_employee_info.department_id',
                                                    'pro_department.department_id',
                                                )
                                                ->select(
                                                    'pro_teams.*',
                                                    'pro_employee_info.employee_name',
                                                    'pro_department.department_name',
                                                )
                                                ->get();
                                        @endphp
                                        @foreach ($m_teams as $team)
                                            <option value="{{ $team->team_id }}"
                                                {{ $team->team_id == $mt_task_assigns->team_id ? 'selected' : '' }}>
                                                {{ $team->team_name }}|{{ $team->employee_name }}
                                                ({{ $team->department_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_team_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <input type="text" name="txt_remark" id="txt_remark" class="form-control"
                                        value="{{ $mt_task_assigns->remark }}" placeholder="Remark">
                                    @error('txt_remark')
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
                                        class="btn btn-primary btn-block float-right">Re-Assign</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
