@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUOTATION DETAILS</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($quotation_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('mt_quotation_details_update', $quotation_details_edit->quotation_details_id) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_master_id }}" id="txt_quatation_number"
                                            name="txt_quatation_number">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_date }}" id="txt_quatation_date"
                                            name="txt_quatation_date">
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-12 col-md-4">
                                        <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                            value="{{ $m_quotation_master->customer_name }}" readonly>
                                        @error('txt_customer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_mobile_number"
                                            name="txt_mobile_number" value="{{ $m_quotation_master->customer_mobile }}"
                                            readonly>
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $m_quotation_master->customer_address }}" readonly>
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                            readonly value="{{ $m_quotation_master->subject }}">
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_reference_name"
                                            name="txt_reference_name" readonly
                                            value="{{ $m_quotation_master->reference }}">
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_reference_number"
                                            name="txt_reference_number" readonly
                                            value="{{ $m_quotation_master->reference_mobile }}">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control"
                                            value="{{ $quotation_details_edit->product_name }}" readonly>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="txt_rate" name="txt_rate"
                                                    value="{{ $quotation_details_edit->rate }}" placeholder="Rate">
                                                @error('txt_rate')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="txt_quantity"
                                                    name="txt_quantity" value="{{ $quotation_details_edit->qty }}"
                                                    placeholder="Quantity">
                                                @error('txt_quantity')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-10 mb-1">
                                        &nbsp;
                                    </div>
                                    <div class="col-12 col-md-2 mb-1">
                                        <button type="Submit" id=""
                                            class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('mt_quotation_details_store', $m_quotation_master->quotation_id) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-12 col-md-4">
                                        @php
                                            if ($m_quotation_master->project_id) {
                                                $m_project = DB::table('pro_projects')
                                                    ->where('project_id', $m_quotation_master->project_id)
                                                    ->first();
                                                $project_name = $m_project->project_name;
                                            } else {
                                                $project_name = '';
                                            }
                                        @endphp
                                        <input type="text" class="form-control" value="{{ $project_name }}" readonly>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <input type="text" class="form-control"
                                            value="{{ $m_quotation_master->quotation_master_id }}" readonly>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <input type="text" class="form-control"
                                            value="{{ $m_quotation_master->quotation_date }}" readonly>
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-md-4">
                                        <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                            value="{{ $m_quotation_master->customer_name }}" readonly>
                                        @error('txt_customer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_mobile_number"
                                            name="txt_mobile_number" value="{{ $m_quotation_master->customer_mobile }}"
                                            readonly placeholder="Customer Phone">
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $m_quotation_master->customer_address }}" readonly
                                            placeholder="Customer Address">
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                            readonly value="{{ $m_quotation_master->subject }}">
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_reference_name"
                                            name="txt_reference_name" readonly placeholder="Reference"
                                            value="{{ $m_quotation_master->reference }}">
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" class="form-control" id="txt_reference_number"
                                            name="txt_reference_number" readonly placeholder="Reference mobile no"
                                            value="{{ $m_quotation_master->reference_mobile }}">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row btn-primary mb-1">
                                    <div class="col-6">
                                        Product
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                Unit
                                            </div>
                                            <div class="col-4">
                                                QTY
                                            </div>
                                            <div class="col-4">
                                                Rate
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row mb-1">
                                    <div class="col-6">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="">-Product-</option>
                                            @foreach ($m_product as $value)
                                                <option value="{{ $value->product_id }}">
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
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <div class="row">

                                            <div class="col-4">
                                                <input type="text" class="form-control" id="txt_unit" readonly
                                                    placeholder="Unit">
                                            </div>

                                            <div class="col-4">
                                                <input type="text" class="form-control" id="txt_quantity"
                                                    name="txt_quantity" value="{{ old('txt_quantity') }}"
                                                    placeholder="Quantity">
                                                @error('txt_quantity')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-4">
                                                <input type="text" class="form-control" id="txt_rate"
                                                    name="txt_rate" value="{{ old('txt_rate') }}" placeholder="Rate">
                                                @error('txt_rate')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-8 mb-1">
                                        &nbsp;
                                    </div>
                                    <div class="col-12 col-md-2 mb-1">
                                        <button type="Submit" id="" class="btn btn-primary btn-block">Add
                                            More</button>
                                    </div>
                                    <div class="col-12 col-md-2 mb-1">
                                        @php
                                            $quotation_details = DB::table('pro_maintenance_quotation_master')
                                                ->where('quotation_id', $m_quotation_master->quotation_id)
                                                ->first();
                                        @endphp
                                        @if (isset($quotation_details))
                                            <a href="{{ route('mt_quotation_final', $m_quotation_master->quotation_id) }}"
                                                class="btn btn-primary btn-block">Continue</a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-block">Continue</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('maintenance.quotation_details_list')
    @endif

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                $('#txt_rate').val('');
                $('#txt_quantity').val('');
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/mt_quotation/product_unit/') }}/" + cbo_product,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_unit').val(data);

                        },
                    });

                } else {
                    $('#txt_unit').val('');
                }

            });
        });
    </script>



    <script>
        function RemoveQutation(details_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#txt_details').val('');

            if (details_id) {
                $('#txt_details').val(details_id);
            } else {
                $('#txt_details').val('');
            }


        }
    </script>
@endsection
