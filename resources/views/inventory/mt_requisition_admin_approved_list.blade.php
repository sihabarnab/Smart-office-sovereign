@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition List for Approve(MGM)</h1>
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
                                    <th>Prepare by</th>
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
                                            $prepareBy = $prepare->employee_name;
                                        } else {
                                            $prepareBy = '';
                                        }

                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row_req_master->req_no }}<br>{{ $row_req_master->entry_date }}</td>
                                        <td>{{ $txt_project_name }}</td>
                                        <td>{{  $prepareBy }}</td>
                                        <td><a
                                                href="{{ route('mt_requisition_admin_approved_details', $row_req_master->requisition_master_id) }}">Details</a>
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
