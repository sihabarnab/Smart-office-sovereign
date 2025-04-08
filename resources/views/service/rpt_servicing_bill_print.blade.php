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

            @page {
                size: auto;
            }

            body {
                background-image: url('{{ asset('public') }}/image/sov.png') !important;
                background-size: cover;
            }


            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */
        }

        .bill {
            margin-top: 10%;
        }

        .img_logo {
            position: absolute;
            width: 20%;
            margin-left: 76%;
            top: 4%;
        }

        .img_back {
            z-index: 1;
            position: absolute;
            top: 25%;
            left: 20%;
            opacity: .1;
        }

        .print_footer {
            position: absolute;
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

    <div class="">
        <img class="img_logo" src="{{ asset('public') }}/image/print_logo.png ">
    </div>
    <div class="container-fluid bill">
        <h1 class="text-center mb-5">SERVICING BILL</h1>
        <div class="">
            <img class="img_back" src="{{ asset('public') }}/image/sov.png ">
        </div>
        <div class="row m-5">
            <div class="col-12">

                <div class="row mt-2">
                    <div class="col-2">
                        Date
                    </div>
                    <div class="col-6">
                        <span>:&nbsp;</span>{{ $service_bill_master->bill_date }}
                    </div>
                    <div class="col-2">
                        Invoice No
                        @if (isset($service_bill_master->issue_date))
                            <br> Issue Date
                        @endif

                    </div>
                    <div class="col-2 ">
                        <span>:&nbsp;</span> {{ $service_bill_master->service_bill_no }}
                        @if (isset($service_bill_master->issue_date))
                            <br> <span>:&nbsp;</span> {{ $service_bill_master->issue_date }}
                        @endif
                    </div>
                </div>

                @php
                    $m_project = DB::table('pro_projects')
                        ->Where('project_id', $service_bill_master->project_id)
                        ->where('valid', 1)
                        ->first();
                    $project_name = $m_project->project_name;
                    $project_address = $m_project->project_address;
                    $m_customer = DB::table('pro_customers')
                        ->where('customer_id', $service_bill_master->customer_id)
                        ->where('valid', 1)
                        ->first();
                    $customer_name = $m_customer->customer_name;
                    $employee_info = DB::table('pro_employee_info')
                        ->where('employee_id', Auth::user()->emp_id)
                        ->first();
                    $desig = DB::table('pro_desig')
                        ->where('desig_id', $employee_info->desig_id)
                        ->first();

                    //due

                    $previous_due = 0;
                    if ($service_bill_master->previous_due > 0) {
                        $previous_due = $service_bill_master->previous_due;
                    }
                @endphp

                <div class="row mt-5">
                    <div class="col-12">
                        To <br>
                        {{ $customer_name }} <br>
                        {{ $project_address }}
                    </div>
                </div>

                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <strong>Subject:-</strong>&nbsp; &nbsp; {{ $service_bill_master->subject }}
                    </div>
                </div>

                <table class="table  table-sm m-0">
                    <thead class="table-bordered">
                        <tr>
                            <th class="text-center" width='10%'>SL No</th>
                            <th width='40%' class="text-center">Description</th>
                            <th width='10%' class="text-center">Month</th>
                            <th width='10%' class="text-center">Lift</th>
                            <th width='15%' class="text-center">Rate</th>
                            <th width='15%' class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered">
                        <tr>
                            <td class="text-center">{{ '1' }}</td>
                            <td class="text-left">{{ $service_bill_master->description }}</td>
                            <td class="text-center">{{ $service_bill_master->month_qty }}
                            </td>
                            <td class="text-center">{{ $service_bill_master->lift_qty }}
                            </td>
                            <td class="text-center"> {{ number_format($service_bill_master->rate, 2) }}</td>
                            <td class="text-right"> {{ number_format($service_bill_master->total, 2) }}</td>
                        </tr>

                        @if (isset($service_bill_master->due_description) && $service_bill_master->previous_due > 0)
                            <tr>
                                <td class="text-center">{{ '2' }}</td>
                                <td class="text-left">{{ $service_bill_master->due_description }}</td>
                                <td class="text-center">
                                    ----
                                </td>
                                <td class="text-center">
                                    ----
                                </td>
                                <td class="text-center">
                                    ----
                                </td>
                                <td class="text-right">
                                    {{ number_format($service_bill_master->previous_due, 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="table-borderless">
                        <tr>
                            <td colspan="5" class="text-right" style="border: 1px solid #DEE2E6;">
                                Total:
                            </td>
                            <td class="text-right" style="border: 1px solid #DEE2E6;">
                                {{ number_format($service_bill_master->total + $previous_due, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="1" class="text-right" style="border: 1px solid #DEE2E6;">
                                Discount:</td>
                            <td class="text-right" style="border: 1px solid #DEE2E6;">
                                {{ number_format($service_bill_master->discount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="1" class="text-right" style="border: 1px solid #DEE2E6;">
                                VAT
                                @if($service_bill_master->vat_percent > 0)
                                ({{$service_bill_master->vat_percent}}%)
                                @endif
                                :</td>
                            <td class="text-right" style="border: 1px solid #DEE2E6;">
                                {{ number_format($service_bill_master->vat, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="1" class="text-right" style="border: 1px solid #DEE2E6;">
                                AIT:
                                @if($service_bill_master->ait_percent > 0)
                                ({{$service_bill_master->ait_percent}}%)
                                @endif
                            </td>
                            <td class="text-right" style="border: 1px solid #DEE2E6;">
                                {{ number_format($service_bill_master->ait, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="1" class="text-right" style="border: 1px solid #DEE2E6;">
                                Others:</td>
                            <td class="text-right" style="border: 1px solid #DEE2E6;">
                                {{ number_format($service_bill_master->other, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="1" class="text-right" style="border: 1px solid #DEE2E6;">
                                Grand Total:</td>
                            <td class="text-right" style="border: 1px solid #DEE2E6;">
                                {{ number_format($service_bill_master->grand_total + $previous_due, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>


                <div class="row mt-3">
                    <div class="col-12">
                        <strong>Amount In Words :</strong>
                        @php
                            $quotation_total_word = convert_number($service_bill_master->grand_total + $previous_due);
                        @endphp
                        Taka {{ $quotation_total_word }} Only.
                    </div>
                </div>

                <div class="row mb-2 mt-3">
                    <div class="col-12">
                        Thanking you & assuring Our best service at all time.
                    </div>
                </div>


                <div class="row mb-1 mt-3">
                    <div class="col-12">
                        <strong>For, Sovereign Technology Ltd</strong>

                        <br><br><br><br><br>
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

</body>


</html>
