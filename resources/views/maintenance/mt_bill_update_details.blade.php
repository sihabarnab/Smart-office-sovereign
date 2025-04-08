@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Bill Details</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row" id="qd">
                            <div class="col-2">
                                <p class="m-0">Invoice No<br>
                                    Quotation No
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="m-0">
                                    <span>:&nbsp;</span>{{ $m_bill_master->maintenance_bill_master_no }}
                                    <br>
                                    <span>:&nbsp;</span>{{ $m_bill_master->quotation_master_id }}
                                </p>
                            </div>
                            <div class="col-2">
                                <p class="m-0">
                                    Invoice Date <br>
                                    Quotation Date
                                </p>
                            </div>
                            <div class="col-2 ">
                                <p class="m-0">
                                    <span>:&nbsp;</span> {{ $m_bill_master->entry_date }} <br>
                                    <span>:&nbsp;</span> {{ $m_bill_master->quotation_date }}
                                </p>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-2">
                                Contact <br>
                                Subject
                            </div>
                            <div class="col-10">
                                : {{ $m_bill_master->customer_name }} ({{ $m_bill_master->customer_phone }}) <br>
                                : {{ $m_bill_master->subject }}

                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $sub_total = 0.00;
        $repair_price = 0.00;
        $i = 1;
    @endphp

  
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            <table class="table table-sm mb-1">
                                <thead>
                                    <tr>
                                        <th width='55%' class="text-left">Service/Repair Details</th>
                                        <th width='15%' class="text-center">Qty</th>
                                        <th width='15%' class="text-center">Total</th>
                                        <th width='15%' class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $repair_price = $m_bill_master->repair_price;
                                    @endphp
                                    <form action="{{ route('mt_bill_update_repair_store') }}" method="post">
                                        @csrf
                                        <input type="hidden" class="form-control" name="txt_maintenance_bill_master_id3"
                                            value="{{ $m_bill_master->maintenance_bill_master_id }}">
                                        <tr>
                                            <td class="pr-0"> <input type="text" class="form-control"
                                                    name="txt_description" value="{{ $m_bill_master->repair_descrption }}">
                                            </td>
                                            <td class="pr-0 text-center"> <input type="number" class="form-control"
                                                    name="txt_qty2" value="{{ $m_bill_master->repair_qty }}"> </td>
                                            <td class="pr-0 text-center"> <input type="number" class="form-control"
                                                    name="txt_repair_price" value="{{ $m_bill_master->repair_price }}">
                                            </td>
                                            <td class="text-center"> <button type="Submit" id=""
                                                    class="btn btn-primary btn-block">Update</button></td>
                                        </tr>
                                    </form>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  


    @if ($m_bill_master->previous_due)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            <table class="table table-sm mb-1">
                                <thead>
                                    <tr>
                                        <th width='40%' class="text-left">Due Description</th>
                                        <th width='10%' class="text-center">Qty</th>
                                        <th width='10%' class="text-center">Rate</th>
                                        <th width='15%' class="text-right">Total</th>
                                        <th width='15%' class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <form action="{{ route('mt_bill_update_due_description') }}" method="post">
                                        @csrf
                                        <input type="hidden" class="form-control" name="txt_maintenance_bill_master_id2"
                                            value="{{ $m_bill_master->maintenance_bill_master_id }}">

                                        @php
                                            $previous_due = $m_bill_master->previous_due;
                                        @endphp
                                        <tr>
                                            <td class="pr-0"> <input type="text" class="form-control"
                                                    name="txt_due_description"
                                                    value="{{ $m_bill_master->due_description }}"> </td>
                                            <td class="pr-0"> <input type="number" class="form-control" value="----"
                                                    readonly> </td>
                                            <td class="pr-0"> <input type="number" class="form-control" value="----"
                                                    readonly> </td>
                                            <td class="pr-0"> <input type="number" class="form-control"
                                                    value="{{ $m_bill_master->previous_due }}" readonly> </td>
                                            <td class="text-right">

                                                <button type="Submit" id=""
                                                    class="btn btn-primary btn-block">Update</button>
                                            </td>
                                        </tr>
                                    </form>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm mb-1">
                            <thead>
                                <tr>
                                    <th width='5%' class="text-center">SL No.</th>
                                    <th width='20%' class="text-center">Product</th>
                                    <th width='8%' class="text-center">Unit</th>
                                    <th width='10%' class="text-center">Qty</th>
                                    <th width='10%' class="text-center">Rate</th>
                                    <th width='10%' class="text-center">Update Qty</th>
                                    <th width='10%' class="text-center">Update Rate</th>
                                    <th width='10%' class="text-right">Total</th>
                                    <th width='8%' class="text-right"></th>
                                    <th width='9%' class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                @foreach ($m_bill_details as $key => $row)
                                    <form action="{{ route('mt_bill_update_store') }}" method="post">
                                        @csrf
                                        {{-- //hidden --}}
                                        <input type="hidden" class="form-control" name="txt_product_id"
                                            value="{{ $row->product_id }}">
                                        <input type="hidden" class="form-control" name="txt_maintenance_bill_details_id"
                                            value="{{ $row->maintenance_bill_details_id }}">

                                        @php
                                            $sub_total += $row->update_sub_total==null?0:$row->update_sub_total;
                                        @endphp
                                        <tr>
                                            <td class="pr-0"> <input type="text" class="form-control text-center"
                                                    value="{{ $i++ }}" readonly></td>
                                            <td class="pr-0"> 
                                                <input type="text" class="form-control"
                                                    value="{{ $row->product_name }}" readonly> 
                                                </td>
                                            <td>
                                                <input type="text" class="form-control text-center"
                                                value="{{ $row->unit_name }}" readonly>
                                            </td>
                                            <td class="pr-0" class="text-right text-center">
                                                <input type="number" class="form-control" 
                                                    value="{{ $row->qty }}" readonly>
                                            </td>
                                            <td class="pr-0" class="text-right text-center">
                                                <input type="number" class="form-control" 
                                                    value="{{ $row->rate }}" readonly>
                                            </td>
                                            <td class="pr-0" class="text-right text-center">
                                                <input type="number" class="form-control" name="txt_qty"
                                                    value="{{ $row->update_qty }}">
                                            </td>
                                            <td class="pr-0" class="text-right text-center">
                                                <input type="number" class="form-control " name="txt_rate"
                                                    value="{{ $row->update_rate }}">
                                            </td>

                                            <td class="pr-0" class="text-right text-center"><input type="number"
                                                    class="form-control text-right" name="txt_total" value="{{ $row->update_sub_total }}" readonly>
                                            </td>

                                            <td class="text-right">
                                                <button type="Submit" id=""
                                                class="btn btn-primary ml-2">Update</button>

                                            </td>
                                            <td>
                                                 <!-- Reject trigger modal -->
                                                 <button type="button" class="btn btn-danger float-right" data-toggle="modal"
                                                 data-target="#confirmModal"
                                                 onclick='RemoveBillProduct("{{ $row->maintenance_bill_details_id }}")'>
                                                 Remove
                                             </button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach


                                <tr class="table-bordered">
                                    <td colspan="6"></td>
                                </tr>
                            </tbody>
                        </table>

                        <form action="{{ route('mt_bill_update_final') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="txt_maintenance_bill_master_id"
                                value="{{ $m_bill_master->maintenance_bill_master_id }}">
                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-1">
                                    <p class="mt-1">Sub-Total</p>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control  text-right"
                                        value="{{ number_format($sub_total + $repair_price + $previous_due,2)}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-1">
                                    <p class="mt-1">Discount</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control  text-right" id="txt_dpp"
                                                name="txt_dpp" value="{{$m_bill_master->discount_percent}}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control  text-right" id="txt_discount"
                                                name="txt_discount" value=" {{ $m_bill_master->discount }}"
                                                placeholder="Discount">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-1">
                                    <p class="mt-1">VAT</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control text-right" id="txt_vpp"
                                                name="txt_vpp" value="{{$m_bill_master->vat_percent}}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control text-right" id="txt_vat"
                                                name="txt_vat" value="{{ $m_bill_master->vat }}" placeholder="VAT">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-1">
                                    <p class="mt-1">AIT</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control text-right" id="txt_tt"
                                                name="txt_tt" value="{{ $m_bill_master->ait_percent }}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control  text-right" id="txt_ait"
                                                name="txt_ait" value="{{ $m_bill_master->ait }}" placeholder="AIT">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-1">
                                    <p class="mt-1">Others</p>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control text-right" id="txt_ot"
                                                name="txt_ot" value="{{ $m_bill_master->other_percent }}" placeholder="%">
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control text-right" id="txt_other"
                                                name="txt_other" value="{{ $m_bill_master->other }}"
                                                placeholder="Other">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <p class="mt-1" >Grand Total</p>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control  text-right" id="txt_gt" name="txt_gt"
                                       >
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col-10">

                                </div>

                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Update
                                        Final</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                    <form action="{{ route('mt_bill_update_remove') }}" method="GET">
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
    <script>
        $(document).ready(function() {
            discount();
            other();
            ait();
            vat();
            grandTotal();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_dpp').on('change', function() {
                discount();
            });
            $('#txt_vpp').on('change', function() {
                vat();
            });
            $('#txt_tt').on('change', function() {
                ait();
            });
            $('#txt_ot').on('change', function() {
                other();
            });
        });

        function discount() {
            var discount = $("#txt_dpp").val();
            if (discount) {
                var price = "{{ $sub_total + $repair_price + $previous_due }}";
                var totalValue = (price * (discount / 100));
                $('#txt_discount').val(totalValue.toFixed(2));
                grandTotal();
            } else {
                $('#txt_dpp').empty();
                $('#txt_discount').empty();
            }
        }

        function other() {
            var other = $('#txt_ot').val();
            if (other) {
                var price = "{{ $sub_total + $repair_price + $previous_due }}";
                var totalValue = (price * (other / 100));
                $('#txt_other').val(totalValue.toFixed(2));
                grandTotal();
            } else {
                $('#txt_ot').val('');
                $('#txt_other').val('');
            }
        }

        function ait() {
            var ait = $('#txt_tt').val();
            if (ait) {
                var price = "{{ $sub_total + $repair_price + $previous_due }}";
                var totalValue = (price / 100) * ait;
                $('#txt_ait').val(totalValue.toFixed(2));
                grandTotal();
            } else {
                $('#txt_tt').val('');
                $('#txt_ait').val('');
            }
        }

        function vat() {
            var vat = $("#txt_vpp").val();
            if (vat) {
                var price = "{{ $sub_total + $repair_price + $previous_due }}";
                var tax = (price / 100) * vat;
                $('#txt_vat').val(tax.toFixed(2));
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
            var subtotal = parseFloat("{{ $sub_total + $repair_price + $previous_due }}") || 0;
            var sum = (subtotal - discount) + vat + ait + other;
            $('#txt_gt').val(sum.toFixed(2));
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to format number to 2 decimal places
            function formatNumber(number) {
                return number.toFixed(2);
            }

            // Function to calculate the total for a row
            function calculateRowTotal(row) {
                const qtyField = row.querySelector('input[name="txt_qty"]');
                const rateField = row.querySelector('input[name="txt_rate"]');
                const totalField = row.querySelector('input[name="txt_total"]');

                if (qtyField && rateField && totalField) {
                    const qty = parseFloat(qtyField.value) || 0;
                    const rate = parseFloat(rateField.value) || 0;
                    const total = qty * rate;
                    totalField.value = formatNumber(total);
                }
            }

            // Get all rows
            const rows = document.querySelectorAll('tr');

            rows.forEach(row => {
                const qtyField = row.querySelector('input[name="txt_qty"]');
                const rateField = row.querySelector('input[name="txt_rate"]');

                if (qtyField && rateField) {
                    // Add event listeners to qty and rate fields
                    qtyField.addEventListener('change', () => calculateRowTotal(row));
                    rateField.addEventListener('change', () => calculateRowTotal(row));
                }
            });
        });
    </script>

<script>
    function RemoveBillProduct(details_id) {
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
