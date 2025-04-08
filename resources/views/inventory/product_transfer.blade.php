@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Transfer</h1>
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
                        </div>
                        <form action="{{ route('product_transfer_store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-6">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value="">-Select Product-</option>
                                        @foreach ($m_product as $row)
                                            <option value="{{ $row->product_id }}"
                                                {{ old('cbo_product') == $row->product_id ? 'selected' : '' }}>
                                                {{ $row->product_name }}
                                                @isset($row->product_des)
                                                    | {{ $row->product_des }}
                                                @endisset
                                                @isset($row->size_name)
                                                    | {{ $row->size_name }}
                                                @endisset
                                                @isset($row->origin_name)
                                                    | {{ $row->origin_name }}
                                                @endisset
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <select class="form-control" id="cbo_store_id" name="cbo_store_id">
                                        <option value="">-Select Warehouse-</option>
                                        @foreach ($m_wearhouse as $row)
                                            <option value="{{ $row->store_id }}"
                                                {{ old('cbo_store_id') == $row->store_id ? 'selected' : '' }}>
                                                {{ $row->store_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_store_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_balance" name="txt_balance"
                                        value="" placeholder="Stock" readonly>
                                    @error('txt_balance')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5">
                                    <select class="form-control" id="cbo_transfer_store_id" name="cbo_transfer_store_id">
                                        <option value="">-Transfer Warehouse-</option>
                                        @foreach ($m_wearhouse as $row)
                                            <option value="{{ $row->store_id }}"
                                                {{ old('cbo_transfer_store_id') == $row->store_id ? 'selected' : '' }}>
                                                {{ $row->store_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_transfer_store_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="number" class="form-control" id="txt_transfer_qty" name="txt_transfer_qty"
                                        value="" placeholder="Transfer Qty">
                                    @error('txt_transfer_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Submit</button>
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
            $('select[name="cbo_product"]').on('change', function() {
                product_info();
            });
            $('select[name="cbo_store_id"]').on('change', function() {
                product_info();
            });
        });
    </script>

    <script>
        function product_info() {
            var cbo_product = $('#cbo_product').val();
            var cbo_store_id = $('#cbo_store_id').val();
            if (cbo_product && cbo_store_id) {
                $.ajax({
                    url: "{{ url('/get/product_stock_detail/') }}/" + cbo_product + '/' + cbo_store_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#txt_balance').val(data.balance);
                    },
                });

            } else {
                $('#txt_balance').val('');
            }
        }
    </script>
@endsection
