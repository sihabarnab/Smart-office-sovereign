@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Return</h1>
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
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $m_material_return->return_no }}"
                                    readonly>
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" value="{{ $m_material_return->return_date }}"
                                    readonly>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $m_material_return->store_name }}"
                                    readonly>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="txt_project_id" id="txt_project_id"
                                    value="{{ $m_material_return->project_name }}" placeholder="Project Name" readonly>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $m_material_return->chalan_no }}"
                                    placeholder="Challan No " readonly>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $m_material_return->dc_date }}"
                                    placeholder="Challan Date " readonly>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $m_material_return->req_no }}"
                                    placeholder="Requisition No " readonly>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $m_material_return->req_date }}"
                                    placeholder="Requisition Date " readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($d_challan_details->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left align-top" width='5%'>SL</th>
                                        <th width='40%' class="text-left align-top">Product</th>
                                        <th class="text-left align-top">Qty</th>
                                        <th class="text-left align-top">Good Qty</th>
                                        <th class="text-left align-top">Bad Qty</th>
                                        <th class="text-left align-top">Remark</th>
                                        <th class="text-left align-top"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($d_challan_details as $key => $value)
                                        @php
                                            if ($value->product_des && $value->size_name == null) {
                                                $product_name = "$value->product_name-$value->product_des-$value->origin_name";
                                            } elseif ($value->product_des == null && $value->size_name) {
                                                $product_name = "$value->product_name-$value->size_name-$value->origin_name";
                                            } else {
                                                $product_name = "$value->product_name-$value->product_des-$value->size_name-$value->origin_name";
                                            }
                                        @endphp
                                        <form action="{{ route('material_return_details_store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="txt_return_no"
                                                value="{{ $m_material_return->return_no }}" readonly>
                                            <input type="hidden" name="txt_delivery_chalan_details_id"
                                                value="{{ $value->delivery_chalan_details_id }}" readonly>

                                            <tr class="">
                                                <td class="text-left align-top pl-0 pr-0"><input type="text"
                                                        class="form-control" name="txt_description"
                                                        value="{{ $i++ }}" readonly>
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0">
                                                    <input type="text" class="form-control" name="txt_description"
                                                        value="{{ $product_name }}" readonly>
                                                </td>

                                                <td class="text-left align-top pl-0 pr-0">
                                                    <input type="number" class="form-control" name="txt_qty"
                                                        value="{{ $value->del_qty }}" readonly>
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0">
                                                    <input type="text" class="form-control" name="txt_good_qty">
                                                    @error('txt_good_qty')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0">
                                                    <input type="text" class="form-control" name="txt_bad_qty">
                                                    @error('txt_bad_qty')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0">
                                                    <input type="text" class="form-control" name="txt_remark">
                                                    @error('txt_remark')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-left align-top pl-1 pr-0">
                                                    <button type="Submit" id="save_event"
                                                        class="btn btn-primary btn-block">ADD</button>
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
    @endif

    @if ($m_material_return_details->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>MR Product List</h1>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left align-top">SL</th>
                                        <th class="text-left align-top">Product Name</th>
                                        <th class="text-left align-top">Good Qty</th>
                                        <th class="text-left align-top">Bad Qty</th>
                                        <th class="text-left align-top">Unit</th>
                                        <th class="text-left align-top">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_material_return_details as $key => $value)
                                        @php
                                            if ($value->product_des && $value->size_name == null) {
                                                $product_name = "$value->product_name-$value->product_des-$value->origin_name";
                                            } elseif ($value->product_des == null && $value->size_name) {
                                                $product_name = "$value->product_name-$value->size_name-$value->origin_name";
                                            } else {
                                                $product_name = "$value->product_name-$value->product_des-$value->size_name-$value->origin_name";
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">{{ $product_name }}</td>
                                            <td class="text-left align-top">{{ $value->good_qty }}</td>
                                            <td class="text-left align-top">{{ $value->bad_qty }}</td>
                                            <td class="text-left align-top">
                                                @php
                                                    $unit = DB::table('pro_units')
                                                        ->where('unit_id', '=', $value->unit_id)
                                                        ->first();
                                                @endphp
                                                @if (isset($unit))
                                                    {{ $unit->unit_name }}
                                                @endif
                                            </td>
                                            <td class="text-left align-top">{{ $value->remark }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="1">
                                            <a href="{{ route('material_return_final', $m_material_return->return_no) }}"
                                                class="btn btn-primary btn-block">Final</a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
