@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Requisition Approved(MGM)</h1>
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
                                Requisition No : {{ $pu_requ_master->purchase_requisition_id }}.
                            </div>
                            <div class="col-4">
                                Requisition Date : {{ $pu_requ_master->purchase_requisition_date }}.
                            </div>
                            <div class="col-4">
                                Prepare By : {{ $pu_requ_master->employee_name }}.
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                Remark : {{ $pu_requ_master->remark }}.
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
                                    <th width='65%'>Product Name</th>
                                    <th width='10%'>QTY</th>
                                    <th width='10%'></th>
                                    <th width='10%'></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pu_requ_details as $key => $row)
                                    <form action="{{ route('purchase_requisition_approved_ok', $row->pu_requ_details_id) }}"
                                        method="post">
                                        @csrf
                                        @php
                                            if ($row->product_des && $row->size_name == null) {
                                                $product_name = "$row->product_name-$row->product_des-$row->origin_name";
                                            } elseif ($row->product_des == null && $row->size_name) {
                                                $product_name = "$row->product_name-$row->size_name-$row->origin_name";
                                            } else {
                                                $product_name = "$row->product_name-$row->product_des-$row->size_name-$row->origin_name";
                                            }
                                        @endphp
                                        <tr>
                                            <td width='5%'><input type="text" class="form-control"
                                                    value="{{ $key + 1 }}" readonly></td>
                                            <td width='65%'><input type="text" class="form-control" value="{{ $product_name }}"
                                                    readonly>
                                            </td>
                                            <td width='10%'>
                                                <input type="text" class="form-control" name="txt_product_qty"
                                                    id="txt_product_qty" value="{{ $row->qty }}">
                                                @error('txt_product_qty')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td width='10%'>
                                                <button type="Submit" class="btn btn-primary ml-2">ok</button>
                                            </td>
                                            <td width='10%'>
                                                <!-- Reject trigger modal -->
                                                <button type="button" class="btn btn-danger"
                                                    data-toggle="modal" data-target="#confirmModal"
                                                    onclick='rejectRequisition("{{ $row->pu_requ_details_id }}")'>
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
                    <form action="{{ route('purchase_requisition_approved_reject') }}" method="GET">
                        @csrf
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
        function rejectRequisition(details_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#txt_details').val('');

            if (details_id) {
                $('#txt_details').val(details_id);
            } else {
                $('#txt_details').val('');
            }


        }
    </script>
@endsection
