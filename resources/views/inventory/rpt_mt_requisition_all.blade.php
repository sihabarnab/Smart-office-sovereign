@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition List</h1>
                    {{ $form }} To {{ $to }}.
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('mt_rpt_search_requation') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" onfocus="(this.type='date')">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-5">
                                    <input type="text" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" onfocus="(this.type='date')">
                                    @error('txt_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($search_requisition_master))
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
                                        <th>Supplier</th>
                                        <th>Prepare By</th>
                                        <th>Approved(MGM)</th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($search_requisition_master as $key => $row_req_master)
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

                                            if ($row_req_master->supplier_id) {
                                                $m_supplier = DB::table('pro_suppliers')
                                                    ->Where('supplier_id', $row_req_master->supplier_id)
                                                    ->first();
                                                $m_supplier_name = $m_supplier->supplier_name;
                                                $m_supplier_add = $m_supplier->supplier_add;
                                            } else {
                                                $m_supplier_name = '';
                                                $m_supplier_add = '';
                                            }

                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_req_master->req_no }}<br>{{ $row_req_master->entry_date }}</td>
                                            <td>{{ $txt_project_name }}</td>
                                            <td>{{ $m_supplier_name }} <br> {{$m_supplier_add}}</td>
                                            <td> {{ $prepareby }} </td>
                                            <td> {{ $approvedByMGM }}</td>
                                            <td> {{ $row_req_master->free_warrenty == 1 ? 'Free Warranty Period' : '' }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('mt_rpt_requisition_details', $row_req_master->requisition_master_id) }}">View</a>
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
    @else
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
                                        <th>Approved(MGM)</th>
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
                                            <td> {{ $approvedByMGM }}</td>
                                            <td> {{ $row_req_master->free_warrenty == 1 ? 'Free Warranty Period' : '' }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('mt_rpt_requisition_details', $row_req_master->requisition_master_id) }}">View</a>
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
    @endif
@endsection
