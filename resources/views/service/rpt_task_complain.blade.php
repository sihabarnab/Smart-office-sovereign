@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Complain List</h1>
                    {{$form}} To {{$to}}
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
                    <form action="{{ route('rpt_search_task_complain') }}" method="post">
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


    @if (isset($search_task_register))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Com. No.</th>
                                        <th>Client <br> Project</th>
                                        <th>Lift</th>
                                        <th>complain</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($search_task_register as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->complaint_register_id }} <br> {{ $row->entry_date}}</td>
                                            <td>{{ $row->customer_name }} <br>{{ $row->project_name }} </td>
                                            <td>{{ $row->lift_name }}<br>{{ $row->remark }}</td>
                                            <td>{{ $row->complaint_description }}</td>
                                            <td>
                                                @if ($row->status == 2)
                                                @php
                                                    $task_assign = DB::table('pro_task_assign')
                                                        ->where('complain_id', $row->complaint_register_id)
                                                        ->first();
                                                    $ci_employee_info = DB::table('pro_employee_info')
                                                        ->Where('employee_id', $task_assign->team_leader_id)
                                                        ->first();
                                                    $txt_team_leader_name = $ci_employee_info->employee_name;
                                                @endphp
                                                {{-- Task Assign by<br>{{ $txt_team_leader_name }} --}}
                                                {{ $txt_team_leader_name }}
                                            @else
                                            @endif
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
                                        <th>Com. No.</th>
                                        <th>Client<br>Project</th>
                                        <th>Lift</th>
                                        <th>complain</th>
                                        <th>Task Assign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_task_register as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->complaint_register_id }} <br> {{ $row->entry_date}}</td>
                                            <td>{{ $row->customer_name }} <br>{{ $row->project_name }}</td>
                                            <td>{{ $row->lift_name }}<br>{{ $row->remark }}</td>
                                            <td>{{ $row->complaint_description }}</td>
                                            <td>
                                                @if ($row->status == 2)
                                                    @php
                                                        $task_assign = DB::table('pro_task_assign')
                                                            ->where('complain_id', $row->complaint_register_id)
                                                            ->first();
                                                        $ci_employee_info = DB::table('pro_employee_info')
                                                            ->Where('employee_id', $task_assign->team_leader_id)
                                                            ->first();
                                                        $txt_team_leader_name = $ci_employee_info->employee_name;
                                                    @endphp
                                                    {{-- Task Assign by<br>{{ $txt_team_leader_name }} --}}
                                                    {{ $txt_team_leader_name }}
                                                @else
                                                @endif
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
