@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Warehouse Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>
@if(isset($m_store_edit))

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div align="left" class=""><h5>{{ "Update" }}</h5></div> --}}
                    <form action="{{ route('warehouse_update',$m_store_edit->store_id) }}" method="Post">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_store_name" name="txt_store_name"
                                    placeholder="Warehous Name" value="{{$m_store_edit->store_name }}">
                                @error('txt_store_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" id="txt_store_address"
                                    name="txt_store_address" placeholder="Warehous Address"
                                    value="{{$m_store_edit->store_address }}">
                                @error('txt_store_address')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-2">
                                <button type="Submit" class="btn btn-primary btn-block">Update</button>
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
                        {{-- <div align="left" class=""><h5>{{ "Add" }}</h5></div> --}}
                        <form action="{{ route('warehouse_store') }}" method="Post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_store_name" name="txt_store_name"
                                        placeholder="Warehous Name" value="{{ old('txt_store_name') }}">
                                    @error('txt_store_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-7">
                                    <input type="text" class="form-control" id="txt_store_address"
                                        name="txt_store_address" placeholder="Warehous Address"
                                        value="{{ old('txt_store_address') }}">
                                    @error('txt_store_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Add</button>
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
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-body">
                        <table id="data1" class="table table-border table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Warehous Name</th>
                                    <th>Warehous Address</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
    
                                @foreach($m_store as $key=>$row)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->store_name }}</td>
                                    <td>{{ $row->store_address }}</td>
                                    <td>
                                        <a href="{{ route('warehouse_edit', $row->store_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
@endsection
