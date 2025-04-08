@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Issue</h1>
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
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('material_issue_details_store', $req_master->smi_master_id) }}" method="post">
                            @csrf

                            <div class="row ">
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    @php
                                        $customer = DB::table('pro_customers')
                                            ->where('customer_id', $ms_task_assign->customer_id)
                                            ->first();
                                    @endphp
                                    <input type="text" name="txt_customer_id" id="txt_customer_id"
                                        value="{{ $customer->customer_name }}" class="form-control" readonly>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    @php
                                        $project = DB::table('pro_projects')
                                            ->where('project_id', $ms_task_assign->project_id)
                                            ->first();
                                    @endphp
                                    <input type="text" name="txt_project_id" id="txt_project_id"
                                        value="{{ $project->project_name }}" class="form-control" readonly>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    @php
                                        $lift = DB::table('pro_lifts')
                                            ->where('lift_id', $ms_task_assign->lift_id)
                                            ->first();
                                    @endphp
                                    <input type="text" name="txt_lift_id" id="txt_lift_id"
                                        value="{{ $lift->lift_name }} | {{ $lift->remark }}" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option selected>-Product-</option>
                                        @foreach ($m_product as $value)
                                            <option value="{{ $value->product_id }}">{{ $value->product_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 mb-2">
                                    <input type="text" class="form-control" name="txt_product_qty" id="txt_product_qty"
                                        value="{{ old('txt_product_qty') }}" placeholder="product qty">
                                    @error('txt_product_qty')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-6 mb-2">
                                    <input type="text" class="form-control" name="txt_product_unit" id="txt_product_unit"
                                        value="{{ old('txt_product_unit') }}" placeholder="Unit">
                                    @error('txt_product_unit')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-sm-2 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-sm-5 mb-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">add</button>
                                </div>
                                <div class="col-lg-2 col-sm-5 mb-2">
                                    @php
                                        $check = DB::table('pro_service_material_issue_details')
                                            ->where('smi_master_id', $req_master->smi_master_id)
                                            ->first();
                                    @endphp
                                    @if (isset($check))
                                        <a class="btn btn-primary btn-block"
                                            href="{{ route('material_issue_final', $req_master->smi_master_id) }}">
                                            Finish</a>
                                    @else
                                        <a class="btn btn-primary btn-block" href="#"> Finish</a>
                                    @endif
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
                                    <th>Product Name</th>
                                    <th>Product QTY</th>
                                    <th>Unit</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($req_details as $key => $row)
                                    @php
                                        $ci_product = DB::table('pro_product')
                                            ->Where('product_id', $row->product_id)
                                            ->first();
                                        $txt_product_name = $ci_product->product_name;

                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', $ci_product->unit_id)
                                            ->first();
                                        $unit_name = $unit->unit_name;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $txt_product_name }}</td>
                                        <td>{{ $row->product_qty }}</td>
                                        <td>{{ $unit_name }}</td>
                                        <td>
                                            {{-- <a href="{{ route('requisition_product_edit', $row->requisition_details_id) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-edit"></i></a> --}}
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                console.log('ok')
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/requisition/product_unit/') }}/" + cbo_product,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="txt_product_unit"]').empty();
                            $('#txt_product_unit').val(data.unit_name);

                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
@endsection
@endsection
