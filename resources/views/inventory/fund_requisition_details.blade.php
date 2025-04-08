@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Requisition Details</h1>
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
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form
                            action="{{ route('fund_requisition_details_store', $fund_requisition_master->fund_requisition_master_id) }}"
                            method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_description" id="txt_description"
                                        value="{{ old('txt_description') }}" placeholder="Description">
                                    @error('txt_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_rate" id="txt_rate"
                                        value="{{ old('txt_rate') }}" placeholder="Rate">
                                    @error('txt_rate')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_qty" id="txt_qty"
                                        value="{{ old('txt_qty') }}" placeholder="QTY">
                                    @error('txt_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                @php
                                    $m_unit = DB::table('pro_units')->where('valid',1)->get();
                                @endphp
                                    <select name="txt_unit" id="txt_unit" class="form-control">
                                        <option value="">--Unit--</option>
                                        @foreach ($m_unit as $row)
                                            <option value="{{ $row->unit_name }}">
                                                {{ $row->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('txt_unit')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Add
                                        More</button>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    @php
                                      $fund_fcheck =  DB::table('pro_fund_requisition_details')->where('fund_requisition_master_id',$fund_requisition_master->fund_requisition_master_id)->count();
                                    @endphp
                                    @if($fund_fcheck >0)
                                    <a href="{{ route('fund_requisition_final',$fund_requisition_master->fund_requisition_master_id) }}"
                                        class="btn btn-primary btn-block">Final</a>
                                    @else
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block" disabled>Final </button>
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
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Project Name</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($fund_requisition_project as $key => $row)
                                    @php
                                        $m_projects = DB::table('pro_projects')
                                            ->where('project_id', $row->project_id)
                                            ->first();
                                        $project_name = $m_projects->project_name;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $project_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end col-6  --}}
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Estimated Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_rate = 0;
                                    $eastimat_price = 0;
                                @endphp
                                @foreach ($fund_requisition_details as $key => $row)
                                    @php
                                        $total_rate = ($row->rate*$row->qty);
                                        $eastimat_price = $eastimat_price + $total_rate ;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td class="text-right">{{ number_format($row->rate, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                        <td>{{ $row->unit_name }}</td>
                                        <td class="text-right">{{ number_format($total_rate, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Total:</td>
                                    <td colspan="1" class="text-right">{{ number_format($eastimat_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end col-6  --}}
        </div>
    </div>
@endsection
