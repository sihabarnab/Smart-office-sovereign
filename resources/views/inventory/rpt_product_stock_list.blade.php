@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Stock</h1>
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
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('rpt_product_stock_list') }}" method="GET">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-10">
                                    <select class="custom-select" id="cbo_product" name="cbo_product">
                                        <option value="">-Select Product-</option>
                                        <option value="0" selected>All Product</option>
                                        @foreach ($m_product as $row)
                                            <option value="{{ $row->product_id }}"
                                                {{ $product_id == $row->product_id ? 'selected' : '' }}>
                                                {{ $row->product_name }}
                                                @isset($row->product_des)
                                                    | {{ $row->product_des }}
                                                @endisset
                                                @isset($row->size_name)
                                                    | {{ $row->size_name }}
                                                @endisset
                                                @isset($row->origin_name)
                                                    | {{ $row->origin_name }}
                                                @endisset
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Submit</button>
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
                                    <th width="">SL</th>
                                    <th width="">Product name</th>
                                    <th>Unit</th>
                                    <th width="">Size</th>
                                    <th width="">Origin</th>
                                    <th>Description</th>
                                    <th width="" class="text-right">Stock</th>
                                    <th width="" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_product as $key => $row)
                                    @php
                                        $total_product_qty = DB::table('pro_product_stock')
                                            ->where('product_id', $row->product_id)
                                            ->orderByDesc('stock_id')
                                            ->first();
                                        if (isset($total_product_qty)) {
                                            $total_stock =
                                                $total_product_qty->total_stock == null
                                                    ? 0
                                                    : $total_product_qty->total_stock;
                                        } else {
                                            $total_stock = 0;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $row->unit_name }}</td>
                                        <td>{{ $row->size_name }}</td>
                                        <td>{{ $row->origin_name }}</td>
                                        <td>{{ $row->product_des }}</td>
                                        <td class="text-right">{{ number_format($total_stock, 2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('rpt_product_stock_details', [$row->product_id]) }}"
                                                class="btn btn-primary" target="_blank">
                                                Details
                                            </a>
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
@endsection
