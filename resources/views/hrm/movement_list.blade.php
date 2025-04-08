<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class=""><h5><?="Movement Application List"; ?></h5></div>
                    <table id="data2" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Description</th>
                                <th>Approved<br>Date</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_late_inform_master as $key=>$row_late_app)
                            @php
                            $ci_late_type=DB::table('pro_late_type')->Where('valid','1')->Where('late_type_id',$row_late_app->late_type_id)->first();

                            $ci_late_status=DB::table('pro_late_inform_master')->Where('late_inform_master_id',$row_late_app->late_inform_master_id)->first();

                            if($ci_late_status->status=='1')
                            {
                                $txt_late_status="Pending";
                            }
                            else if($ci_late_status->status=='2')
                            {
                                $txt_late_status="Approved";
                            }
                            else if($ci_late_status->status=='3')
                            {
                                $txt_late_status="Cancel";
                            }
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ci_late_type->late_type }}</td>
                                <td>{{ $row_late_app->entry_date }}<br>{{ $row_late_app->entry_time }}</td>
                                <td>{{ $row_late_app->late_form }} to {{ $row_late_app->late_to }}<br>{{ $row_late_app->late_total }} day</td>
                                <td>{{ $row_late_app->purpose_late }}</td>
                                <td>{{ $row_late_app->approved_date }}</td>
                                <td>{{ $txt_late_status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>