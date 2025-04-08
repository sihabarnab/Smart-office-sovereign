@extends('layouts.crm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION DETAILS</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($quotation_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('quotation_details_update', $quotation_details_edit->quotation_details_id) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-2"></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_master_id }}" id="txt_quatation_number"
                                            name="txt_quatation_number">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_date }}" id="txt_quatation_date"
                                            name="txt_quatation_date">
                                    </div>
                                    <div class="col-2"></div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-4">
                                        <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                            value="{{ $m_quotation_master->customer_name }}" readonly>
                                        @error('txt_customer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_mobile_number"
                                            name="txt_mobile_number" value="{{ $m_quotation_master->customer_mobile }}"
                                            readonly>
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $m_quotation_master->customer_address }}" readonly>
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                            readonly value="{{ $m_quotation_master->subject }}">
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_name"
                                            name="txt_reference_name" readonly
                                            value="{{ $m_quotation_master->reference }}">
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_number"
                                            name="txt_reference_number" readonly
                                            value="{{ $m_quotation_master->reference_mobile }}">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_product_group" name="cbo_product_group">
                                            <option value="0">-Product Group-</option>
                                            @foreach ($product_group as $value)
                                                <option
                                                    value="{{ $value->pg_id }}"{{ $value->pg_id == $quotation_details_edit->pg_id ? 'selected' : '' }}>
                                                    {{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_product_sub_group"
                                            name="cbo_product_sub_group">
                                            <option value="{{ $quotation_details_edit->pg_sub_id }}">
                                                {{ $quotation_details_edit->pg_sub_name }}</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="{{ $quotation_details_edit->product_id }}">
                                                {{ $quotation_details_edit->product_name }}</option>
                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="txt_rate" name="txt_rate"
                                                    value="{{ $quotation_details_edit->rate }}" placeholder="Rate">
                                                @error('txt_rate')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="txt_quantity"
                                                    name="txt_quantity" value="{{ $quotation_details_edit->qty }}"
                                                    placeholder="Quantity">
                                                @error('txt_quantity')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-8">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id=""
                                            class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('quotation_details_store', $m_quotation_master->quotation_id) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-2"></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_master_id }}"
                                            id="txt_quatation_number" name="txt_quatation_number">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_date }}" id="txt_quatation_date"
                                            name="txt_quatation_date">
                                    </div>
                                    <div class="col-2"></div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-4">
                                        <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                            value="{{ $m_quotation_master->customer_name }}" readonly>
                                        @error('txt_customer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_mobile_number"
                                            name="txt_mobile_number" value="{{ $m_quotation_master->customer_mobile }}"
                                            readonly>
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $m_quotation_master->customer_address }}" readonly>
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                            readonly value="{{ $m_quotation_master->subject }}">
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_name"
                                            name="txt_reference_name" readonly
                                            value="{{ $m_quotation_master->reference }}">
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_number"
                                            name="txt_reference_number" readonly
                                            value="{{ $m_quotation_master->reference_mobile }}">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
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
                                <div class="row ">
                                    <div class="col-8">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id=""
                                            class="btn btn-primary btn-block">Add</button>
                                    </div>
                                    <div class="col-2">
                                        @php
                                            $quotation_details = DB::table('pro_quotation_details')
                                                ->where('quotation_id', $m_quotation_master->quotation_id)
                                                ->first();
                                        @endphp
                                        @if (isset($quotation_details))
                                            <a href="{{ route('quotation_details_more', $m_quotation_master->quotation_id) }}"
                                                class="btn btn-primary btn-block">Continue</a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-block">Continue</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('crm.quotation_details_list')
    @endif

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {

                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/crm/quotation/product_sub_group/') }}/" +
                            cbo_product_group,
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
                    alert('danger');
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
                        url: "{{ url('/get/crm/quotation/product/') }}/" + cbo_product_sub_group +
                            "/" +
                            "{{ $m_quotation_master->quotation_id }}",
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
                    alert('danger');
                }

            });
        });
    </script>
@endsection
