@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Receving Report</h1>
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
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form action="{{ route('add_more_receving',$m_master->purchase_no) }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" name="txt_purchase_no" value="{{ $m_master->purchase_no}}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"  value="{{ $m_supplyer->supplier_name}}" readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="txt_supply_add" id="txt_supply_add"
                                        value="{{ $m_supplyer->supplier_add}}" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" name="txt_ref" id="txt_ref"
                                    placeholder="Reference Name" value="{{$m_master->reference}}" >
                                    @error('txt_ref')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
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
                                    <select class="form-control" id="cbo_product_sub_group" name="cbo_product_sub_group">
                                        <option selected>-Product Sub Group-</option>
                                    </select>
                                    @error('cbo_product_sub_group')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option selected>-Product-</option>
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-2">
                                <div class="col-2">
                                    <input type="text" class="form-control" name="txt_product_qty" id="txt_product_qty"
                                        value="{{ old('txt_product_qty') }}" placeholder="QTY" >
                                    @error('txt_product_qty')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" name="txt_product_unit" id="txt_product_unit"
                                        value="{{ old('txt_product_unit') }}" placeholder="Unit" readonly>
                                    @error('txt_product_unit')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" name="txt_product_rate" id="txt_product_rate"
                                        value="{{ old('txt_product_rate') }}" placeholder="Rate">
                                    @error('txt_product_rate')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="txt_remark" id="txt_remark"
                                        value="{{ old('txt_remark') }}" placeholder="Remark">
                                    @error('txt_remark')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                    <div class="row mb-2">
                        <div class="col-10">
                            &nbsp;
                        </div>
                        <div class="col-2">
                            <button type="Submit" id="save_event" class="btn btn-primary btn-block">Next</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- @include('purchase.purchase_details_list') --}}

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {
                console.log('ok')
                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/purchase_details_sub/') }}/" + cbo_product_group+"/{{$m_master->purchase_no}}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            var d = $('select[name="cbo_product_sub_group"]').empty();
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
                    alert('danger');
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
                        url: "{{ url('/get/purchase_details_product/') }}/" + cbo_product_sub_group+"/{{$m_master->purchase_no}}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            var d = $('select[name="cbo_product"]').empty();
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
                    alert('danger');
                }

            });
        });
    </script>
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
                    alert('danger');
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_supplier_id"]').on('change', function() {
                var cbo_supplier_id = $(this).val();
                if (cbo_supplier_id) {
                    $.ajax({
                        url: "{{ url('/get/supply_add/') }}/" + cbo_supplier_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_supply_add').empty();
                            $('#txt_supply_add').val(data.supplier_add);

                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
@endsection
@endsection
