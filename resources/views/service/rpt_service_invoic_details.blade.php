@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Service Invoice Details</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Client</th>
                                    <th>Project</th>
                                    <th>Product Price</th>
                                    <th>Service Charge</th>
                                    <th>Vat</th>
                                    <th>Other</th>
                                    <th>Total Bill</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sub_total = 0;
                                @endphp
                                @foreach ($ser_bill_master as $key => $row)
                                    @php

                                        $m_customer = DB::table('pro_customers')
                                            ->where('customer_id', $row->customer_id)
                                            ->where('valid', '1')
                                            ->first();
                                        $txt_customer_name = $m_customer->customer_name;
                                        
                                        $ci_complaint_register = DB::table('pro_complaint_register')
                                            ->Where('complaint_register_id', $row->complain_id)
                                            ->first();

                                        $ci_projects = DB::table('pro_projects')
                                            ->Where('project_id', $ci_complaint_register->project_id)
                                            ->first();
                                        $txt_project_name = $ci_projects->project_name;
                                        
                                        //
                                        if(isset($row->service_bill_master_id)){
                                            $sum_product_bill = DB::table('pro_service_bill_details')
                                                ->where('customer_id', $row->customer_id)
                                                ->where('service_bill_master_id', $row->service_bill_master_id)
                                                ->where('valid', 1)
                                                ->sum('sub_total');
                                        }

                                        $sub_total += $row->total;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $txt_customer_name }}</td>
                                        <td>{{ $txt_project_name }}</td>
                                        <td>
                                            @if (isset($sum_product_bill))
                                            {{ $sum_product_bill }}
                                            @else
                                                {{ '0' }}
                                            @endif
                                          
                                        </td>
                                        <td>{{ $row->service_charge }}</td>
                                        <td>{{ $row->vat }}</td>
                                        <td>{{ $row->other }}</td>
                                        <td>{{ $row->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-right font-weight-bold">Total:</td>
                                    <td class="text-right font-weight-bold ">
                                        {{ $sub_total }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right font-weight-bold">Paid:</td>
                                    <td class="text-right font-weight-bold ">
                                        {{ $m_paid_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right font-weight-bold">Balance:</td>
                                    <td class="text-right font-weight-bold ">
                                        {{ $sub_total - $m_paid_amount }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
