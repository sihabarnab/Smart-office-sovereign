@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUOTATION APPROVED (MGM)</h1>
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
                        <form action="{{ route('mt_quotation_approved_details_mgm') }}" method="get">
                            @csrf
                            <div class="row">

                                <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
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
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                                    <input type="text" class="form-control" id="txt_date" placeholder="Quotation Date"
                                        readonly>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-1">
                                    <input type="text" class="form-control" id="txt_address"
                                        placeholder="Customer Address" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_name" placeholder="Customer Name"
                                        readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_mobile" placeholder="Customer Mobile"
                                        readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_subject" placeholder="Subject"
                                        readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_prepare" placeholder="Prepare By"
                                        readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-6 col-sm-3 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-9 mb-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Next</button>
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
                        url: "{{ url('/get/prepare_quotation') }}/" +
                            cbo_quotation_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data1) {
                            $('#txt_date').val(data1.quotation_date);
                            $('#txt_address').val(data1.customer_address);
                            $('#txt_name').val(data1.customer_name);
                            $('#txt_mobile').val(data1.customer_mobile);
                            $('#txt_subject').val(data1.subject);
                            $('#txt_prepare').val(data1.employee_name);
                        },
                    });


                } else {
                    $('#txt_date').val('');
                    $('#txt_address').val('');
                    $('#txt_name').val('');
                    $('#txt_mobile').val('');
                    $('#txt_subject').val('');
                    $('#txt_prepare').val('');
                }

            });
        });
    </script>
@endsection
