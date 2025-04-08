@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Requisition Approved(MGM)</h1>
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
                                    <th>Requisition No</th>
                                    <th>Requisition Date</th>
                                    <th>Prepare By</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pu_requ_master as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->purchase_requisition_id  }}</td>
                                        <td>{{ $row->purchase_requisition_date }}</td>
                                        <td>{{ $row->employee_name }}</td>
                                        <td>{{ $row->remark }}</td>
                                        <td><a target="_blank" href="{{route('purchase_requisition_approved_details',$row->purchase_requisition_id)}}">Details</a></td>
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
