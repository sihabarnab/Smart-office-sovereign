@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Invoice Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    {{-- <a href="{{route('rpt_purchase_print',$pu_master->purchase_no)}}" class="btn btn-primary float-right">Print</a> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @php

        $ci_employee_info = DB::table('pro_employee_info')
            ->Where('employee_id', $m_purchase_master->approved_id)
            ->first();
        $mgm_approved = $ci_employee_info->employee_name;

    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-4">
                                Invoice No : {{ $m_purchase_master->purchase_invoice_no }} <br>
                                Invoice Date : {{ $m_purchase_master->purchase_invoice_date }}
                            </div>
                            <div class="col-4">
                                Requisition No : {{ $m_purchase_master->purchase_requisition_id }} <br>
                                Requisition Date : {{ $m_purchase_master->purchase_requisition_date }}
                            </div>

                            <div class="col-4">
                                Warehouse : {{ $m_purchase_master->store_name }} <br>
                                Approved By : {{ $mgm_approved }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                Remark : {{ $m_purchase_master->remark }}.
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Origin</th>
                                    <th>Product QTY</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($m_purchase_details as $key => $row)
                                    @php
                                        $ci_product = DB::table('pro_product')
                                            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                                            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                                            ->select('pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
                                            ->Where('pro_product.product_id', $row->product_id)
                                            ->first();

                                        $txt_product_name = $ci_product->product_name;

                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', $ci_product->unit_id)
                                            ->first();
                                        $unit_name = $unit->unit_name;

                                        $sum = $sum + $row->approved_qty;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $txt_product_name }}</td>
                                        <td>
                                            @isset($ci_product->product_des)
                                                {{ $ci_product->product_des }}
                                            @endisset
                                            @isset($ci_product->size_name)
                                                -{{ $ci_product->size_name }}
                                            @endisset
                                        </td>
                                        <td>
                                            {{ $ci_product->origin_name }}
                                        </td>
                                        <td class="text-right">{{ number_format($row->approved_qty, 2) }}</td>
                                        <td>{{ $unit_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">Total:</td>
                                    <td colspan="1" class="text-right">{{ number_format($sum, 2) }}</td>
                                    <td colspan="1"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
