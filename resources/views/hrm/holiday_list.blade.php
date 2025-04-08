<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Holiday List</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Holiday Name</th>
                                <th>Holiday Year</th>
                                <th>Holiday Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $key=>$row)
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->holiday_name }}</td>
                                <td>{{ $row->holiday_year }}</td>
                                <td>{{ $row->holiday_date }}</td>
                                <td>
                                    <a href="{{ route('hrmbackholidayedit', $row->holiday_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
