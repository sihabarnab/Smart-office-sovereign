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
                                <th>Institute</th>
                                <th>Address</th>
                                <th>Course Name</th>
                                <th>Start date</th>
                                <th>End date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            $ci_employee_training=DB::table('pro_employee_training')
                            ->Where('employee_id',$emp_id)
                            ->Where('valid','1')
                            ->get();
                            @endphp
                            @foreach($ci_employee_training as $xy=>$row)
                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->institute }}</td>
                                <td>{{ $row->address }}</td>
                                <td>{{ $row->traning_title }}</td>
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
