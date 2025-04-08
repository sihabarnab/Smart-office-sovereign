@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Purchase Requisition List</h1>
                    {{ $form }} To {{ $to }}.
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
                        <form action="{{ route('rpt_purchase_requisition_info') }}" method="GET">
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
                                    <th>Requisition No & Date</th>
                                    <th>Prepare By</th>
                                    <th>Approved By</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pu_requ_master as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->purchase_requisition_id }} <br> {{ $row->purchase_requisition_date }}</td>
                                        <td>{{ $row->employee_name }}</td>
                                        <td>{{ $row->approved_by == null ?'Pending': $row->approved_by }}</td>
                                        <td>{{ $row->remark }}</td>
                                        <td><a  href="{{route('rpt_purchase_requisition_details',$row->purchase_requisition_id)}}">Details</a></td>
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
