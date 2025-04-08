
@php
$sub_total = 0.00;
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('mt_quotation_approved_final', $m_quotation_master->quotation_id) }}"
                        method="post">
                        @csrf
                        <table id="" class="table table-bordered table-striped table-sm mb-1">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Product Group</th>
                                    <th>Product Sub Group</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Extended Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_quotation_approved_details as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->pg_name }}</td>
                                        <td>{{ $row->pg_sub_name }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td class="text-right">{{ numberFormat($row->approved_qty, 2) }}</td>
                                        <td class="text-right">{{ numberFormat($row->approved_rate, 2) }}</td>
                                        <td class="text-right">{{ numberFormat($row->approved_total, 2) }}</td>
                                        @php
                                            $sub_total += $row->approved_total;
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class=" text-right">Sub Total :</td>
                                    <td class="text-right">
                                        <input type="hidden" name="txt_subtotal" id="txt_subtotal"
                                            value="{{ $sub_total }}">
                                        {{ numberFormat($sub_total, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">Discount</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_dpp" name="txt_dpp"
                                            value="{{ old('txt_dpp') }}" placeholder="%">
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_discount" name="txt_discount"
                                        value="{{ numberFormat($m_quotation_master->discount, 2) }}" placeholder="Discount">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">VAT</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_vpp" name="txt_vpp"
                                            value="{{ old('txt_vpp') }}" placeholder="%">
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_vat" name="txt_vat"
                                        value="{{ numberFormat($m_quotation_master->vat, 2) }}" placeholder="VAT">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">AIT</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_tt" name="txt_tt"
                                            value="{{ old('txt_tt') }}" placeholder="%">
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_ait" name="txt_ait"
                                        value="{{ numberFormat($m_quotation_master->ait,2) }}" placeholder="AIT">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">Others</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_ot" name="txt_ot"
                                            value="{{ old('txt_ot') }}" placeholder="%">
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_other" name="txt_other"
                                        value="{{ numberFormat($m_quotation_master->other, 2) }}" placeholder="Other">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-10">

                            </div>
                            <div class="col-2">
                                @php
                                    $data_1 = DB::table('pro_maintenance_quotation_details')
                                        ->where('quotation_id', $m_quotation_master->quotation_id)
                                        ->where('status', 3)
                                        ->count();

                                    $data_2 = DB::table('pro_maintenance_quotation_details')
                                        ->where('quotation_id', $m_quotation_master->quotation_id)
                                        ->count();
                                @endphp

                                @if ($data_1 == $data_2)
                                    <button type="Submit" id=""
                                        class="btn btn-primary btn-block">Final</button>
                                @else
                                    <button id="" class="btn btn-primary btn-block" disabled>Final</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@php

    //Number Formate
    function numberFormat($number, $decimals = 0)
    {
        // desimal (.) dat part
        if (strpos($number, '.') != null) {
            $decimalNumbers = substr($number, strpos($number, '.'));
            $decimalNumbers = substr($decimalNumbers, 1, $decimals);
        } else {
            $decimalNumbers = 0;
            for ($i = 2; $i <= $decimals; $i++) {
                $decimalNumbers = $decimalNumbers . '0';
            }
        }
        // echo $decimalNumbers;
        $number = (int) $number;
        // reverse
        $number = strrev($number);
        $n = '';
        $stringlength = strlen($number);
        for ($i = 0; $i < $stringlength; $i++) {
            if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                $n = $n . $number[$i] . ',';
            } else {
                $n = $n . $number[$i];
            }
        }
        $number = $n;
        // reverse
        $number = strrev($number);
        $decimals != 0 ? ($number = $number . '.' . $decimalNumbers) : $number;
        return $number;
    }
@endphp

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_dpp').on('change', function() {
                var discount = $(this).val();
                if (discount) {
                    var price = "{{ round($sub_total, 2) }}";
                    var totalValue = (price * (discount / 100));
                    $('#txt_discount').val(totalValue.toFixed(2));
                } else {
                    $('#txt_dpp').empty();
                    $('#txt_discount').empty();
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_ot').on('change', function() {
                var ait = $(this).val();
                if (ait) {
                    var price = "{{ round($sub_total, 2) }}";
                    var totalValue = (price * (ait / 100));
                    $('#txt_other').val(totalValue.toFixed(2));
                } else {
                    $('#txt_ot').val('');
                    $('#txt_other').val('');
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_tt').on('change', function() {
                var ait = $(this).val();
                if (ait) {
                    var price = "{{ round($sub_total, 2) }}";
                    var totalValue = (price / 100) * ait;
                    $('#txt_ait').val(totalValue.toFixed(2));
                } else {
                    $('#txt_tt').val('');
                    $('#txt_ait').val('');
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#txt_vpp').on('change', function() {
                var vat = $(this).val();
                if (vat) {
                    var price = "{{ $sub_total }}";
                    var tax = (price / 100) * vat;
                    $('#txt_vat').val(tax.toFixed(2));
                } else {
                    $('#txt_vpp').empty();
                    $('#txt_vat').empty();
                }

            });
        });
    </script>
@endsection
