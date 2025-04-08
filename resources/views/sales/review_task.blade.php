@extends('layouts.sales_app')

@section('content')
    <div class="content-header mt-5">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <form action="{{ route('review_task_store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude" value="0">
                        <input type="hidden" name="longitude" id="longitude" value="0">

                        <div class="card border border-success">
                            <div class="card-header border border-success">
                                Task Review
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="txt_task_id" value="{{ $task->task_id }}">
                                <div class="row mb-1">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="feedback">File Upload:</label>
                                        <input type="text" class="form-control" id="feedback" name="feedback"
                                            placeholder="Upload" value="{{ old('feedback') }}"
                                            onfocus="(this.type='file')">
                                        @error('feedback')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="description">Description:</label>
                                        <textarea class="form-control" name="description" id="description" rows="5">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-12 col-md-12  col-sm-12">
                                        <label for="cbo_task_status">Complete:</label>
                                        <select class="form-control" id="cbo_task_status" name="cbo_task_status">
                                            <option value="">-Select Option-</option>
                                            <option value="ACCEPTED">ACCEPTED</option>
                                            <option value="DECLINED">DECLINED</option>
                                            <option value="DRAFT">DRAFT</option>
                                            <option value="SENT">SENT</option>
                                            <option value="DELETE">DELETE</option>
                                        </select>
                                        @error('cbo_task_status')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="border border-success">
                                <button type="submit" class="btn btn-success float-right m-2">Submit</button>
                            </div>
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

                $('#latitude_01').val(lat);
                $('#longitude_01').val(long);
            }

            console.log(lat);
            console.log(long);

        }


        function cancelTask() {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
        }
    </script>
@endsection
