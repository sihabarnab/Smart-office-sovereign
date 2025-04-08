<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bio Device List</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Bio Device</th>
                                <th>Place of Posting</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $key=>$row)
                            @php
                            $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row->placeofposting_id)->first();
                            $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->biodevice_name }}</td>
                                <td>{{ $txt_placeofposting_name }}</td>
                                <td>
                                    <a href="{{ route('hrmbackbio_deviceedit', $row->biodevice_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
