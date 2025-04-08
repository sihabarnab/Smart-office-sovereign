@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill collection List</h1>
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
                        <form action="{{ route('mt_bill_collection_info') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                        <option value="">--Select Customer--</option>
                                        <option value="all">--ALL Customer--</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}"
                                                {{ $customer == $row->customer_id ? 'selected' : '' }}>
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_projet_id" id="cbo_projet_id" class="form-control">
                                        <option value="">--Select Project--</option>

                                    </select>
                                    @error('cbo_projet_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_from_date" id="txt_from_date"
                                        placeholder="Form" onfocus="(this.type='date')" value="{{ $form }}">
                                    @error('txt_from_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_to_date" id="txt_to_date"
                                        placeholder="To" onfocus="(this.type='date')" value="{{ $to }}">
                                    @error('txt_to_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-8 col-sm-3 mb-2">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-9 mb-2">
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
                        <table id="maintenance_bill_data" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th class="text-center" colspan="5">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $project_name = '';
                                    $customer_name = '';
                                    $prefer_by = '';
                                    $recive = 0;
                                    $due = 0;
                                @endphp
                                @foreach ($m_bill_master as $key => $row)
                                    @php
                                        $recive = DB::table('pro_maintenance_money_receipt')
                                            ->where('maintenance_bill_master_id', $row->maintenance_bill_master_id)
                                            ->whereNull('due_status')
                                            ->sum('paid_amount');
                                        $due = $row->grand_total - $recive + $row->repair_price;

                                        //Approved check
                                        $all_mr_count = DB::table('pro_maintenance_money_receipt')
                                            ->where('maintenance_bill_master_id', $row->maintenance_bill_master_id)
                                            ->count();
                                        $approved_mr_count = DB::table('pro_maintenance_money_receipt')
                                            ->where('maintenance_bill_master_id', $row->maintenance_bill_master_id)
                                            ->where('approved_status', 1)
                                            ->count();
                                    @endphp



                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->maintenance_bill_master_no }} <br>
                                            {{ $row->entry_date }} {{ $row->entry_time }}
                                        </td>
                                        <td colspan="5" class="m-0">
                                            <table class="table table-borderless">
                                                <thead class="table-bordered">
                                                    <tr>
                                                        <td colspan="1"> Description</td>
                                                        <td colspan="1" class="text-center"> Total</td>
                                                        <td colspan="1" class="text-center"> Receive</td>
                                                        <td colspan="1" class="text-center">Due</td>
                                                        <td colspan="1"> </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                        <td>
                                                            Project: {{ $row->project_name }} <br>
                                                            Subject: {{ $row->subject }} <br>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->grand_total + $row->repair_price }}</td>
                                                        <td class="text-center">
                                                            {{ $recive }} <br>
                                                            @if ($all_mr_count == $approved_mr_count && $recive > 0)
                                                                <span style="color: green;">{{ 'Received' }}</span>
                                                            @else
                                                                <span style="color: red;">{{ 'Not Received' }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="{{ $due > 0 ? 'taskblink text-center' : 'text-center' }}"
                                                            style="color: yellow;">
                                                            {{ $due }}</td>
                                                        <td>
                                                            @if ($due > 0)
                                                                <a target="_blank" class="btn btn-primary m-1"
                                                                    href="{{ route('maintenance_add_money', $row->maintenance_bill_master_id) }}">Add
                                                                    Money</a>

                                                                <a target="_blank" class="btn btn-success m-1"
                                                                    href="{{ route('maintenance_mr_list', $row->maintenance_bill_master_id) }}">Money
                                                                    Receipt List</a>

                                                                <a target="_blank" class="btn btn-info m-1"
                                                                    href="{{ route('rpt_mt_bill_view', $row->maintenance_bill_master_id) }}">Bill
                                                                    Details</a>
                                                            @else
                                                                <a target="_blank" class="btn btn-success m-1"
                                                                    href="{{ route('maintenance_mr_list', $row->maintenance_bill_master_id) }}">Money
                                                                    Receipt List</a>

                                                                <a target="_blank" class="btn btn-info m-1"
                                                                    href="{{ route('rpt_mt_bill_view', $row->maintenance_bill_master_id) }}">Bill
                                                                    Details</a>
                                                            @endif
                                                        </td>

                                                    </tr>

                                                    <tr class="m-0 p-0">
                                                        <td class="m-0 p-0" colspan="5">
                                                            <hr color="#6C757D">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="1">{{ $row->due_description }}</td>
                                                        <td colspan="1">{{ $row->previous_due }}</td>
                                                        <td colspan="2"></td>
                                                        <td colspan="1">
                                                            <a target="_blank" class="btn btn-warning"
                                                                style="color:white;"
                                                                href="{{ route('maintenance_due_add_money', $row->maintenance_bill_master_id) }}">
                                                                Due Add Money </a>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('select[name="cbo_customer_id"]').on('change', function() {
                getClientProject();
            });
            getClientProject();
        });

        function getClientProject() {
            var cbo_customer_id = $('select[name="cbo_customer_id"]').val();
            if (cbo_customer_id) {
                $.ajax({
                    url: "{{ url('/get/summery/project_list/') }}/" + cbo_customer_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_projet_id"]').empty();
                        $('select[name="cbo_projet_id"]').append(
                            '<option value="">--Select Project--</option>');
                        //
                        $.each(data, function(key, value) {
                            if (value.project_id == "{{ $project }}") {
                                $('select[name="cbo_projet_id"]').append(
                                    '<option selected value="' + value.project_id + '">' +
                                    value.project_name + '</option>');
                            } else {
                                $('select[name="cbo_projet_id"]').append(
                                    '<option value="' + value.project_id + '">' +
                                    value.project_name + '</option>');
                            }

                        });
                    },
                });

            } else {
                $('select[name="cbo_projet_id"]').empty();
            }
        }
    </script>

    <script>
        var data = "{{ $m_bill_master->count() }}";
        if (data) {
            var page = data;
        } else {
            var page = 10000;
        }

        $(function() {
            $("#maintenance_bill_data").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": page,
                "buttons": [{
                        extend: 'copy',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'csv',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'excel',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'pdf',
                        title: 'Bill Information'
                    },
                    {
                        extend: 'print',
                        title: 'Bill Information'
                    },
                    'colvis'
                ]
            }).buttons().container().appendTo('#maintenance_bill_data_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

@endsection
