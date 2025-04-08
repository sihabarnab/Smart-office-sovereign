@extends('layouts.maintenance_app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('rpt_mt_bill_print', $m_bill_master->maintenance_bill_master_id) }}"
                            class="btn btn-primary float-right">Print</a>

                        <h1 class="text-center">MAINTENANCE BILL</h1>


                        <div class="row">
                            <div class="col-2">
                                Invoice Date<br>
                                Quotation Date
                            </div>
                            <div class="col-6">
                                <span>:&nbsp;</span>{{ $m_bill_master->entry_date }}
                                <br>
                                <span>:&nbsp;</span>{{ $m_bill_master->quotation_date }}
                            </div>
                            <div class="col-2">
                                Invoice No <br>
                                Quotation No

                            </div>
                            <div class="col-2 ">

                                <span>:&nbsp;</span> {{ $m_bill_master->maintenance_bill_master_no }} <br>
                                <span>:&nbsp;</span> {{ $m_bill_master->quotation_master_id }}

                            </div>
                        </div>



                        <div class="row mt-3">
                            <div class="col-12">
                                <strong>To</strong> <br>
                                <strong>{{ $m_bill_master->customer_name }}</strong> <br>
                                {{ $m_bill_master->customer_add }} <br>
                                {{ $m_bill_master->customer_phone }}
                            </div>
                        </div>

                        <div class="row mt-4 mb-3">
                            <div class="col-12">
                                <strong>Subject:- </strong> &nbsp; &nbsp; {{ $m_bill_master->subject }}
                            </div>
                        </div>

                        <table class="table table-sm m-0">
                            <thead class="table-bordered">
                                <tr>
                                    <th class="text-center">SL NO.</th>
                                    <th class="text-center">DESCRIPTION</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">UNIT</th>
                                    <th class="text-center">RATE</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="table-bordered">
                                @php
                                    $sub_total = 0;
                                    $repair_price = 0;
                                    $previous_due = 0;
                                    $bill_total = 0;
                                    $total_word = 0;
                                    $i = 1;
                                @endphp
                                @foreach ($m_bill_details as $key => $row)
                                    @php
                                        $sub_total += $row->sub_total;
                                        $extended = number_format($row->sub_total, 2);
                                        $qty = number_format($row->qty, 2);
                                        $unit = number_format($row->rate, 2);
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td class="text-center">{{ $qty }} </td>
                                        <td class="text-center">{{ $row->unit_name }} </td>
                                        <td class="text-center">{{ $unit }}</td>
                                        <td class="text-right">{{ $extended }}</td>
                                    </tr>
                                @endforeach
                                @if ($m_bill_master->repair_price > 0 && $m_bill_master->repair_descrption)
                                    @php
                                        $repair_price = $m_bill_master->repair_price;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $m_bill_master->repair_descrption }}</td>
                                        <td class="text-center">----</td>
                                        <td class="text-center"> ---- </td>
                                        <td class="text-center"> ---- </td>
                                        <td class="text-right">{{ number_format($m_bill_master->repair_price, 2) }}
                                        </td>
                                    </tr>
                                @endif

                                @if ($m_bill_master->previous_due > 0 && $m_bill_master->due_description)
                                    @php
                                        $previous_due = $m_bill_master->previous_due;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $m_bill_master->due_description }}</td>
                                        <td class="text-center">----</td>
                                        <td class="text-center">----</td>
                                        <td class="text-center">----</td>
                                        <td class="text-right">{{ number_format($m_bill_master->previous_due, 2) }}
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                            @php
                                $ait = number_format($m_bill_master->ait, 2);
                                $other = number_format($m_bill_master->other, 2);
                                $vat = number_format($m_bill_master->vat, 2);
                                $discount = number_format($m_bill_master->discount, 2);
                                $bill_total = number_format(
                                    $m_bill_master->grand_total + $repair_price + $previous_due,
                                    2,
                                );
                                $total_word = $m_bill_master->grand_total + $repair_price + $previous_due;

                            @endphp
                            <tfoot class="table-borderless">
                                <tr>
                                    <td colspan="5" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">SUB-TOTAL:</td>
                                    <td class="text-right font-weight-bold" style="border: 1px solid #6C757D;">
                                        @php
                                            $sub_total_new = number_format(
                                                $sub_total + $repair_price + $previous_due,
                                                2,
                                            );
                                        @endphp
                                        {{ $sub_total_new }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        DISCOINT
                                        @if ($m_bill_master->discount_percent > 0)
                                            ({{ $m_bill_master->discount_percent }}%)
                                        @endif
                                        :
                                    </td>
                                    <td colspan="1" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        {{ $discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        VAT
                                        @if ($m_bill_master->vat_percent > 0)
                                            ({{ $m_bill_master->vat_percent }}%)
                                        @endif
                                        :
                                    </td>
                                    <td colspan="1" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        {{ $vat }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        AIT
                                        @if ($m_bill_master->ait_percent > 0)
                                            ({{ $m_bill_master->ait_percent }}%)
                                        @endif
                                        :
                                    </td>
                                    <td colspan="1" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        {{ $ait }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        OTHERS
                                        @if ($m_bill_master->other_percent > 0)
                                            ({{ $m_bill_master->other_percent }}%)
                                        @endif
                                        :
                                    </td>
                                    <td colspan="1" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        {{ $other }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        GRAND TOTAL:</td>
                                    <td colspan="1" class="text-right font-weight-bold"
                                        style="border: 1px solid #6C757D;">
                                        {{ $bill_total }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>



                        <div class="row mb-1 mt-2">
                            <div class="col-12">
                                @php
                                    $bill_total_word = convert_number($total_word);
                                @endphp
                                <strong>Amount In word:-</strong> &nbsp; Taka {{ $bill_total_word }} only.

                            </div>
                        </div>

                        @if ($m_bill_master->vat > 0 || $m_bill_master->ait > 0)
                        @else
                            <div class="row mb-1">
                                <div class="col-12">
                                    <strong>Note:-</strong> TAX, VAT is not included with the above price.
                                </div>
                            </div>
                        @endif

                        <div class="row mb-1">
                            <div class="col-12">
                                Thanking you & assuring Our best service at all time.
                            </div>
                        </div>


                        @php
                            $employee_info = DB::table('pro_employee_info')
                                ->where('employee_id', Auth::user()->emp_id)
                                ->first();
                            $desig = DB::table('pro_desig')->where('desig_id', $employee_info->desig_id)->first();
                        @endphp

                        <div class="row">
                            <div class="col-12">
                                <strong>For, Sovereign Technology Ltd</strong>

                                <br><br><br><br><br><br>
                                @isset($employee_info)
                                    <strong>{{ $employee_info->employee_name }}</strong> <br>
                                @endisset
                                @isset($desig)
                                    {{ $desig->desig_name }} <br>
                                @endisset
                                @isset($employee_info->mobile)
                                    {{ $employee_info->mobile }}
                                @endisset
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        //Number to word BD Taka
        function convert_number($number)
        {
            $my_number = $number;

            if ($number < 0 || $number > 999999999) {
                throw new Exception('Number is out of range');
            }
            $Kt = floor($number / 10000000); /* Koti */
            $number -= $Kt * 10000000;
            $Gn = floor($number / 100000); /* lakh  */
            $number -= $Gn * 100000;
            $kn = floor($number / 1000); /* Thousands (kilo) */
            $number -= $kn * 1000;
            $Hn = floor($number / 100); /* Hundreds (hecto) */
            $number -= $Hn * 100;
            $Dn = floor($number / 10); /* Tens (deca) */
            $n = $number % 10; /* Ones */

            $res = '';

            if ($Kt) {
                $res .= convert_number($Kt) . ' Koti ';
            }
            if ($Gn) {
                $res .= convert_number($Gn) . ' Lakh';
            }

            if ($kn) {
                $res .= (empty($res) ? '' : ' ') . convert_number($kn) . ' Thousand';
            }

            if ($Hn) {
                $res .= (empty($res) ? '' : ' ') . convert_number($Hn) . ' Hundred';
            }

            $ones = [
                '',
                'One',
                'Two',
                'Three',
                'Four',
                'Five',
                'Six',
                'Seven',
                'Eight',
                'Nine',
                'Ten',
                'Eleven',
                'Twelve',
                'Thirteen',
                'Fourteen',
                'Fifteen',
                'Sixteen',
                'Seventeen',
                'Eightteen',
                'Nineteen',
            ];
            $tens = ['', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eigthy', 'Ninety'];

            if ($Dn || $n) {
                if (!empty($res)) {
                    $res .= ' and ';
                }

                if ($Dn < 2) {
                    $res .= $ones[$Dn * 10 + $n];
                } else {
                    $res .= $tens[$Dn];

                    if ($n) {
                        $res .= '-' . $ones[$n];
                    }
                }
            }

            if (empty($res)) {
                $res = 'zero';
            }

            return $res;
        }
    @endphp
@endsection
