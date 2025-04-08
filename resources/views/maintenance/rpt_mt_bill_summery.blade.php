@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill Summery</h1>
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
                        <table id="maintenance_bill_data" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Project Name</th>
                                    <th class="text-right">Bill Issue <br> To: {{ $to }}</th>
                                    <th class="text-right">Bill Received <br>To: {{ $to }}</th>
                                    <th class="text-right">Bill Due <br> To: {{ $to }}</th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $balance = 0;
                                    $bill_issue = 0;
                                    $bill_received = 0;

                                    //
                                    $total_bill_issue = 0;
                                    $total_bill_received = 0;
                                    $total_balance = 0;

                                @endphp
                                @foreach ($m_project as $key => $row)
                                    @php

                                        //opening bill
                                        $project_opening_balance = DB::table('pro_maintenance_opening_bill')
                                            ->where('project_id', $row->project_id)
                                            ->sum('amount');

                                        //bill with quotation
                                        $maintenance_bill_grand_total = DB::table('pro_maintenance_bill_master')
                                            ->where('project_id', $row->project_id)
                                            ->where('valid', 1)
                                            ->sum('grand_total');

                                        $maintenance_bill_repair_price = DB::table('pro_maintenance_bill_master')
                                            ->where('project_id', $row->project_id)
                                            ->where('valid', 1)
                                            ->sum('repair_price');

                                        //receiving
                                        $maintenance_bill_add_money = DB::table('pro_maintenance_money_receipt')
                                            ->where('project_id', $row->project_id)
                                            ->sum('paid_amount');

                                        $bill_issue = $project_opening_balance + $maintenance_bill_grand_total + $maintenance_bill_repair_price;
                                        $bill_received =  $maintenance_bill_add_money;
                                        $balance = $bill_issue - $bill_received; 
                                        //
                                        $total_bill_issue += $bill_issue;
                                        $total_bill_received += $bill_received;
                                        $total_balance += $balance;
                                        
                                    @endphp


                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->project_name }}</td>
                                        <td class="text-right">{{ number_format($bill_issue, 2) }}</td>
                                        <td class="text-right">{{ number_format($bill_received, 2) }}</td>
                                        <td class="text-right">{{ number_format($balance, 2) }}</td>
                                        <td class="text-right">
                                            <a href="">More Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_bill_issue, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_bill_received, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_balance, 2) }}</td>
                                    <td colspan="1" class="text-right"></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var data = "{{ $m_project->count() }}";
        if (data) {
            var page = data;
        } else {
            var page = 10000;
        }

        $(function() {
            $("#maintenance_bill_data").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": page,
                "buttons": [{
                        extend: 'copy',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'csv',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'excel',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'pdf',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'print',
                        title: 'Bill Information'
                    },
                    'colvis'
                ]
            }).buttons().container().appendTo('#maintenance_bill_data_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
