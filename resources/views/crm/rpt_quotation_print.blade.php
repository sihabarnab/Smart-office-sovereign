<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">

    <style>
        @media print {
            .noPrint {
                display: none;
            }

            header,
            footer {
                display: none;
            }

            @page {
                size: auto;
            }


            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */
        }
    </style>

</head>

<body>


    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="row" id="qd">
                            <div class="col-2">
                                <p class="m-0">Quotation Number</p>
                            </div>
                            <div class="col-6">
                                <p class="m-0"> <span>:&nbsp;</span>{{ $m_quotation_master->quotation_master_id }}
                                </p>
                            </div>
                            <div class="col-2">
                                <p class="m-0">Quotation Date</p>
                            </div>
                            <div class="col-2 ">
                                <p class="m-0"><span>:&nbsp;</span> {{ $m_quotation_master->quotation_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3" id="qd">
                    <p class="m-0">To</p>
                    <p class="m-0"> {{ $m_quotation_master->customer_name }}</p>
                    <p class="m-0"> {{ $m_quotation_master->customer_address }}</p>
                    <p class="m-0">{{ $m_quotation_master->customer_mobile }}</p>
                    <p class="m-0">{{ $m_quotation_master->reference }}</p>
                    <p>{{ $m_quotation_master->reference_mobile }}</p>
                </div>

                <div class="row">
                    <div class="col-2">
                        <p class="font-weight-bold">Subject</p>
                    </div>
                    <div class="col-10">
                        <p class="font-weight-bold"><span>:&nbsp;</span> {{ $m_quotation_master->subject }}
                        </p>
                    </div>
                </div>
                <div class="qd">
                    <p class="m-0 p-0">Dear Sir/Madam,</p>
                    <p>Please refer to your subsequence discussion. We would like to quote you the following prices
                        against your query.</p>
                </div>
                <table id="ta" class="table table-bordered m-0 ">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Product Group</th>
                            <th>Product Sub Group</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Extended Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sub_total = 0;
                        @endphp
                        @foreach ($m_quotation_details as $key => $row)
                            @php
                                $sub_total += $row->total;
                                $unit = numberFormat($row->rate, 2);
                                $extended = numberFormat($row->total, 2);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row->pg_name }}</td>
                                <td>{{ $row->pg_sub_name }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->qty }}</td>
                                <td class="text-right">{{ $unit }}</td>
                                <td class="text-right">{{ $extended }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right font-weight-bold">Sub Total:</td>
                            <td class="text-right font-weight-bold ">
                                @php
                                    $sub_total_new = numberFormat($sub_total, 2);
                                @endphp
                                {{ $sub_total_new }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="row text-right">
                    <div class="col-7">

                    </div>
                    <div class="col-3 font-weight-bold">
                        <p class="m-0">VAT</p>
                        <p class="m-0">Advance Income Tax</p>
                    </div>
                    <div class="col-2 font-weight-bold ">
                        @php
                            $vat = numberFormat($m_quotation_master->vat, 2);
                            $ait = numberFormat($m_quotation_master->ait, 2);
                            $quotation_total = numberFormat($m_quotation_master->quotation_total, 2);
                        @endphp
                        <p class="m-0"> {{ $vat }} </p>
                        <p class="m-0">{{ $ait }}</p>
                    </div>
                </div>


                <div class="row text-right border">
                    <div class="col-8">

                    </div>
                    <div class="col-2 font-weight-bold">
                        <p class="m-0">Grand Total</p>

                    </div>
                    <div class="col-2 font-weight-bold border">
                        <p class=" m-0">{{ $quotation_total }}</p>
                    </div>
                </div>
                <div class="row border font-weight-bold mb-2">
                    <p class="m-0"> <span>In Words :</span>
                        @php
                            $quotation_total_word = convert_number(intval($quotation_total));
                        @endphp
                        {{ $quotation_total_word }}
                    </p>
                </div>


                <div class="row mb-2">
                    <div class="col-12">
                        <h6 class="text-center font-weight-bold">Terms &amp; Conditions</h6>

                        <div class="row border ">
                            <ol>
                                <li>The content of the pages of this website is for your general information and use
                                    only. It is subject to change without notice.</li>
                                <li>
                                    This website uses cookies to monitor browsing preferences. Please check our Privacy
                                    Policy for more information on the cookies we use.</li>
                                <li>
                                    All trade-marks reproduced in this website which are not the property of, or
                                    licensed to, the operator are acknowledged on the website</li>
                                <li>
                                    Unauthorized use of this website may give rise to a claim for damages and/or be a
                                    criminal offence</li>
                                <li>Price including VAT, Excluding AIT.</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-5"></div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <p class="text-center">Thanking You for your business <br>
                            If you have any quiries about this quotation please feel free to contact with us.</p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        @php
                            $employee_info = DB::table('pro_employee_info')
                                ->where('employee_id', Auth::user()->emp_id)
                                ->first();
                            $desig = DB::table('pro_desig')
                                ->where('desig_id', $employee_info->desig_id)
                                ->first();
                            
                        @endphp
                        <h6>
                            @isset($employee_info)
                                {{ $employee_info->employee_name }}
                            @endisset
                        </h6>
                        <h6>
                            @isset($desig)
                                {{ $desig->desig_name }}
                            @endisset
                        </h6>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>


    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
        setTimeout(function() {
            window.location.replace("{{ route('rpt_quotation_list') }}");
        }, 2000);
    </script>

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
        
            $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eightteen', 'Nineteen'];
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

</body>

</html>
