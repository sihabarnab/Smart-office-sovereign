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
                                <th>Supplier Name</th>
                                <th>Address</th>
                                <th>Contact Person<br />Contact No.</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $key=>$row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->supplier_name }}</td>
                                <td>{{ $row->supplier_add }}<BR>{{ $row->supplier_email }}</td>
                                <td>{{ $row->contact_person }}<BR>{{ $row->supplier_phone }}</td>
                                <td>
                                    <a href="{{ route('supplier_info_edit', $row->supplier_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
