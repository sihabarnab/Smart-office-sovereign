@extends('layouts.worker_app')

@section('content')
    <div class="container-fluid mt-5">
        @include('flash-message')
    </div>

    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                @foreach ($data as $row)
                    @php
                        $helper = DB::table('pro_helpers')
                            ->leftjoin('pro_employee_info','pro_helpers.helper_id','pro_employee_info.employee_id')
                            ->select('pro_employee_info.employee_name')
                            ->where('pro_helpers.task_id', $row->task_id)
                            ->where('pro_helpers.valid',1)
                            ->get();
                    @endphp
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="card border border-success  {{ $row->status == null ? '' : 'btn-primary' }}">
                            <div class="card-header border border-success">
                                {{ $row->complaint_description }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Project: {{ $row->project_name }} <br>
                                    Address: {{ $row->project_address }}. <br>
                                    Lift: {{ $row->lift_name }}. <br>
                                    Team: {{ $row->team_name."(L)" }} 
                                    @foreach ($helper as $value)
                                       {{','.$value->employee_name}}
                                    @endforeach
                                    
                                    <br>
                                    Customer: {{ $row->customer_name }}. <br>
                                    Date: {{ $row->entry_date . ' ' . $row->entry_time }}.
                                </p>

                            </div>
                            <div class=" border border-success">
                                @if ($row->status == 'TASK_ACTIVE')
                                    <form action="{{ route('openCompletelyEndTask') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="txt_task_id" value="{{ $row->task_id }}">
                                        <button type="submit" class="btn btn-success float-right m-2">Complete
                                            Task</button>
                                    </form>
                                @elseif ($row->status == 'JOURNEY_END')
                                    <form action="{{ route('openStartTask') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="txt_task_id" value="{{ $row->task_id }}">
                                        <button type="submit" class="btn btn-success float-right m-2">Task Start</button>
                                    </form>
                                @elseif ($row->status == 'JOURNEY_STARTED')
                                    <form action="{{ route('openEndJourney') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="txt_task_id" value="{{ $row->task_id }}">
                                        <button type="submit" class="btn btn-success float-right m-2">End Journey</button>
                                    </form>
                                @else
                                    <form action="{{ route('startJourney') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="latitude" id="latitude" value="0">
                                        <input type="hidden" name="longitude" id="longitude" value="0">

                                        <input type="hidden" name="txt_task_id" value="{{ $row->task_id }}">
                                        @if ($row->department_id == 2)
                                            <button type="button" class="btn btn-warning float-left m-2 text-white"
                                                data-toggle="modal" data-target="#taskSolvingOverPhone"
                                                onclick="SetTask({{ $row->task_id }})">
                                                Solve Call Back
                                            </button>
                                        @endif
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

    <div class="modal fade" id="taskSolvingOverPhone" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-success">
                <div class="modal-body text-center">
                    <h2>Call Back Solve Over Phone !</h2> <br>
                    <form action="{{ route('taskSolvingOverPhone') }}" method="POST">
                        @csrf
                        <input class="form-control" id="txt_remark" name="txt_remark" placeholder="Remark" required>
                        <input type="hidden" name="latitude_01" id="latitude_01">
                        <input type="hidden" name="longitude_01" id="longitude_01">
                        <input type="hidden" name="task_id" id="task_id">
                        <button type="submit" class="btn btn-success float-right m-2">Submit</button>
                    </form>

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

        function SetTask(task_id) {
            if (task_id) {
                $('#task_id').val('');
                $('#task_id').val(task_id);
            } else {
                $('#task_id').val('');
            }
        }
    </script>
@endsection
