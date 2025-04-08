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
                                <th>SL</th>
                                <th>Leave Type</th>
                                <th>Short Name</th>
                                <th>Days</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_leave_config as $key=>$row_leave_config)
                            @php
                            //$aa='yyyy';
                            // $txt_joinning_date=date("d-m-Y",strtotime("$row->joinning_date"));

                            $ci_leave_type=DB::table('pro_leave_type')->Where('leave_type_id',$row_leave_config->leave_type_id)->first();
                            // dd($ci_leave_type);
                            $txt_leave_type=$ci_leave_type->leave_type;
                            $txt_leave_type_sname=$ci_leave_type->leave_type_sname;


                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_leave_type }}</td>
                                <td>{{ $txt_leave_type_sname }}</td>
                                <td>{{ $row_leave_config->leave_days }}</td>
                                <td>
                                    <a href="{{ route('hrmbackleave_configedit',$row_leave_config->leave_config_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
