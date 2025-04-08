@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill Assign</h1>
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
                        <form action="{{ route('bill_assign_store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_service_bill_no" id="cbo_service_bill_no" class="form-control">
                                        <option value="">--Select Bill--</option>
                                        @foreach ($service_bill_master as $key => $row)
                                            @php
                                                $m_project = DB::table('pro_projects')
                                                    ->Where('project_id', $row->project_id)
                                                    ->where('valid', 1)
                                                    ->first();
                                                $project_name = $m_project->project_name;
                                            @endphp
                                            <option value="{{ $row->service_bill_no }}">
                                                {{ $row->service_bill_no }} | {{ $project_name }} | Total:
                                                {{ $row->grand_total + $row->previous_due }} | Date: {{ $row->bill_date }}
                                                {{ $row->entry_time }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_service_bill_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                        <option value="">--Select Employee--</option>
                                        @foreach ($m_employee as $row)
                                            <option value="{{ $row->employee_id }}">
                                                {{ $row->employee_id }} | {{ $row->employee_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_employee_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12  col-md-12 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_remark" id="txt_remark"
                                        placeholder="Remark">
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-6 col-sm-12 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12">
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


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SI NO</th>
                                    <th>Invoice No </th>
                                    <th>Assign Date</th>
                                    <th>Employee</th>
                                    <th>Customer</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bill_assign_list as $key => $row)
                                    @php
                                        $employee = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->employee_id)
                                            ->first();
                                        $employee_name = $employee == null ? '' : $employee->employee_name;
                                        $ci_customers = DB::table('pro_customers')
                                            ->Where('customer_id', $row->customer_id)
                                            ->first();
                                        $customer_name = $ci_customers == null ? '' : $ci_customers->customer_name;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->service_bill_no }} </td>
                                        <td>{{ $employee_name }}</td>
                                        <td>{{ $row->colection_date }}</td>
                                        <td>{{ $customer_name }}</td>
                                        <td>{{ $row->remarks }}</td>

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
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
