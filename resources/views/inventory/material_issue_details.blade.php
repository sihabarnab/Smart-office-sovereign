@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Issue</h1>
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
                            <form action="{{ route('material_issue_details_store',$mi_master->mi_master_no) }}" method="post">
                                @csrf
                                <div class="row bg-secondary ">
                                    <div class="col-2 ">
                                        Issue No.
                                    </div>
                                    <div class="col-2">
                                        Issue Date
                                    </div>
                                    <div class="col-2">
                                        Department
                                    </div>
                                    <div class="col-2">
                                        Requesition No.
                                    </div>
                                    <div class="col-2">
                                        Requesition Date
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        {{ $mi_master->mi_master_no }}
                                    </div>
                                    <div class="col-2">
                                        {{ $mi_master->entry_date }}
                                    </div>
                                    <div class="col-2">
                                        @if ( $mi_master->department_id == 1)
                                        {{"Servicing"}}
                                        @elseif ( $mi_master->department_id == 2)
                                        {{"Electrical"}}
                                        @elseif ( $mi_master->department_id == 3)
                                        {{"Mechanical"}}
                                        @else
                                            
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        {{ $mi_master->req_no }}
                                    </div>
                                    <div class="col-2">
                                        {{ $mi_master->req_date }}
                                    </div>
                                </div>

                                <div class="row bg-primary mb-1">
                                    <div class="col-3">
                                        Product Group
                                    </div>
                                    <div class="col-3">
                                        Product Sub group
                                    </div>
                                    <div class="col-4">
                                        Product
                                    </div>
                                    <div class="col-2">
                                        Unit
                                    </div>
                                </div>


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                            <option value="0">-Select Product Group-</option>
                                            @foreach ($product_group as $value)
                                                <option value="{{ $value->pg_id }}">{{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="0">-Select Product Sub Group-</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option value="0">-Select Product-</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_unit_name" id="txt_unit_name"
                                            readonly placeholder="Unit">
                                        @error('txt_unit')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_stock_qty" id="txt_stock_qty"
                                            value="{{ old('txt_stock_qty') }}" placeholder="Stock Qty" >
                                        @error('txt_stock_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_requsition_qty"
                                            id="txt_requsition_qty" value="{{ old('txt_requsition_qty') }}"
                                            placeholder="Requesition Qty" readonly>
                                        @error('txt_requsition_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_pre_issue_qty"
                                            id="txt_pre_issue_qty" value="{{ old('txt_pre_issue_qty') }}"
                                            placeholder="Pre. Issue Qty" readonly>
                                        @error('txt_pre_issue_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_issue_qty" id="txt_issue_qty"
                                            value="{{ old('txt_issue_qty') }}" placeholder="Issue Qty">
                                        @error('txt_issue_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="txt_Remarks" id="txt_Remarks"
                                            value="{{ old('txt_Remarks') }}" placeholder="Remarks">
                                        @error('txt_Remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8"></div>
                                    <div class="col-2">
                                        <button type="submit" class="form-control  bg-primary">Issue</button>
                                    </div>
                                    <div class="col-2">
                                        @php
                                            $havadata = DB::table('pro_material_issue_details')
                                                ->where('mi_master_no', '=', $mi_master->mi_master_no)
                                                ->get();
                                        @endphp
                                        @if ($havadata)
                                            <a href="{{ route('material_issue_final', $mi_master->mi_master_no) }}"
                                                class="form-control btn bg-primary">Final</a>
                                        @else
                                            <a href="" class="form-control btn bg-primary">Final</a>
                                        @endif
                                    </div>

                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('inventory.material_issue_details_list')


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {
                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/mi_issue/product_sub_group/') }}/" +
                            cbo_product_group +"/{{ $mi_master->mi_master_no }}",

                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            var d = $('select[name="cbo_product_sub_group"]').empty();
                            $('select[name="cbo_product_sub_group"]').append(
                                '<option value="0">-Select Product Sub Group-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product_sub_group"]').append(
                                    '<option value="' + value.pg_sub_id + '">' +
                                    value.pg_sub_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_sub_group"]').empty();
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_sub_group"]').on('change', function() {
                var cbo_product_sub_group = $(this).val();
                if (cbo_product_sub_group) {
                    $.ajax({
                        url: "{{ url('/get/mi_issue/product/') }}/" + cbo_product_sub_group +"/{{ $mi_master->mi_master_no }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_product"]').empty();
                            $('select[name="cbo_product"]').append(
                                '<option value="0">-Select Product-</option>');
                            //
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product"]').empty();
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                console.log('ok2')
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/mi_issue/product_details') }}/" + cbo_product +"/{{ $mi_master->mi_master_no }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            $('select[name="txt_unit_name"]').empty();
                            document.getElementById("txt_unit_name").value = data.unit_name;
                            document.getElementById("txt_requsition_qty").value = data.requsition_qty;
                            document.getElementById("txt_pre_issue_qty").value = data.mi_qty;
                            document.getElementById("txt_issue_qty").value = data.issue_qty;

                        },
                    });

                    $.ajax({
                        url: "{{ url('/get/mi_issue/total_stock') }}/" + cbo_product +"/{{ $mi_master->mi_master_no }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            document.getElementById("txt_stock_qty").value = data;
                        },
                    });

                } else {
                    $('txt_unit_name').empty();
                    $('txt_requsition_qty').empty();
                    $('txt_pre_issue_qty').empty();
                    $('txt_issue_qty').empty();
                    $('txt_stock_qty').empty();
                }

            });
        });
    </script>
@endsection

@endsection
