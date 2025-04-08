@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
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
                        <table id="stock_data" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        {{ $m_product->product_name }}
                                        @isset($m_product->product_des)
                                            | {{ $m_product->product_des }}
                                        @endisset
                                        @isset($m_product->size_name)
                                            | {{ $m_product->size_name }}
                                        @endisset
                                        @isset($m_product->origin_name)
                                            | {{ $m_product->origin_name }}
                                        @endisset
                                    </th>
                                </tr>
                                <tr>
                                    <th>SL</th>
                                    <th>Warehouse</th>
                                    <th class="text-right">Stock Qty </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_qty = 0;
                                @endphp
                                @foreach ($m_store as $key => $row)
                                    @php
                                        $stock_in = DB::table('pro_product_stock')
                                            ->where('product_id', $m_product->product_id)
                                            ->where('store_id', $row->store_id)
                                            ->where('status', 1)
                                            ->sum('qty');

                                        $stock_out = DB::table('pro_product_stock')
                                            ->where('product_id', $m_product->product_id)
                                            ->where('store_id', $row->store_id)
                                            ->where('status', 2)
                                            ->sum('qty');

                                        $balance = $stock_in - $stock_out;
                                        $total_qty = $total_qty + $balance;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->store_name }}</td>
                                        <td class="text-right">{{ number_format($balance, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td colspan="1" class="text-right">{{ $total_qty }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
