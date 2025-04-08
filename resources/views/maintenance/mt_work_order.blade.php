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
                        <form action="{{ route('mt_work_order_store') }}" method="post">
                            @csrf
                            <div class="row mb-1">

                                <div class="col-3">
                                    <select class="form-control" id="cbo_quotation_id" name="cbo_quotation_id">
                                        <option value="">-Select Quotation-</option>
                                        @foreach ($m_quotation_master as $value)
                                            <option value="{{ $value->quotation_id }}">{{ $value->quotation_master_id }} | {{ $value->customer_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_quotation_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_date"
                                    placeholder="Quotation Date" readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_address"
                                        placeholder="Customer Address" readonly>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_name"
                                    placeholder="Customer Name" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_mobile"
                                    placeholder="Customer Mobile" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_subject"
                                    placeholder="Subject" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reff"
                                    placeholder="Reference" readonly>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_product_group" name="cbo_product_group">
                                        <option value="">-Product Group-</option>
                                    </select>
                                    @error('cbo_product_group')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_product_sub_group" name="cbo_product_sub_group">
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
                                            <input type="text" class="form-control" id="txt_rate" name="txt_rate"
                                                value="{{ old('txt_rate') }}" placeholder="Rate">
                                            @error('txt_rate')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="txt_quantity" name="txt_quantity"
                                                value="{{ old('txt_quantity') }}" placeholder="Quantity">
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
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_quotation_id"]').on('change', function() {

                var cbo_quotation_id = $(this).val();
                if (cbo_quotation_id) {
                    $.ajax({
                        url: "{{ url('/get/mt/quotation') }}/" +
                        cbo_quotation_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data1) {
                            $('#txt_date').val(data1.quotation_date);
                            $('#txt_address').val(data1.customer_address);
                            $('#txt_name').val(data1.customer_name);
                            $('#txt_mobile').val(data1.customer_mobile);
                            $('#txt_subject').val(data1.subject);
                            $('#txt_reff').val(data1.reference); 
                        },
                    });

                    $.ajax({
                        url: "{{ url('/get/mt/quotation_group') }}/" +
                        cbo_quotation_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product_group"]').empty();
                            $('select[name="cbo_product_group"]').append(
                                '<option value="">-Product Group-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product_group"]').append(
                                    '<option value="' + value.pg_id + '">' +
                                    value.pg_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_group"]').empty();
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {
                var cbo_quotation_id = $('#cbo_quotation_id').val();
                var cbo_product_group = $(this).val();
                if (cbo_product_group && cbo_quotation_id) {
                    $.ajax({
                        url: "{{ url('/get/mt/work_oder/product_sub_group/') }}/" +
                            cbo_product_group + "/" + cbo_quotation_id,
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
                var cbo_quotation_id = $('#cbo_quotation_id').val();
                if (cbo_product_sub_group && cbo_quotation_id) {
                    $.ajax({
                        url: "{{ url('/get/mt/work_oder/product/') }}/" +
                            cbo_product_sub_group +
                            "/" + cbo_quotation_id,
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
                var cbo_quotation_id = $('#cbo_quotation_id').val();
                var cbo_product = $(this).val();
                if (cbo_product && cbo_quotation_id) {
                    $.ajax({
                        url: "{{ url('/get/mt/work_oder/product_rate/') }}/" + cbo_product +
                            "/" + cbo_quotation_id,
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
