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
                                <th>Exame Title</th>
                                <th>Group</th>
                                <th>Result</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            $ci_employee_edu=DB::table('pro_employee_edu')
                            ->Where('employee_id',$emp_id)
                            ->Where('valid','1')
                            ->get();
                            @endphp
                            @foreach($ci_employee_edu as $xy=>$row)
                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->institute }}</td>
                                <td>{{ $row->exame_title }}</td>
                                <td>{{ $row->edu_group }}</td>
                                <td>{{ $row->result }}</td>
                                <td>{{ $row->passing_year }}</td>
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
