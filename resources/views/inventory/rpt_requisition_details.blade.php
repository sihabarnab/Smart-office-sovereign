@extends('layouts.inventory_app')
@section('content')
    <form action="{{ route('rpt_requisition_print', [$m_requisition_master->requisition_master_id]) }}" method="post">
        @csrf

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Requisition Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">

                        {{-- <a href="{{ route('rpt_requisition_print', $m_requisition_master->requisition_master_id) }}"
                        class="btn btn-primary float-right">Print</a> --}}

                        <button type="Submit" class="btn btn-primary float-right">Print</button>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="container-fluid">
            @include('flash-message')
        </div>


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


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

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
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="" class="table table-bordered table-striped table-sm mb-1">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Product Name</th>
                                        <th>Product Description</th>
                                        <th>Origin</th>
                                        <th>Quantity</th>
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
                                                ->leftJoin(
                                                    'pro_origins',
                                                    'pro_product.origin_id',
                                                    'pro_origins.origin_id',
                                                )
                                                ->select(
                                                    'pro_product.*',
                                                    'pro_sizes.size_name',
                                                    'pro_origins.origin_name',
                                                )
                                                ->Where('pro_product.product_id', $row->product_id)
                                                ->first();
                                            $unit = DB::table('pro_units')
                                                ->where('unit_id', $product->unit_id)
                                                ->first();
                                            $total_qty = $total_qty + $row->approved_qty;
                                        @endphp

                                        @if($row->approved_qty > 0)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>
                                                @isset($product->product_des)
                                                    {{ $product->product_des }}
                                                @endisset
                                                @isset($product->size_name)
                                                    -{{ $product->size_name }}
                                                @endisset
                                            </td>
                                            <td> <input type="checkbox" id="p{{ $row->product_id }}"
                                                    name="p{{ $row->product_id }}" value="{{ $row->product_id }}" />
                                                <label for="{{ $row->product_id }}">{{ $product->origin_name }}</label>
                                            </td>
                                            <td style="text-align: right;">{{ numberFormat($row->approved_qty, 2) }}</td>
                                            <td>{{ $unit->unit_name }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">Total</td>
                                        <td colspan="1" style="text-align: right;">
                                            {{ numberFormat(round($total_qty, 4), 2) }}</td>
                                        <td colspan="1"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

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
