<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Com. No.</th>
                                <th>Client</th>
                                <th>Project</th>
                                <th>Lift</th>
                                <th>complain</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($m_complaint_register as $key => $row_complaint_register)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row_complaint_register->complaint_register_id }}</td>
                                    <td>{{ $row_complaint_register->customer_name }}</td>
                                    <td>{{ $row_complaint_register->project_name }}</td>
                                    <td>{{ $row_complaint_register->lift_name }}<br>{{ $row_complaint_register->remark }}</td>
                                    <td>{{ $row_complaint_register->complaint_description }}</td>
                                    <td>
                                       <a href="{{route('mt_complaint_register_edit',$row_complaint_register->complaint_register_id)}}"class="btn btn-info btn-sm"><i
                                                class="fas fa-edit"></i></a>
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
