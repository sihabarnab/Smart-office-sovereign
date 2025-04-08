@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Servicing Bill List</h1>
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Customer Name</th>
                                    <th>Project Name</th>
                                    <th>Description</th>
                                    <th>Prepared By</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $project_name = '';
                                    $customer_name = '';
                                    $prefer_by = '';
                                    $total = 0;
                                @endphp
                                @foreach ($service_bill_master as $key => $row)
                                    @php
                                        $m_project = DB::table('pro_projects')
                                            ->Where('project_id', $row->project_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $project_name = $m_project->project_name;
                                        $m_customer = DB::table('pro_customers')
                                            ->where('customer_id', $row->customer_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $customer_name = $m_customer->customer_name;
                                        $m_employee = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();
                                        $prefer_by = $m_employee->employee_name;

                                        $total = $row->grand_total + $row->previous_due;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->service_bill_no }}</td>
                                        <td>{{ $customer_name }}</td>
                                        <td>{{ $project_name }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>{{ $prefer_by }}</td>
                                        <td>{{ $total }}</td>
                                        <td><a href="{{route('servicing_bill_edit',$row->service_bill_master_id)}}">Edit</a></td>
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



