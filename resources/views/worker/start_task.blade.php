@extends('layouts.worker_app')

@section('content')
    <div class="content-header mt-5">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="card border border-success">
                        <div class="card-header border border-success">
                            Start Task
                        </div>
                        <div class="card-body">
                            @php
                                $work_start = DB::table('pro_work_start')
                                    ->where('task_id', $task_id)
                                    ->where('journey_id', $journey_id)
                                    ->first();
                                if (isset($work_start)) {
                                    if ($work_start->image_1) {
                                        $image_01 = 1;
                                    } else {
                                        $image_01 = 0;
                                    }

                                    if ($work_start->image_2) {
                                        $image_02 = 1;
                                    } else {
                                        $image_02 = 0;
                                    }

                                    if ($work_start->image_3) {
                                        $image_03 = 1;
                                    } else {
                                        $image_03 = 0;
                                    }
                                    if ($work_start->image_4) {
                                        $image_04 = 1;
                                    } else {
                                        $image_04 = 0;
                                    }
                                    if ($work_start->image_5) {
                                        $image_05 = 1;
                                    } else {
                                        $image_05 = 0;
                                    }
                                } else {
                                    $image_01 = 0;
                                    $image_02 = 0;
                                    $image_03 = 0;
                                    $image_04 = 0;
                                    $image_05 = 0;
                                }

                            @endphp

                            {{-- // --}}
                            <form action="{{ route('startTaskFirstImageUpload') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="latitude" id="latitude" value="0">
                                <input type="hidden" name="longitude" id="longitude" value="0">
                                <input type="hidden" name="task_id" value="{{ $task_id }}">
                                <input type="hidden" name="journey_id" value="{{ $journey_id }}">
                                <div class="row mb-2">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="image_1">ARRIVAL IMAGE:</label>

                                        <div class="row">
                                            <div class="col-8">
                                                @if ($image_01 == 0)
                                                    <input type="text" class="form-control" id="image_1" name="image_1"
                                                        placeholder="Upload Image" value="{{ old('image_1') }}"
                                                        onfocus="(this.type='file')" required>
                                                    @error('image_1')
                                                        <span class="text-warning">{{ $message }}</span>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" placeholder="Upload Image"
                                                        disabled>
                                                @endif
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-4">
                                                @if ($image_01 == 0)
                                                    <button type="submit"
                                                        class="btn btn-success float-right">Upload</button>
                                                @else
                                                    <div class=" checkmark float-right mb-1">✔</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </form>

                            {{-- // --}}
                            <form action="{{ route('startTaskSecondImageUpload') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task_id }}">
                                <input type="hidden" name="journey_id" value="{{ $journey_id }}">
                                <div class="row mb-2">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="image_2">BEFORE SERVICE:</label>

                                        <div class="row">
                                            <div class="col-8">
                                                @if ($image_02 == 0)
                                                    <input type="text" class="form-control" id="image_2" name="image_2"
                                                        placeholder="Upload Image" value="{{ old('image_2') }}"
                                                        onfocus="(this.type='file')" required>
                                                    @error('image_2')
                                                        <span class="text-warning">{{ $message }}</span>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" placeholder="Upload Image"
                                                        disabled>
                                                @endif
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-4">
                                                @if ($image_02 == 0)
                                                    <button type="submit"
                                                        class="btn btn-success float-right">Upload</button>
                                                @else
                                                    <div class=" checkmark float-right mb-1">✔</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            {{-- // --}}
                            <form action="{{ route('startTaskThirdImageUpload') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task_id }}">
                                <input type="hidden" name="journey_id" value="{{ $journey_id }}">
                                <div class="row mb-2">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="image_3">BEFORE SERVICE:</label>

                                        <div class="row">
                                            <div class="col-8">
                                                @if ($image_03 == 0)
                                                    <input type="text" class="form-control" id="image_3" name="image_3"
                                                        placeholder="Upload Image" value="{{ old('image_3') }}"
                                                        onfocus="(this.type='file')">
                                                    @error('image_3')
                                                        <span class="text-warning">{{ $message }}</span>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" placeholder="Upload Image"
                                                        disabled>
                                                @endif
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-4">
                                                @if ($image_03 == 0)
                                                    <button type="submit"
                                                        class="btn btn-success float-right">Upload</button>
                                                @else
                                                    <div class=" checkmark float-right mb-1">✔</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            {{-- // --}}
                            <form action="{{ route('startTaskFourthImageUpload') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task_id }}">
                                <input type="hidden" name="journey_id" value="{{ $journey_id }}">
                                <div class="row mb-2">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="image_4">BEFORE SERVICE:</label>

                                        <div class="row">
                                            <div class="col-8">
                                                @if ($image_04 == 0)
                                                    <input type="text" class="form-control" id="image_4"
                                                        name="image_4" placeholder="Upload Image"
                                                        value="{{ old('image_4') }}" onfocus="(this.type='file')">
                                                    @error('image_4')
                                                        <span class="text-warning">{{ $message }}</span>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" placeholder="Upload Image"
                                                        disabled>
                                                @endif
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-4">
                                                @if ($image_04 == 0)
                                                    <button type="submit"
                                                        class="btn btn-success float-right">Upload</button>
                                                @else
                                                    <div class=" checkmark float-right mb-1">✔</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            {{-- // --}}
                            <form action="{{ route('startTaskFifthImageUpload') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task_id }}">
                                <input type="hidden" name="journey_id" value="{{ $journey_id }}">
                                <div class="row mb-2">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="image_5">BEFORE SERVICE:</label>

                                        <div class="row">
                                            <div class="col-8">
                                                @if ($image_05 == 0)
                                                    <input type="text" class="form-control" id="image_5"
                                                        name="image_5" placeholder="Upload Image"
                                                        value="{{ old('image_5') }}" onfocus="(this.type='file')">
                                                    @error('image_5')
                                                        <span class="text-warning">{{ $message }}</span>
                                                    @enderror
                                                @else
                                                    <input type="text" class="form-control" placeholder="Upload Image"
                                                        disabled>
                                                @endif
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-4">
                                                @if ($image_05 == 0)
                                                    <button type="submit"
                                                        class="btn btn-success float-right">Upload</button>
                                                @else
                                                    <div class=" checkmark float-right mb-1">✔</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>


                        <div class=" border border-success">
                            @if ($image_01 == 1 && $image_02 == 1)
                            <form action="{{ route('startTask') }}" method="post">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task_id }}">
                                <button type="submit" class="btn btn-success float-right m-2">Submit</button>
                            </form>
                            @else
                                <button class="btn btn-success float-right m-2" disabled>Submit</button>
                            @endif

                            <!-- Cancel trigger modal -->
                            <button type="button" class="btn btn-danger float-left m-2" data-toggle="modal"
                                data-target="#confirmModal" onclick="cancelTask()">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!--Cancel Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-success">
                <div class="modal-body text-center">
                    <h2>Are You Confirm ?</h2> <br>
                    <form action="{{ route('cancelJourney') }}" method="GET">
                        @csrf
                        <input type="hidden" name="latitude_01" id="latitude_01">
                        <input type="hidden" name="longitude_01" id="longitude_01">
                        <input type="hidden" name="task_id" id="task_id" value="{{ $task_id }}">
                        <button type="button" class="btn btn-danger float-center m-1" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success float-center m-1">Yes</button>
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
        function cancelTask(){
            var element = document.querySelector(".ctm_anim");
            element.classList.remove("ctm_anim");
        }
    </script>
@endsection
