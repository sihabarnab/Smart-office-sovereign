@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CUSTOMER QUATATION APPROVED</h1>
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
                            <div class="col-4">
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
                                <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number"
                                    value="{{ $m_quotation_master->customer_mobile }}" readonly>
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
                                <input type="text" class="form-control" id="txt_subject" name="txt_subject" readonly
                                    value="{{ $m_quotation_master->subject }}">
                                @error('txt_subject')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_reference_name" name="txt_reference_name"
                                    readonly value="{{ $m_quotation_master->reference }}">
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($m_quotation_master->reject_comment) && isset($m_quotation_master->mgm_confirm_approved_id))
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
    @endif


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
                                        <th width='15%'>Rate</th>
                                        <th width='15%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="txt_repair_descrption"
                                                name="txt_repair_descrption"
                                                value="{{ $m_quotation_master->repair_descrption }}">
                                            @error('txt_repair_descrption')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="txt_repair_qty"
                                                name="txt_repair_qty" value="{{ $m_quotation_master->repair_qty }}">
                                            @error('txt_repair_qty')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="txt_repair_price"
                                                name="txt_repair_price" value="{{ $m_quotation_master->repair_price }}">
                                            @error('txt_repair_price')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <button type="Submit" id=""
                                                class="btn btn-primary btn-block">Update</button>
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



    @if ($m_quotation_details->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="9">
                                            <!-- All Approved trigger modal -->
                                            <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                                data-target="#allApprovedModal">
                                                All Approved
                                            </button>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td width='5%'>SL No</td>
                                        <td width='30%'>Product Name</td>
                                        <td width='8%'>Unit</td>
                                        <td width='10%'>QTY</td>
                                        <td width='10%'>Rate</td>
                                        <td width='10%'>Appr.QTY</td>
                                        <td width='10%'>Appr.Rate</td>
                                        <td width='8%'></td>
                                        <td width='9%'></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_quotation_details as $key => $row)
                                        <form
                                            action="{{ route('mt_customer_quotation_approved_update', $row->quotation_details_id) }}"
                                            method="post">
                                            @csrf
                                            @php
                                                $product = DB::table('pro_product')
                                                    ->where('product_id', $row->product_id)
                                                    ->first();
                                                $unit = DB::table('pro_units')
                                                    ->where('unit_id', $product->unit_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td width='5%'>
                                                    <input class="form-control" value="{{ $key + 1 }}" readonly>
                                                </td>
                                                <td width='30%'>
                                                    <input class="form-control" value="{{ $product->product_name }}"
                                                        readonly>
                                                </td>
                                                <td width='8%'>
                                                    <input class="form-control" value="{{ $unit->unit_name }}" readonly>
                                                </td>

                                                <td width='10%'>
                                                    <input class="form-control" value="{{ $row->qty }}" readonly>
                                                </td>
                                                <td width='10%'>
                                                    <input class="form-control" value="{{ $row->rate }}" readonly>
                                                </td>
                                                <td width='10%'>
                                                    <input class="form-control" name="txt_approved_qty"
                                                        placeholder="Approved QTY" value="{{ $row->approved_qty == null ? $row->qty : $row->approved_qty }}">
                                                    @error('txt_approved_qty')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td width='10%'>
                                                    <input class="form-control" name="txt_approved_rate"
                                                        placeholder="Approved Rate" value="{{ $row->approved_rate == null ? $row->rate : $row->approved_rate }}">
                                                    @error('txt_approved_rate')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td width='8%'>
                                                    <button type="Submit" id="save_event"
                                                        class="btn btn-primary  ml-3">OK</button>
                                                </td>

                                                <td width='9%'>

                                                    <!-- Reject trigger modal -->
                                                    <button type="button" class="btn btn-danger float-right"
                                                        data-toggle="modal" data-target="#confirmModal"
                                                        onclick='RemoveQutation("{{ $row->quotation_details_id }}")'>
                                                        Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @php
        $sub_total = 0.0;
        $repair_price = 0;
        $i = 1;
    @endphp


    @if ($m_quotation_approved_details->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('mt_customer_quotation_approved_final', $m_quotation_master->quotation_id) }}"
                                method="post">
                                @csrf
                                <table id="" class="table table-bordered table-striped table-sm mb-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th>Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Rate</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($m_quotation_approved_details as $key => $row)
                                            <tr>
                                                <td class="text-center">{{ $i++ }}</td>
                                                <td>{{ $row->product_name }}</td>
                                                <td class="text-center">{{ number_format($row->approved_qty, 2) }}</td>
                                                <td class="text-center">{{ number_format($row->approved_rate, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->approved_total, 2) }}</td>
                                                @php
                                                    $sub_total += $row->approved_total;
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
                                                <td class="text-center">
                                                    {{ number_format($m_quotation_master->repair_qty, 2) }}</td>
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
                                            <td class="text-right">
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
                                        <p class="mt-1">Discount (%)</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" class="form-control" id="txt_dpp" name="txt_dpp"
                                                    value="{{ $m_quotation_master->discount_percent }}" placeholder="%">
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control text-right" id="txt_discount"
                                                    name="txt_discount" value="{{ $m_quotation_master->discount }}"
                                                    placeholder="Discount">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6"></div>
                                    <div class="col-2 text-right">
                                        <p class="mt-1">VAT (%)</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" class="form-control" id="txt_vpp" name="txt_vpp"
                                                    value="{{ $m_quotation_master->vat_percent }}" placeholder="%">
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control text-right" id="txt_vat"
                                                    name="txt_vat" value="{{ $m_quotation_master->vat }}"
                                                    placeholder="VAT">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6"></div>
                                    <div class="col-2 text-right">
                                        <p class="mt-1">AIT (%)</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" class="form-control" id="txt_tt" name="txt_tt"
                                                    value="{{ $m_quotation_master->ait_percent }}" placeholder="%">
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control text-right" id="txt_ait"
                                                    name="txt_ait" value="{{ $m_quotation_master->ait }}"
                                                    placeholder="AIT">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6"></div>
                                    <div class="col-2 text-right">
                                        <p class="mt-1">Others (%):</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" class="form-control" id="txt_ot" name="txt_ot"
                                                    value="{{ $m_quotation_master->other_percent }}" placeholder="%">
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control text-right" id="txt_other"
                                                    name="txt_other" value="{{ $m_quotation_master->other }}"
                                                    placeholder="Other">
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
                                    <div class="col-10">

                                    </div>
                                    <div class="col-2">
                                        @php
                                            $data_1 = DB::table('pro_maintenance_quotation_details')
                                                ->where('quotation_id', $m_quotation_master->quotation_id)
                                                ->where('customer_status', 1)
                                                ->where('valid', 1)
                                                ->count();

                                            $data_2 = DB::table('pro_maintenance_quotation_details')
                                                ->where('quotation_id', $m_quotation_master->quotation_id)
                                                ->where('valid', 1)
                                                ->count();
                                        @endphp

                                        @if ($data_1 == $data_2)
                                            <button type="Submit" id=""
                                                class="btn btn-primary btn-block">Final</button>
                                        @else
                                            <button id="" class="btn btn-primary btn-block"
                                                disabled>Final</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!--allApproved Modal -->
    <div class="modal fade" id="allApprovedModal" tabindex="-1" role="dialog" aria-labelledby="allApprovedModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-success">
                <div class="modal-body text-center">
                    <h2>Are You Confirm ?</h2> <br>
                    <form action="{{ route('mt_customer_quotation_all_approved') }}" method="GET">
                        @csrf
                        <input type="hidden" name="txt_quotation_id_modal" id="txt_quotation_id_modal" value="{{ $m_quotation_master->quotation_id}}">
                        <button type="button" class="btn btn-danger float-center m-1" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success float-center m-1">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!--Reject Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-success">
                <div class="modal-body text-center">
                    <h2>Are You Confirm ?</h2> <br>
                    <form action="{{ route('mt_customer_quotation_approved_remove') }}" method="GET">
                        @csrf
                        <input type="hidden" name="txt_details" id="txt_details">
                        <button type="button" class="btn btn-danger float-center m-1" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success float-center m-1">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            discount();
            vat();
            ait();
            other();

            $('#txt_dpp').on('change', function() {
                discount()
            });
            $('#txt_vpp').on('change', function() {
                vat()
            });
            $('#txt_tt').on('change', function() {
                ait()
            });
            $('#txt_ot').on('change', function() {
                other()
            });
        });


        function discount() {
            var discount = $("#txt_dpp").val();
            if (discount) {
                var price = "{{ round($sub_total + $repair_price, 2) }}";
                var totalValue = (price * (discount / 100));
                $('#txt_discount').val(totalValue);
                grandTotal()
            } else {
                $('#txt_dpp').empty();
                $('#txt_discount').empty();
            }
        }

        function other() {
            var ait = $("#txt_ot").val();
            if (ait) {
                var price = "{{ round($sub_total + $repair_price, 2) }}";
                var totalValue = (price * (ait / 100));
                $('#txt_other').val(totalValue);
                grandTotal();
            } else {
                $('#txt_ot').val('');
                $('#txt_other').val('');
            }
        }

        function ait() {
            var ait = $('#txt_tt').val();
            if (ait) {
                var price = "{{ round($sub_total + $repair_price, 2) }}";
                var totalValue = (price / 100) * ait;
                $('#txt_ait').val(totalValue);
                grandTotal();
            } else {
                $('#txt_tt').val('');
                $('#txt_ait').val('');
            }
        }

        function vat() {
            var vat = $("#txt_vpp").val();
            if (vat) {
                var price = "{{ $sub_total + $repair_price }}";
                var tax = (price / 100) * vat;
                $('#txt_vat').val(tax);
                grandTotal();
            } else {
                $('#txt_vpp').empty();
                $('#txt_vat').empty();
            }
        }
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

    <script>
        function RemoveQutation(details_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#txt_details').val('');

            if (details_id) {
                $('#txt_details').val(details_id);
            } else {
                $('#txt_details').val('');
            }
        }
    </script>


@endsection
