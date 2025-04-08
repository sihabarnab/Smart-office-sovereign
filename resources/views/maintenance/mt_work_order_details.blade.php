@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Work Oder</h1>
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
                            <form action="{{ route('mt_work_order_details_store', $wo_master->wo_master_id) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">

                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $wo_master->wo_invoice_no }}" readonly>
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_date"
                                            value="{{ $wo_master->entry_date }}" readonly>
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $wo_master->quotation_master_id }}" readonly>
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_date"
                                            value="{{ $wo_master->quotation_date }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_date"
                                            value="{{ $wo_master->customer_address }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_date"
                                            value="{{ $wo_master->customer_name }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_date"
                                            value="{{ $wo_master->reference }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_product_group" name="cbo_product_group">
                                            <option value="0">-Product Group-</option>
                                            @foreach ($product_group as $value)
                                                <option value="{{ $value->pg_id }}">{{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_product_sub_group"
                                            name="cbo_product_sub_group">
                                            <option value="0">-Product Sub Group-</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="0">-Product-</option>
                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="txt_rate"
                                                    name="txt_rate" value="{{ old('txt_rate') }}" placeholder="Rate">
                                                @error('txt_rate')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="txt_quantity"
                                                    name="txt_quantity" value="{{ old('txt_quantity') }}"
                                                    placeholder="Quantity">
                                                @error('txt_quantity')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                            value="{{ old('txt_remark') }}" placeholder="Remark">
                                    </div>
                                </div>


                                <div class="row ">
                                    <div class="col-8">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="" class="btn btn-primary btn-block">Add
                                            More</button>
                                    </div>
                                    <div class="col-2">
                                        <a href="{{ route('mt_work_order_final', $wo_master->wo_master_id) }}"
                                            class="btn btn-primary btn-block">Final</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('maintenance.work_order_details_list')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {

                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/mt/work_oder_details/product_sub_group/') }}/" +
                            cbo_product_group + "/" +
                            "{{ $wo_master->quotation_id }}" + "/{{ $wo_master->wo_master_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            //
                            $('select[name="cbo_product"]').empty();
                            $('select[name="cbo_product"]').append(
                                '<option value="0">-Product-</option>');
                            //
                            $('select[name="cbo_product_sub_group"]').empty();
                            $('select[name="cbo_product_sub_group"]').append(
                                '<option value="0">-Product Sub Group-</option>');
                            //
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
                console.log('ok')
                var cbo_product_sub_group = $(this).val();
                if (cbo_product_sub_group) {
                    $.ajax({
                        url: "{{ url('/get/mt/work_oder_details/product/') }}/" +
                            cbo_product_sub_group +
                            "/" +
                            "{{ $wo_master->quotation_id }}" + "/{{ $wo_master->wo_master_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            $('select[name="cbo_product"]').empty();
                            $('select[name="cbo_product"]').append(
                                '<option value="0">-Product-</option>');
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
                console.log('ok')
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/mt/work_oder/product_rate/') }}/" + cbo_product +
                            "/" +
                            "{{ $wo_master->quotation_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_rate').val(data.rate);
                            $('#txt_quantity').val(data.qty);
                        },
                    });

                } else {
                    $('#txt_rate').empty();
                    $('#txt_quantity').empty();
                }

            });
        });
    </script>
@endsection
