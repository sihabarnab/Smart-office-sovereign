@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Summery</h1>
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
                        <form action="{{ route('rpt_all_report_summery_list') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                        <option value="">--Select Customer--</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}"
                                                {{ $row->customer_id == $customer_id ? 'selected' : '' }}>
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_projet_id" id="cbo_projet_id" class="form-control">
                                        <option value="">--Select Project--</option>
                                    </select>
                                    @error('cbo_projet_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" onfocus="(this.type='date')" value="{{ $form }}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" onfocus="(this.type='date')" value="{{ $to }}">
                                    @error('txt_to')
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



                        <table id="rpt2" class="table table-bordered table-striped table-sm">
                            <thead class="">
                                <tr>
                                    <th colspan="6" class="bg-primary text-left">Complain List</th>
                                </tr>
                                <tr>
                                    <th>SL</th>
                                    <th width = '10%'>Date</th>
                                    <th>Project</th>
                                    <th>lift</th>
                                    <th width = '30%'>Complain</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_complaint as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }} </td>
                                        <td>{{ $row->entry_date }}</td>
                                        <td> {{ $row->project_name }}</td>
                                        <td> {{ $row->lift_name }}</td>
                                        <td> {{ $row->complaint_description }}</td>
                                        <td>
                                            @php
                                                 $m_task_assign = DB::table('pro_task_assign')->where("complain_id",$row->complaint_register_id)->select('pro_task_assign.task_id')->first();
                                            @endphp
                                            @if (isset($m_task_assign))
                                            <a target="_blank" class="btn btn-info m-1"
                                            href="{{ route('mt_rpt_task_view', $m_task_assign->task_id) }}">Details</a>
                                            @else

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <hr>

                        <table id="rpt3" class="table table-bordered table-striped table-sm">
                            <thead class="">
                                <tr>
                                    <th colspan="5" class="bg-primary text-left">Quotation List</th>
                                </tr>
                                <tr>
                                    <th>SL No</th>
                                    <th>Qu. No / Date</th>
                                    <th>Project</th>
                                    <th>Approved(MGM)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_maintenance_quation as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }} </td>
                                        <td>{{ $row->quotation_master_id }} <br> {{ $row->quotation_date }}</td>
                                        <td> {{ $row->project_name }}</td>
                                        <td> {{ $row->mgm_name }}</td>
                                        <td>
                                            <a target="_blank" class="btn btn-info m-1"
                                            href="{{ route('rpt_mt_quotation_view', $row->quotation_id) }}">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr>

                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead class="">
                                <tr>
                                    <th colspan="7" class="bg-primary text-left">Bill List</th>
                                </tr>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No/Date</th>
                                    <th>Project</th>
                                    <th>Total</th>
                                    <th>Receive</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $project_name = '';
                                    $customer_name = '';
                                    $prefer_by = '';
                                    $recive = 0;
                                    $due = 0;
                                    $total_due = 0;
                                    $total_receive = 0;
                                    $total_bill = 0;
                                @endphp
                                @foreach ($m_bill_master as $key => $row)
                                    @php
                                        $recive = DB::table('pro_maintenance_money_receipt')
                                            ->where('maintenance_bill_master_id', $row->maintenance_bill_master_id)
                                            ->sum('paid_amount');
                                        $due = $row->grand_total - $recive;
                                        $total_due = $due + $total_due;
                                        //
                                        $total_receive = $recive + $total_receive;
                                        $total_bill = $row->grand_total + $total_bill;

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
                                        <td>{{ $row->maintenance_bill_master_no }} <br> {{ $row->entry_date }}</td>
                                        <td>{{ $row->project_name }}</td>
                                        <td class="text-right">{{ $row->grand_total }}</td>
                                        <td class="text-right">
                                            {{ $recive }} <br>
                                            @if ($all_mr_count == $approved_mr_count && $recive > 0)
                                                <span style="color: green;">{{ 'Received' }}</span>
                                            @else
                                                <span style="color: red;">{{ 'Pending' }}</span>
                                            @endif
                                        </td>
                                        <td class="{{ $due > 0 ? 'taskblink text-right' : 'text-right' }}"
                                            style="color: yellow;">
                                            {{ $due }}
                                        </td>
                                        <td>
                                            <a target="_blank" class="btn btn-success m-1"
                                                href="{{ route('maintenance_mr_list', $row->maintenance_bill_master_id) }}">Money
                                                Receipt List</a>

                                            <a target="_blank" class="btn btn-info m-1"
                                                href="{{ route('rpt_mt_bill_view', $row->maintenance_bill_master_id) }}">Bill
                                                Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="1">{{ $total_bill }}</td>
                                    <td colspan="1">{{ $total_receive }}</td>
                                    <td colspan="1">{{ $total_due }}</td>
                                    <td colspan="1"></td>
                                </tr>
                            </tfoot>
                        </table>





                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            //
            $("#rpt2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');

            //
            $("#rpt3").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');
            //


            var cbo_customer_id = $('select[name="cbo_customer_id"]').val();
            if (cbo_customer_id) {
                getClientProject();
            }
            $('select[name="cbo_customer_id"]').on('change', function() {
                getClientProject();

            });
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
                            $('select[name="cbo_projet_id"]').append(
                                '<option value="' + value.project_id + '">' +
                                value.project_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_projet_id"]').empty();
            }
        }
    </script>


@endsection
