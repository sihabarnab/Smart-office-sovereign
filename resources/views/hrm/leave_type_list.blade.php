<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Leave Type</th>
                                <th>Short Name</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_leave_type as $key=>$row_leave_type)
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_leave_type->leave_type }}</td>
                                <td>{{ $row_leave_type->leave_type_sname }}</td>
                                <td>
                                    <a href="{{ route('hrmbackleave_typeedit',$row_leave_type->leave_type_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
