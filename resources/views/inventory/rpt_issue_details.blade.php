@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Receving Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                   {{-- <a href="{{route('rpt_purchase_print',$pu_master->purchase_no)}}" class="btn btn-primary float-right">Print</a> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @php
        $ci_employee_info = DB::table('pro_employee_info')
            ->Where('employee_id', $issue_master->user_id)
            ->first();
        $txt_name = $ci_employee_info->employee_name;

    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-4">
                                Issue NO : {{ $issue_master->mi_master_no }}.
                            </div>
                            <div class="col-4">
                                Req. NO : {{ $issue_master->req_no }}.
                            </div>
                            <div class="col-4">
                                Entry By : {{  $txt_name }}.
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4">
                                Issue Date : {{ $issue_master->entry_date }}.
                            </div>
                            <div class="col-4">
                                Req. Date : {{ $issue_master->req_date }}.
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
                                    <th>Product Group</th>
                                    <th>Product Sub Group</th>
                                    <th>Product Name</th>
                                    <th>Issue QTY</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($issue_details as $key => $row)
                                    @php
                                        $ci_product_group = DB::table('pro_product_group')
                                            ->Where('pg_id', $row->pg_id)
                                            ->first();
                                        $txt_pg_name = $ci_product_group->pg_name;

                                        $ci_product_sub_group = DB::table('pro_product_sub_group')
                                            ->Where('pg_sub_id', $row->pg_sub_id)
                                            ->first();
                                        $txt_pg_sub_name = $ci_product_sub_group->pg_sub_name;

                                        $ci_product = DB::table('pro_product')
                                            ->Where('product_id', $row->product_id)
                                            ->first();
                                        $txt_product_name = $ci_product->product_name;

                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', $ci_product->unit_id)
                                            ->first();
                                        $unit_name = $unit->unit_name;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $txt_pg_name }}</td>
                                        <td>{{ $txt_pg_sub_name }}</td>
                                        <td>{{ $txt_product_name }}</td>
                                        <td class="text-right">{{ $row->issue_qty }}</td>
                                        <td>{{ $unit_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
