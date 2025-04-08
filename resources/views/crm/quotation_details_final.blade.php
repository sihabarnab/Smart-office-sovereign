@extends('layouts.crm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION DETAILS</h1>
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
                        <div class="row mb-1">
                            <div class="col-2"></div>
                            <div class="col-4">
                                <input type="text" class="form-control" readonly
                                    value="{{ $m_quotation_master->quotation_master_id }}" id="txt_quatation_number"
                                    name="txt_quatation_number">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" readonly
                                    value="{{ $m_quotation_master->quotation_date }}" id="txt_quatation_date"
                                    name="txt_quatation_date">
                            </div>
                            <div class="col-2"></div>

                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                    value="{{ $m_quotation_master->customer_name }}" readonly>
                                @error('txt_customer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number"
                                    value="{{ $m_quotation_master->customer_mobile }}" readonly>
                                @error('txt_mobile_number')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="txt_address" name="txt_address"
                                    value="{{ $m_quotation_master->customer_address }}" readonly>
                                @error('txt_address')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row mb-1">
                            <div class="col-6">
                                <input type="text" class="form-control" id="txt_subject" name="txt_subject" readonly
                                    value="{{ $m_quotation_master->subject }}">
                                @error('txt_subject')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_reference_name" name="txt_reference_name"
                                    readonly value="{{ $m_quotation_master->reference }}">
                                @error('txt_reference_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_reference_number"
                                    name="txt_reference_number" value="{{ $m_quotation_master->reference_mobile }}">
                                @error('txt_reference_number')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $sub_total = 0;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('sales_quotation_details_final', $m_quotation_master->quotation_id) }}"
                            method="post">
                            @csrf
                            <table id="" class="table table-bordered table-striped table-sm mb-1">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Product Group</th>
                                        <th>Product Sub Group</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Extended Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_quotation_details as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->pg_name }}</td>
                                            <td>{{ $row->pg_sub_name }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->rate }}</td>
                                            <td>{{ $row->total }}</td>
                                            @php
                                                $sub_total += $row->total;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class=" text-right">Sub Total :</td>
                                        <td>
                                            <input type="hidden" name="txt_subtotal" id="txt_subtotal"
                                                value="{{ $sub_total }}">
                                            {{ $sub_total }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-1">
                                    <p class="mt-1">VAT</p>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_vat" name="txt_vat"
                                        value="{{ old('txt_vat') }}" placeholder="VAT">
                                    @error('txt_vat')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-1">
                                    <p class="mt-1">AIT</p>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_ait"
                                        name="txt_ait" value="{{ old('txt_ait') }}"
                                        placeholder="Advance Income Tax">
                                    @error('txt_ait')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-10">

                                </div>
                                <div class="col-2">
                                    <button type="Submit" id=""
                                        class="btn btn-primary btn-block">Final</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
