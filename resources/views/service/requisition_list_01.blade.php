<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Req No.</th>
                                <th>Task No.</th>
                                <th>task_assign_id</th>
                                <th>status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($m_requisition_master as  $key=>$row_req_master)

{{--                             @php
                            $ci_customers=DB::table('pro_customers')->Where('customer_id',$row->customer_id)->first();
                            $txt_customer_name=$ci_customers->customer_name;

                            $ci_projects=DB::table('pro_projects')->Where('project_id',$row->project_id)->first();
                            $txt_project_name=$ci_projects->project_name;

                            $ci_lifts=DB::table('pro_lifts')->Where('lift_id',$row->lift_id)->first();
                            $txt_lift_name=$ci_lifts->lift_name;
                            $txt_lift_remark=$ci_lifts->remark;

                            $ci_teams=DB::table('pro_teams')->Where('team_id',$row->team_id)->first();
                            $txt_team_name=$ci_teams->team_name;

                            $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->team_leader_id)->first();
                            $txt_team_leader_name=$ci_employee_info->employee_name;

                            @endphp
 --}}                                <tr>
                                    <td >{{ $key+1 }}</td>
                                    <td>{{ $row_req_master->requisition_master_id }}</td>
                                    <td>{{ $row_req_master->complain_id }}</td>
                                    <td>{{ $row_req_master->task_assign_id }}</td>
                                    <td>{{ $row_req_master->status }}</td>
                                    <td>
                                    &nbsp;
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