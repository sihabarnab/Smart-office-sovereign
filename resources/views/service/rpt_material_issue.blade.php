@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Issue</h1>
                    {{ $form }} To {{ $to }}.
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rpt_search_requation') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" onfocus="(this.type='date')">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-5">
                                    <input type="text" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" onfocus="(this.type='date')">
                                    @error('txt_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($search_requisition_master))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Req No.<br>Date</th>
                                        <th>Task Assign No.<br>Date</th>
                                        <th>Team<br>Team Leader</th>
                                        <th>Client<br>Project</th>
                                        <th>Lift</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($search_requisition_master as $key => $row_req_master)
                                        @php
                                            $ci_complaint_register = DB::table('pro_complaint_register')
                                                ->Where('complaint_register_id', $row_req_master->complain_id)
                                                ->first();
                                            $txt_complaint_description = $ci_complaint_register->complaint_description;
                                            $txt_complain_date = $ci_complaint_register->entry_date;

                                            $ci_task_assign = DB::table('pro_task_assign')
                                                ->Where('task_id', $row_req_master->task_id)
                                                ->first();
                                            $txt_task_date = $ci_task_assign->entry_date;
                                            $txt_task_time = $ci_task_assign->entry_time;
                                            $txt_task_remark = $ci_task_assign->remark;

                                            $ci_customers = DB::table('pro_customers')
                                                ->Where('customer_id', $ci_complaint_register->customer_id)
                                                ->first();
                                            $txt_customer_name = $ci_customers->customer_name;

                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $ci_complaint_register->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;

                                            $ci_lifts = DB::table('pro_lifts')
                                                ->Where('lift_id', $ci_complaint_register->lift_id)
                                                ->first();
                                            $txt_lift_name = $ci_lifts->lift_name;
                                            $txt_lift_remark = $ci_lifts->remark;

                                            $ci_teams = DB::table('pro_teams')
                                                ->Where('team_leader_id', $row_req_master->team_leader_id)
                                                ->first();
                                            $txt_team_name = $ci_teams->team_name;

                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $row_req_master->team_leader_id)
                                                ->first();
                                            $txt_team_leader_name = $ci_employee_info->employee_name;

                                          

                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_req_master->smi_master_id }}<br>{{ $row_req_master->entry_date }} <br> {{ $row_req_master->entry_time }}</td>
                                            <td>{{ $row_req_master->task_id }}<br>{{ $txt_task_date }} <br>{{ $txt_task_time }}  <br>{{ $txt_task_remark }} </td>
                                            <td>{{ $txt_team_name }}<br>{{ $txt_team_leader_name }}</td>
                                            <td>{{ $txt_customer_name }}<br>{{ $txt_project_name }}</td>
                                            <td>{{ $txt_lift_name }}<br>{{ $txt_lift_remark }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('rpt_requisition_details', $row_req_master->smi_master_id) }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                        <th>Req No.<br>Date</th>
                                        <th>Task Assign No.<br>Date</th>
                                        <th>Team<br>Team Leader</th>
                                        <th>Client<br>Project</th>
                                        <th>Lift</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_requisition_master as $key => $row_req_master)
                                        @php
                                            $ci_complaint_register = DB::table('pro_complaint_register')
                                                ->Where('complaint_register_id', $row_req_master->complain_id)
                                                ->first();
                                            $txt_complaint_description = $ci_complaint_register->complaint_description;
                                            $txt_complain_date = $ci_complaint_register->entry_date;

                                            $ci_task_assign = DB::table('pro_task_assign')
                                                ->Where('task_id', $row_req_master->task_id)
                                                ->first();
                                            $txt_task_date = $ci_task_assign->entry_date;
                                            $txt_task_time = $ci_task_assign->entry_time;
                                            $txt_task_remark = $ci_task_assign->remark;

                                            $ci_customers = DB::table('pro_customers')
                                                ->Where('customer_id', $ci_complaint_register->customer_id)
                                                ->first();
                                            $txt_customer_name = $ci_customers->customer_name;

                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $ci_complaint_register->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;

                                            $ci_lifts = DB::table('pro_lifts')
                                                ->Where('lift_id', $ci_complaint_register->lift_id)
                                                ->first();
                                            $txt_lift_name = $ci_lifts->lift_name;
                                            $txt_lift_remark = $ci_lifts->remark;

                                            $ci_teams = DB::table('pro_teams')
                                                ->Where('team_leader_id', $row_req_master->team_leader_id)
                                                ->first();
                                            $txt_team_name = $ci_teams->team_name;

                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $row_req_master->team_leader_id)
                                                ->first();
                                            $txt_team_leader_name = $ci_employee_info->employee_name;

                                           
                                          

                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_req_master->smi_master_id }}<br>{{ $row_req_master->entry_date }} <br> {{ $row_req_master->entry_time }}
                                            </td>
                                            <td>{{ $row_req_master->task_id }}<br>{{ $txt_task_date }} <br>
                                                {{ $txt_task_time }}
                                                 <br>{{ $txt_task_remark }}</td>
                                            <td>{{ $txt_team_name }}<br>{{ $txt_team_leader_name }}</td>
                                            <td>{{ $txt_customer_name }}<br>{{ $txt_project_name }}</td>
                                            <td>{{ $txt_lift_name }}<br>{{ $txt_lift_remark }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('rpt_requisition_details', $row_req_master->smi_master_id) }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
