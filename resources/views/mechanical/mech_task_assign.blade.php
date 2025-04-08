@extends('layouts.mechanical_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task Assign</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if (isset($m_task_assign))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form action="{{ route('mech_task_assign_update', $m_task_assign->task_id) }}" method="post">
                                @csrf
                                
                                <div class="row ">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                            <option value="0">--Select Client--</option>
                                            @foreach ($m_customer as $row_customer)
                                                <option value="{{ $row_customer->customer_id }}"
                                                    {{ $row_customer->customer_id == $m_task_assign->customer_id ? 'selected' : '' }}>
                                                    {{ $row_customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                            <option value="{{ $m_task_assign->project_id }}">{{ $m_task_assign->project_name }}</option>
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_lift_id" name="cbo_lift_id">
                                            <option value="{{ $m_task_assign->lift_id }}">{{ $m_task_assign->lift_name }}</option>
                                        </select>
                                        @error('cbo_lift_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_team_id" id="cbo_team_id" class="form-control">
                                            <option value="0">--Select Team--</option>
                                            @foreach ($mech_employee as $row)
                                                <option value="{{ $row->employee_id }}"
                                                    {{ $row->employee_id == $m_task_assign->team_leader_id ? 'selected' : '' }}>
                                                    {{ $row->employee_id }} | {{ $row->employee_name }}|{{ $row->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_team_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <input type="text" name="txt_remark" id="txt_remark" class="form-control"
                                            value="{{ $m_task_assign->complaint_description }}" placeholder="Remark">
                                        @error('txt_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-6 col-sm-12">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12">
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
                            <form action="{{ route('mech_task_assign_store') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                            <option value="">--Select Client--</option>
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
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                            <option value="">--Select Project--</option>
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_lift_id" name="cbo_lift_id">
                                            <option value="">--Select Lift--</option>
                                        </select>
                                        @error('cbo_lift_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_team_id" id="cbo_team_id" class="form-control">
                                            <option value="" >--Select Team--</option>
                                            @foreach ($mech_employee as $row)
                                                <option value="{{ $row->employee_id }}">
                                                    {{ $row->employee_id }}|{{ $row->employee_name }} ({{ $row->department_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_team_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6  col-md-6 col-sm-12 mb-2">
                                        <input type="text"  class="form-control" name="txt_remark" id="txt_remark" placeholder="Remark" >
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-6 col-sm-12">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block float-right">Next</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('mechanical.task_assign_list') --}}
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
                                '<option>--Select Project--</option>');
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
                                '<option>--Select Lift--</option>');
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
