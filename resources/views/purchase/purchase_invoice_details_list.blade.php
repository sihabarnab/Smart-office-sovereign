<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Origin</th>
                                <th class="text-right">Product QTY</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sum = 0;
                            @endphp
                            @foreach ($m_purchase_details as $key => $row)
                                @php
                                    $ci_product = DB::table('pro_product')
                                        ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                                        ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                                        ->select('pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
                                        ->where('pro_product.product_id', $row->product_id)
                                        ->where('pro_product.valid', 1)
                                        ->first();
                                    $txt_product_name = $ci_product->product_name;

                                    $unit = DB::table('pro_units')
                                        ->where('unit_id', $ci_product->unit_id)
                                        ->first();
                                    $unit_name = $unit->unit_name;
                                    $sum = $sum + $row->qty;
                                @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $txt_product_name }}</td>
                                    <td>
                                        @isset($ci_product->product_des)
                                            {{ $ci_product->product_des }}
                                        @endisset
                                        @isset($ci_product->size_name)
                                            <br> {{ $ci_product->size_name }}
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($ci_product->origin_name)
                                            {{ $ci_product->origin_name }}
                                        @endisset
                                    </td>
                                    <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                    <td>{{ $unit_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total:</td>
                                <td colspan="1" class="text-right">{{ number_format($sum, 2) }}</td>
                                <td colspan="1"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
