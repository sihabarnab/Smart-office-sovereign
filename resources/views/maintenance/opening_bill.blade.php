@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Opening Bill</h1>
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
                        <form action="{{ route('opening_bill_store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_projet_id" id="cbo_projet_id" class="form-control">
                                        <option value="">--Select Project--</option>
                                        @foreach ($m_project as $row)
                                            <option value="{{ $row->project_id }}"
                                                {{ $row->project_id == old('cbo_projet_id') ? 'selected' : '' }}>
                                                {{ $row->project_id }}|{{ $row->project_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_projet_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <input type="number" class="form-control" name="txt_balance" id="txt_balance"
                                        placeholder="Balance" value="{{ old('txt_balance') }}">
                                    @error('txt_balance')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-lg-2 col-md-4 col-sm-9 mb-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Submit</button>
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
                        <table id="opening_bill_data" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">SL NO</th>
                                    <th class="text-center">Project</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                 $total = 0;
                                @endphp
                                @foreach ($opening_bill_list as $key => $row)
                                @php
                                $total += $row->amount;
                               @endphp
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-left">{{ $row->project_name }}</td>
                                        <td class="text-right">{{ number_format($row->amount,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td class="text-right" >{{number_format($total,2)}}</td>
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
        var data = "{{ $opening_bill_list->count() }}";
        if (data) {
            var page = data;
        } else {
            var page = 10000;
        }

        $(function() {
            $("#opening_bill_data").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": page,
                "buttons": [{
                        extend: 'copy',
                        title: 'Opening Bill'
                    },
                    {
                        extend: 'csv',
                        title: 'Opening Bill'
                    },
                    {
                        extend: 'excel',
                        title: 'Opening Bill'
                    },
                    {
                        extend: 'pdf',
                        title: 'Opening Bill'
                    },
                    {
                        extend: 'print',
                        title: 'Opening Bill'
                    },
                    'colvis'
                ]
            }).buttons().container().appendTo('#service_bill_data_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
