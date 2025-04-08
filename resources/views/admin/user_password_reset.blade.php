@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Password Reset</h1>
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
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>

                        <form action="{{ route('user_password_update') }}" method="POST">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="">--Company--</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->company_id }}">
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                        <option value="">--Select Employee--</option>
                                    </select>
                                    @error('cbo_employee_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="password" class="form-control" id="txt_new_pass" name="txt_new_pass"
                                        placeholder="New Password" value="{{ old('txt_new_pass') }}">
                                    @error('txt_new_pass')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm Password"
                                        value="{{ old('password_confirmation') }}">
                                    @error('password_confirmation')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-12">
                <div align="center" class="">
                    <h4> Valid Password</h4>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div align="center" class="">
                    <mark>Must be at least 8 characters in length</mark>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div align="center" class="">
                    <mark> Must have at least one numeric character</mark>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div align="center" class="">
                    <mark>Must have at least one lowercase character</mark>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div align="center" class="">
                    <mark>Must have at least one uppercase character</mark>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div align="center" class="">
                    <mark>Must have at least one special symbol among @$!%*#?&</mark>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/employee1/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_employee_id"]').empty();
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="0">--Employee--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_employee_id"]').append(
                                    '<option value="' + value.employee_id + '">' +
                                    value.employee_id + ' | ' + value
                                    .employee_name + '</option>');
                            });
                        },
                    });

                }

            });
        });
    </script>


    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
