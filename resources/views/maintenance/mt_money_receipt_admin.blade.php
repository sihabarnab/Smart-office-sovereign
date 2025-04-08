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

    @if (isset($m_money_receipt_edit))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Edit' }}</h5>
                        </div>
                        <form action="{{ route('mt_money_receipt_update',$m_money_receipt_edit->money_receipt_id) }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_customer" name="cbo_customer">
                                        <option value="0">-Customer-</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}" {{ $m_money_receipt_edit->customer_id == $row->customer_id ? "selected":"" }} >
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_collection_date"
                                        name="txt_collection_date" value="{{ $m_money_receipt_edit->collection_date }}"
                                        placeholder="Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_collection_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_payment_type" name="cbo_payment_type">
                                        <option value="0">-Payment Type-</option>
                                        <option value="1" {{ $m_money_receipt_edit->payment_type == 1 ? "selected":"" }} >Cash</option>
                                        <option value="2" {{ $m_money_receipt_edit->payment_type == 2 ? "selected":"" }}>Cheque</option>
                                    </select>
                                    @error('cbo_payment_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" id="txt_bank" name="txt_bank" class="form-control"
                                        placeholder="Bank" value="{{ $m_money_receipt_edit->bank }}">
                                    @error('txt_bank')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" id="txt_dd_no" name="txt_dd_no" class="form-control"
                                        placeholder="Chq/PO/DD No." value="{{ $m_money_receipt_edit->chq_no }}">
                                    @error('txt_dd_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_dd_date" name="txt_dd_date"
                                        value="{{ $m_money_receipt_edit->chq_date }}" placeholder="Chq/PO/DD Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_dd_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_amount" name="txt_amount" onchange="cword()" value="{{ $m_money_receipt_edit->paid_amount }}"
                                        placeholder="Amount">
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="txt_amount_word" name="txt_amount_word" value="{{  $m_money_receipt_edit->amount_word }}"  readonly>
                                    @error('txt_amount_word')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Remark" value="{{ $m_money_receipt_edit->remark }}">
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
    @else
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

    @include('maintenance.money_receipt_list')
    @endif


@endsection

@section('script')
<script>

function cword(){
var amount = document.getElementById("txt_amount").value;
console.log(amount);
var amountInWords = convertBDTtoWords(amount);
console.log(amountInWords);
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
