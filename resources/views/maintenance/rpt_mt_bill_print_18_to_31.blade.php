<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/fontawesome-free/css/all.min.css">

    <style>
        @media print {
            .noPrint {
                display: none;
            }

            header,
            footer {
                display: none;
            }

            /* @page {
                size: auto;
            } */

            body {
                background-image: url('{{ asset('public') }}/image/sov.png') !important;
                background-size: cover;
            }


            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */
        }

        .img_logo {
            position: fixed;
            width: 20%;
            margin-left: 75%;
            top: -4px;
        }

        .img_back {
            z-index: 1;
            position: fixed;
            top: 25%;
            left: 20%;
            opacity: .1;
        }

        .print_footer {
            position: fixed;
            bottom: 0;
            display: flex;
            font-size: 18px;
        }

        .print_footer i {
            color: blueviolet
        }

        .print_footer img {
            width: 70%;
            margin-top: -25px;
            margin-right: 10px;
        }
    </style>

</head>

<body>


    <div class="container-fluid">
        <div class="row  ml-5 mr-5 mt-4 mb-5">
            <div class="col-12">
                <table class="table table-borderless table-sm m-0">
                    <thead class="table-borderless">
                        <tr>
                            <td colspan="5">
                                <img class="img_logo" src="{{ asset('public') }}/image/print_logo.png ">
                                <h2 class="text-center">MAINTENANCE BILL</h2>
                                <img class="img_back" src="{{ asset('public') }}/image/sov.png ">
                                <br>

                            </td>
                        </tr>
                    </thead>
                    <tbody class="table-borderless">

                        <tr>
                            <td colspan="3" class="text-left">
                                Invoice No : {{ $m_bill_master->maintenance_bill_master_no }} <br>
                                Quotation No : {{ $m_bill_master->quotation_master_id }} <br>
                            </td>
                            <td colspan="2" class="text-right">
                                Invoice Date : {{ $m_bill_master->entry_date }} <br>
                                Quotation Date : {{ $m_bill_master->quotation_date }} <br>
                            </td>
                            <br>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <strong>To</strong> <br>
                                <strong>{{ $m_bill_master->customer_name }}</strong> <br>
                                {{ $m_bill_master->customer_add }} <br>
                                {{ $m_bill_master->customer_phone }} <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <strong>Subject:- </strong> &nbsp; {{ $m_bill_master->subject }} <br class="m-0">
                                <br class="m-0">
                            </td>
                        </tr>
                        <tr>
                            <th width='10%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                SL NO</th>
                            <th width='50%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                PRODUCT</th>
                            <th width='10%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                QTY</th>
                            <th width='15%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                RATE</th>
                            <th width='15%' class="text-right font-weight-bold" style="border: 1px solid #DEE2E6;">
                                TOTAL</th>
                        </tr>

                        @php
                            $sub_total = 0;
                            $repair_price = 0;
                            $previous_due = 0;
                            $bill_total = 0;
                            $total_word = 0;
                            $i = 1;
                        @endphp
                        @foreach ($m_bill_details as $key => $row)
                            @if (!$loop->last)
                                @php
                                    $sub_total += $row->sub_total;
                                    $extended = number_format($row->sub_total, 2);
                                    $qty = number_format($row->qty, 2);
                                    $unit = number_format($row->rate, 2);
                                @endphp
                                <tr>
                                    <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $i++ }}</td>
                                    <td width='50%' style="border: 1px solid #DEE2E6;">{{ $row->product_name }}</td>
                                    <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $qty }} </td>
                                    <td width='15%' class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $unit }}</td>
                                    <td width='15%'class="text-right" style="border: 1px solid #DEE2E6;">
                                        {{ $extended }}</td>
                                </tr>
                            @endif
                        @endforeach


                        {{-- 24 gape, increse product per gape  minus  --}}

                        @php
                            $tr_count = 37 - $countRaw;
                            $next_page = (int) ($tr_count / 2);
                        @endphp
                        @for ($x = 0; $x <= $tr_count; $x++)
                            @if ($next_page == $x)
                                <tr>
                                    <td colspan="5" class="text-right"></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            @endif
                        @endfor


                        <tr>
                            <th width='10%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                SL NO</th>
                            <th width='50%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                PRODUCT</th>
                            <th width='10%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                QTY</th>
                            <th width='15%' class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                RATE</th>
                            <th width='15%' class="text-right font-weight-bold" style="border: 1px solid #DEE2E6;">
                                TOTAL</th>
                        </tr>
                        {{-- @endif --}}


                        @foreach ($m_bill_details as $key => $row)
                            @if ($loop->last)
                                @php
                                    $sub_total += $row->sub_total;
                                    $extended = number_format($row->sub_total, 2);
                                    $qty = number_format($row->qty, 2);
                                    $unit = number_format($row->rate, 2);
                                @endphp
                                <tr>
                                    <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $i++ }}</td>
                                    <td width='50%' style="border: 1px solid #DEE2E6;">{{ $row->product_name }}</td>
                                    <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $qty }} </td>
                                    <td width='15%' class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $unit }}</td>
                                    <td width='15%'class="text-right" style="border: 1px solid #DEE2E6;">
                                        {{ $extended }}</td>
                                </tr>
                            @endif
                        @endforeach


                        @if ($m_bill_master->repair_price > 0 && $m_bill_master->repair_descrption)
                            @php
                                $repair_price = $m_bill_master->repair_price;
                            @endphp
                            <tr>
                                <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">
                                    {{ $i++ }}</td>
                                <td width='50%' style="border: 1px solid #DEE2E6;">
                                    {{ $m_bill_master->repair_descrption }}</td>
                                <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">----</td>
                                <td width='15%'class="text-center" style="border: 1px solid #DEE2E6;"> ---- </td>
                                <td width='15%' class="text-right" style="border: 1px solid #DEE2E6;">
                                    {{ number_format($m_bill_master->repair_price, 2) }}
                                </td>
                            </tr>
                        @endif

                        @if ($m_bill_master->previous_due > 0 && $m_bill_master->due_description)
                            @php
                                $previous_due = $m_bill_master->previous_due;
                            @endphp
                            <tr>
                                <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">
                                    {{ $i++ }}</td>
                                <td width='50%' style="border: 1px solid #DEE2E6;">
                                    {{ $m_bill_master->due_description }}</td>
                                <td width='10%' class="text-center" style="border: 1px solid #DEE2E6;">----</td>
                                <td width='15%' class="text-center" style="border: 1px solid #DEE2E6;">----</td>
                                <td width='15%' class="text-right" style="border: 1px solid #DEE2E6;">
                                    {{ number_format($m_bill_master->previous_due, 2) }}
                                </td>
                            </tr>
                        @endif
                
            
                

                        @php
                            $ait = number_format($m_bill_master->ait, 2);
                            $other = number_format($m_bill_master->other, 2);
                            $vat = number_format($m_bill_master->vat, 2);
                            $discount = number_format($m_bill_master->discount, 2);
                            $bill_total = number_format($m_bill_master->grand_total + $repair_price + $previous_due, 2);
                            $total_word = $m_bill_master->grand_total + $repair_price + $previous_due;

                        @endphp

                        <tr>
                            <td colspan="4" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                SUB-TOTAL:</td>
                            <td class="text-right font-weight-bold" style="border: 1px solid #DEE2E6;">
                                @php
                                    $sub_total_new = number_format($sub_total + $repair_price + $previous_due, 2);
                                @endphp
                                {{ $sub_total_new }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                DISCOINT
                                @if ($m_bill_master->discount_percent > 0)
                                    ({{ $m_bill_master->discount_percent }}%)
                                @endif
                                :
                            </td>
                            <td colspan="1" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                {{ $discount }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                VAT
                                @if ($m_bill_master->vat_percent > 0)
                                    ({{ $m_bill_master->vat_percent }}%)
                                @endif
                                :
                            </td>
                            <td colspan="1" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                {{ $vat }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                AIT
                                @if ($m_bill_master->ait_percent > 0)
                                    ({{ $m_bill_master->ait_percent }}%)
                                @endif
                                :
                            </td>
                            <td colspan="1" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                {{ $ait }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                OTHERS
                                @if ($m_bill_master->other_percent > 0)
                                    ({{ $m_bill_master->other_percent }}%)
                                @endif
                                :
                            </td>
                            <td colspan="1" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                {{ $other }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                GRAND TOTAL:</td>
                            <td colspan="1" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                {{ $bill_total }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5">
                                @php
                                    $bill_total_word = convert_number($total_word);
                                @endphp
                                <strong>Amount In word:-</strong> &nbsp; Taka {{ $bill_total_word }} Only.
                            </td>
                        </tr>
                        @if ($m_bill_master->vat > 0 || $m_bill_master->ait > 0)
                        @else
                            <tr>
                                <td colspan="5">
                                    <strong>Note:-</strong> TAX, VAT is not included with the above price.
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="5">
                                Thanking you & assuring Our best service at all time.

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                @php
                                    $employee_info = DB::table('pro_employee_info')
                                        ->where('employee_id', Auth::user()->emp_id)
                                        ->first();
                                    $desig = DB::table('pro_desig')
                                        ->where('desig_id', $employee_info->desig_id)
                                        ->first();
                                @endphp
                                <strong>For, Sovereign Technology Ltd</strong>
                                <br><br><br><br>
                                @isset($employee_info)
                                    <strong>{{ $employee_info->employee_name }}</strong> <br>
                                @endisset
                                @isset($desig)
                                    {{ $desig->desig_name }} <br>
                                @endisset
                                @isset($employee_info->mobile)
                                    {{ $employee_info->mobile }}
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-borderless">
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>

                    </tfoot>
                </table>

            </div>
        </div>
    </div>





    <div class="row print_footer">
        <div class="col-10">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
            Twin Brooks, Flat #A-4, House #8, Road #2/B, Block # J, Baridhara, Dhaka-1212,
            Bangladesh <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
            <i class="fas fa-tty"></i> +88-02-8837483, 8835049, 226616379, <i class="fas fa-envelope"></i>
            info@sovereignbd.com, <i class="fas fa-globe"></i>&nbsp;
            sovereignbd.com

        </div>
        <div class="col-2">
            <img src="{{ asset('public') }}/image/member_logo.png">
        </div>

    </div>


    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
        setTimeout(function() {
            history.back();
        }, 2000);
    </script>



</body>

</html>
