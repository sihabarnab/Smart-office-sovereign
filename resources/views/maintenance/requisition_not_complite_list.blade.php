@php
     $req_master = DB::table('pro_requisition_master')
            ->where('status', 1)
            ->where('valid', 1)
            ->get();
@endphp

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Requisition not complete list</h1>
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
                            @foreach ($req_master as $key => $row_req_master)
                                @php
                                    $ci_projects = DB::table('pro_projects')
                                        ->Where('project_id', $row_req_master->project_id)
                                        ->first();
                                    $txt_project_name = $ci_projects->project_name;
                                 
                                    
                                    $ci_employee_info = DB::table('pro_employee_info')
                                        ->Where('employee_id', $row_req_master->user_id)
                                        ->first();
                                    $txt_prepare_by = $ci_employee_info->employee_name;
                                    
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row_req_master->req_no }}<br>{{ $row_req_master->entry_date }}</td>
                                    <td>{{ $txt_project_name }}</td>
                                    <td>{{$txt_prepare_by}}</td>
                                    <td>
                                        <a
                                            href="{{ route('mt_requisition_product', $row_req_master->requisition_master_id) }}">Next</a>
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
