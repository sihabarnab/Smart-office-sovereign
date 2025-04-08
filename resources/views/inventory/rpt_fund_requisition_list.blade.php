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
                        <form action="{{ route('rpt_fund_requisition_search') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" value="{{$form}}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" value="{{$to}}">
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

    @if (isset($search_fund_requisition))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Fund Req No</th>
                                        <th>Req Date</th>
                                        <th>Team</th>
                                        <th>Prepare By</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($search_fund_requisition as $key => $row_req_master)
                                        @php
                                            if ($row_req_master->user_id) {
                                                $prepare = DB::table('pro_employee_info')
                                                    ->Where('employee_id', $row_req_master->user_id)
                                                    ->first();
                                                $prepareby = $prepare->employee_name;
                                            } else {
                                                $prepareby = 'Pending';
                                            }

                                            $m_teams = DB::table('pro_teams')
                                                ->leftJoin(
                                                    'pro_employee_info',
                                                    'pro_teams.team_leader_id',
                                                    'pro_employee_info.employee_id',
                                                )
                                                ->leftJoin(
                                                    'pro_department',
                                                    'pro_employee_info.department_id',
                                                    'pro_department.department_id',
                                                )
                                                ->select(
                                                    'pro_teams.*',
                                                    'pro_employee_info.employee_name',
                                                    'pro_department.department_name',
                                                )
                                                ->where('team_id', $row_req_master->team_id)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_req_master->fund_requisition_no }}</td>
                                            <td>{{ $row_req_master->entry_date }}</td>
                                            <td>{{ $m_teams->team_name . '|' . $m_teams->employee_name . "($m_teams->department_name)" }}
                                            </td>
                                            <td> {{ $prepareby }} </td>
                                            <td>
                                                <a
                                                    href="{{ route('rpt_fund_requisition_view', $row_req_master->fund_requisition_master_id) }}">View</a>
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
                                        <th>Fund Req No</th>
                                        <th>Req Date</th>
                                        <th>Team</th>
                                        <th>Prepare By</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fund_requisition_master as $key => $row_req_master)
                                        @php
                                            if ($row_req_master->user_id) {
                                                $prepare = DB::table('pro_employee_info')
                                                    ->Where('employee_id', $row_req_master->user_id)
                                                    ->first();
                                                $prepareby = $prepare->employee_name;
                                            } else {
                                                $prepareby = 'Pending';
                                            }

                                            $m_teams = DB::table('pro_teams')
                                                ->leftJoin(
                                                    'pro_employee_info',
                                                    'pro_teams.team_leader_id',
                                                    'pro_employee_info.employee_id',
                                                )
                                                ->leftJoin(
                                                    'pro_department',
                                                    'pro_employee_info.department_id',
                                                    'pro_department.department_id',
                                                )
                                                ->select(
                                                    'pro_teams.*',
                                                    'pro_employee_info.employee_name',
                                                    'pro_department.department_name',
                                                )
                                                ->where('team_id', $row_req_master->team_id)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_req_master->fund_requisition_no }}</td>
                                            <td>{{ $row_req_master->entry_date }}</td>
                                            <td>{{ $m_teams->team_name . '|' . $m_teams->employee_name . "($m_teams->department_name)" }}
                                            </td>
                                            <td> {{ $prepareby }} </td>
                                            <td>
                                                <a
                                                    href="{{ route('rpt_fund_requisition_view', $row_req_master->fund_requisition_master_id) }}">View</a>
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
