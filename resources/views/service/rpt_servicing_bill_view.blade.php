@extends('layouts.service_app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('rpt_servicing_bill_print', $service_bill_master->service_bill_master_id) }}"
                            class="btn btn-primary float-right">Print</a>

                        <h1 class="text-center">SERVICING BILL</h1>
                        <div class="row m-4">
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

                                <div class="row mt-5 mb-4">
                                    <div class="col-12">
                                        <strong>Subject:-</strong>&nbsp; &nbsp; {{ $service_bill_master->subject }}
                                    </div>
                                </div>


                                <table class="table table-sm m-0">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th width='10%' class="text-center">SL No.</th>
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
                                            <td class="text-center"> {{ number_format($service_bill_master->rate, 2) }}
                                            </td>
                                            <td class="text-right"> {{ number_format($service_bill_master->total, 2) }}
                                            </td>
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
                                            <td colspan="5" class="text-right font-weight-bold"
                                                style="border: 1px solid #6C757D;">Total:
                                            </td>
                                            <td class="text-right font-weight-bold" style="border: 1px solid #6C757D;">
                                                {{ number_format($service_bill_master->total + $previous_due, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1" class="text-right font-weight-bold"
                                                style="border: 1px solid #6C757D;">
                                                Discount:</td>
                                            <td class="text-right font-weight-bold" style="border: 1px solid #6C757D">
                                                {{ number_format($service_bill_master->discount, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1" class="text-right font-weight-bold"
                                                style="border: 1px solid #6C757D;">
                                                VAT 
                                                @if($service_bill_master->vat_percent > 0)
                                                ({{$service_bill_master->vat_percent}}%)
                                                @endif
                                                :
                                            </td>
                                            <td class="text-right font-weight-bold" style="border: 1px solid #6C757D">
                                                {{ number_format($service_bill_master->vat, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1" class="text-right font-weight-bold"
                                                style="border: 1px solid #6C757D;">
                                                AIT
                                                @if($service_bill_master->ait_percent > 0)
                                                ({{$service_bill_master->ait_percent}}%)
                                                @endif
                                                :
                                            </td>
                                            <td class="text-right font-weight-bold" style="border: 1px solid #6C757D">
                                                {{ number_format($service_bill_master->ait, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1" class="text-right font-weight-bold"
                                                style="border: 1px solid #6C757D;">
                                                Others:</td>
                                            <td class="text-right font-weight-bold" style="border: 1px solid #6C757D">
                                                {{ number_format($service_bill_master->other, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1" class="text-right font-weight-bold"
                                                style="border: 1px solid #6C757D;">
                                                Grand Total:</td>
                                            <td class="text-right font-weight-bold" style="border: 1px solid #6C757D">
                                                {{ number_format($service_bill_master->grand_total + $previous_due, 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>


                                <div class="row mt-3">
                                    <div class="col-12">
                                        <strong>Amount In Words :</strong>
                                        @php
                                            $quotation_total_word = convert_number(
                                                $service_bill_master->grand_total + $previous_due,
                                            );
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
