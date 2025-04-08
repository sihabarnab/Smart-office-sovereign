@extends('layouts.sales_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer List</h1>
                </div><!-- /.col -->



            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h3 class="card-title"></h3> --}}
                    </div>
                    <div class="card-body">
                        <table id="data1" class="table table-border table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Customer Phone</th>
                                    <th>Customer Name</th>
                                    <th>Mail</th>
                                    <th>Contact Person</th>
                                    <th>Entry By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_customer as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->customer_phone }}</td>
                                        <td>{{ $row->customer_name }}</td>
                                        <td>{{ $row->customer_email }}</td>
                                        <td>{{ $row->contact_person }}</td>
                                        <td>{{ $row->employee_name }}</td>

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
