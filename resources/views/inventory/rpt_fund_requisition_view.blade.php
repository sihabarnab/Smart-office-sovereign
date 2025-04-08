@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{ route('rpt_fund_requisition_print', $fund_requisition_master->fund_requisition_master_id) }}"
                        class="btn btn-primary float-right">Print</a>
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
                                    <th>Estimated Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_rate = 0;
                                    $eastimat_price = 0;
                                @endphp
                                @foreach ($fund_requisition_details as $key => $row)
                                    @php
                                        $total_rate = ($row->rate*$row->qty);
                                        $eastimat_price = $eastimat_price + $total_rate ;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td class="text-right">{{ number_format($row->rate, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                        <td>{{ $row->unit_name }}</td>
                                        <td class="text-right">{{ number_format($total_rate, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Total:</td>
                                    <td colspan="1" class="text-right">{{ number_format($eastimat_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
