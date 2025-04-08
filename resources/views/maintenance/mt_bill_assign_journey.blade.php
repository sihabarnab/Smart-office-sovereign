@extends('layouts.maintenance_app')

@section('content')
    <div class="content-header mt-5">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <form action="{{ route('mtEndJourneyStore') }}" method="post">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude" value="0">
                        <input type="hidden" name="longitude" id="longitude" value="0">

                        <div class="card border border-success">
                            <div class="card-header border border-success">
                                End Journey
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="txt_bill_assign_id" value="{{ $bill_assign_id }}">
                                <div class="row mb-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="form-control" id="cbo_transport_type" name="cbo_transport_type"
                                            required>
                                            <option value="">-Transport Type-</option>
                                            <option value="BUS">BUS</option>
                                            <option value="RIKSHA">RIKSHA</option>
                                            <option value="CAR">CAR</option>
                                            <option value="BIKE">BIKE</option>
                                            <option value="CNG">CNG</option>
                                            <option value="CYCLE">CYCLE</option>
                                            <option value="PLANE">PLANE</option>
                                            <option value="SHIP">SHIP</option>
                                            <option value="MULTIPLE">MULTIPLE</option>
                                            <option value="OTHER">OTHER</option>
                                        </select>
                                        @error('cbo_transport_type')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="number" class="form-control" id="txt_fare" name="txt_fare"
                                            placeholder="Fare" required>
                                        @error('txt_fare')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="border border-success">
                                <button type="submit" class="btn btn-success float-right m-2">Submit</button>
                    </form>
                   
                </div>
            </div>

        </div><!-- /.col -->
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

                $('#latitude_01').val(lat);
                $('#longitude_01').val(long);
            }

            console.log(lat);
            console.log(long);

        }
    </script>
@endsection
