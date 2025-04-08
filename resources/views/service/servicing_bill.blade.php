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
                        <form action="{{ route('servicing_bill_store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select class="form-control" id="cbo_customer_id" name="cbo_customer_id">
                                        <option value="">-Select customer-</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}">
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                        <option value="">-Select project-</option>
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <div class="input-group date" id="sedate3" data-target-input="nearest"
                                        onchange="getMonthDifference()">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_start_date"
                                            name="txt_start_date" placeholder="Start Month" value="{{ old('txt_year') }}"
                                            data-target="#sedate3" onchange="getMonthDifference()">
                                        <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('txt_start_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <div class="input-group date" id="sedate4" data-target-input="nearest"
                                        onchange="getMonthDifference()">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_end_date"
                                            name="txt_end_date" placeholder="End Month" value="{{ old('txt_year') }}"
                                            data-target="#sedate4" onchange="getMonthDifference()">
                                        <div class="input-group-append" data-target="#sedate4" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('txt_end_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_month_qty" id="txt_month_qty"
                                        placeholder="Month Qty" onchange="total()">
                                    @error('txt_month_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_lift_qty" id="txt_lift_qty"
                                        placeholder="Lift Qty" onchange="total()">
                                    @error('txt_lift_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_rate" id="txt_rate"
                                        placeholder="Rate" onchange="total()">
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

                            <div class="row">
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <input type="number" class="form-control" id="txt_discount" name="txt_discount"
                                        value="{{ old('txt_discount') }}" placeholder="Discount" onchange="grandTotal()">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2 d-flex">

                                    <input type="number" class="form-control" id="txt_vpp" name="txt_vpp"
                                        value="{{ old('txt_vpp') }}" placeholder="%" style="width: 30%;">
                                    <input type="number" class="form-control" id="txt_vat" name="txt_vat"
                                        value="{{ old('txt_vat') }}" placeholder="VAT" style="width: 70%;" onchange="grandTotal()">


                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2 d-flex">
                                    <input type="number" class="form-control" id="txt_tt" name="txt_tt"
                                        value="{{ old('txt_tt') }}" placeholder="%" style="width: 30%;">
                                    <input type="number" class="form-control" id="txt_ait" name="txt_ait"
                                        value="{{ old('txt_ait') }}" placeholder="AIT" style="width: 70%;" onchange="grandTotal()">
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <input type="number" class="form-control" id="txt_other" name="txt_other"
                                        value="{{ old('txt_other') }}" placeholder="Other" onchange="grandTotal()">
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <input type="number" class="form-control" id="txt_gt" name="txt_gt"
                                        value="{{ old('txt_gt') }}" placeholder="Grand Total" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-sm-12 col-md-12 mb-2">
                                    <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                        value="Lift Servicing and Maintenance Bill." placeholder="Subject"
                                        list="sub_op">
                                    <datalist id="sub_op">
                                        <option>Lift Servicing and Maintenance Bill.</option>
                                    </datalist>

                                    @error('txt_subject')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_issue_date" name="txt_issue_date"
                                        value="{{ old('txt_issue_date') }}" placeholder="Issue Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_issue_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-2">
                                    <textarea name="txt_description" id="txt_description" cols="10" rows="2" class="form-control"
                                        placeholder="Description">{{ 'Monthly servicing and maintenance Bill for the month of January-2025' }}</textarea>
                                    @error('txt_description')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                                    <textarea name="txt_due_description" id="txt_due_description" cols="10" rows="3" class="form-control"
                                        placeholder="Due Description"></textarea>
                                    @error('txt_due_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <label for="txt_due">Previous Due</label>
                                    <input type="number" class="form-control" name="txt_due" id="txt_due"
                                        placeholder="Previous Due" readonly>
                                    @error('txt_due')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12 mb-1">
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Save</button>
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
            $('select[name="cbo_customer_id"]').on('change', function() {
                var cbo_customer_id = $(this).val();
                if (cbo_customer_id) {

                    $.ajax({
                        url: "{{ url('/get/complete_project/') }}/" + cbo_customer_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_project_id"]').empty();
                            $('select[name="cbo_project_id"]').append(
                                '<option value="0">--Select Project--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_project_id"]').append(
                                    '<option value="' + value.project_id + '">' +
                                    value.project_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_project_id"]').empty();
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_project_id"]').on('change', function() {
                var cbo_project_id = $(this).val();
                var cbo_customer_id = $('#cbo_customer_id').val();
                if (cbo_project_id) {

                    $.ajax({
                        url: "{{ url('/get/service/previous_due/') }}/" + cbo_project_id + '/' +
                        cbo_customer_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_due').val(data.toFixed(2));

                        },
                    });

                } else {
                    $('#txt_due').val('');
                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sedate3').datetimepicker({
                format: 'YYYY-MM'
            });
            $('#sedate4').datetimepicker({
                format: 'YYYY-MM'
            });
        });

        function getMonthDifference() {
            var startDate = $('#txt_start_date').val();
            var endDate = $('#txt_end_date').val();
            if (startDate && endDate) {
                const [startYear, startMonth] = startDate.split('-').map(Number);
                const [endYear, endMonth] = endDate.split('-').map(Number);
                const months = (endYear - startYear) * 12 + (endMonth - startMonth);
                $('#txt_month_qty').val((months + 1));
            } else {
                $('#txt_month_qty').val('');
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_vpp').on('change', function() {
                vat();
            });
            $('#txt_tt').on('change', function() {
                ait();
            });
        });

        function vat(){
            var vat = $('#txt_vpp').val();
                if (vat) {
                    var price =  $('#txt_sub_total').val();
                    var tax = (price / 100) * vat;
                    $('#txt_vat').val(tax.toFixed(2));
                    grandTotal();
                } else {
                    $('#txt_vpp').empty();
                    $('#txt_vat').empty();
                }
        }
        function ait(){
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
            var sum =  month * (lift * rate);
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
