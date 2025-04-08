@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bill Information</h1>
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
                        @php
                            $m_complaint_register = DB::table('pro_complaint_register')
                                ->where('customer_id', $m_customer->customer_id)
                                ->where('project_id', $m_projects->project_id)
                                ->where('lift_id', $m_lifts->lift_id)
                                ->where('valid', 1)
                                ->first();
                        @endphp
                        <form action="{{ route('bill_store',$m_complaint_register->complaint_register_id) }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $m_customer->customer_name }}"
                                        readonly>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $m_projects->project_name }}"
                                        readonly>
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $m_lifts->lift_name }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_service_charge"
                                        name="txt_service_charge" placeholder="Service charge">
                                    @error('txt_service_charge')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_vat" name="txt_vat"
                                        placeholder="VAT">
                                    @error('txt_vat')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_other" name="txt_other"
                                        placeholder="Other">
                                    @error('txt_other')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
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
@endsection

@section('script')
@endsection
