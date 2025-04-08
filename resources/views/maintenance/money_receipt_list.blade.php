<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Payment Type</th>
                                <th>Bank <br> Cheq No/ Cheq date</th>
                                <th>Amount</th>
                                <th>Remark</th>
                                <th>&nbsp;</th>
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
                                    <td>{{ $m_customer->customer_name }}</td>
                                    <td>{{ $row->collection_date }}</td>
                                    <td>
                                        @if ($row->payment_type == 1)
                                            {{ 'Cash' }}
                                        @else
                                            {{ 'Cheque' }}
                                        @endif

                                    </td>
                                    <td>{{ $row->bank }} <br> {{ $row->chq_no }} <br> {{ $row->chq_date }}</td>
                                    <td>{{ $row->paid_amount }}</td>
                                    <td>{{ $row->remark }}</td>
                                    <td>
                                        <a href="{{ route('mt_money_receipt_edit',$row->money_receipt_id ) }}">Edit</a>
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
