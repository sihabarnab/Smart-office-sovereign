@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CUSTOMER QUOTATION (APPROVED)</h1>
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
                        <form action="{{ route('mt_customer_quotation_approved_edit') }}" method="GET">
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

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_name" placeholder="Customer Name"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_mobile" placeholder="Customer Mobile"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_subject" placeholder="Subject"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_approved" placeholder="Approved By"
                                        readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($reject_quotation_master->count()>0)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CUSTOMER QUOTATION (REJECT)</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="quotation_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Qu. No / Date</th>
                                    <th>Subject</th>
                                    <th>Valid</th>
                                    <th>Prepare By</th>
                                    <th>Reject Comment</th>
                                    <th>Reject(MGM)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($reject_quotation_master as $key => $value)
                                        <form action="{{ route('mt_customer_quotation_approved_edit') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="cbo_quotation_id"
                                                value="{{ $value->quotation_id }}">
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->quotation_master_id }} <br> {{ $value->quotation_date }}</td>
                                    <td>{{ $value->subject }}</td>
                                    <td>{{ $value->offer_valid }}</td>
                                    <td>
                                        @php
                                            $employee = DB::table('pro_employee_info')
                                                ->where('employee_id', $value->user_id)
                                                ->first();
                                            if ($employee == null) {
                                                $Prepare = '';
                                            } else {
                                                $Prepare = $employee->employee_name;
                                            }
                                        @endphp
                                        {{ $Prepare }}
                                    </td>

                                    <td>{{ $value->reject_comment }}</td>
                                    <td>
                                        @php
                                            $reject_employee = DB::table('pro_employee_info')
                                                ->where('employee_id', $value->mgm_confirm_approved_id)
                                                ->first();
                                            if ($reject_employee == null) {
                                                $Reject = '';
                                            } else {
                                                $Reject = $reject_employee->employee_name;
                                            }
                                        @endphp
                                        {{ $Reject }}
                                    </td>
                                    <td><button type="Submit" id=""
                                            class="btn btn-primary btn-block">Next</button></td>
                                </tr>
                                </form>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_quotation_id"]').on('change', function() {

                var cbo_quotation_id = $(this).val();
                if (cbo_quotation_id) {
                    $.ajax({
                        url: "{{ url('/get/approved_quotation') }}/" +
                            cbo_quotation_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data1) {
                            $('#txt_date').val(data1.quotation_date);
                            $('#txt_address').val(data1.customer_address);
                            $('#txt_name').val(data1.customer_name);
                            $('#txt_mobile').val(data1.customer_mobile);
                            $('#txt_subject').val(data1.subject);
                            $('#txt_approved').val(data1.employee_name);
                        },
                    });

                } else {
                    $('#txt_date').val('');
                    $('#txt_address').val('');
                    $('#txt_name').val('');
                    $('#txt_mobile').val('');
                    $('#txt_subject').val('');
                    $('#txt_approved').val('');
                }

            });
        });
    </script>
@endsection
