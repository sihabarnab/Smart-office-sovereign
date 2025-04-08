@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">BILL INFORMATION</h1>
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
                        <form action="{{ route('mt_bill_store') }}" method="post">
                            @csrf
                            <div class="row mb-1">

                                <div class="col-3">
                                    <select class="form-control" id="cbo_quotation_id" name="cbo_quotation_id">
                                        <option value="">-Select Quotation-</option>
                                        @foreach ($m_quotation_master as $value)
                                            <option value="{{ $value->quotation_id }}">{{ $value->quotation_master_id }} |
                                                {{ $value->customer_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_quotation_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_date" placeholder="Quotation Date"
                                        readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_address"
                                        placeholder="Customer Address" readonly>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_name" placeholder="Customer Name"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_mobile" placeholder="Customer Mobile"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_prefer" placeholder="Prefer By"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_approved" placeholder="Approved By"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                        value="{{ old('txt_subject') }}" placeholder="Subject" list="sub_op">
                                    <datalist id="sub_op">
                                        <option>Bill for </option>
                                        <option>Bill for lift Door Motore Repaire.</option>
                                    </datalist>

                                    @error('txt_subject')
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
                                <div class="col-lg-10 col-md-12 col-sm-12 mb-1">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <button type="Submit"  class="btn btn-primary btn-block">Next</button>
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
            $('select[name="cbo_quotation_id"]').on('change', function() {

                var cbo_quotation_id = $(this).val();
                if (cbo_quotation_id) {
                    $.ajax({
                        url: "{{ url('/get/bill/customer_quotation') }}/" +
                            cbo_quotation_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_date').val('');
                            $('#txt_address').val('');
                            $('#txt_name').val('');
                            $('#txt_mobile').val('');
                            $('#txt_prefer').val('');
                            $('#txt_approved').val('');
                            $('#txt_due').val('');
                            //
                            var data1 = data[0];
                            var balance = data[1];
                            $('#txt_date').val(data1.quotation_date);
                            $('#txt_address').val(data1.customer_add);
                            $('#txt_name').val(data1.customer_name);
                            $('#txt_mobile').val(data1.customer_phone);
                            $('#txt_prefer').val(data1.prefer_by);
                            $('#txt_approved').val(data1.approved_by);
                            $('#txt_due').val(balance.toFixed(2));
                        },
                    });

                } else {
                    $('#txt_date').val('');
                    $('#txt_address').val('');
                    $('#txt_name').val('');
                    $('#txt_mobile').val('');
                    $('#txt_prefer').val('');
                    $('#txt_approved').val('');
                    $('#txt_due').val('');
                }

            });
        });
    </script>
@endsection
