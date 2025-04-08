<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Product Group</th>
                                <th class="text-left align-top">Product Sub Group</th>
                                <th class="text-left align-top">Product Name </th>
                                <th class="text-left align-top">Qty</th>
                                <th class="text-left align-top">Unit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mi_details as $key => $value)
                                @php
                                    $ci_product_group = DB::table('pro_product_group')
                                        ->Where('pg_id', $value->pg_id)
                                        ->first();
                                    $txt_pg_name = $ci_product_group->pg_name;

                                    $ci_product_sub_group = DB::table('pro_product_sub_group')
                                        ->Where('pg_sub_id', $value->pg_sub_id)
                                        ->first();
                                    $txt_pg_sub_name = $ci_product_sub_group->pg_sub_name;

                                    $ci_product = DB::table('pro_product')
                                        ->Where('product_id', $value->product_id)
                                        ->first();
                                    $txt_product_name = $ci_product->product_name;
                                    $unit = DB::table('pro_units')
                                        ->where('unit_id', $value->unit_id)
                                        ->first();
                                    $unit_name = $unit->unit_name;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{  $txt_pg_name }} </td>
                                    <td> {{ $txt_pg_sub_name  }}</td>
                                    <td>{{  $txt_product_name }}</td>
                                    <td>{{ $value->issue_qty }}</td>
                                    <td>{{    $unit_name  }}</td>
                                    <td>
                                        {{-- <a href="{{ route('req_material_issue_edit',$value->rid_id) }}">Edit</a> --}}
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
