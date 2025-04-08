@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Issue List</h1>
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
                                        <th>Issue No.<br>Date</th>
                                        <th>Req. No.<br>Date</th>
                                        <th>Entry By</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($issue_master as $key => $row)
                                        @php
                                         
                                         $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->user_id)
                                            ->first();
                                        $txt_name = $ci_employee_info->employee_name;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->mi_master_no }}<br>{{ $row->entry_date }}
                                            </td>
                                            <td>{{ $row->req_no }}<br>{{ $row->req_date }}</td>
                                            <td>{{ $txt_name}}</td>
                                          
                                            <td>
                                                <a
                                                    href="{{ route('rpt_issue_details', $row->mi_master_no) }}">Details</a>
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
