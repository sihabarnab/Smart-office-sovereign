@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Money Receipt List</h3>
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Description</th>
                                    <th>Payment Type</th>
                                    <th>Bank <br> Cheq No/ Cheq date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_money_receipt as $key => $row)
                                    @php
                                        $m_customer = DB::table('pro_customers')
                                            ->where('customer_id', $row->customer_id)
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            Customer : {{ $m_customer->customer_name }} <br>
                                            Invoice No : {{ $row->receipt_no }} <br>
                                            Collection Date : {{ $row->collection_date }} <br>
                                            Remark: {{ $row->remark }}

                                        </td>
                                        <td>
                                            @if ($row->payment_type == 1)
                                                {{ 'Cash' }}
                                            @else
                                                {{ 'Cheque' }}
                                            @endif

                                        </td>
                                        <td>{{ $row->bank }} <br> {{ $row->chq_no }} <br> {{ $row->chq_date }}</td>
                                        <td>{{ $row->paid_amount }}</td>
                                        <td>
                                            @if ($row->approved_status == 1)
                                                <span style="color: green;">{{ 'Received' }} <br></span>
                                                @php
                                                    $m_employee = DB::table('pro_employee_info')
                                                        ->where('employee_id', $row->approved_id)
                                                        ->first();
                                                @endphp
                                               Received by: {{ $m_employee->employee_name}} <br>
                                               Received Date {{ $row->approved_date}}

                                            @else
                                                <span style="color: red;">{{ 'Not Received' }}</span>
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
