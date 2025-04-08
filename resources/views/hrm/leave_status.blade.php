<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                              <th>SL No</th>
                              <th>Leave Type</th>
                              <th>Short Name</th>
                              <th>Total Leave</th>
                              <th>Availed Leave</th>
                              <th>Available Leave</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_leave_config_01 as $key=>$row_leave_config_01)
                            @php
                            $mentrydate=time();
                            $m_leave_year=date("Y",$mentrydate);

                            $ci_leave_type=DB::table('pro_leave_type')->Where('leave_type_id',$row_leave_config_01->leave_type_id)->first();
                            // dd($ci_leave_type);
                            $txt_leave_type=$ci_leave_type->leave_type;
                            $txt_leave_type_sname=$ci_leave_type->leave_type_sname;

                            $ci_pro_leave_info_master=DB::table('pro_leave_info_master')->Where('leave_type_id',$row_leave_config_01->leave_type_id)->where('employee_id',Auth::user()->emp_id)->where('valid',1)->where('status',2)->where('leave_year',$m_leave_year)->orderby('leave_type_id')->get();

                            $m_avail_day = collect($ci_pro_leave_info_master)->sum('g_leave_total'); // 60

                            // dd($sum);

                            $m_available=$row_leave_config_01->leave_days-$m_avail_day;
                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_leave_type }}</td>
                                <td>{{ $txt_leave_type_sname }}</td>
                                <td>{{ $row_leave_config_01->leave_days }}</td>
                                <td>{{ $m_avail_day }}</td>
                                <td>{{ $m_available }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
