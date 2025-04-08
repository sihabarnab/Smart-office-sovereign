@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task List</h1>
                    {{ $form }} To {{ $to }}.
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
                        <form action="{{ route('mt_rpt_search_task') }}" method="GET">
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

    @if (isset($search_task))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Task No.</th>
                                        <th>Client<br>Project</th>
                                        <th>Complain</th>
                                        <th>Team <br> Leader</th>
                                        <th>Remark</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($search_task as $key => $mt_task_assign)
                                        @php
                                            $ci_customers = DB::table('pro_customers')
                                                ->Where('customer_id', $mt_task_assign->customer_id)
                                                ->first();
                                            $txt_customer_name = $ci_customers->customer_name;
                                            
                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $mt_task_assign->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;
                                            
                                            $ci_lifts = DB::table('pro_lifts')
                                                ->Where('lift_id', $mt_task_assign->lift_id)
                                                ->first();
                                            $txt_lift_name = $ci_lifts->lift_name;
                                            $txt_lift_remark = $ci_lifts->remark;

                                            $ci_complaint_register = DB::table('pro_complaint_register')
                                                ->Where('complaint_register_id', $mt_task_assign->complain_id)
                                                ->first();
                                            $txt_complaint_description = $ci_complaint_register->complaint_description;
                                            $txt_complain_date = $ci_complaint_register->entry_date;
                                            
                                            $ci_teams = DB::table('pro_teams')
                                                ->Where('team_id', $mt_task_assign->team_id)
                                                ->first();
                                            $txt_team_name = $ci_teams->team_name;
                                            
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $mt_task_assign->team_leader_id)
                                                ->first();
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                            
                                            
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $mt_task_assign->complain_id }} <br> {{ $txt_complain_date }}</td>
                                            <td>{{ $txt_customer_name }} <br> {{ $txt_project_name }} </td>
                                            <td>{{ $txt_lift_name }}<br>{{ $txt_complaint_description }}</td>
                                            <td>{{ $txt_team_name }} <br> {{ $txt_team_leader_name }}</td>
                                            <td>

                                                {{ $mt_task_assign->remark ? $mt_task_assign->remark : '' }}

                                            </td>
                                            <td>
                                                <a target="__blanck"
                                                    href="{{ route('mt_rpt_task_view', $mt_task_assign->task_id) }}">View</a>
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
                                        <th>Com. No.</th>
                                        <th>Client<br>Project</th>
                                        <th>Complain</th>
                                        <th>Team <br> Leader</th>
                                        <th>Remark</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        
                                    @endphp
                                    @foreach ($mt_task_assigns as $key => $mt_task_assign)
                                        @php
                                            $ci_customers = DB::table('pro_customers')
                                                ->Where('customer_id', $mt_task_assign->customer_id)
                                                ->first();
                                            $txt_customer_name = $ci_customers->customer_name;
                                            
                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $mt_task_assign->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;
                                            
                                            $ci_lifts = DB::table('pro_lifts')
                                                ->Where('lift_id', $mt_task_assign->lift_id)
                                                ->first();
                                            $txt_lift_name = $ci_lifts->lift_name;
                                            $txt_lift_remark = $ci_lifts->remark;

                                            $ci_complaint_register = DB::table('pro_complaint_register')
                                                ->Where('complaint_register_id', $mt_task_assign->complain_id)
                                                ->first();
                                            $txt_complaint_description = $ci_complaint_register->complaint_description;
                                            $txt_complain_date = $ci_complaint_register->entry_date;
                                            
                                            $ci_teams = DB::table('pro_teams')
                                                ->Where('team_id', $mt_task_assign->team_id)
                                                ->first();
                                            $txt_team_name = $ci_teams->team_name;
                                            
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $mt_task_assign->team_leader_id)
                                                ->first();
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                           
                                            // if()
                                        @endphp
                                        <tr >
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $mt_task_assign->complain_id }} <br> {{ $txt_complain_date }}</td>
                                            <td>{{ $txt_customer_name }} <br>{{ $txt_project_name }}</td>
                                            <td>{{ $txt_lift_name }}<br>{{  $txt_complaint_description }}</td>
                                            <td>{{ $txt_team_name }} <br> {{ $txt_team_leader_name }}</td>
                                            <td>

                                                {{ $mt_task_assign->remark ? $mt_task_assign->remark : '' }}

                                            </td>
                                            <td>
                                                <a target="__blanck"
                                                    href="{{ route('mt_rpt_task_view', $mt_task_assign->task_id) }}">View</a>
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

@section('script')
@endsection
