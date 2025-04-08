@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task</h1>
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
                        <form action="{{ route('store_task') }}" method="Post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-9 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_task_title" name="txt_task_title"
                                        placeholder="Task Title" value="{{ old('txt_task_title') }}">
                                    @error('txt_task_title')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_task_type" id="cbo_task_type" class="form-control">
                                        <option value="">--Select Type--</option>
                                        <option value="MEETING">MEETING</option>
                                        <option value="MAIL">MAIL</option>
                                        <option value="CALL">CALL</option>
                                    </select>
                                    @error('cbo_task_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5 col-sm-12 col-md-12 mb-2">
                                    <select name="cbo_customer" id="cbo_customer" class="form-control">
                                        <option value="">--Select Client--</option>
                                        @foreach ($m_customer as $value)
                                            <option value="{{ $value->customer_id }}"
                                                {{ $value->customer_id == old('cbo_customer') ? 'selected' : '' }}>
                                                {{ $value->customer_name }} | {{ $value->customer_phone }}</option>
                                        @endforeach

                                    </select>
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-7 col-sm-12 col-md-12 mb-2">
                                    <input type="text" id='txt_customer_address' name="txt_customer_address"
                                        class="form-control" placeholder="Client Address" readonly>

                                </div>

                                {{-- <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_contact_person"
                                        name="txt_contact_person" placeholder="Contact Person"
                                        value="{{ old('txt_contact_person') }}">
                                    @error('txt_contact_person')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" id="txt_due_date" name="txt_due_date"
                                        value="{{ old('txt_due_date') }}" placeholder="Scheduled Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_due_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_task_priority" id="cbo_task_priority" class="form-control">
                                        <option value="">--Select Priority--</option>
                                        <option value="HIGH">HIGH</option>
                                        <option value="MEDIUM">MEDIUM</option>
                                        <option value="LOW">LOW</option>
                                    </select>
                                    @error('cbo_task_priority')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="Submit" class="btn btn-primary float-right pl-5 pr-5">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table  table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Task Title</th>
                                    <th>Task Type</th>
                                    <th>Client</th>
                                    <th>Priority</th>
                                    <th>Scheduled Date</th>
                                    <th>Assign By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales_task as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->task_title }}</td>
                                        <td>{{ $row->task_type }}</td>
                                        <td>
                                            {{ $row->customer_name }} <br> 
                                            {{ $row->customer_phone }}
                                        </td>
                                        <td>{{ $row->priority }}</td>
                                        <td>{{ $row->due_date }}</td>
                                        <td>{{ $row->employee_name }}</td>
                                        <td>
                                            @if ($row->status == 1)
                                                <form action="{{ route('sales_start_journey') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="latitude" id="latitude" value="0">
                                                    <input type="hidden" name="longitude" id="longitude" value="0">
                                                    <input type="hidden" name="txt_task_id" value="{{ $row->task_id }}">
                                                    <button type="submit" class="btn btn-success float-right m-0">Start
                                                        Journey</button>
                                                </form>
                                            @elseif($row->status == 2)
                                                <a href="{{ route('sales_end_journey', $row->task_id) }}"
                                                    class="btn btn-success float-right m-0">End Journey</a>
                                            @elseif($row->status == 3)
                                                <a href="{{ route('review_task', $row->task_id) }}"
                                                    class="btn btn-success float-right m-0">Review Task</a>
                                            @endif
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
        $(document).ready(function() {
            //defult call
            getLocation();

            //check location on /off
            navigator.geolocation.watchPosition(function(position) {
                    console.log("Location Found , Success!");
                },
                function(error) {
                    if (error.code == error.PERMISSION_DENIED)
                        alert("Please, On Your Location");


                });
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;

            if (lat) {
                $('#latitude').val('');
                $('#longitude').val('');

                $('#latitude').val(lat);
                $('#longitude').val(long);
                //
                $('#latitude_01').val(lat);
                $('#longitude_01').val(long);
            }
        }
    </script>

    <script>
        var cbo_customer = $('#cbo_customer').val();
        if (cbo_customer) {
            getCustomerDetails();
        }

        $(document).ready(function() {
            $('select[name="cbo_customer"]').on('change', function() {
                getCustomerDetails();
            });
        });

        function getCustomerDetails() {
            var cbo_customer = $('#cbo_customer').val();
            if (cbo_customer) {
                $.ajax({
                    url: "{{ url('/get/sales/customer_details') }}/" + cbo_customer,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#txt_customer_address').val(data);

                    },
                });

            } else {
                $('#txt_customer_address').val('');
            }
        }
    </script>
@endsection
