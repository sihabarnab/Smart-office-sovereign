@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill collection List</h1>
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Description</th>
                                    <th class="text-left"></th>
                                    <th class="text-left"></th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Receive</th>
                                    <th class="text-right">Due</th>
                                    <th class="text-center" width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $project_name = '';
                                    $customer_name = '';
                                    $prefer_by = '';
                                    $recive = 0;
                                    $due = 0;
                                @endphp
                                @foreach ($service_bill_master as $key => $row)
                                    @php
                                        $m_project = DB::table('pro_projects')
                                            ->Where('project_id', $row->project_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $project_name = $m_project->project_name;
                                        $m_customer = DB::table('pro_customers')
                                            ->where('customer_id', $row->customer_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $customer_name = $m_customer->customer_name;

                                        $recive = DB::table('pro_service_money_receipt')
                                            ->where('service_bill_master_id', $row->service_bill_master_id)
                                            ->sum('paid_amount');
                                        $due = $row->grand_total - $recive;

                                        //Approved check
                                        $all_mr_count = DB::table('pro_service_money_receipt')
                                            ->where('service_bill_master_id', $row->service_bill_master_id)
                                            ->count();
                                        $approved_mr_count = DB::table('pro_service_money_receipt')
                                            ->where('service_bill_master_id', $row->service_bill_master_id)
                                            ->where('approved_status', 1)
                                            ->count();
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->service_bill_no }} <br> {{ $row->bill_date }}</td>
                                        <td>
                                            Customer: {{ $customer_name }} <br>
                                            Project: {{ $project_name }} <br>
                                            Description: {{ $row->description }} <br>
                                            Duration: {{ $row->start_date }} To {{ $row->end_date }}
                                        </td>
                                        <td class="text-left">
                                          Month:  {{ $row->month_qty }} <br>
                                          Lift:  {{ $row->lift_qty }} <br>
                                          Rate:  {{ $row->rate }} <br>

                                        </td>
                                        <td class="text-left">
                                           Discount: {{ $row->discount }} <br>
                                           Vat 
                                           @if($row->vat_percent>0)
                                           ({{$row->vat_percent}}%)
                                           @endif
                                           : {{ $row->vat }} <br>

                                           Ait
                                           @if($row->ait_percent>0)
                                           ({{$row->ait_percent}}%)
                                           @endif
                                           : {{ $row->ait }} <br>
                                           Other: {{ $row->other }} <br>

                                        </td>
                                        <td class="text-right">{{ number_format($row->grand_total,2) }}</td>
                                        <td class="text-right">
                                            {{ number_format($recive,2) }} <br>
                                            @if ($all_mr_count == $approved_mr_count && $recive > 0)
                                                <span style="color: green;">{{ 'Received' }}</span>
                                            @else
                                                <span style="color: red;">{{ 'Not Received' }}</span>
                                            @endif
                                        </td>
                                        <td class="{{ $due > 0 ? 'taskblink text-right' : 'text-right' }}"
                                            style="color: yellow;">
                                            {{ number_format($due,2) }}</td>
                                        <td>
                                            @if ($due > 0)
                                                <a target="_blank" class="btn btn-primary m-1"
                                                    href="{{ route('servicing_add_money', $row->service_bill_master_id) }}">Add
                                                    Money</a> <br>
                                                <a target="_blank" class="btn btn-success m-1"
                                                    href="{{ route('service_mr_list', $row->service_bill_master_id) }}">Money
                                                    Receipt List</a> <br>
                                                <a target="_blank" class="btn btn-success m-1"
                                                    href="{{ route('rpt_servicing_bill_view', $row->service_bill_master_id) }}">Bill
                                                    View</a>
                                            @else
                                                <a target="_blank" class="btn btn-success m-1"
                                                    href="{{ route('service_mr_list', $row->service_bill_master_id) }}">Money
                                                    Receipt List</a> <br>
                                                <a target="_blank" class="btn btn-success m-1"
                                                    href="{{ route('rpt_servicing_bill_view', $row->service_bill_master_id) }}">Bill
                                                    View</a>
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
@endsection
