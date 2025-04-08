@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Requisition</h1>
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
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form action="{{ route('fund_requisition_store') }}" method="post">
                            @csrf

                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_team_id" id="cbo_team_id" class="form-control">
                                        <option value="">--Select Team--</option>
                                        @foreach ($m_teams as $row_team)
                                            <option value="{{ $row_team->team_id }}">
                                                {{ $row_team->team_name }} | {{ $row_team->employee_name }} ({{$row_team->department_name}})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_team_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                        <option value="">--Select Project--</option>
                                        @foreach ($m_projects as $row)
                                            <option value="{{ $row->project_id }}">
                                                {{ $row->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-6 col-sm-12 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Next</button>
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
                    <div class="card-title">
                        <h5>Fund Requisition Not Final</h5>
                    </div>
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
                                                href="{{ route('fund_requisition_add_more', $row_req_master->fund_requisition_master_id) }}">Next</a>
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
