@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Money Receipt</h1>
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
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('servicing_store_money') }}" method="post">
                            @csrf

                            {{-- // --}}
                            <input type="hidden" name='txt_service_bill_master_id'
                                value="{{ $service_bill_master->service_bill_master_id }}">

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $service_bill_master->service_bill_no }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $service_bill_master->entry_date }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text"  class="form-control"
                                            value="{{ $m_customer->customer_name }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text"  class="form-control"
                                            value="{{ $m_customer->customer_phone }}" readonly>
                                    </div>
                                </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" type="text" class="form-control"
                                        value="{{ $service_bill_master->grand_total }}" readonly>
                                </div>
                                <div class="col-8">
                                    <textarea name="txt_description" id="txt_description" cols="10" rows="1" class="form-control" placeholder="Description" readonly>{{$service_bill_master->description}}</textarea>
                                    @error('txt_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">

                                <div class="col-2">
                                    <select class="form-control" id="cbo_payment_type" name="cbo_payment_type">
                                        <option value="">-Payment Type-</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Cheque</option>
                                    </select>
                                    @error('cbo_payment_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <input type="text" id="txt_bank" name="txt_bank" class="form-control"
                                        placeholder="Bank" value="{{ old('txt_bank') }}" list="bank_list">
                                        <datalist id="bank_list">
                                            <option>Standard Bank Ltd.</option>
                                            <option>Al-Arafah Islami Bank Ltd.</option>
                                            <option>Prime Bank Ltd.</option>
                                            <option>IFIC Bank</option>
                                            <option>Dutch-Bangla Bank Ltd.</option>
                                            <option>Shahjalal Islami Bank</option>
                                            <option>South Bangla Agricultural </option>
                                            <option>The Hongkong and Shanghai Banking Corporation Limited </option>
                                            <option>Union Bank Limited </option>
                                            <option>National Credit and Commerce Bank Limited </option>
                                            <option>Pubali Bank Ltd </option>
                                            <option>Janata Bank Ltd.</option>
                                            <option>NRB Bank Ltd</option>
                                            <option>Islami Bank Bangladesh Limited</option>
                                            <option>Agrani Bank Ltd</option>
                                        </datalist>
                                    @error('txt_bank')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_dd_no" name="txt_dd_no" class="form-control"
                                        placeholder="Chq/PO/DD No." value="{{ old('txt_dd_no') }}">
                                    @error('txt_dd_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_dd_date" name="txt_dd_date"
                                        value="{{ old('txt_dd_date') }}" placeholder="Chq/PO/DD Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_dd_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_amount" name="txt_amount"
                                        onchange="cword()" placeholder="Amount">
                                    @error('txt_amount')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <input type="text"  class="form-control text-uppercase" id="txt_amount_word" name="txt_amount_word"
                                        readonly>
                                    @error('txt_amount_word')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Remark" value="{{ old('txt_remark') }}">
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                </div>
                                <div class="col-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Submit</button>
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
                                               Receive by: {{ $m_employee->employee_name}} <br>
                                               Receive Date {{ $row->approved_date}}

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

@section('script')
    <script>
        var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ',
            'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '
        ];
        var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        function inWords(num) {
            if ((num = num.toString()).length > 9) return 'overflow';
            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return;
            var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) +
                'only ' : '';
            return str;
        }

        document.getElementById('txt_amount').onkeyup = function() {
            document.getElementById('txt_amount_word').value = inWords(document.getElementById('txt_amount').value);
        };
    </script>

@endsection
