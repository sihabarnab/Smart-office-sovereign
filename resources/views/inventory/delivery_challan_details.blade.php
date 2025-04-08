@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Challan Details </h1>
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
                        <form action="{{ route('mt_delivery_challan_details_store', $d_challan_master->chalan_no) }}"
                            method="post">
                            @csrf

                            <div class="row mb-1">
                                <div class="col-2">
                                    <input type="hidden" class="form-control" name="cbo_requisition_master_id"
                                        id="cbo_requisition_master_id"
                                        value="{{ $m_requisition_master->requisition_master_id }}"
                                        placeholder="Requiction No" readonly>
                                    <input type="text" class="form-control" name="cbo_req_no" id="cbo_req_no"
                                        value="{{ $m_requisition_master->req_no }}" placeholder="Requiction No" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" name="cbo_approved_date"
                                        id="cbo_approved_date" value="{{ $m_requisition_master->approved_date }}"
                                        placeholder="Approved Date" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="cbo_mgm_name" id="cbo_mgm_name"
                                        value="{{ $m_requisition_master->mgm_name }}" placeholder="Approved By" readonly>
                                </div>
                                <div class="col-5">
                                    <input type="hidden" class="form-control" name="cbo_project_id" id="cbo_project_id"
                                        value="{{ $m_requisition_master->project_id }}" placeholder="Project Name" readonly>
                                    <input type="text" class="form-control"
                                        value="{{ $m_requisition_master->project_name }}" placeholder="Project Name"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="txt" class="form-control" id="txt_chalan_no" name="txt_chalan_no"
                                        placeholder="DC No" value="{{ $d_challan_master->chalan_no }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="txt_dcm_date" name="txt_dcm_date"
                                        placeholder="DC Date" value="{{ $d_challan_master->dc_date }}" readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="cbo_address" name="cbo_address" class="form-control"
                                        value="{{ $d_challan_master->address }}" placeholder="Address">
                                    @error('cbo_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1 btn-primary">
                                <div class="col-2">Warehouse</div>
                                <div class="col-4">Product</div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">Stock</div>
                                        <div class="col-4">Req.QTY</div>
                                        <div class="col-4">Unit</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-2">
                                    <input class="form-control" id="cbo_store_id" name="cbo_store_id"
                                        value="{{ $d_challan_master->store_name }}" readonly>

                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value="">-Product-</option>
                                        @foreach ($m_product as $value)
                                            <option value="{{ $value->product_id }}"
                                                {{ old('cbo_product') == $value->product_id ? 'selected' : '' }}>
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

                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="txt_balance"
                                                name="txt_balance" value="{{ old('txt_balance') }}"
                                                placeholder="Balance" readonly>
                                            @error('txt_balance')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="txt_quantity"
                                                name="txt_quantity" value="{{ old('txt_quantity') }}" placeholder="QTY">
                                            @error('txt_quantity')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="txt_unit" name="txt_unit"
                                                value="{{ old('txt_unit') }}" placeholder="Unit" readonly>
                                            @error('txt_unit')
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
                                    <button type="Submit" class="btn btn-primary btn-block">Add More</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ route('mt_delivery_challan_final', $d_challan_master->chalan_no) }}"
                                        class="btn btn-primary btn-block">Final</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inventory.delivery_challan_details_list')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                product_info();
            });
        });
    </script>

    <script>
        function product_info() {
            var cbo_product = $('#cbo_product').val();
            var cbo_store_id = "{{ $d_challan_master->store_id }}";
            var txt_requisition_master_id = "{{ $m_requisition_master->requisition_master_id }}";
            if (cbo_product && cbo_store_id) {
                $.ajax({
                    url: "{{ url('/get/dc/product_details/') }}/" + cbo_product + '/' + txt_requisition_master_id +
                        '/' + cbo_store_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#txt_balance').val(data.balance);
                        $('#txt_quantity').val(data.qty);
                        $('#txt_unit').val(data.unit_name);
                    },
                });

            } else {
                $('#txt_balance').val('');
                $('#txt_quantity').val('');
                $('#txt_unit').val('');
            }
        }
    </script>
@endsection
