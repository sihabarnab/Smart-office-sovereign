@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Requisition</h1>
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
                        <form action="{{ route('purchase_requisition_store') }}" method="post">
                            @csrf


                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_purchase_requistion_date"
                                        name="txt_purchase_requistion_date" placeholder="Purchase Requisition Date"
                                        value="{{ old('txt_purchase_requistion_date') }}" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_purchase_requistion_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value=''>-Product-</option>
                                        @foreach ($m_product as $value)
                                            <option value="{{ $value->product_id }}">
                                                {{ $value->product_name }}
                                                @isset($value->product_des)
                                                    |{{ $value->product_des }}
                                                @endisset
                                                @isset($value->size_name)
                                                    |{{ $value->size_name }}
                                                @endisset
                                                @isset($value->origin_name)
                                                    |{{ $value->origin_name }}
                                                @endisset
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" name="txt_product_price"
                                        id="txt_product_price" value="{{ old('txt_product_price') }}" placeholder="Price">
                                    @error('txt_product_price')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" name="txt_product_qty" id="txt_product_qty"
                                        value="{{ old('txt_product_qty') }}" placeholder="QTY">
                                    @error('txt_product_qty')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="txt_product_unit" id="txt_product_unit"
                                        value="{{ old('txt_product_unit') }}" placeholder="Unit" readonly>
                                    @error('txt_product_unit')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="txt_remark" id="txt_remark"
                                        value="{{ old('txt_remark') }}" placeholder="Remark">
                                    @error('txt_remark')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Next</button>
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
                <h1 class="m-0">Purchase Requisition Not Final</h1>
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Requisition No & Date</th>
                                    <th>Prepare By</th>
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
                                        <td>{{ $row->remark }}</td>
                                        <td><a  href="{{route('purchase_requisition_details',$row->purchase_requisition_id)}}">Details</a></td>
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
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/Add_product_stock/unit/') }}/" + cbo_product,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="txt_product_unit"]').empty();
                            $('#txt_product_unit').val(data.unit_name);

                        },
                    });

                } else {
                    $('select[name="txt_product_unit"]').empty();
                }

            });
        });
    </script>
@endsection
@endsection
