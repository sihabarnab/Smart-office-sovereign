@extends('layouts.crm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION LIST</h1>
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
                        <table id="quotation_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Qutation Number <br> Date</th>
                                    <th>Customer</th>
                                    <th>Customer Address</th>
                                    <th>Valid</th>
                                    <th>Subject</th>
                                    <th>Ref. Info</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              
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
        window.onload = function() {
            var k = 1;
            $.ajax({
                url: "{{ url('/get/crm/quotation_list/') }}/",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#quotation_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Quotation'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Quotation'
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
                            },
                            {
                                extend: 'print',
                                title: 'Quotation',
                                autoPrint: true,
                                exportOptions: {
                                    columns: ':visible'
                                },
                            },
                            'colvis',
                        ],
                        "data": data,
                        "columns": [{
                                data: null,
                                render: function(data, type, full) {
                                    return k++;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.quotation_master_id + '<br>' + data
                                        .quotation_date;
                                }
                            },
                            {
                                "data": "customer_name"                              
                            },
                            {
                                "data": "customer_address"
                            },
                            {
                                "data": "offer_valid"
                            },
                            {
                                "data": "subject"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.reference + '<br>' + data.reference_mobile;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a href="{{ url('/') }}/crm/rpt_quotation_print/' +
                                        data.quotation_id + '">Print</a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        }; // end document
    </script>
@endsection

@section('CSS')
    <style>
        #quotation_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
