@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUOTATION</h1>
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
                        <form action="{{ route('mt_quotation_store') }}" method="post">
                            @csrf

                           
                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                            <option value="">--Select Project--</option>
                                            @foreach ($m_projects as $row)
                                                <option value="{{ $row->project_id }}">{{ $row->project_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" name="txt_customer" list="list_customer" id="txt_customer"
                                            placeholder="Customer Name">
                                        <datalist id="list_customer"></datalist>
                                        @error('txt_customer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number"
                                            value="{{ old('txt_mobile_number') }}" placeholder="Customer Phone">
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ old('txt_address') }}" placeholder="Customer Address">
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="email" class="form-control" id="txt_email" name="txt_email"
                                            value="{{ old('txt_email') }}" placeholder="Customer Email">
                                        @error('txt_email')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_attention" name="txt_attention"
                                            value="{{ old('txt_attention') }}" placeholder="Contact person">
                                        @error('txt_attention')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-md-4">
                                        <input type="text" class="form-control" id="txt_date" name="txt_date"
                                            value="{{ old('txt_date') }}" placeholder="Quotation Date"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <input type="number" class="form-control" id="txt_valid_until" name="txt_valid_until"
                                            value="{{ old('txt_valid_until') }}" placeholder="Valid until">
                                        @error('txt_valid_until')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <select name="cbo_mode_of_payment" id="cbo_mode_of_payment" class="form-control">
                                            <option value="">--Mode Of Payment--</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        @error('cbo_mode_of_payment')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject" list="demo_text"
                                            value="{{ old('txt_subject') }}" placeholder="Subject">
                                        <datalist id="demo_text">
                                            <option>Quotation for</option>
                                            <option>Quotation for lift spares parts.</option>
                                        </datalist>
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_reference_name" name="txt_reference_name"
                                            value="{{ old('txt_reference_name') }}" placeholder="Reference name">
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_reference_number" name="txt_reference_number"
                                            value="{{ old('txt_reference_number') }}" placeholder="Reference number">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="Submit" id="" class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                           
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quotation(Not Final)</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Date/Qu. No.</th>
                                    <th>Customer</th>
                                    <th>Customer Address</th>
                                    <th>Valid</th>
                                    {{-- <th>Subject</th> --}}
                                    <th>Ref. Info</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_quotation_master as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->quotation_date }}<br> {{ $row->quotation_master_id }}</td>
                                        <td>
                                            {{ $row->customer_name }}
                                        </td>
                                        <td>{{ $row->customer_address }}</td>
                                        <td>{{ $row->offer_valid }}</td>
                                        {{-- <td>{{ $row->subject }}</td> --}}
                                        <td>{{ $row->reference }}<br> {{ $row->reference_mobile }}</td>
                                        <td> <a href="{{ route('mt_quotation_details', $row->quotation_id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quotation(Reject)</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Date/Qu. No.</th>
                                    <th>Customer</th>
                                    <th>Valid</th>
                                    <th>Reject Comment</th>
                                    <th>Reject</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reject_quotation_master as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->quotation_date }}<br> {{ $row->quotation_master_id }}</td>
                                        <td>
                                            {{ $row->customer_name }} <br>
                                            {{ $row->customer_address }}
                                        </td>
                                        <td>{{ $row->offer_valid }}</td>
                                        <td>{{$row->reject_comment}}</td>
                                        <td>
                                            @php
                                                $employee = DB::table('pro_employee_info')
                                                    ->where('employee_id', $row->approved_mgm_id)
                                                    ->first();
                                                if ($employee == null) {
                                                    $employee_name = '';
                                                } else {
                                                    $employee_name = $employee->employee_name;
                                                }
                                            @endphp

                                            {{ $employee_name }}
                                        </td>
                                        <td> <a href="{{ route('mt_quotation_details', $row->quotation_id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function getCustomer() {
            $('#txt_address').val('');
            $('#txt_email').val('');
            $('#txt_mobile_number').val('');
            $('#txt_attention').val('');
            let name = $('#txt_customer').val();
            let token = "{{ csrf_token() }}";
            console.log(name);
            if (name) {
                $.ajax({
                    url: "{{ route('GetCustomer') }}",
                    type: "POST",
                    data: {
                        name: name,
                        _token: token
                    },
                    success: function(data) {
                        $('#list_customer').empty();
                        $.each(data, function(key, value) {
                            $('#list_customer').append(
                                '<option value="' + value.customer_name + '">');
                        });

                    },
                });

            } else {
                $('#list_customer').empty();
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#cbo_project_id').on('change', function() {
                var cbo_project_id = $(this).val();
                console.log(cbo_project_id);
                if (cbo_project_id) {
                    $.ajax({
                        url: "{{ url('/get/customer_details/') }}/" + cbo_project_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            if (data != '0') {
                                $('#list_customer').empty();
                                $('#txt_customer').val('');
                                $('#txt_address').val('');
                                $('#txt_email').val('');
                                $('#txt_mobile_number').val('');
                                $('#txt_attention').val('');
                                //
                                $('#txt_customer').val(data.customer_name);
                                $('#txt_address').val(data.customer_add);
                                $('#txt_mobile_number').val(data.customer_phone);
                                $('#txt_email').val(data.customer_email);
                                $('#txt_attention').val(data.contact_person);
                            } else {
                                $('#txt_customer').val('');
                                $('#txt_address').val('');
                                $('#txt_email').val('');
                                $('#txt_mobile_number').val('');
                                $('#txt_attention').val('');
                            }


                        },
                    });

                } else {
                    $('#txt_customer').val('');
                    $('#txt_address').val('');
                    $('#txt_email').val('');
                    $('#txt_mobile_number').val('');
                    $('#txt_attention').val('');
                }

            });
        });
    </script>
@endsection
