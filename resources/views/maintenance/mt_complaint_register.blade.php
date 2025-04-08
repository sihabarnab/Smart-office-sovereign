@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task Register</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_complaint_register1))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form action="{{ route('mt_complaint_register_update',$m_complaint_register1->complaint_register_id) }}" method="post" >
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-lg-4  col-md-4 col-sm-12">
                                        <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                            <option value="0">--Select Client--</option>
                                            @foreach ($m_customer as $row_customer)
                                                <option value="{{ $row_customer->customer_id }}"
                                                    {{ $row_customer->customer_id == $m_complaint_register1->customer_id ? 'selected' : '' }}>
                                                    {{ $row_customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4  col-md-4 col-sm-12">
                                        <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                            <option value="{{ $m_complaint_register1->project_id }}">{{ $m_complaint_register1->project_name }}</option>
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4  col-md-4 col-sm-12">
                                        <select class="form-control" id="cbo_lift_id" name="cbo_lift_id">
                                            <option value="{{ $m_complaint_register1->lift_id }}">{{ $m_complaint_register1->lift_name }} | {{ $m_complaint_register1->remark }}</option>
                                        </select>
                                        @error('cbo_lift_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_complaint_description"
                                            name="txt_complaint_description" placeholder="Complaint description"
                                            value="{{ $m_complaint_register1->complaint_description}}">
                                        @error('txt_complaint_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-6 col-sm-3 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-9 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block float-right">Update</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>

                            <form action="{{ route('mt_complaint_register_store') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                            <option value="0">--Select Client--</option>
                                            @foreach ($m_customer as $row_customer)
                                                <option value="{{ $row_customer->customer_id }}">
                                                    {{ $row_customer->customer_id }} | {{ $row_customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4  col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                            <option value="0">--Select Project--</option>
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4  col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_lift_id" name="cbo_lift_id">
                                            <option value="0">--Select Lift--</option>
                                        </select>
                                        @error('cbo_lift_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="txt_complaint_description"
                                            name="txt_complaint_description" placeholder="Complaint description"
                                            value="{{ old('txt_complaint_description') }}">
                                        @error('txt_complaint_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-6 col-sm-3 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-9 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block float-right">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('service.complaint_register_list')
    @endif
@endsection

@section('script')
    {{-- //Client to Project Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_customer_id"]').on('change', function() {
                console.log('ok')
                var cbo_customer_id = $(this).val();
                if (cbo_customer_id) {

                    $.ajax({
                        url: "{{ url('/get/project/') }}/" + cbo_customer_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_project_id"]').empty();
                            $('select[name="cbo_project_id"]').append(
                                '<option value="0">--Select Project--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_project_id"]').append(
                                    '<option value="' + value.project_id + '">' +
                                    value.project_name + '</option>');
                            });
                        },
                    });

                }

            });
        });
    </script>

    {{-- //Project to Lift Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_project_id"]').on('change', function() {
                console.log('ok')
                var cbo_project_id = $(this).val();
                if (cbo_project_id) {

                    $.ajax({
                        url: "{{ url('/get/lift/') }}/" + cbo_project_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_lift_id"]').empty();
                            $('select[name="cbo_lift_id"]').append(
                                '<option value="0">--Select Lift--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_lift_id"]').append(
                                    '<option value="' + value.lift_id + '">' +
                                    value.lift_name + ' | ' +
                                    value.remark + '</option>');
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
