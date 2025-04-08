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
                                <th>Organization</th>
                                <th>Address</th>
                                <th>Designation</th>
                                <th>Job Responsibilities</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            $ci_employee_experiance =DB::table('pro_employee_experiance')
                            ->Where('employee_id',$emp_id)
                            ->Where('valid','1')
                            ->get();
                            @endphp
                            @foreach($ci_employee_experiance as $xy=>$row)
                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->organization }}</td>
                                <td>{{ $row->address }}</td>
                                <td>{{ $row->designation }}</td>
                                <td>{{ $row->responsibilities }}</td>
                                <td>{{ $row->start_date }}</td>
                                <td>{{ $row->end_date }}</td>
                            </tr>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
