<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Task Date/Time</th>
                                <th>Client/Project</th>
                                <th>Lift</th>
                                <th>Team/Leader</th>
                                <th>Remark</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mt_task_assign as  $key=>$row)

                            @php
                            $ci_customers=DB::table('pro_customers')->Where('customer_id',$row->customer_id)->first();
                            $txt_customer_name=$ci_customers->customer_name;

                            $ci_projects=DB::table('pro_projects')->Where('project_id',$row->project_id)->first();
                            $txt_project_name=$ci_projects->project_name;

                            $ci_lifts=DB::table('pro_lifts')->Where('lift_id',$row->lift_id)->first();
                            $txt_lift_name=$ci_lifts->lift_name;
                            $txt_lift_remark=$ci_lifts->remark;

                            $ci_teams=DB::table('pro_teams')->Where('team_id',$row->team_id)->first();
                            $txt_team_name=$ci_teams->team_name;

                            $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$ci_teams->team_leader_id)->first();
                            $txt_team_leader_name=$ci_employee_info->employee_name;

                            $journey = DB::table('pro_journey')->where('task_id', $row->task_id)->orderByDesc('journey_id')->first();

                            @endphp
                                <tr>
                                    <td >{{ $key+1 }}</td>
                                    <td>{{ $row->task_id }} <br> {{ $row->entry_date }} <br> {{ $row->entry_time }}</td>
                                    <td>{{ $txt_customer_name }} <br> {{ $txt_project_name }}</td>
                                    <td>{{ $txt_lift_name }}<br>{{ $txt_lift_remark }}</td>
                                    <td>{{ $txt_team_name }} <br> {{ $txt_team_leader_name }}</td>
                                    <td>{{ $row->remark }}</td>
                                    <td>
                                    @if(isset($journey))
                                    @else
                                    <a href="{{ route('task_assign_edit', $row->task_id) }}"class="btn btn-info btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                    @endif
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