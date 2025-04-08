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
    @php

        $ci_projects = DB::table('pro_projects')
            ->Where('project_id', $m_requisition_master->project_id)
            ->first();
        $txt_project_name = $ci_projects->project_name;
        $txt_project_add = $ci_projects->project_address;
        if ($m_requisition_master->approved_id) {
            $approvedMGM = DB::table('pro_employee_info')
                ->Where('employee_id', $m_requisition_master->approved_id)
                ->first();
            $approvedByMGM = $approvedMGM->employee_name;
        } else {
            $approvedByMGM = 'Pending';
        }

    @endphp

    <div class="">
        <img class="img_logo" src="{{ asset('public') }}/image/print_logo.png ">
    </div>
    <div class="container-fluid bill">

        <h1 class="text-center mb-5">Requisition</h1>
        <div class="">
            <img class="img_back" src="{{ asset('public') }}/image/sov.png ">
        </div>
        <div class="row m-5">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-12">

                        <div class="row" id="qd">
                            <div class="col-2">
                                <p class="m-0">
                                    Req No
                                </p>

                            </div>
                            <div class="col-6">
                                <p class="m-0">
                                    <span>:&nbsp;</span>{{ $m_requisition_master->req_no }}.
                                </p>
                            </div>
                            <div class="col-2">
                                <p class="m-0">
                                    Req Date
                                </p>
                            </div>
                            <div class="col-2 ">
                                <p class="m-0">
                                    <span>:&nbsp;</span>
                                    {{ $m_requisition_master->entry_date }}.
                                </p>
                            </div>
                            <div class="col-12">
                                @if ($m_requisition_master->free_warrenty == 1)
                                    <p class="m-0">Purpose : Free Warranty Period</p>
                                @endif
                                <p class="m-0">Project Name & Address: {{ $txt_project_name }},
                                    {{ $txt_project_add }}</p>
                                <p class="m-0">Approved(MGM) & Date: {{ $approvedByMGM }},
                                    {{ $m_requisition_master->approved_date }}
                                    {{ $m_requisition_master->approved_time }}
                                </p>
                            </div>
                        </div>


                    </div>
                </div>




                <table id="" class="table table-bordered table-striped table-sm mb-1">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Product</th>
                            <th width = "15%">Quantity</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_qty = 0;
                        @endphp
                        @foreach ($m_requisition_details as $key => $row)
                            @php
                                $product = DB::table('pro_product')
                                    ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                                    ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                                    ->select('pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
                                    ->Where('product_id', $row->product_id)
                                    ->first();
                                if (in_array($row->product_id, $data)) {
                                    $product_name = "$product->product_name($product->origin_name)";
                                } else {
                                    $product_name = "$product->product_name";
                                }
                                $unit = DB::table('pro_units')
                                    ->where('unit_id', $product->unit_id)
                                    ->first();
                                $total_qty = $total_qty + $row->approved_qty;
                            @endphp
                             @if($row->approved_qty > 0)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product_name }} </td>
                                <td style="text-align: right;">{{ numberFormat($row->approved_qty, 2) }}</td>
                                <td>{{ $unit->unit_name }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align: right;">Total</td>
                            <td colspan="1" style="text-align: right;">
                                {{ numberFormat(round($total_qty, 4), 2) }}</td>
                            <td colspan="1"></td>
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
