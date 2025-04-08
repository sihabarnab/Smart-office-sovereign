@extends('layouts.crm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION</h1>
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
                        <form action="{{ route('quotation_store') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                {{-- <div class="col-3">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="0">-Select Customer-</option>
                                        @foreach ($m_customers as $value)
                                            <option value="{{ $value->customer_id  }}">{{ $value->customer_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror 
                                </div> --}}

                                <div class="col-3">
                                    <input type="text" class="form-control" name="txt_customer" id="txt_customer" placeholder="Customer Name">
                                    @error('txt_customer')
                                    <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_date"
                                    name="txt_date" value="{{ old('txt_date') }}"
                                    placeholder="Date" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_date')
                                    <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div> 
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_address" name="txt_address"
                                        value="{{ old('txt_address') }}" placeholder="Address">
                                    @error('txt_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>                                                      

                            </div>
                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number"
                                        value="{{ old('txt_mobile_number') }}" placeholder="Mobile number">
                                    @error('txt_mobile_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="email" class="form-control" id="txt_email" name="txt_email"
                                        value="{{ old('txt_email') }}" placeholder="Email">
                                    @error('txt_email')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_attention" name="txt_attention"
                                        value="{{ old('txt_attention') }}" placeholder="Contact person">
                                    @error('txt_attention')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_valid_until" name="txt_valid_until"
                                        value="{{ old('txt_valid_until') }}" placeholder="Valid until">
                                    @error('txt_valid_until')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                        value="{{ old('txt_subject') }}" placeholder="Subject">
                                    @error('txt_subject')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reference_name" name="txt_reference_name"
                                        value="{{ old('txt_reference_name') }}" placeholder="Reference name">
                                    @error('txt_reference_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reference_number" name="txt_reference_number"
                                        value="{{ old('txt_reference_number') }}" placeholder="Reference number">
                                    @error('txt_reference_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
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
                    <h1 class="m-0">Quatation(Not Final)</h1>
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
                                    <th>Date<br>Qutation Number</th>
                                    <th>Customer</th>
                                    <th>Customer Address</th>
                                    <th>Valid</th>
                                    <th>Subject</th>
                                    <th>Ref. Info</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_quotation_master as $key=>$row) 
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->quotation_date }}<br> {{ $row->quotation_master_id }}</td>
                                    <td>
                                        @php
                                        $company = DB::table('pro_company')
                                            ->where('company_id', $row->company_id)
                                            ->first();
                                    @endphp
                                        {{ $company->company_name }}
                                    </td>
                                    <td>{{ $row->customer_address }}</td>
                                    <td>{{ $row->offer_valid }}</td>
                                    <td>{{ $row->subject }}</td>
                                    <td>{{ $row->reference }}<br> {{ $row->reference_mobile }}</td>
                                    <td> <a href="{{ route('quotation_details',$row->quotation_id) }}">Edit</a></td>
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
