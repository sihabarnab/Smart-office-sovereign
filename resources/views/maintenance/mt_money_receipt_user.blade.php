@extends('layouts.maintenance_app')
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
                        <form action="{{ route('mt_money_receipt_store') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_customer" name="cbo_customer">
                                        <option value="0">-Customer-</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}">
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_collection_date"
                                        name="txt_collection_date" value="{{ old('txt_collection_date') }}"
                                        placeholder="Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_collection_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_payment_type" name="cbo_payment_type">
                                        <option value="0">-Payment Type-</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Cheque</option>
                                    </select>
                                    @error('cbo_payment_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" id="txt_bank" name="txt_bank" class="form-control"
                                        placeholder="Bank" value="{{ old('txt_bank') }}">
                                    @error('txt_bank')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" id="txt_dd_no" name="txt_dd_no" class="form-control"
                                        placeholder="Chq/PO/DD No." value="{{ old('txt_dd_no') }}">
                                    @error('txt_dd_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-4">
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
                                    <input type="number" class="form-control" id="txt_amount" name="txt_amount" onchange="cword()"
                                        placeholder="Amount">
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="txt_amount_word" name="txt_amount_word" readonly>
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
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Submit</button>
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

function cword(){
var amount = document.getElementById("txt_amount").value;
var amountInWords = convertBDTtoWords(amount);
document.getElementById("txt_amount_word").value = amountInWords;
}

function convertBDTtoWords(amount) {
  var taka = parseInt(amount);
  var paisa = Math.round((amount - taka) * 100);
  var words = '';

  if (taka === 0) {
    words = 'Zero Taka';
  } else {
    var takaInWords = convertNumberToWords(taka);
    words = takaInWords + ' Taka';
  }

  if (paisa > 0) {
    var paisaInWords = convertNumberToWords(paisa);
    words += ' and ' + paisaInWords + ' Paisa';
  }

  return words;
}

function convertNumberToWords(number) {
  var words = '';
  var units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
  var tens = ['', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
  var scales = ['', 'Thousand', 'Lakh', 'Crore'];

  if (number === 0) {
    return 'Zero';
  }

  var i = 0;
  while (number > 0) {
    var group = number % 1000;
    var ones = group % 10;
    var tensDigit = Math.floor(group / 10) % 10;
    var hundredsDigit = Math.floor(group / 100);
    var scale = scales[i];

    if (group > 0) {
      if (hundredsDigit > 0) {
        words = units[hundredsDigit] + ' Hundred ';
      }
      if (tensDigit >= 2) {
        words += tens[tensDigit] + ' ';
        if (ones > 0) {
          words += units[ones] + ' ';
        }
      } else if (tensDigit === 1) {
        words += units[10 + ones] + ' ';
      } else if (ones > 0) {
        words += units[ones] + ' ';
      }

      if (i > 0 && group > 0) {
        words += scale + ' ';
      }
    }

    i++;
    number = Math.floor(number / 1000);
  }

  return words.trim();
}
</script>
@endsection
