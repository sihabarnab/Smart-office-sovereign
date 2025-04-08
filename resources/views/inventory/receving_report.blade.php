@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Receving Report</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
                                    <th>Purchase No <br> Date</th>
                                    <th>Supplyer Name</th>
                                    <th>Preferred By</th>
                                    <th>Approved</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($m_master as $key => $row)
                                    @php
                                        $m_supplyer = DB::table('pro_suppliers')
                                            ->where('supplier_id', $row->supplier_id)
                                            ->first();

                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->user_id)
                                            ->first();
                                        $txt_name = $ci_employee_info->employee_name;

                                        $ci_approved= DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->approved_id)
                                            ->first();
                                        $txt_approved_name = $ci_approved == null ? '':  $ci_approved->employee_name;

                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->purchase_no }} <br> {{ $row->entry_date }}</td>
                                        <td>{{ $m_supplyer->supplier_name }} <br> {{$m_supplyer->supplier_add }}</td>
                                        <td>{{ $txt_name}}</td>
                                        <td>{{ $txt_approved_name}}</td>
                                        <td>
                                            <a href="{{ route('receving_details',$row->purchase_no) }}" >Add</a>
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
