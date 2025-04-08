@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Challan</h1>
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
                        <form action="{{ route('mt_delivery_challan_store') }}" method="post">
                            @csrf

                            <div class="row mb-1">
                                <div class="col-2">
                                    <input type="hidden" class="form-control" name="cbo_requisition_master_id"
                                        id="cbo_requisition_master_id"
                                        value="{{ $m_requisition_master->requisition_master_id }}"
                                        placeholder="Requiction No" readonly>
                                    <input type="text" class="form-control" name="cbo_req_no" id="cbo_req_no"
                                        value="{{ $m_requisition_master->req_no }}" placeholder="Requiction No" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" name="cbo_approved_date"
                                        id="cbo_approved_date" value="{{ $m_requisition_master->approved_date }}"
                                        placeholder="Approved Date" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="cbo_mgm_name" id="cbo_mgm_name"
                                        value="{{ $m_requisition_master->mgm_name }}" placeholder="Approved By" readonly>
                                </div>
                                <div class="col-5">
                                    <input type="hidden" class="form-control" name="cbo_project_id" id="cbo_project_id"
                                        value="{{ $m_requisition_master->project_id }}" placeholder="Project Name" readonly>
                                    <input type="text" class="form-control"
                                        value="{{ $m_requisition_master->project_name }}" placeholder="Project Name"
                                        readonly>
                                </div>
                            </div>


                            <div class="row mb-1 btn-primary">
                                <div class="col-4">Delivery Date</div>
                                <div class="col-8">Delivery Address</div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_dcm_date" name="txt_dcm_date"
                                        placeholder="DC Date" value="{{ old('txt_dcm_date') }}" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_dcm_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <input type="text" id="cbo_address" name="cbo_address" class="form-control"
                                        value="{{ $m_requisition_master->project_address }}" placeholder="Address">
                                    @error('cbo_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1 btn-primary">
                                <div class="col-2">Warehouse</div>
                                <div class="col-4">Product</div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">Stock</div>
                                        <div class="col-4">Re.QTY</div>
                                        <div class="col-4">Unit</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-2">
                                    <select class="form-control" id="cbo_store_id" name="cbo_store_id">
                                        <option value="">-Select Warehouse-</option>
                                        @foreach ($m_wearhouse as $row)
                                            <option value="{{ $row->store_id }}"
                                                {{ old('cbo_store_id') == $row->store_id ? 'selected' : '' }}>
                                                {{ $row->store_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_store_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value="">-Product-</option>
                                        @foreach ($m_product as $value)
                                            <option value="{{ $value->product_id }}"
                                                {{ old('cbo_product') == $value->product_id ? 'selected' : '' }}>
                                                {{ $value->product_name }}
                                                @isset($value->product_des)
                                                    | {{ $value->product_des }}
                                                @endisset
                                                @isset($value->size_name)
                                                    | {{ $value->size_name }}
                                                @endisset
                                                @isset($value->origin_name)
                                                    | {{ $value->origin_name }}
                                                @endisset
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="txt_balance"
                                                name="txt_balance" value="" placeholder="Stock" readonly>
                                            @error('txt_balance')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="txt_quantity"
                                                name="txt_quantity" value="" placeholder="QTY">
                                            @error('txt_quantity')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="txt_unit" name="txt_unit"
                                                value="" placeholder="Unit" readonly>
                                            @error('txt_unit')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                        value="{{ old('txt_remark') }}" placeholder="Remark">
                                </div>
                            </div>


                            <div class="row ">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Challan Not Final</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Ch. No & Date</th>
                                    <th>Req. No & Approved Date</th>
                                    <th>Name & Address</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($d_challan_master as $key => $row)
                                    @php
                                        $m_project = DB::table('pro_projects')
                                            ->where('project_id', $row->project_id)
                                            ->first();
                                        $m_project_name = $m_project->project_name;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->chalan_no }} <br> {{ $row->dc_date }}</td>
                                        <td>{{ $row->req_no }} <br> {{ $row->req_date }}</td>
                                        <td>{{ $m_project_name }} <br> {{ $row->address }}</td>
                                        <td> {{ $row->remark }}</td>
                                        <td><a href="{{ route('mt_delivery_challan_details', $row->chalan_no) }}">Next</a>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_project_id"]').on('change', function() {
                var cbo_project_id = $(this).val();
                if (cbo_project_id) {
                    $.ajax({
                        url: "{{ url('/get/dc/project_address/') }}/" + cbo_project_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#cbo_address').val();
                            $('#cbo_address').val(data.address);
                        },
                    });

                } else {
                    $('#cbo_address').val('');
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                product_info();
            });
            $('select[name="cbo_store_id"]').on('change', function() {
                product_info();
            });
        });
    </script>

    <script>
        function product_info() {
            var cbo_product = $('#cbo_product').val();
            var cbo_store_id = $('#cbo_store_id').val();
            var txt_requisition_master_id = "{{ $m_requisition_master->requisition_master_id }}";
            if (cbo_product && cbo_store_id) {
                $.ajax({
                    url: "{{ url('/get/dc/product_details/') }}/" + cbo_product + '/' + txt_requisition_master_id +
                        '/' + cbo_store_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#txt_balance').val(data.balance);
                        $('#txt_quantity').val(data.qty);
                        $('#txt_unit').val(data.unit_name);
                    },
                });

            } else {
                $('#txt_balance').val('');
                $('#txt_quantity').val('');
                $('#txt_unit').val('');
            }
        }
    </script>
@endsection
