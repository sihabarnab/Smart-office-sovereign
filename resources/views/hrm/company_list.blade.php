<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Company Information</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Company Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $key=>$row)
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->company_name }}</td>
                                <td>{{ $row->company_add }}, {{ $row->company_city}} <br>{{ $row->company_zip }} <br>{{ $row->company_country }}</td>
                                <td> {{ $row->company_phone }} <br> {{ $row->company_mobile }} <br> {{ $row->company_email }}</td>
                                <td>
                                    <a href="{{ route('hrmbackcompanyedit', $row->company_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
