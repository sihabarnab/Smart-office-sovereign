@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">CUSTOMER QUOTATION APPROVED (MGM)</h1>
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
                            <div class="col-4">
                                <input type="text" class="form-control" name="txt_customer" id="txt_customer"
                                    value="{{ $m_quotation_master->customer_name }}" readonly>
                                @error('txt_customer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row mb-1">

                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number"
                                    value="{{ $m_quotation_master->customer_mobile }}" readonly>
                                @error('txt_mobile_number')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-8">
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
                                    readonly value="{{ $m_quotation_master->reference }}" placeholder="Reference Name">
                                @error('txt_reference_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_reference_number"
                                    name="txt_reference_number" readonly
                                    value="{{ $m_quotation_master->reference_mobile }}" placeholder="Reference Number">
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
        $sub_total = 0.0;
        $repair_price = 0;
        $i = 1;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <table id="" class="table table-bordered table-striped table-sm mb-1">
                            <thead>
                                <tr>
                                    <th class="text-center">SL No</th>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_quotation_approved_details as $key => $row)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td class="text-center">{{ numberFormat($row->approved_qty, 2) }}</td>
                                        <td class="text-center">{{ numberFormat($row->approved_rate, 2) }}</td>
                                        <td class="text-right">{{ numberFormat($row->approved_total, 2) }}</td>
                                        @php
                                            $sub_total += $row->approved_total;
                                        @endphp
                                    </tr>
                                @endforeach

                                @if ($m_quotation_master->repair_price)
                                    @php
                                        $repair_price = $m_quotation_master->repair_price;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $m_quotation_master->repair_descrption }}</td>
                                        <td class="text-center">{{ number_format($m_quotation_master->repair_qty, 2) }}</td>
                                        <td class="text-center">{{ number_format($m_quotation_master->repair_price, 2) }}
                                        </td>
                                        <td class="text-right">{{ number_format($m_quotation_master->repair_price, 2) }}
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class=" text-right">Sub Total :</td>
                                    <td class="text-right">
                                        <input type="hidden" name="txt_subtotal" id="txt_subtotal"
                                            value="{{ $sub_total }}">
                                        {{ numberFormat($sub_total + $repair_price, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">Discount</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control  text-right" id="txt_dpp"
                                            name="txt_dpp" value="{{ $m_quotation_master->discount_percent }} %"
                                            placeholder="%" readonly>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control  text-right" id="txt_discount"
                                            name="txt_discount"
                                            value=" {{ numberFormat($m_quotation_master->approved_discount, 2) }}"
                                            placeholder="Discount" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">VAT</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control text-right" id="txt_vpp"
                                            name="txt_vpp" value="{{ $m_quotation_master->vat_percent }} %"
                                            placeholder="%" readonly>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control text-right" id="txt_vat"
                                            name="txt_vat"
                                            value="{{ numberFormat($m_quotation_master->approved_vat, 2) }}"
                                            placeholder="VAT" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">AIT</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control text-right" id="txt_tt"
                                            name="txt_tt" value="{{ $m_quotation_master->ait_percent }} %"
                                            placeholder="%" readonly>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control  text-right" id="txt_ait"
                                            name="txt_ait"
                                            value="{{ numberFormat($m_quotation_master->approved_ait, 2) }}"
                                            placeholder="AIT" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-1">
                                <p class="mt-1">Others</p>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control text-right" id="txt_ot"
                                            name="txt_ot" value="{{ $m_quotation_master->other_percent }} %"
                                            placeholder="%" readonly>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control text-right" id="txt_other"
                                            name="txt_other"
                                            value="{{ numberFormat($m_quotation_master->approved_other, 2) }}"
                                            placeholder="Other" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8 text-right">
                                Grand Total
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control text-right" id="txt_gt" name="txt_gt"
                                    value="{{ numberFormat($m_quotation_master->approved_quotation_total + $repair_price, 2) }}"
                                    readonly>
                            </div>
                        </div>

                        <form action="{{ route('mt_customer_quotation_reject', $m_quotation_master->quotation_id) }}"
                            method="post">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <textarea class="form-control" name="txt_comment" placeholder="Reject Comment" id="txt_comment" cols="30"
                                        rows="2">{{ old('txt_comment') }}</textarea>
                                    @error('txt_comment')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mt-2">
                                    <button type="Submit" id=""
                                        class="btn btn-danger btn-block">Reject</button>
                                </div>
                        </form>
                        <div class="col-lg-2 col-md-12 col-sm-12 mt-2">
                            <a href="{{ route('mt_customer_quotation_accept', $m_quotation_master->quotation_id) }}"
                                class="btn btn-success btn-block">Accept</a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @php

        //Number Formate
        function numberFormat($number, $decimals = 0)
        {
            // desimal (.) dat part
            if (strpos($number, '.') != null) {
                $decimalNumbers = substr($number, strpos($number, '.'));
                $decimalNumbers = substr($decimalNumbers, 1, $decimals);
            } else {
                $decimalNumbers = 0;
                for ($i = 2; $i <= $decimals; $i++) {
                    $decimalNumbers = $decimalNumbers . '0';
                }
            }
            // echo $decimalNumbers;
            $number = (int) $number;
            // reverse
            $number = strrev($number);
            $n = '';
            $stringlength = strlen($number);
            for ($i = 0; $i < $stringlength; $i++) {
                if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                    $n = $n . $number[$i] . ',';
                } else {
                    $n = $n . $number[$i];
                }
            }
            $number = $n;
            // reverse
            $number = strrev($number);
            $decimals != 0 ? ($number = $number . '.' . $decimalNumbers) : $number;
            return $number;
        }
    @endphp
@endsection
