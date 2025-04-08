@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUOTATION LIST</h1>
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
                                    <th>Qu. No / Date</th>
                                    <th>Contact</th>
                                    <th>Valid</th>
                                    <th>Subject</th>
                                    <th>Prepare By</th>
                                    <th>Approved(MGM)</th>
                                    <th>Requisition</th>
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
                url: "{{ url('/get/mt/rpt_quotation_list/') }}/",
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
                                        .quotation_date+ '<br>' + data
                                        .entry_time;
                                }
                            },
                            { 
                                data: null,
                                render: function(data, type, full) {
                                    
                                    var name = data.customer_name;
                                    var address = data
                                        .customer_address==null ? "" : data
                                        .customer_address;

                                    var mobile = data
                                        .customer_mobile==null?'': data
                                        .customer_mobile;

                                    return name + '<br>' + address + '<br>' + mobile;
                                }                            
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
                                    return data.approved == null ? '': data.approved;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    if(data.status == 5){
                                        return data.mgm_name == null ? '': data.mgm_name+"<br> (Reject)";
                                    }else{
                                        return data.mgm_name == null ? '': data.mgm_name;
                                    }
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    if(data.requisition_master_id){
                                        return '<a class="m-1" href="{{ url('/') }}/inventory/rpt_requisition_details/' +
                                            data.requisition_master_id + '">'+data.req_no+'</a>';
                                    }else{
                                        return '';
                                    }
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    if(data.status == 3){
                                        return '<a class="m-1" href="{{ url('/') }}/maintenance/rpt_mt_quotation_view/' +
                                            data.quotation_id + '">view/Print</a>';
                                    }
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
