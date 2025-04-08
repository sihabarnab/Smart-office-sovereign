@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task Assign</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_task_assign))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form action="{{ route('mt_task_assign_update', $m_task_assign->task_id) }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_complain_id" id="cbo_complain_id" class="form-control">
                                            <option value="0">--Select Complain--</option>
                                            @foreach ($m_complaint_register as $row_complaint_register)
                                                <option value="{{ $row_complaint_register->complaint_register_id }}"
                                                    {{ $row_complaint_register->complaint_register_id == $m_task_assign->complain_id ? 'selected' : '' }}>
                                                    {{ $row_complaint_register->complaint_register_id }}|
                                                    {{ $row_complaint_register->lift_name }} | {{ $row_complaint_register->project_name }} |
                                                    {{ $row_complaint_register->customer_name }} |  {{$row_complaint_register->complaint_description}} | Date: {{$row_complaint_register->entry_date}} | 
                                                    Time: {{$row_complaint_register->entry_time}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_complain_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_team_id" id="cbo_team_id" class="form-control">
                                            <option value="0">--Select Team--</option>
                                            @foreach ($m_teams as $team)
                                                <option value="{{ $team->team_id }}"
                                                    {{ $team->team_id == $m_task_assign->team_id ? 'selected' : '' }}>
                                                    {{ $team->team_name }}|{{ $team->employee_name }} ({{$team->department_name}})
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
                                            value="{{ $m_task_assign->remark }}" placeholder="Remark">
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
                                            class="btn btn-primary btn-block float-right">Update</button>
                                    </div>
                                </div>
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('mt_task_assign_store') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_complain_id" id="cbo_complain_id" class="form-control">
                                            <option value="0">--Select Complain--</option>
                                            @foreach ($m_complaint_register as $row_complaint_register)
                                                @php
                                                    $ci_customer = DB::table('pro_customers')
                                                        ->Where('customer_id', $row_complaint_register->customer_id)
                                                        ->first();
                                                    $se_projects = DB::table('pro_projects')
                                                        ->Where('project_id', $row_complaint_register->project_id)
                                                        ->first();
                                                    $se_lift = DB::table('pro_lifts')
                                                        ->Where('lift_id', $row_complaint_register->lift_id)
                                                        ->first();

                                                @endphp
                                                <option value="{{ $row_complaint_register->complaint_register_id }}">
                                                    {{ $row_complaint_register->complaint_register_id }}|
                                                    {{ $se_lift->lift_name }} | {{ $se_projects->project_name }} |
                                                    {{ $ci_customer->customer_name }} |  {{$row_complaint_register->complaint_description}} | Date: {{$row_complaint_register->entry_date}} | 
                                                    Time: {{$row_complaint_register->entry_time}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_complain_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_team_id" id="cbo_team_id" class="form-control">
                                            <option value="0">--Select Team--</option>
                                            @foreach ($m_teams as $row_team)
                                                <option value="{{ $row_team->team_id }}">
                                                    {{ $row_team->team_name }} | {{ $row_team->employee_name }} ({{$row_team->department_name}})
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
                                            value="{{ old('txt_remark') }}" placeholder="Remark">
                                        @error('txt_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-6 col-sm-3 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block float-right">Next</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('maintenance.task_assign_list')
    @endif

@endsection
