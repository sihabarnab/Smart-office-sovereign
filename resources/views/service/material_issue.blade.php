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
                        <form action="{{ route('material_issue_store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_complain_id" id="cbo_complain_id" class="form-control">
                                        <option value="0">--Select Task--</option>
                                        @foreach ($m_complaint_register as $row_complaint_register)
                                            @php
                                                $ci_customer = DB::table('pro_customers')
                                                    ->Where('customer_id', $row_complaint_register->customer_id)
                                                    ->first();
                                                $se_projects = DB::table('pro_projects')
                                                    ->Where('project_id', $row_complaint_register->project_id)
                                                    ->first();
                                                $se_lift = DB::table('pro_lifts')
                                                    ->Where('lift_id', $row_complaint_register->lift_id)
                                                    ->first();

                                            @endphp
                                            <option value="{{ $row_complaint_register->task_id }}">
                                                {{ $row_complaint_register->task_id }}|
                                                {{ $se_lift->lift_name }} | {{ $se_projects->project_name }} |
                                                {{ $ci_customer->customer_name }}|
                                                {{ $row_complaint_register->remark }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_complain_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-lg-3 col-md-3 col-sm-12">
                                    <select class="form-control" id="cbo_product_group" name="cbo_product_group">
                                        <option value="0">-Product Group-</option>
                                        @foreach ($m_product as $value)
                                            <option value="{{ $value->pg_id }}">{{ $value->pg_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product_group')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                {{-- <div class="col-3">
                                    <select class="form-control" id="cbo_product_sub_group" name="cbo_product_sub_group">
                                        <option selected>-Product Sub Group-</option>
                                    </select>
                                    @error('cbo_product_sub_group')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div> --}}
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
                                        value="{{ old('txt_product_qty') }}" placeholder="qty">
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

                            <div class="row mb-2">
                                <div class="col-lg-10 col-md-8 col-sm-3">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-9">
                                    <button type="Submit" id="save_event"
                                        class="btn btn-primary btn-block float-right">Next</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('service.material_not_complite_list')

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
