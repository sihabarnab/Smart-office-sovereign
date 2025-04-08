@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Challan </h1>
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
                        <form action="{{ route('rpt_mt_delivery_datewise') }}" method="get">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" value="{{ $form }}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" value="{{ $to }}">
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Ch. No & Date</th>
                                    <th>Req. No & Approved Date</th>
                                    <th>WareHouse</th>
                                    <th>Name & Address</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($d_challan as $key => $row)
                                    @php
                                        $m_project = DB::table('pro_projects')
                                            ->where('project_id', $row->project_id)
                                            ->first();
                                        $m_project_name = $m_project->project_name;
                                        $m_warehouse = DB::table('pro_store_details')
                                            ->select('store_name', 'store_id')
                                            ->where('store_id', $row->store_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $m_store_name = $m_warehouse == null ? '': $m_warehouse->store_name;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->chalan_no }} <br> {{ $row->dc_date }}</td>
                                        <td>{{ $row->req_no }} <br> {{ $row->req_date }}</td>
                                        <td>{{ $m_store_name }}</td>
                                        <td>{{ $m_project_name }} <br> {{ $row->address }}</td>
                                        <td> {{ $row->remark }}</td>
                                        <td><a
                                                href="{{ route('rpt_mt_delivery_challan_view', $row->chalan_no) }}">Details</a>
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
