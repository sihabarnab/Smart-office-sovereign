@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Mode Of Payment</h3>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if(isset($m_mode_edit))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('mode_of_payment_update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12 mb-2">
                                    <input type="hidden" id="txt_mode_id" name="txt_mode_id" class="form-control"
                                         value="{{$m_mode_edit->mode_id}}" readonly>
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Title" value="{{$m_mode_edit->mode_title}}">
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                           
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
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
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('mode_of_payment_store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12 mb-2">
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Title" value="{{ old('txt_remark') }}">
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                           
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Save</button>
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
                                    <th class="text-center">SI NO</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_mode as $key => $row)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $row->mode_title }}</td>
                                        <td class="text-center">
                                            <a href="{{route('mode_of_payment_edit',$row->mode_id)}}">Edit</a>
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


