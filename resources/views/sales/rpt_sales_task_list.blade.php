@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task List</h1>
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
                        <form action="{{ route('rpt_sales_task_search') }}" method="GET">
                            @csrf

                            <div class="row">

                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                        <option value="">--Select Employee--</option>
                                        @foreach ($employees as $row)
                                            <option value="{{ $row->employee_id }}"
                                                {{ $row->employee_id == $employee_id ? 'selected' : '' }}>
                                                {{ $row->employee_id }}|{{ $row->employee_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_employee_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <input type="date" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" value="{{$form}}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <input type="date" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" value="{{$to}}">
                                    @error('txt_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <button type="Submit" class="btn btn-primary float-right pl-5 pr-5">Search</button>
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
                        <table  class="table  table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Task Title</th>
                                    <th>Task Type</th>
                                    <th>Customer</th>
                                    <th>Priority</th>
                                    <th>Scheduled Date</th>
                                    <th>Assign By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($sales_task as $key=>$row)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$row->task_title}}</td>
                                    <td>{{$row->task_type}}</td>
                                    <td>{{$row->customer_name}}</td>
                                    <td>{{$row->priority}}</td>
                                    <td>{{$row->due_date}}</td>
                                    <td>{{$row->employee_name}}</td>
                                    <td>
                                      @isset($row->review_status)
                                         {{$row->review_status}}  
                                      @endisset
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
@endsection