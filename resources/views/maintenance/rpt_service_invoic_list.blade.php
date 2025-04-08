@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Service Invoice List</h1>
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
                                    <th>Client</th>
                                    <th>Total bill</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_customer as $key => $row)
                                    @php
                                        $total_bill = DB::table('pro_service_bill_master')
                                            ->where('customer_id', $row->customer_id)
                                            ->where('valid', 1)
                                            ->sum('total');
                                        
                                        $m_paid_amount = DB::table('pro_money_receipt')
                                            ->where('customer_id', $row->customer_id)
                                            ->where('valid', '1')
                                            ->sum('paid_amount');
                                        
                                        if (isset($total_bill)) {
                                            $all_bill = $total_bill;
                                        } else {
                                            $all_bill = 0;
                                        }
                                        
                                        if (isset($m_paid_amount)) {
                                            $all_paid_amount = $m_paid_amount;
                                        } else {
                                            $all_paid_amount = 0;
                                        }
                                        
                                    @endphp
                                    @if ($total_bill > 0 || $m_paid_amount > 0)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $all_bill }}</td>
                                            <td>{{ $all_paid_amount }}</td>
                                            <td>{{ $all_bill - $all_paid_amount }}</td>
                                            <td>
                                                @if ($total_bill > 0)
                                                    <a
                                                        href="{{ route('rpt_service_invoic_details', $row->customer_id) }}">Details</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
