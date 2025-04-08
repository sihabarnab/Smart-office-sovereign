<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Sub Group Information</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Group Name</th>
                                <th>Sub Group Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $key=>$row)
                            @php
                            $ci_product_group=DB::table('pro_product_group')->Where('pg_id',$row->pg_id)->first();
                            $txt_pg_name=$ci_product_group->pg_name;

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_pg_name }}</td>
                                <td>{{ $row->pg_sub_name }}</td>
                                <td>
                                    <a href="{{ route('inventorypgsubedit', $row->pg_sub_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
