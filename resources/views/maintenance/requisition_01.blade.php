@extends('layouts.maintenance_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task List for Requisition</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($ms_task_assign))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                {{-- <h5>{{ 'Add' }}</h5> --}}
                            </div>
                            <form action="{{ route('requisition_store', $ms_task_assign->task_id) }}" method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-4">
                                        @php
                                            $customer = DB::table('pro_customers')
                                                ->where('customer_id', $ms_task_assign->customer_id)
                                                ->first();
                                        @endphp
                                        <input type="text" name="txt_customer_id" id="txt_customer_id"
                                            value="{{ $customer->customer_name }}" class="form-control" readonly>
                                    </div>
                                    <div class="col-4">
                                        @php
                                            $project = DB::table('pro_projects')
                                                ->where('project_id', $ms_task_assign->project_id)
                                                ->first();
                                        @endphp
                                        <input type="text" name="txt_project_id" id="txt_project_id"
                                            value="{{ $project->project_name }}" class="form-control" readonly>
                                    </div>
                                    <div class="col-4">
                                        @php
                                            $lift = DB::table('pro_lifts')
                                                ->where('lift_id', $ms_task_assign->lift_id)
                                                ->first();
                                        @endphp
                                        <input type="text" name="txt_lift_id" id="txt_lift_id"
                                            value="{{ $lift->lift_name }} | {{ $lift->remark }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-5">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Next</button>
                                    </div>
                                    <div class="col-5">
                                        &nbsp;
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
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Client</th>
                                        <th>Project</th>
                                        <th>Task No.</th>
                                        <th>Lift</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_task_assign as $key => $row)
                                        @php
                                            $ci_customers = DB::table('pro_customers')
                                                ->Where('customer_id', $row->customer_id)
                                                ->first();
                                            $txt_customer_name = $ci_customers->customer_name;
                                            
                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $row->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;
                                            
                                            $ci_lifts = DB::table('pro_lifts')
                                                ->Where('lift_id', $row->lift_id)
                                                ->first();
                                            $txt_lift_name = $ci_lifts->lift_name;
                                            $txt_lift_remark = $ci_lifts->remark;
                                            
                                            $ci_teams = DB::table('pro_teams')
                                                ->Where('team_id', $row->team_id)
                                                ->first();
                                            $txt_team_name = $ci_teams->team_name;
                                            
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $row->team_leader_id)
                                                ->first();
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                            //
                                            $m_user_id = Auth::user()->emp_id;
                                            $req_master = DB::table('pro_requisition_master')
                                                ->where('team_leader_id', $m_user_id)
                                                ->where('complain_id', $row->complain_id)
                                                ->where('status', 3)
                                                ->where('valid', 1)
                                                ->first();
                                            
                                        @endphp
                                        @if (isset($req_master))
                                        @else
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $txt_customer_name }}</td>
                                                <td> {{ $txt_project_name }}</td>
                                                <td> {{ $row->complain_id }}</td>
                                                <td> {{ $txt_lift_name }} | {{ $txt_lift_remark }}</td>
                                                <td>
                                                    <a href="{{ route('create_requisition', $row->task_id) }}">Create
                                                        Requisition </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- @include('service.requisition_list_01') --}}

@endsection
