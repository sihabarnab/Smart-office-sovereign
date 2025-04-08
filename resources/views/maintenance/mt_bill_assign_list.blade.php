@extends('layouts.maintenance_app')

@section('content')
    <div class="container-fluid mt-5">
        @include('flash-message')
    </div>

    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                @php
                    $total = 0;
                @endphp
                @foreach ($bill_assign_list as $row)
                    @php

                        $employee = DB::table('pro_employee_info')
                            ->where('employee_id', $row->employee_id)
                            ->first();
                        $employee_name = $employee == null ? '' : $employee->employee_name;

                        $maintenance_bill_master = DB::table('pro_maintenance_bill_master')
                            ->where('maintenance_bill_master_no', $row->maintenance_bill_master_no)
                            ->first();
                        if ($maintenance_bill_master->repair_price > 0) {
                            $total = $maintenance_bill_master->grand_total + $maintenance_bill_master->repair_price + $maintenance_bill_master->previous_due;
                        } else {
                            $total = $maintenance_bill_master->grand_total + $maintenance_bill_master->previous_due;
                        }

                        $recive = DB::table('pro_maintenance_money_receipt')
                            ->where('maintenance_bill_master_id', $maintenance_bill_master->maintenance_bill_master_id)
                            ->whereNull('due_status')
                            ->sum('paid_amount');
                        $due = $total - $recive;

                        $m_customer = DB::table('pro_customers')
                            ->where('customer_id', $row->customer_id)
                            ->where('valid', 1)
                            ->first();
                        $customer_name = $m_customer == null ? '' : $m_customer->customer_name;

                    @endphp
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="card border border-success  {{ $row->status == 1 ? '' : 'btn-primary' }}">
                            <div class="card-header border border-success">
                                {{ $row->remarks }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Invoice No: {{ $row->maintenance_bill_master_no }} <br>
                                    Customer: {{ $customer_name }} <br>
                                    Total: {{ number_format($total,2) }} <br>
                                    Employee: {{ $employee_name }}. <br>
                                    Date: {{ $row->colection_date }}.
                                </p>

                            </div>
                            <div class=" border border-success">

                                @if ($row->status == 3)
                                    <form action="{{ route('mt_task_review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="txt_bill_assign_id"
                                            value="{{ $row->mt_bill_assign_id }}">
                                        <button type="submit" class="btn btn-success float-right m-2">Review</button>
                                    </form>
                                @elseif ($row->status == 2)
                                    <form action="{{ route('mtEndJourney') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="txt_bill_assign_id"
                                            value="{{ $row->mt_bill_assign_id }}">
                                        <button type="submit" class="btn btn-success float-right m-2">End Journey</button>
                                    </form>
                                @elseif($row->status == 1)
                                    <form action="{{ route('mtStartJourney') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="latitude" id="latitude" value="0">
                                        <input type="hidden" name="longitude" id="longitude" value="0">
                                        <input type="hidden" name="txt_bill_assign_id"
                                            value="{{ $row->mt_bill_assign_id }}">
                                        <button type="submit" class="btn btn-success float-right m-2">Start
                                            Journey</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div><!-- /.col -->
                @endforeach
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
@endsection
