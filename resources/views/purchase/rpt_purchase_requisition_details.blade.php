@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Requisition List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    {{-- <a href="{{route('rpt_purchase_print',$pu_master->purchase_no)}}" class="btn btn-primary float-right">Print</a> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>




    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-4">
                                Requisition No : {{ $pu_requ_master->purchase_requisition_id }}
                            </div>
                            <div class="col-4">
                                Prepare By : {{ $pu_requ_master->employee_name }}.
                            </div>
                            <div class="col-4">
                                Approved By : {{ $pu_requ_master->approved_by }}.
                            </div>
                            <div class="col-4">
                                Requisition Date : {{ $pu_requ_master->purchase_requisition_date }}
                            </div>
                            <div class="col-8">
                                Remark : {{ $pu_requ_master->remark }}
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
                                @foreach ($pu_requ_details as $key => $row)
                                    @php
                                        $sum = $sum + $row->approved_qty;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>
                                            @isset($row->product_des)
                                                {{ $row->product_des }}
                                            @endisset
                                            @isset($row->size_name)
                                                <br> {{ $row->size_name }}
                                            @endisset
                                        </td>
                                        <td>
                                            {{ $row->origin_name }}
                                        </td>
                                        <td class="text-right">{{ number_format($row->approved_qty, 2) }}</td>
                                        <td>{{ $row->unit_name }}</td>
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
