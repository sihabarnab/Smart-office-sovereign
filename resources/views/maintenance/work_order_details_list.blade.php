<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product Group</th>
                                <th>Product Sub Group</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Extended Price</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wo_details as $key=>$row)  
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->pg_name }}</td>
                                <td>{{ $row->pg_sub_name }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ $row->rate }}</td>
                                <td>{{ $row->total}}</td>
                                {{-- <td> <a href="{{ route('sales_work_order_edit',$row->wo_details_id) }}">Edit</a></td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>