@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Received Bill collection List</h1>
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Description</th>
                                    <th>Payment Type</th>
                                    <th>Paid Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $project_name = '';
                                    $customer_name = '';
                                    $prefer_by = '';
                                    $recive = 0;
                                @endphp
                                @foreach ($m_money_receipt as $key => $row)
                                    @php
                                        $m_bill_master = DB::table('pro_maintenance_bill_master')
                                            ->where('maintenance_bill_master_id', $row->maintenance_bill_master_id)
                                            ->first();
                                        $m_project = DB::table('pro_projects')
                                            ->Where('project_id', $m_bill_master->project_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $project_name = $m_project->project_name;
                                        $m_customer = DB::table('pro_customers')
                                            ->where('customer_id', $m_bill_master->customer_id)
                                            ->where('valid', 1)
                                            ->first();
                                        $customer_name = $m_customer->customer_name;
                                        // $m_employee = DB::table('pro_employee_info')
                                        //     ->where('employee_id', $row->user_id)
                                        //     ->first();
                                        // $prefer_by = $m_employee->employee_name;
                                        $recive = $row->paid_amount;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $m_bill_master->maintenance_bill_master_no }}</td>
                                        <td>
                                            Customer: {{ $customer_name }} <br>
                                            Project: {{ $project_name }} <br>
                                            Subject: {{ $m_bill_master->subject }} <br>
                                            Date: {{ $m_bill_master->entry_date }} {{ $m_bill_master->entry_time }} <br>

                                        </td>
                                        <td>
                                            @if ($row->payment_type == 1)
                                                {{'Cash'}}
                                            @elseif($row->payment_type == 2)
                                                {{'Cheque'}} <br>
                                                {{$row->chq_no}} <br>
                                                {{$row->chq_date}}

                                            @endif
                                        </td>
                                        <td class="text-right">{{ $recive }} <br>
                                            @if ($row->approved_status == 1)
                                                <span style="color: green;">{{ 'Received' }}</span>
                                            @else
                                                <span style="color: red;">{{ 'Not Received' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->approved_status == 1)
                                            @else
                                                <button type="button" class="btn btn-primary float-left m-2"
                                                    data-toggle="modal" data-target="#confirmModal"
                                                    onclick="set_bill_id({{ $row->mmr_id }})">
                                                    Received
                                                </button>
                                            @endif
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

    <!--Cancel Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-success">
                <div class="modal-body text-center">
                    <h2>Are You Confirm ?</h2> <br>
                    <form action="{{ route('mt_approved_bill_collection_ok') }}" method="GET">
                        @csrf
                        <input type="hidden" name="txt_mmr_id" id="txt_mmr_id">
                        <button type="button" class="btn btn-danger float-center m-1" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success float-center m-1">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function set_bill_id(id) {
            if (id) {
                $('#txt_mmr_id').val(id);
            } else {
                $('#txt_mmr_id').val('');
            }
        }
    </script>
@endsection
