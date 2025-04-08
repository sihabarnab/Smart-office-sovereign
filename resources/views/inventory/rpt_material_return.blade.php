@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Return</h1>
                    {{ $form }} To {{ $to }}.
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
                        <form action="{{ route('rpt_material_return_datewise') }}" method="get">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form"  value="{{$form}}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" value="{{$to}}">
                                    @error('txt_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Search</button>
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL</th>
                                    <th class="text-left align-top">Return No <br> Date</th>
                                    <th class="text-left align-top">Challan No <br> Date</th>
                                    <th class="text-left align-top">Warehouse</th>
                                    <th class="text-left align-top">Project Name</th>
                                    <th class="text-left align-top">Prepare By</th>
                                    <th class="text-left align-top">Remark</th>
                                    <th class="text-left align-top">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_material_return as $key => $value)
                                    <tr>
                                        <td class="text-left align-top">{{ $key + 1 }}</td>
                                        <td class="text-left align-top">{{ $value->return_no }} <br> {{$value->return_date}}</td>
                                        <td class="text-left align-top">{{ $value->chalan_no }} <br> {{$value->dc_date}}</td>
                                        <td class="text-left align-top">{{ $value->store_name }}</td>
                                        <td class="text-left align-top">{{ $value->project_name }}</td>
                                        <td class="text-left align-top">{{ $value->employee_name }}</td>
                                        <td class="text-left align-top">{{ $value->remark }}</td>
                                        <td class="text-left align-top">  <a href="{{route('rpt_material_return_view',$value->return_no )}}"
                                            class="btn btn-primary btn-block">View</a></td>
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


