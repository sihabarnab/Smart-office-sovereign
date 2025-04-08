@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Invoice Details</h1>
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
                        <form action="{{ route('purchase_invoice_details_store', $m_purchase_master->purchase_master_id) }}"
                            method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" name="txt_purchase_requisition_id"
                                        id="txt_purchase_requisition_id"
                                        value="{{ $m_purchase_master->purchase_requisition_id }}" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" name="txt_purchase_requisition_date"
                                        id="txt_purchase_requisition_date"
                                        value="{{ $m_purchase_master->purchase_requisition_date }}"
                                        placeholder="Requisition Date" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $m_purchase_master->purchase_invoice_no }}" readonly>
                                    @error('txt_req_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" placeholder="Purchase Invoice Date"
                                        value="{{ $m_purchase_master->purchase_invoice_date }}" readonly>
                                    @error('txt_purchase_invoice_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" value="{{ $m_purchase_master->store_name }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-1 btn-primary">
                                <div class="col-4">Product</div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-2">Requisition</div>
                                        <div class="col-2">Remaining</div>
                                        <div class="col-3">Pu. Qty</div>
                                        <div class="col-3">Rate</div>
                                        <div class="col-2">Unit</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">

                                <div class="col-4">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value="">-Product-</option>
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

                                <div class="col-8">
                                    <div class="row">

                                        <div class="col-2">
                                            <input type="number" class="form-control" name="txt_re_product_qty"
                                                value="{{ old('txt_re_product_qty') }}" id="txt_re_product_qty"
                                                placeholder="Requisition" readonly>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" class="form-control" name="txt_pu_product_qty"
                                                value="{{ old('txt_pu_product_qty') }}" id="txt_pu_product_qty"
                                                placeholder="Remaining" readonly>
                                        </div>

                                        <div class="col-3">
                                            <input type="number" class="form-control" name="txt_product_qty"
                                                id="txt_product_qty" value="" placeholder="Pu. QTY">
                                            @error('txt_product_qty')
                                                <span class="text-warning">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control" name="txt_product_rate"
                                                id="txt_product_rate" value="" placeholder="Rate">
                                            @error('txt_product_rate')
                                                <span class="text-warning">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" name="txt_product_unit"
                                                id="txt_product_unit" value="" placeholder="Unit" readonly>
                                            @error('txt_product_unit')
                                                <span class="text-warning">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="txt_remark" id="txt_remark"
                                        value="{{ old('txt_remark') }}" placeholder="Remark">
                                    @error('txt_remark')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-8">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Add
                                        More</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ route('purchase_invoice_final', $m_purchase_master->purchase_master_id) }}"
                                        class="btn btn-primary btn-block">Final</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('purchase.purchase_invoice_details_list')

@section('script')
    {{-- //product  to QTY --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                var cbo_product = $(this).val();
                var txt_purchase_requisition_id = "{{ $m_purchase_master->purchase_requisition_id }}";
                if (cbo_product && txt_purchase_requisition_id) {
                    $.ajax({
                        url: "{{ url('/get/purchase/product_qty/') }}/" + cbo_product + '/' +
                            txt_purchase_requisition_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_product_qty').val('');
                            $('#txt_re_product_qty').val('');
                            $('#txt_pu_product_qty').val('');
                            //
                            $('#txt_product_qty').val(data.qty);
                            $('#txt_re_product_qty').val(data.approved_qty);
                            $('#txt_pu_product_qty').val(data.pu_qty);

                        },
                    });

                } else {
                    $('#txt_product_qty').val('');
                    $('#txt_re_product_qty').val('');
                    $('#txt_pu_product_qty').val('');
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
                    $('select[name="txt_product_unit"]').empty();
                }

            });
        });
    </script>
@endsection
@endsection
