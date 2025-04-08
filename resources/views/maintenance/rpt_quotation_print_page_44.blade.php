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

            /* @page {
                size: auto;
            } */

            body {
                background-image: url('{{ asset('public') }}/image/sov.png') !important;
                background-size: cover;
            }

            header,
            footer {
                display: none;
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
            top: -8px;
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
        <div class="row m-5">
            <div class="col-12">
                <table class="table table-borderless table-sm m-0">
                    <thead class="table-borderless">
                        <tr>
                            <td colspan="5">
                                <img class="img_logo" src="{{ asset('public') }}/image/print_logo.png ">
                                <h1 class="text-center">QUOTATION</h1>
                                <img class="img_back" src="{{ asset('public') }}/image/sov.png ">
                                <br>

                            </td>
                        </tr>
                    </thead>
                    <tbody class="table-borderless">
                        <tr>
                            <td colspan="2" class="text-right">Quotation Date :
                                {{ $m_quotation_master->quotation_date }}</td>
                            <td colspan="3" class="text-left">Quotation No :
                                {{ $m_quotation_master->quotation_master_id }}</td>
                            <br>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <strong>To</strong> <br>
                                <strong>{{ $m_quotation_master->customer_name }}</strong> <br>
                                {{ $m_quotation_master->customer_address }}
                                {{-- {{ $m_quotation_master->customer_mobile }} --}}

                                @isset($m_quotation_master->reference)
                                    <br> Reference: {{ $m_quotation_master->reference }}
                                    @isset($m_quotation_master->reference_mobile)
                                        ({{ $m_quotation_master->reference_mobile }})
                                    @endisset
                                @endisset

                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <strong>Subject:- </strong> &nbsp; {{ $m_quotation_master->subject }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                Dear Sir/Madam, <br>
                                Please refer to your subsequence discussion. We would like to quote you the following
                                prices against your query.
                            </td>
                        </tr>

                        <tr>
                            <th width="10%" class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                SL NO.</th>
                            <th width="50%" class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                PRODUCT</th>
                            <th width="10%" class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                QTY</th>
                            <th width="15%" class="text-center font-weight-bold" style="border: 1px solid #DEE2E6;">
                                RATE</th>
                            <th width="15%" class="text-right font-weight-bold" style="border: 1px solid #DEE2E6;">
                                TOTAL</th>
                        </tr>

                        @php
                            $sub_total = 0;
                            $i = 1;
                            $repair_price = 0;
                        @endphp
                        @foreach ($m_quotation_details as $key => $row)
                            @if ($key<25)
                                @php

                                    if ($row->status == 3 && $row->customer_status == null) {
                                        $sub_total += $row->total;
                                        $extended = number_format($row->total, 2);
                                        $qty = number_format($row->qty, 2);
                                        $unit = number_format($row->rate, 2);
                                    } else {
                                        $sub_total += $row->approved_total;
                                        $extended = number_format($row->approved_total, 2);
                                        $unit = number_format($row->approved_rate, 2);
                                        $qty = number_format($row->approved_qty, 2);
                                    }
                                @endphp
                                <tr>
                                    <td width="10%" class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $i++ }}</td>
                                    <td width="50%" style="border: 1px solid #DEE2E6;">{{ $row->product_name }}</td>
                                    <td width="10%" class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $qty }} </td>
                                    <td width="15%" class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $unit }}</td>
                                    <td width="15%" class="text-right" style="border: 1px solid #DEE2E6;">
                                        {{ $extended }}</td>
                                </tr>
                            @endif
                        @endforeach

                        {{-- 7 gape  --}}
                        @for ($x = 0; $x <= 7; $x++)
                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                        @endfor

                        <tr>
                            <th width="10%" class="text-center font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                SL NO.</th>
                            <th width="50%" class="text-center font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                PRODUCT</th>
                            <th width="10%" class="text-center font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                QTY</th>
                            <th width="15%" class="text-center font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                RATE</th>
                            <th width="15%" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                TOTAL</th>
                        </tr>

                        @foreach ($m_quotation_details as $key => $row)
                            @if ($key > 24)
                                @php

                                    if ($row->status == 3 && $row->customer_status == null) {
                                        $sub_total += $row->total;
                                        $extended = number_format($row->total, 2);
                                        $qty = number_format($row->qty, 2);
                                        $unit = number_format($row->rate, 2);
                                    } else {
                                        $sub_total += $row->approved_total;
                                        $extended = number_format($row->approved_total, 2);
                                        $unit = number_format($row->approved_rate, 2);
                                        $qty = number_format($row->approved_qty, 2);
                                    }
                                @endphp
                                <tr>
                                    <td width="10%" class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $i++ }}</td>
                                    <td width="50%" style="border: 1px solid #DEE2E6;">{{ $row->product_name }}
                                    </td>
                                    <td width="10%" class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $qty }} </td>
                                    <td width="15%" class="text-center" style="border: 1px solid #DEE2E6;">
                                        {{ $unit }}</td>
                                    <td width="15%" class="text-right" style="border: 1px solid #DEE2E6;">
                                        {{ $extended }}</td>
                                </tr>
                            @endif
                        @endforeach

                        @if ($m_quotation_master->repair_price > 0 && $m_quotation_master->repair_descrption)
                            @php
                                $repair_price = $m_quotation_master->repair_price;
                            @endphp
                            <tr>
                                <td width="10%" class="text-center" style="border: 1px solid #DEE2E6;">
                                    {{ $i++ }}</td>
                                <td width="50%" style="border: 1px solid #DEE2E6;">
                                    {{ $m_quotation_master->repair_descrption }}
                                </td>
                                <td width="10%" class="text-center" style="border: 1px solid #DEE2E6;">----</td>
                                <td width="15%" class="text-center" style="border: 1px solid #DEE2E6;"> ---- </td>
                                <td width="15%" class="text-right" style="border: 1px solid #DEE2E6;">
                                    {{ number_format($m_quotation_master->repair_price, 2) }}
                                </td>
                            </tr>
                        @endif
                      
                       



                        @php
                            //
                            if ($m_quotation_master->status == 3 && $m_quotation_master->customer_status == null) {
                                $ait = number_format($m_quotation_master->ait, 2);
                                $other = number_format($m_quotation_master->other, 2);
                                $vat = number_format($m_quotation_master->vat, 2);
                                $discount = number_format($m_quotation_master->discount, 2);
                                $quotation_total = number_format(
                                    $m_quotation_master->quotation_total + $repair_price,
                                    2,
                                );
                                $total_word = $m_quotation_master->quotation_total + $repair_price;
                            } else {
                                $ait = number_format($m_quotation_master->approved_ait, 2);
                                $other = number_format($m_quotation_master->approved_other, 2);
                                $vat = number_format($m_quotation_master->approved_vat, 2);
                                $discount = number_format($m_quotation_master->approved_discount, 2);
                                $quotation_total = number_format(
                                    $m_quotation_master->approved_quotation_total + $repair_price,
                                    2,
                                );
                                $total_word = $m_quotation_master->approved_quotation_total + $repair_price;
                            }

                            //

                        @endphp

                        <tr>
                            <td colspan="4" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                SUB-TOTAL:</td>
                            <td class="text-right font-weight-bold" style="border: 1px solid #DEE2E6;">
                                @php
                                    $sub_total_new = number_format($sub_total + $repair_price, 2);
                                @endphp
                                {{ $sub_total_new }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right font-weight-bold"
                                style="border: 1px solid #DEE2E6;">
                                DISCOINT
                                @if ($m_quotation_master->discount_percent > 0)
                                    ({{ $m_quotation_master->discount_percent }}%)
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
                                @if ($m_quotation_master->vat_percent > 0)
                                    ({{ $m_quotation_master->vat_percent }}%)
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
                                @if ($m_quotation_master->ait_percent > 0)
                                    ({{ $m_quotation_master->ait_percent }}%)
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
                                @if ($m_quotation_master->other_percent > 0)
                                    ({{ $m_quotation_master->other_percent }}%)
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
                                {{ $quotation_total }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5">
                                @php
                                    $quotation_total_word = convert_number($total_word);
                                @endphp
                                <strong>Amount In word:-</strong> &nbsp; Taka {{ $quotation_total_word }} Only.
                                @if ($vat > 0 || $ait > 0)
                                @else
                                <br> <strong>Note:-</strong> TAX, VAT is not included with the above price.
                                @endif

                                @if ($m_quotation_master->mode_payment_status == 1)
                                    <br> <strong>Mode Of Payment :</strong> <br>
                                    @foreach ($m_mode_of_payment as $key => $value)
                                        {{ $key + 1 }}. {{ $value->mode_title }} <br>
                                    @endforeach
                                @endif

                                <strong>Validity :</strong>
                                {{ $m_quotation_master->offer_valid }} Days From the date of issue. <br>

                                Please call us for any further clarifications.
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



        {{-- <div class="col-12">
            <div class="page-number">
                
            </div>
        </div> --}}
    </div>

    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
            updatePageNumbers();
        }
        setTimeout(function() {
            history.back();
        }, 2000);
    </script>

</body>


</html>
