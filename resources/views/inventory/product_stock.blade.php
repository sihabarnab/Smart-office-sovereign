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
                        <form action="{{ route('product_stock_store') }}" method="POST">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control"  id="cbo_product" name="cbo_product">
                                        <option value="">-Select Product-</option>
                                        @foreach ($m_product as $row)
                                            <option value="{{ $row->product_id }}"
                                                {{ old('cbo_product') == $row->product_id ? 'selected' : '' }}>
                                                {{ $row->product_name }} |  {{ $row->product_des }} | {{$row->size_name}} | {{$row->origin_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control"  id="cbo_store_id" name="cbo_store_id">
                                        <option value="">-Select Warehouse-</option>
                                        @foreach ($m_wearhouse as $row)
                                            <option value="{{ $row->store_id }}"
                                                {{ old('cbo_store_id') == $row->store_id ? 'selected' : '' }}>
                                                {{ $row->store_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_store_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-2">
                                   <input type="number" class="form-control"  id="txt_qty" name="txt_qty" placeholder="Qty">
                                    @error('txt_qty')
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



@endsection
