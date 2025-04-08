@extends('layouts.inventory_app')
@section('content')
    @php
        $total_qty = 0;

        $m_project = DB::table('pro_projects')
            ->where('project_id', $d_challan->project_id)
            ->first();
        $m_project_name = $m_project->project_name;

    @endphp

    <form action="{{ route('rpt_mt_delivery_challan_print', $d_challan->chalan_no) }}" method="post">
        @csrf

        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- <a href="{{ route('rpt_mt_delivery_challan_print', $d_challan->chalan_no) }}"
                                class="btn btn-primary float-right">Print</a> --}}
                                <button type="Submit" class="btn btn-primary float-right">Print</button>

                            <h1 class="text-center">Delivery Challan</h1>
                            <div class="row m-4">
                                <div class="col-12">
                                    <div class="row mt-1 mb-3">
                                        <div class="col-12">

                                            <div class="row">
                                                <div class="col-2">
                                                    <p class="m-0">
                                                        Challan No
                                                    </p>

                                                </div>
                                                <div class="col-6">
                                                    <p class="m-0">
                                                        <span>:&nbsp;</span>{{ $d_challan->chalan_no }}.
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
                                                        {{ $d_challan->dc_date }}.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <p class="m-0">
                                                        Requisition No
                                                    </p>

                                                </div>
                                                <div class="col-6">
                                                    <p class="m-0">
                                                        <span>:&nbsp;</span>{{ $d_challan->req_no }}.
                                                    </p>
                                                </div>
                                                <div class="col-2">
                                                    <p class="m-0">
                                                        Requisition Date
                                                    </p>
                                                </div>
                                                <div class="col-2 ">
                                                    <p class="m-0">
                                                        <span>:&nbsp;</span>
                                                        {{ $d_challan->req_date }}.
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="m-0">Name: {{ $m_project_name }}</p>
                                                    <p class="m-0">Address: {{ $d_challan->address }}</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <table id="" class="table table-bordered table-striped table-sm mb-1">
                                        <thead>
                                            <tr>
                                                <th>SL No</th>
                                                <th>Product</th>
                                                <th>Product Description</th>
                                                <th>Origin</th>
                                                <th style="text-align: right;">Quantity</th>
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($d_details as $key => $row)
                                                @php

                                                    $product = DB::table('pro_product')
                                                        ->leftJoin(
                                                            'pro_sizes',
                                                            'pro_product.size_id',
                                                            'pro_sizes.size_id',
                                                        )
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
                                                        ->Where('product_id', $row->product_id)
                                                        ->first();

                                                    $unit = DB::table('pro_units')
                                                        ->where('unit_id', $product->unit_id)
                                                        ->first();
                                                    $total_qty = $total_qty + $row->del_qty;
                                                @endphp
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
                                                            name="p{{ $row->product_id }}"
                                                            value="{{ $row->product_id }}" />
                                                        <label
                                                            for="{{ $row->product_id }}">{{ $product->origin_name }}</label>
                                                    </td>
                                                    <td style="text-align: right;">{{ number_format($row->del_qty, 2) }}
                                                    </td>
                                                    <td>{{ $unit->unit_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="text-align: right;">Total</td>
                                                <td colspan="1" style="text-align: right;">
                                                    {{ number_format(round($total_qty, 4), 2) }}</td>
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
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
