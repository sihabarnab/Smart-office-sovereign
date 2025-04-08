@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
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

                        <div class="row mb-1">
                            <div class="col-12">
                                Date : {{ $fund_requisition_master->entry_date }} <br>
                                Req No : {{ $fund_requisition_master->fund_requisition_no }}.
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-12">
                                Team :
                                {{ $m_teams->team_name . '|' . $m_teams->employee_name . "($m_teams->department_name)" }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                Project: <br>
                                <div class="row mb-1">
                                    @foreach ($fund_requisition_project as $key => $row)
                                        <div class="col-4">
                                            @php
                                                $m_projects = DB::table('pro_projects')
                                                    ->where('project_id', $row->project_id)
                                                    ->first();
                                                $project_name = $m_projects->project_name;
                                            @endphp

                                            {{ $key + 1 }}. {{ $project_name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($fund_requisition_details->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table  table-striped table-sm">
                                {{-- table-bordered --}}
                                <thead>
                                    <tr>
                                        <th width='5%'>SL No</th>
                                        <th width='30%'>Description</th>
                                        <th width='15%'>Estimate Cost</th>
                                        <th width='15%'>Actual Cost</th>
                                        <th width='10%'>Qty</th>
                                        <th width='15%'>File</th>
                                        <th width='10%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fund_requisition_details as $key => $row)
                                        <form
                                            action="{{ route('fund_requisition_details_02_ok', $row->fund_requisition_details_id) }}"
                                            method="post">
                                            @csrf
                                            <tr>
                                                <td> <input type="text" class="form-control" value="{{ $key + 1 }}">
                                                </td>
                                                <td> <input type="text" class="form-control"
                                                        value="{{ $row->description }}" readonly> </td>
                                                <td class="text-right">
                                                    <input type="text" class="form-control" name="txt_rate"
                                                        value="{{ number_format($row->rate, 2) }}" readonly>
                                                </td>
                                                <td class="text-right">
                                                    <input type="number" class="form-control"
                                                        value="{{ number_format($row->rate, 2) }}" name="txt_actual_rate"
                                                        id="txt_actual_rate">
                                                    @error('txt_actual_rate')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-right">
                                                    <input type="number" class="form-control"
                                                        value="{{ number_format($row->qty, 2) }}" name = "txt_actual_qty"
                                                        id="txt_actual_qty">
                                                    @error('txt_actual_qty')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="txt_file"
                                                        name="txt_file" placeholder="Upload File"
                                                        onfocus="(this.type='file')">
                                                </td>
                                                <td> <button type="Submit" id="save_event"
                                                        class="btn btn-primary btn-block">OK</button></td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_rate = 0;
                                @endphp
                                @foreach ($approved_fund_requisition_details as $key => $row)
                                    @php
                                        $total_rate = $total_rate + $row->actual_rate;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td class="text-right">{{ number_format($row->actual_rate, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->actual_qty, 2) }}</td>
                                        <td>{{ $row->unit_name }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">Total:</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_rate, 2) }}</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
