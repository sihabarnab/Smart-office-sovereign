@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition Product Add</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($edit_req_details))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                {{-- <h5>{{ 'Add' }}</h5> --}}
                            </div>
                            <form
                                action="{{ route('requisition_product_update', $edit_req_details->requisition_details_id) }}"
                                method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                        <input type="text" class="form-control" value="{{ $edit_req_master->req_no }}"
                                            readonly>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                                        @php
                                            $project = DB::table('pro_projects')
                                                ->where('project_id', $edit_req_master->project_id)
                                                ->first();
                                        @endphp
                                        <input type="text" name="txt_project_id" id="txt_project_id"
                                            value="{{ $project->project_name }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="">-Product-</option>
                                            @foreach ($m_product as $value)
                                                <option value="{{ $value->product_id }}"
                                                    {{ $edit_req_details->product_id == $value->product_id ? 'selected' : '' }}>
                                                    {{ $value->product_name }}
                                                    @isset($value->product_des)
                                                        | {{ $value->product_des }}
                                                    @endisset
                                                    @isset($value->size_name)
                                                        | {{ $value->size_name }}
                                                    @endisset
                                                    @isset($value->origin_name)
                                                        | {{ $value->origin_name }}
                                                    @endisset
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <input type="text" class="form-control" name="txt_product_price"
                                            id="txt_product_price" value="{{ $edit_req_details->product_price }}"
                                            placeholder="Price">
                                        @error('txt_product_price')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 cl-sm-12 mb-2">
                                        <input type="text" class="form-control" name="txt_product_qty"
                                            id="txt_product_qty" value="{{ $edit_req_details->product_qty }}"
                                            placeholder="product qty">
                                        @error('txt_product_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-2 col-md-6 cl-sm-12 mb-2">
                                        <input type="text" class="form-control" name="txt_product_unit"
                                            id="txt_product_unit" placeholder="Unit" readonly>
                                        @error('txt_product_unit')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-12  col-sm-12 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Update</button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                {{-- <h5>{{ 'Add' }}</h5> --}}
                            </div>
                            <form action="{{ route('mt_requisition_add_product', $req_master->requisition_master_id) }}"
                                method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                        <input type="text" class="form-control" value="{{ $req_master->req_no }}"
                                            readonly>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                                        @php
                                            $project = DB::table('pro_projects')
                                                ->where('project_id', $req_master->project_id)
                                                ->first();
                                        @endphp
                                        <input type="text" name="txt_project_id" id="txt_project_id"
                                            value="{{ $project->project_name }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="">-Product-</option>
                                            @foreach ($m_product as $value)
                                                <option value="{{ $value->product_id }}">
                                                    {{ $value->product_name }}
                                                    @isset($value->product_des)
                                                        | {{ $value->product_des }}
                                                    @endisset
                                                    @isset($value->size_name)
                                                        | {{ $value->size_name }}
                                                    @endisset
                                                    @isset($value->origin_name)
                                                        | {{ $value->origin_name }}
                                                    @endisset
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <input type="text" class="form-control" name="txt_product_price"
                                            id="txt_product_price" value="{{ old('txt_product_price') }}"
                                            placeholder="Price">
                                        @error('txt_product_price')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 cl-sm-12 mb-2">
                                        <input type="text" class="form-control" name="txt_product_qty"
                                            id="txt_product_qty" value="{{ old('txt_product_qty') }}"
                                            placeholder="product qty">
                                        @error('txt_product_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-2 col-md-6 cl-sm-12 mb-2">
                                        <input type="text" class="form-control" name="txt_product_unit"
                                            id="txt_product_unit" value="{{ old('txt_product_unit') }}"
                                            placeholder="Unit" readonly>
                                        @error('txt_product_unit')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-8 col-md-12  col-sm-12 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">add</button>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                        @php
                                            $check = DB::table('pro_requisition_details')
                                                ->where('requisition_master_id', $req_master->requisition_master_id)
                                                ->first();
                                        @endphp
                                        @if (isset($check))
                                            <a class="btn btn-primary btn-block"
                                                href="{{ route('mt_requisition_finish', $req_master->requisition_master_id) }}">
                                                Finish</a>
                                        @else
                                            <a class="btn btn-primary btn-block" href="#"> Finish</a>
                                        @endif
                                    </div>
                                </div>
                            </form>

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
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Product QTY</th>
                                        <th>Unit</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($req_details as $key => $row)
                                        @php

                                            $ci_product = DB::table('pro_product')
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
                                            <td>
                                                {{ $txt_product_name }}
                                                @isset($ci_product->product_des)
                                                    | {{ $ci_product->product_des }}
                                                @endisset
                                                @isset($ci_product->size_name)
                                                    | {{ $ci_product->size_name }}
                                                @endisset
                                                @isset($ci_product->origin_name)
                                                    | {{ $ci_product->origin_name }}
                                                @endisset

                                            </td>
                                            <td>{{ number_format($row->product_price, 2) }}</td>
                                            <td>{{ number_format($row->product_qty, 2) }}</td>
                                            <td>{{ $unit_name }}</td>
                                            <td>
                                                <a href="{{ route('requisition_product_edit', $row->requisition_details_id) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            //initial get unit
            Getunit();
            // change time get unit
            $('select[name="cbo_product"]').on('change', function() {
                Getunit();
            });
        });

        function Getunit() {
            var cbo_product = $('#cbo_product').val();
            if (cbo_product) {
                $.ajax({
                    url: "{{ url('/get/inventory/requisition/product_unit/') }}/" + cbo_product,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="txt_product_unit"]').empty();
                        $('#txt_product_unit').val(data.unit_name);

                    },
                });

            } else {
                $('#txt_product_unit').val('');
            }
        }
    </script>
@endsection
@endsection
