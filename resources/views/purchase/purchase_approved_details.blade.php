@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Approved(MGM)</h1>
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
                        <div class="row mb-1">
                            <div class="col-4">
                                Invoice No : {{  $purchase_master->purchase_invoice_no }} <br>
                                Invoice Date : {{  $purchase_master->purchase_invoice_date }}
                            </div>
                            <div class="col-4">
                                Requisition No : {{  $purchase_master->purchase_requisition_id }} <br>
                                Requisition Date : {{  $purchase_master->purchase_requisition_date }}
                            </div>
                            <div class="col-4">
                                Warehouse : {{ $purchase_master->store_name }} <br>
                                Prepare By : {{ $purchase_master->employee_name }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                Remark : {{ $purchase_master->remark }}
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


                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width='5%'>SL</th>
                                    <th >Product Name</th>
                                    <th width='15%'>Requistion QTY</th>
                                    <th width='15%'>Purchase QTY</th>
                                    <th width='10%'>Invoice QTY</th>
                                    <th width='10%'></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_details as $key => $row)
                                    <form  action="{{ route('purchase_approved_ok', $row->purchase_details_id) }}" method="post">
                                        @csrf
                                        @php
                                             $m_purchase_details = DB::table('pro_purchase_requisition_details')
                                             ->where('product_id', $row->product_id)
                                             ->where('purchase_requisition_id', $row->purchase_requisition_id)
                                             ->where('status', 3)
                                             ->first();
                                             $pu_qty = $m_purchase_details->pu_qty == null?0:$m_purchase_details->pu_qty;

                                             if ($row->product_des && $row->size_name == null) {
                                                $product_name = "$row->product_name-$row->product_des-$row->origin_name";
                                            } elseif ($row->product_des == null && $row->size_name) {
                                                $product_name = "$row->product_name-$row->size_name-$row->origin_name";
                                            } else {
                                                $product_name = "$row->product_name-$row->product_des-$row->size_name-$row->origin_name";
                                            }
                                        @endphp
                                        <tr>
                                            <td><input type="text" class="form-control" value="{{ $key + 1 }}"
                                                    readonly></td>
                                            <td><input type="text" class="form-control" value="{{ $product_name }}"
                                                    readonly></td>
                                            <td><input type="text" class="form-control" value="{{ $m_purchase_details->approved_qty }}"
                                                    readonly></td>
                                            <td><input type="text" class="form-control" value="{{$pu_qty }}"
                                                    readonly></td>
                                            <td>
                                                <input type="text" class="form-control" name="txt_product_qty"
                                                    id="txt_product_qty" value="{{ $row->qty }}" readonly>
                                                @error('txt_product_qty')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td> <button type="Submit" class="btn btn-primary btn-block">ok</button></td>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
