@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill Update </h1>
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
                        <table id="maintenance_bill_data" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Invoice No/ Date</th>
                                    <th>Qu No / Date</th>
                                    <th>Contact</th>
                                    <th>Prefer By</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($m_bill_master as $key=>$row) 
                                  <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->maintenance_bill_master_no  }} <br> {{$row->entry_date}}</td>
                                    <td>{{ $row->quotation_master_id  }} <br> {{$row->quotation_date}}</td>
                                    <td>{{ $row->customer_name }} <br> {{$row->customer_add}} <br> {{$row->customer_phone}}</td>
                                    <td>{{ $row->prefer }}</td>
                                    <td>{{number_format(($row->grand_total+$row->repair_price+$row->previous_due),2)}}</td>
                                    <td><a href="{{route('mt_bill_update_details',$row->maintenance_bill_master_id)}}">Details</a></td>
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

@section('script')
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