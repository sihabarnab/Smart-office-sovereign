@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Invoice List</h1>
                    {{ $form }} To {{ $to }}.
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rpt_purchase_invoice_info') }}" method="GET">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="date" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" value="{{$form}}">
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No <br> Date</th>
                                    <th>Requiction No <br> Date</th>
                                    <th>Warehouse</th>
                                    <th>Prepare By</th>
                                    <th>Approved By</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_purchase_master as $key => $row)
                                    @php
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->user_id)
                                            ->first();
                                        $txt_name =  $ci_employee_info == null ? '': $ci_employee_info->employee_name;
                                        $approved_mgm = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->approved_id)
                                            ->first();
                                        $mgm_name = $approved_mgm->employee_name;

                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->purchase_invoice_no }} <br> {{ $row->purchase_invoice_date }}</td>
                                        <td>{{ $row->purchase_requisition_id }} <br> {{ $row->purchase_requisition_date }}</td>
                                        <td>{{ $row->store_name}}</td>
                                        <td>{{ $txt_name}}</td>
                                        <td>{{ $mgm_name}}</td>
                                        <td>
                                            <a href="{{ route('rpt_purchase_invoice_details',$row->purchase_master_id) }}" >Print/View</a>
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
