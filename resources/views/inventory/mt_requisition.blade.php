@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition</h1>
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
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form action="{{ route('mt_requisition_store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                        <option value="0">--Select Project--</option>
                                        @foreach ($m_projects as $row)
                                            <option value="{{ $row->project_id }}">
                                                {{ $row->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value="">-Product-</option>
                                        @foreach ($m_product as $row)
                                        <option value="{{ $row->product_id }}"
                                            {{ old('cbo_product') == $row->product_id ? 'selected' : '' }}>
                                            {{ $row->product_name }}
                                            @isset( $row->product_des)
                                            | {{ $row->product_des }}
                                            @endisset
                                            @isset( $row->size_name)
                                            | {{ $row->size_name }}
                                            @endisset
                                            @isset( $row->origin_name)
                                            | {{ $row->origin_name }}
                                            @endisset
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_product_price"
                                        id="txt_product_price" value="{{ old('txt_product_price') }}" placeholder="Price">
                                    @error('txt_product_price')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_product_qty" id="txt_product_qty"
                                        value="{{ old('txt_product_qty') }}" placeholder="qty">
                                    @error('txt_product_qty')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_product_unit" id="txt_product_unit"
                                        value="{{ old('txt_product_unit') }}" placeholder="Unit" readonly>
                                    @error('txt_product_unit')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <input type="checkbox" name="free_warrenty"> Free Warranty Period
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-6 col-sm-12 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('maintenance.requisition_not_complite_list')

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_supplier_id"]').on('change', function() {
                var cbo_supplier_id = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/inventory/supplier_details/') }}/" + cbo_supplier_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_supplier').empty();
                            $('#txt_supplier').val(data.supplier_add);

                        },
                    });

                } else {
                    $('#txt_supplier').val('');
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/inventory/requisition/product_unit/') }}/" +
                            cbo_product,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="txt_product_unit"]').empty();
                            $('#txt_product_unit').val(data.unit_name);

                        },
                    });

                } else {
                    $('#txt_product_unit').val('');
                }

            });
        });
    </script>
@endsection
@endsection
