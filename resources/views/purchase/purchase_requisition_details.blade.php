@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Requisition</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('purchase_requisition_details_store',$pu_requ_master->purchase_requisition_id) }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_purchase_requistion_date"
                                        name="txt_purchase_requistion_date" value="{{ $pu_requ_master->purchase_requisition_date }}" readonly>
                                    @error('txt_purchase_requistion_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"  value="{{ $pu_requ_master->purchase_requisition_id }}" readonly>
                                    
                                </div>
                                <div class="col-6">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value=''>-Product-</option>
                                        @foreach ($m_product as $value)
                                            <option value="{{ $value->product_id }}">
                                                {{ $value->product_name }}
                                                @isset($value->product_des)
                                                    |{{ $value->product_des }}
                                                @endisset
                                                @isset($value->size_name)
                                                    |{{ $value->size_name }}
                                                @endisset
                                                @isset($value->origin_name)
                                                    |{{ $value->origin_name }}
                                                @endisset
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" name="txt_product_price"
                                        id="txt_product_price" value="{{ old('txt_product_price') }}" placeholder="Price">
                                    @error('txt_product_price')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" name="txt_product_qty" id="txt_product_qty"
                                        value="{{ old('txt_product_qty') }}" placeholder="QTY">
                                    @error('txt_product_qty')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="txt_product_unit" id="txt_product_unit"
                                        value="{{ old('txt_product_unit') }}" placeholder="Unit" readonly>
                                    @error('txt_product_unit')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                           

                            <div class="row mb-2">
                                <div class="col-8">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Add More</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{route('purchase_requisition_final',$pu_requ_master->purchase_requisition_id)}}" class="btn btn-primary btn-block">Final</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Product QTY</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sum=0;
                                @endphp
                                @foreach ($pu_requ_details as $key => $row)
                                    @php
                                        $ci_product = DB::table('pro_product')
                                            ->Where('product_id', $row->product_id)
                                            ->first();
                                        $txt_product_name = $ci_product->product_name;
                                        
                                        $unit = DB::table('pro_units')->where('unit_id',$ci_product->unit_id)->first();
                                        $unit_name =  $unit->unit_name;
                                        $sum=$sum+$row->qty;
                                    @endphp
    
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $txt_product_name }}</td>
                                        <td>{{ number_format($row->qty,2) }}</td>
                                        <td>{{ $unit_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">Total:</td>
                                    <td colspan="1">{{number_format($sum,2)}}</td>
                                    <td colspan="1"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/Add_product_stock/unit/') }}/" + cbo_product,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="txt_product_unit"]').empty();
                            $('#txt_product_unit').val(data.unit_name);

                        },
                    });

                } else {
                    $('select[name="txt_product_unit"]').empty();
                }

            });
        });
    </script>
@endsection
@endsection
