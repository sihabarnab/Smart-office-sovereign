<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product</th>
                                <th>Product Description</th>
                                <th>Origin</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($d_challan_details as $key => $row)
                                @php
                                    $product = DB::table('pro_product')
                                        ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                                        ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                                        ->select('pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
                                        ->Where('product_id', $row->product_id)
                                        ->first();
                                    $unit = DB::table('pro_units')
                                        ->where('unit_id', $product->unit_id)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        @isset($product->product_des)
                                            {{ $product->product_des }}
                                        @endisset
                                        @isset($product->size_name)
                                            -{{ $product->size_name }}
                                        @endisset
                                    </td>
                                    <td>{{ $product->origin_name }}</td>
                                    <td>{{ $row->del_qty }}</td>
                                    <td>{{ $unit->unit_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
