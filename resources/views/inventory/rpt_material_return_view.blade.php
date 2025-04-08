@extends('layouts.inventory_app')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">Material Return</h1>
                        <div class="row m-4">
                            <div class="col-12">

                                <div class="row mt-1 mb-3">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-2">
                                                <p class="m-0">
                                                    Return No
                                                </p>

                                            </div>
                                            <div class="col-6">
                                                <p class="m-0">
                                                    <span>:&nbsp;</span>{{ $m_material_return->return_no }}.
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <p class="m-0">
                                                    Return Date
                                                </p>
                                            </div>
                                            <div class="col-2 ">
                                                <p class="m-0">
                                                    <span>:&nbsp;</span>
                                                    {{ $m_material_return->return_date }}.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <p class="m-0">
                                                    Challan No
                                                </p>

                                            </div>
                                            <div class="col-6">
                                                <p class="m-0">
                                                    <span>:&nbsp;</span>{{ $m_material_return->chalan_no }}.
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <p class="m-0">
                                                    Challan Date
                                                </p>
                                            </div>
                                            <div class="col-2 ">
                                                <p class="m-0">
                                                    <span>:&nbsp;</span>
                                                    {{ $m_material_return->dc_date }}.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <p class="m-0">Warehouse: {{ $m_material_return->store_name }}</p>
                                                <p class="m-0">Project: {{ $m_material_return->project_name }}</p>
                                                <p class="m-0">Prepare By: {{ $m_material_return->employee_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-left align-top">SL</th>
                                            <th class="text-left align-top">Product Name</th>
                                            <th class="text-left align-top">Good Qty</th>
                                            <th class="text-left align-top">Bad Qty</th>
                                            <th class="text-left align-top">Unit</th>
                                            <th class="text-left align-top">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $good = 0;
                                            $bad = 0;
                                        @endphp
                                        @foreach ($m_material_return_details as $key => $value)
                                            @php
                                                $good = $good + $value->good_qty;
                                                $bad = $bad + $value->bad_qty;
                                                $unit = DB::table('pro_units')
                                                    ->where('unit_id', '=', $value->unit_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td class="text-left align-top">{{ $key + 1 }}</td>
                                                <td class="text-left align-top">{{ $value->product_name }}</td>
                                                <td class="text-left align-top">{{ number_format($value->good_qty,2) }}</td>
                                                <td class="text-left align-top">{{ number_format($value->bad_qty,2) }}</td>
                                                <td class="text-left align-top">
                                                    @if (isset($unit))
                                                        {{ $unit->unit_name }}
                                                    @endif
                                                </td>
                                                <td class="text-left align-top">{{ $value->remark }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="2"></td>
                                            <td class="text-right" colspan="1">{{ number_format($good,2) }}</td>
                                            <td class="text-right" colspan="1">{{ number_format($bad,2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>


                                <div class="row mt-3">
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


                            </div>
                        </div>


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
@endsection
