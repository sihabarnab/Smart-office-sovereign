@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUOTATION DETAILS</h1>
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
                        <div class="row mb-1">
                            <div class="col-12 col-md-4">
                                @php
                                    if ($m_quotation_master->project_id) {
                                        $m_project = DB::table('pro_projects')
                                            ->where('project_id', $m_quotation_master->project_id)
                                            ->first();
                                        $project_name = $m_project->project_name;
                                    } else {
                                        $project_name = '';
                                    }
                                @endphp
                                <input type="text" class="form-control" value="{{ $project_name }}" readonly>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" class="form-control" readonly
                                    value="{{ $m_quotation_master->quotation_master_id }}" id="txt_quatation_number"
                                    name="txt_quatation_number">
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" class="form-control" readonly
                                    value="{{ $m_quotation_master->quotation_date }}" id="txt_quatation_date"
                                    name="txt_quatation_date">
                            </div>

                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-md-4">
                                <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                    value="{{ $m_quotation_master->customer_name }}" readonly>
                                @error('txt_customer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number"
                                    value="{{ $m_quotation_master->customer_mobile }}" readonly>
                                @error('txt_mobile_number')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-5">
                                <input type="text" class="form-control" id="txt_address" name="txt_address"
                                    value="{{ $m_quotation_master->customer_address }}" readonly>
                                @error('txt_address')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-md-6">
                                <input type="text" class="form-control" id="txt_subject" name="txt_subject" readonly
                                    value="{{ $m_quotation_master->subject }}">
                                @error('txt_subject')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control" id="txt_reference_name" name="txt_reference_name"
                                    readonly value="{{ $m_quotation_master->reference }}">
                                @error('txt_reference_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control" id="txt_reference_number"
                                    name="txt_reference_number" value="{{ $m_quotation_master->reference_mobile }}">
                                @error('txt_reference_number')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @isset($m_quotation_master->reject_comment)
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h3 class="m-0">REJECT COMMENT</h3>
                    </div><!-- /.col -->

                    <div class="col-12">
                        <textarea class="form-control" name="txt_comment" placeholder="Reject Comment" id="txt_comment" cols="30"
                            rows="2" readonly>{{ $m_quotation_master->reject_comment }}</textarea>
                    </div>

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    @endisset

    @if ($m_quotation_master->repair_price)
    @else
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('mt_quotation_repair_store', $m_quotation_master->quotation_id) }}"
                                method="post">
                                @csrf
                                <table id="" class="table table-bordered table-striped table-sm mb-1">
                                    <thead>
                                        <tr>
                                            <th width='60%'>Repair Description</th>
                                            <th width='10%'>QTY</th>
                                            <th width='15%'>Unit Price</th>
                                            <th width='15%'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" id="txt_repair_descrption"
                                                    name="txt_repair_descrption"
                                                    value="{{ old('txt_repair_descrption') }}">
                                                @error('txt_repair_descrption')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="txt_repair_qty"
                                                    name="txt_repair_qty" value="{{ old('txt_repair_qty') }}">
                                                @error('txt_repair_qty')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="txt_repair_price"
                                                    name="txt_repair_price" value="{{ old('txt_repair_price') }}">
                                                @error('txt_repair_price')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <button type="Submit" id=""
                                                    class="btn btn-primary btn-block">ADD</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    @endif


    @php
        $sub_total = 0;
        $i = 1;
        $repair_price = 0;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('mt_quotation_final_store', $m_quotation_master->quotation_id) }}"
                            method="post">
                            @csrf
                            <table class="table table-bordered table-striped table-sm mb-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL No</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_quotation_details as $key => $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td class="text-center">{{ number_format($row->qty, 2) }}</td>
                                            <td class="text-center">{{ number_format($row->rate, 2) }}</td>
                                            <td class="text-right">{{ number_format($row->total, 2) }}</td>
                                            @php
                                                $sub_total += $row->total;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    @if ($m_quotation_master->repair_price)
                                        @php
                                            $repair_price = $m_quotation_master->repair_price;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $m_quotation_master->repair_descrption }}</td>
                                            <td class="text-center">{{ number_format($m_quotation_master->repair_qty, 2) }}
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($m_quotation_master->repair_price, 2) }}</td>
                                            <td class="text-right">
                                                {{ number_format($m_quotation_master->repair_price, 2) }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class=" text-right">Sub Total :</td>
                                        <td class="text-right" colspan="1">
                                            <input type="hidden" name="txt_subtotal" id="txt_subtotal"
                                                value="{{ $sub_total }}">
                                            {{ number_format($sub_total + $repair_price, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <p class="mt-1">Discount:</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="txt_dpp" name="txt_dpp"
                                                value="{{ old('txt_dpp') }}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control text-right" id="txt_discount"
                                                name="txt_discount" value="{{ old('txt_discount') }}"
                                                placeholder="Discount" onchange="grandTotal()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <p class="mt-1">VAT:</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="txt_vpp" name="txt_vpp"
                                                value="{{ old('txt_vpp') }}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control text-right" id="txt_vat"
                                                name="txt_vat" value="{{ old('txt_vat') }}" placeholder="VAT"
                                                onchange="grandTotal()">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <p class="mt-1">AIT:</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="txt_tt" name="txt_tt"
                                                value="{{ old('txt_tt') }}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control text-right" id="txt_ait"
                                                name="txt_ait" value="{{ old('txt_ait') }}" placeholder="AIT"
                                                onchange="grandTotal()">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <p class="mt-1">Others:</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="txt_ot" name="txt_ot"
                                                value="{{ old('txt_ot') }}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control text-right" id="txt_other"
                                                name="txt_other" value="{{ old('txt_other') }}" placeholder="Other"
                                                onchange="grandTotal()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <p class="mt-1">Grand Total:</p>
                                </div>
                                <div class="col-4">
                                    <input type="number" name="txt_gt" id="txt_gt"
                                        class="form-control text-right ml-1" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-10 mb-1">

                                </div>
                                <div class="col-12 col-md-2 mb-1">
                                    <button type="Submit" id=""
                                        class="btn btn-primary float-right">Final</button>
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
    <script>
        $(document).ready(function() {
            grandTotal();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_dpp').on('change', function() {
                var discount = $(this).val();
                if (discount) {
                    var price = "{{ round($sub_total + $repair_price, 2) }}";
                    var totalValue = (price * (discount / 100));
                    $('#txt_discount').val(totalValue.toFixed(2));
                    grandTotal();
                } else {
                    $('#txt_dpp').empty();
                    $('#txt_discount').empty();
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_ot').on('change', function() {
                var ait = $(this).val();
                if (ait) {
                    var price = "{{ round($sub_total + $repair_price, 2) }}";
                    var totalValue = (price * (ait / 100));
                    $('#txt_other').val(totalValue.toFixed(2));
                    grandTotal();
                } else {
                    $('#txt_ot').val('');
                    $('#txt_other').val('');
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_tt').on('change', function() {
                var ait = $(this).val();
                if (ait) {
                    var price = "{{ round($sub_total + $repair_price, 2) }}";
                    var totalValue = (price / 100) * ait;
                    $('#txt_ait').val(totalValue.toFixed(2));
                    grandTotal();
                } else {
                    $('#txt_tt').val('');
                    $('#txt_ait').val('');
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_vpp').on('change', function() {
                var vat = $(this).val();
                if (vat) {
                    var price = "{{ $sub_total + $repair_price }}";
                    var tax = (price / 100) * vat;
                    $('#txt_vat').val(tax.toFixed(2));
                    grandTotal();
                } else {
                    $('#txt_vpp').empty();
                    $('#txt_vat').empty();
                }

            });
        });
    </script>

    <script>
        function grandTotal() {
            $('#txt_gt').val('');
            var discount = parseFloat($('#txt_discount').val()) || 0;
            var vat = parseFloat($('#txt_vat').val()) || 0;
            var ait = parseFloat($('#txt_ait').val()) || 0;
            var other = parseFloat($('#txt_other').val()) || 0;
            var subtotal = parseFloat("{{ $sub_total + $repair_price }}") || 0;
            var sum = (subtotal - discount) + vat + ait + other;
            $('#txt_gt').val(sum.toFixed(2));
        }
    </script>
@endsection
