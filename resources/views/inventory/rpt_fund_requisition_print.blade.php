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
                margin-top: 7%;
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

        <h1 class="text-center mb-5">Fund Requisition</h1>
        <div class="">
            <img class="img_back" src="{{ asset('public') }}/image/sov.png ">
        </div>
        <div class="row m-5">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-12">

                        <div class="row mb-1">
                            <div class="col-12">
                                Date : {{ $fund_requisition_master->entry_date }}. <br>
                                Req No : {{ $fund_requisition_master->fund_requisition_no }}.
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-12">
                                Team :
                                {{ $m_teams->team_name . '|' . $m_teams->employee_name . "($m_teams->department_name)" }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                Project: <br>
                                <div class="row mb-1">
                                    @foreach ($fund_requisition_project as $key => $row)
                                        <div class="col-4">
                                            @php
                                                $m_projects = DB::table('pro_projects')
                                                    ->where('project_id', $row->project_id)
                                                    ->first();
                                                $project_name = $m_projects->project_name;
                                            @endphp

                                            {{ $key + 1 }}. {{ $project_name }} 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>




                <table class="table table-border table-striped table-sm mb-1">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Estimated Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_rate = 0;
                            $eastimat_price = 0;
                        @endphp
                        @foreach ($fund_requisition_details as $key => $row)
                            @php
                                $total_rate = ($row->rate*$row->qty);
                                $eastimat_price = $eastimat_price + $total_rate ;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row->description }}</td>
                                <td class="text-right">{{ number_format($row->rate, 2) }}</td>
                                <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                <td>{{ $row->unit_name }}</td>
                                <td class="text-right">{{ number_format($total_rate, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right">Total:</td>
                            <td colspan="1" class="text-right">{{ number_format($total_rate, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>


                <div class="row mt-3">
                    Received the above goods in good condition.
                </div>

                <div class="row">
                    @php
                        $employee_info = DB::table('pro_employee_info')
                            ->where('employee_id', Auth::user()->emp_id)
                            ->first();
                        $desig = DB::table('pro_desig')
                            ->where('desig_id', $employee_info->desig_id)
                            ->first();

                        $user_name = $employee_info->employee_name;
                        $user_desg = $desig->desig_name;
                    @endphp
                    {{ $user_name }} <br>{{ $user_desg }}
                </div>



            </div> {{-- End col  --}}
        </div> {{-- End row  --}}
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
