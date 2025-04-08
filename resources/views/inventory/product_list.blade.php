<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Information</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Size</th>
                                <th>Origin</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $key => $row)
                                @php

                                    $ci_units = DB::table('pro_units')
                                        ->Where('unit_id', $row->unit_id)
                                        ->first();
                                    $txt_unit_name = $ci_units->unit_name;

                                    if ($row->size_id == '0') {
                                        $txt_size_name = 'N/A';
                                    } else {
                                        $ci_sizes = DB::table('pro_sizes')
                                            ->Where('size_id', $row->size_id)
                                            ->first();
                                        $txt_size_name = $ci_sizes->size_name;
                                    }

                                    if ($row->origin_id == '0') {
                                        $txt_origin_name = 'N/A';
                                    } else {
                                        $ci_origins = DB::table('pro_origins')
                                            ->Where('origin_id', $row->origin_id)
                                            ->first();
                                        $txt_origin_name = $ci_origins->origin_name;
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $txt_unit_name }}</td>
                                    <td>{{ $txt_size_name }}</td>
                                    <td>{{ $txt_origin_name }}</td>
                                    <td>{{ $row->product_des }}</td>
                                    <td>
                                        <a href="{{ route('inventoryproductedit', $row->product_id) }}"
                                            class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
