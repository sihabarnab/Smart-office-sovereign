@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition List for Approve</h1>
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

        $prepare = DB::table('pro_employee_info')
            ->Where('employee_id', $m_requisition_master->user_id)
            ->first();
        $prepare_by = $prepare->employee_name;

        if ($m_requisition_master->supplier_id) {
            $m_supplier = DB::table('pro_suppliers')
                ->Where('supplier_id', $m_requisition_master->supplier_id)
                ->first();
            $m_supplier_name = $m_supplier->supplier_name;
            $m_supplier_add = $m_supplier->supplier_add;
        } else {
            $m_supplier_name = '';
            $m_supplier_add = '';
        }
    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4">
                                Req No/Date : {{ $m_requisition_master->req_no }} |
                                {{ $m_requisition_master->entry_date }}
                            </div>
                            <div class="col-3">
                                Prepare by : {{ $prepare_by }},
                            </div>
                            <div class="col-5">
                                Project : {{ $txt_project_name }}.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Supplier : {{ $m_supplier_name }}
                            </div>
                            <div class="col-8">
                                Supplier Address : {{ $m_supplier_add }},
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
                                <th>SL No</th>
                                <th>Product Name</th>
                                <th>QTY</th>
                                <th>Approved QTY (MGM)</th>
                                <th>Unit</th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($m_requisition_details as $key => $row)
                                    @php
                                        $product = DB::table('pro_product')
                                            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                                            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                                            ->select('pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
                                            ->Where('product_id', $row->product_id)
                                            ->first();

                                        if ($product->product_des && $product->size_name == null) {
                                            $product_name = "$product->product_name-$product->product_des-$product->origin_name";
                                        } elseif ($product->product_des == null && $product->size_name) {
                                            $product_name = "$product->product_name-$product->size_name-$product->origin_name";
                                        } else {
                                            $product_name = "$product->product_name-$product->product_des-$product->size_name-$product->origin_name";
                                        }

                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', $product->unit_id)
                                            ->first();
                                    @endphp
                                    <form
                                        action="{{ route('mt_requisition_admin_approved_final', $row->requisition_details_id) }}"
                                        method="post">
                                        @csrf
                                        <tr>
                                            <td width="10%"><input type="text" class="form-control"
                                                    value="{{ $key + 1 }}" readonly></td>
                                            <td width="35%"><input type="text" class="form-control"
                                                    value="{{ $product_name }}" readonly></td>
                                            <td width="15%"> <input class="form-control" value="{{ $row->product_qty }}"
                                                    readonly></td>
                                            <td width="10%">
                                                <input class="form-control" name="txt_approved_qty" id="txt_approved_qty"
                                                    placeholder="Approved QTY" value="{{ $row->product_qty }}">
                                                @error('txt_approved_qty')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td width="10%"><input class="form-control" value="{{ $unit->unit_name }}"
                                                    readonly></td>
                                            <td width="10%"> <button type="Submit" id="save_event"
                                                    class="btn btn-primary btn-block">OK</button></td>
                                            <td width="10%">
                                                <!-- Reject trigger modal -->
                                                <button type="button" class="btn btn-danger"
                                                    data-toggle="modal" data-target="#confirmModal"
                                                    onclick='rejectRequisition("{{$row->requisition_details_id}}","{{$row->requisition_master_id}}")'>
                                                    Reject
                                                </button>
                                            </td>
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

    <!--Reject Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-success">
                <div class="modal-body text-center">
                    <h2>Are You Confirm ?</h2> <br>
                    <form action="{{ route('requisition_admin_approved_reject') }}" method="GET">
                        @csrf
                        <input type="hidden" name="txt_master" id="txt_master">
                        <input type="hidden" name="txt_details" id="txt_details">
                        <button type="button" class="btn btn-danger float-center m-1" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success float-center m-1">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function rejectRequisition(details_id,master_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#txt_details').val('');
            $('#txt_master').val(''); 

            if(master_id && details_id){
                $('#txt_details').val(details_id);
                $('#txt_master').val(master_id);
            }else{
                $('#txt_details').val('');
                $('#txt_master').val(''); 
            }


        }
    </script>
@endsection
