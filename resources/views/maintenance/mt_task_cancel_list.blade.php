@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task Cancel List</h1>
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
                            <table id="task_cancel_data" class="table table-bordered table-striped table-sm">
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
                                                <a 
                                                    href="{{ route('mt_task_reassign', $mt_task_assign->task_id) }}">reassign</a>
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



@endsection

@section('script')
<script>
    $(function() {
        $("#task_cancel_data").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 100,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');

    });
</script>
@endsection
