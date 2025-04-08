@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Servicing Bill</h1>
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
                        <form action="{{ route('servicing_bill_update', $service_bill_master->service_bill_master_id) }}"
                            method="post">
                            @csrf
                            <div class="row btn-primary">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    customer
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    Project
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select class="form-control" id="cbo_customer_id" name="cbo_customer_id">
                                        <option value="">-Select customer-</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}"
                                                {{ $row->customer_id == $service_bill_master->customer_id ? 'selected' : '' }}>
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                        <option value="">--Select Project--</option>
                                        <option value="{{ $m_project->project_id }}" selected>{{ $m_project->project_name }}
                                        </option>
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="row btn-primary">
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    Start Date
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    End Date
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    Month Qty
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    Lift Qty
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    Rate
                                </div>

                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    Total
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="date" class="form-control" id="txt_start_date" name="txt_start_date"
                                        value="{{ $service_bill_master->start_date }}" placeholder="Start Date">
                                    @error('txt_start_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="date" class="form-control" id="txt_end_date" name="txt_end_date"
                                        value="{{ $service_bill_master->end_date }}" placeholder="End Date">
                                    @error('txt_end_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_month_qty" id="txt_month_qty"
                                        value="{{ $service_bill_master->month_qty }}" placeholder="Month Qty"
                                        onchange="total()">
                                    @error('txt_month_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_lift_qty" id="txt_lift_qty"
                                        value="{{ $service_bill_master->lift_qty }}" placeholder="Lift Qty"
                                        onchange="total()">
                                    @error('txt_lift_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_rate" id="txt_rate"
                                        value="{{ $service_bill_master->rate }}" placeholder="Rate" onchange="total()">
                                    @error('txt_rate')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_sub_total" id="txt_sub_total"
                                        placeholder="Total" readonly>
                                    @error('txt_sub_total')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row btn-primary">
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    Discount
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 d-flex">
                                    %&nbsp;&nbsp; &nbsp;&nbsp;VAT
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 d-flex">
                                    %&nbsp;&nbsp; &nbsp;&nbsp;AIT
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    Other
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    Grand Total
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <input type="number" class="form-control" id="txt_discount" name="txt_discount"
                                        value="{{ number_format($service_bill_master->discount, 2) }}"
                                        value="{{ old('txt_discount') }}" placeholder="Discount"
                                        onchange="grandTotal()">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2 d-flex">
                                    <input type="number" class="form-control" id="txt_vpp" name="txt_vpp"
                                        value="{{ $service_bill_master->vat_percent }}" placeholder="%"
                                        style="width: 30%;">
                                    <input type="number" class="form-control" id="txt_vat" name="txt_vat"
                                        value="{{ number_format($service_bill_master->vat, 2) }}"
                                        value="{{ old('txt_vat') }}" placeholder="VAT" onchange="grandTotal()">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2 d-flex">
                                    <input type="number" class="form-control" id="txt_tt" name="txt_tt"
                                        value="{{ $service_bill_master->ait_percent }}" placeholder="%"
                                        style="width: 30%;">
                                    <input type="number" class="form-control" id="txt_ait" name="txt_ait"
                                        value="{{ number_format($service_bill_master->ait, 2) }}"
                                        value="{{ old('txt_ait') }}" placeholder="AIT" onchange="grandTotal()">
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <input type="number" class="form-control" id="txt_other" name="txt_other"
                                        value="{{ number_format($service_bill_master->other, 2) }}"
                                        value="{{ old('txt_other') }}" placeholder="Other" onchange="grandTotal()">
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <input type="number" class="form-control" id="txt_gt" name="txt_gt"
                                        value="{{ old('txt_gt') }}" placeholder="Grand Total" readonly>
                                </div>
                            </div>

                            <div class="row btn-primary">
                                <div class="col-lg-8 col-sm-12 col-md-12">
                                    Subject
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    Issue Date
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 col-sm-12 col-md-12 mb-2">
                                    <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                        value="{{ $service_bill_master->subject }}" placeholder="Subject"
                                        list="sub_op">
                                    <datalist id="sub_op">
                                        <option>Bill for </option>
                                        <option>Lift Servicing and Maintenance Bill.</option>
                                    </datalist>

                                    @error('txt_subject')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <input type="date" class="form-control" id="txt_issue_date" name="txt_issue_date"
                                        value="{{ $service_bill_master->issue_date }}" placeholder="Issue Date">
                                    @error('txt_issue_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row btn-primary">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                   Bill Description
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-2">
                                    <input type="text" class="form-control" id="txt_description"
                                        name="txt_description" value="{{ $service_bill_master->description }}"
                                        placeholder="Description">
                                    @error('txt_description')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                                    <textarea name="txt_due_description" id="txt_due_description" cols="10" rows="3" class="form-control"
                                        placeholder="Due Description">{{ $service_bill_master->due_description }}</textarea>
                                    @error('txt_due_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <label for="txt_due">Previous Due</label>
                                    <input type="number" class="form-control" name="txt_due" id="txt_due"
                                        placeholder="Previous Due" value="{{ $service_bill_master->previous_due }}"
                                        readonly>
                                    @error('txt_due')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
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
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            total();
            $('#txt_vpp').on('change', function() {
                vat();
            });
            $('#txt_tt').on('change', function() {
                ait();
            });
        });

        function vat() {
            var vat = $('#txt_vpp').val();
            if (vat) {
                var price = $('#txt_sub_total').val();
                var tax = (price / 100) * vat;
                $('#txt_vat').val(tax.toFixed(2));
                grandTotal();
            } else {
                $('#txt_vpp').empty();
                $('#txt_vat').empty();
            }
        }

        function ait() {
            var ait = $('#txt_tt').val();
            if (ait) {
                var price = $('#txt_sub_total').val();
                var totalValue = (price / 100) * ait;
                $('#txt_ait').val(totalValue.toFixed(2));
                grandTotal();
            } else {
                $('#txt_tt').val('');
                $('#txt_ait').val('');
            }
        }
    </script>


    <script>
        function total() {
            $('#txt_gt').val('');
            var month = parseFloat($('#txt_month_qty').val()) || 0;
            var lift = parseFloat($('#txt_lift_qty').val()) || 0;
            var rate = parseFloat($('#txt_rate').val()) || 0;
            var sum = month * (lift * rate);
            $('#txt_sub_total').val(sum.toFixed(2));
            vat();
            ait();
            grandTotal();
        }

        function grandTotal() {
            $('#txt_gt').val('');
            var discount = parseFloat($('#txt_discount').val()) || 0;
            var vat = parseFloat($('#txt_vat').val()) || 0;
            var ait = parseFloat($('#txt_ait').val()) || 0;
            var other = parseFloat($('#txt_other').val()) || 0;
            var subtotal = parseFloat($('#txt_sub_total').val()) || 0;
            var sum = (subtotal - discount) + vat + ait + other;
            $('#txt_gt').val(sum.toFixed(2));
        }
    </script>
@endsection
