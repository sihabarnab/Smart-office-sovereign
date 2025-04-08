@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill Summery</h1>
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
                        <table id="service_bill_data" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Project Name</th>
                                    <th class="text-right">Bill Issue <br> To: {{ $to }}</th>
                                    <th class="text-right">Bill Received <br>To: {{ $to }}</th>
                                    <th class="text-right">Bill Due <br> To: {{ $to }}</th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $due = 0;
                                    $gg_total_bill = 0;
                                    $gg_total_received = 0;
                                    $gg_total_due = 0;
                                @endphp
                                @foreach ($m_project as $key => $row)
                                    @php
                                        $service_bill_grand_total = DB::table('pro_service_bill_master')
                                            ->where('project_id', $row->project_id)
                                            ->sum('grand_total');

                                        $service_recive_total = DB::table('pro_service_money_receipt')
                                            ->where('project_id', $row->project_id)
                                            ->where('approved_status', 1)
                                            ->sum('paid_amount');
                                        $due = $service_bill_grand_total - $service_recive_total;

                                        $gg_total_bill = $gg_total_bill + $service_bill_grand_total;
                                        $gg_total_received = $gg_total_received + $service_recive_total;
                                        $gg_total_due = $gg_total_due + $due;
                                    @endphp


                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->project_name }}</td>
                                        <td class="text-right">{{ number_format($service_bill_grand_total, 2) }}</td>
                                        <td class="text-right">{{ number_format($service_recive_total, 2) }}</td>
                                        <td class="text-right">
                                            {{ number_format($due, 2) }}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{route('rpt_bill_summery_details',$row->project_id)}}">More Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td colspan="1" class="text-right">{{ number_format($gg_total_bill, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($gg_total_received, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($gg_total_due, 2) }}</td>
                                    <td colspan="1" class="text-right"></td>
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
    <script>
        var data = "{{$m_project->count();}}";
        if(data){
            var page = data;
        }else{
            var page = 10000; 
        }

        $(function() {
            $("#service_bill_data").DataTable({
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
            }).buttons().container().appendTo('#service_bill_data_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
