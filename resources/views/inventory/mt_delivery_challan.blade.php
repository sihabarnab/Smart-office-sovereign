@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Chalan List</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
                                        <th>Req No.<br>Date</th>
                                        <th>Project</th>
                                        <th>Prepare By</th>
                                        <th>Approved(MGM) <br> Date</th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_requisition_master as $key => $row_req_master)
                                        @php
                                            $ci_projects = DB::table('pro_projects')
                                                ->Where('project_id', $row_req_master->project_id)
                                                ->first();
                                            $txt_project_name = $ci_projects->project_name;

                                            if ($row_req_master->user_id) {
                                                $prepare = DB::table('pro_employee_info')
                                                    ->Where('employee_id', $row_req_master->user_id)
                                                    ->first();
                                                $prepareby = $prepare->employee_name;
                                            } else {
                                                $prepareby = 'Pending';
                                            }
                                            if ($row_req_master->approved_id) {
                                                $approvedMGM = DB::table('pro_employee_info')
                                                    ->Where('employee_id', $row_req_master->approved_id)
                                                    ->first();
                                                $approvedByMGM = $approvedMGM->employee_name;
                                            } else {
                                                $approvedByMGM = 'Pending';
                                            }

                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_req_master->req_no }}<br>{{ $row_req_master->entry_date }}</td>
                                            <td>{{ $txt_project_name }}</td>
                                            <td> {{ $prepareby }} </td>
                                            <td> {{ $approvedByMGM }} <br> {{$row_req_master->approved_date}}</td>
                                            <td> {{ $row_req_master->free_warrenty == 1 ? 'Free Warranty Period' : '' }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('mt_delivery_challan_master', $row_req_master->requisition_master_id) }}">Details</a>
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
