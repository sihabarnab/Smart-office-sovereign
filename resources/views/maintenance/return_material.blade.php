@extends('layouts.maintenance_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Material</h1>
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
                                        <th>Complain No.</th>
                                        <th>Client</th>
                                        <th>Project</th>
                                        <th>Lift</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complain as $key => $row)
                                        @php
                                            $ci_customers = DB::table('pro_customers')
                                                ->Where('customer_id', $row->customer_id)
                                                ->first();
                                            $txt_customer_name = $ci_customers->customer_name;
                                            
                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $row->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;
                                            
                                            $ci_lifts = DB::table('pro_lifts')
                                                ->Where('lift_id', $row->lift_id)
                                                ->first();
                                            $txt_lift_name = $ci_lifts->lift_name;
                                            $txt_lift_remark = $ci_lifts->remark;
                                            
                                        @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $row->complaint_register_id }}</td>
                                                <td> {{ $txt_customer_name }}</td>
                                                <td> {{ $txt_project_name }}</td>
                                                <td> {{ $txt_lift_name }} | {{ $txt_lift_remark }}</td>
                                                <td>
                                                    <a href="{{ route('add_return_material', $row->complaint_register_id) }}">Return</a>
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
