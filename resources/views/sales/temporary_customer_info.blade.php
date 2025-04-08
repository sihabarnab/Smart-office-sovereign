@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Client Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>


    @if (isset($m_customer))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form name="" method="post" action="{{ route('temporary_customer_info_update') }}">
                                @csrf


                                <div class="row mb-2">
                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">

                                        <input type="hidden" class="form-control" id="txt_customer_id"
                                            name="txt_customer_id" value="{{ $m_customer->customer_id }}" readonly>

                                        <input type="text" class="form-control" id="txt_customer_phone"
                                            name="txt_customer_phone" placeholder="Client Phone"
                                            value="{{ $m_customer->customer_phone }}">
                                        @error('txt_customer_phone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" placeholder="Client Name"
                                            value="{{ $m_customer->customer_name }}">
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_desig"
                                            name="txt_customer_desig" placeholder="Desig Ex.Director, Operations"
                                            value="{{ $m_customer->customer_desig }}">
                                        @error('txt_customer_desig')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_road"
                                            name="txt_customer_road" placeholder="Road No"
                                            value="{{ $m_customer->customer_road }}">
                                        @error('txt_customer_road')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_house_no"
                                            name="txt_customer_house_no" placeholder="House/Building No"
                                            value="{{ $m_customer->customer_house_no }}">
                                        @error('txt_customer_house_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_post_code" name="txt_post_code"
                                            placeholder="Post Code" value="{{ $m_customer->customer_post_code }}">
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_city" name="txt_city"
                                            placeholder="City" value="{{ $m_customer->customer_city }}">
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_country" name="txt_country"
                                            placeholder="Country" value="{{ $m_customer->customer_country }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_contact_person"
                                            name="txt_contact_person" placeholder="Contact Person"
                                            value="{{ $m_customer->contact_person }}">
                                        @error('txt_contact_person')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-8 col-sm-12 col-md-12 mb-2">
                                        <input type="mail" class="form-control" id="txt_customer_mail"
                                            name="txt_customer_mail" placeholder="Customer Mail"
                                            value="{{ $m_customer->customer_email }}">
                                        @error('txt_customer_mail')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-sm-12 col-md-12">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Update</button>
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('temporary_customer_store') }}" method="POST">
                                @csrf

                                <div class="row mb-2">

                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_phone"
                                            name="txt_customer_phone" placeholder="Client Phone"
                                            value="{{ old('txt_customer_phone') }}">
                                        @error('txt_customer_phone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" placeholder="Client Name"
                                            value="{{ old('txt_customer_name') }}">
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_desig"
                                            name="txt_customer_desig" placeholder="Desig Ex.Director, Operations"
                                            value="{{ old('txt_customer_desig') }}">
                                        @error('txt_customer_desig')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_road"
                                            name="txt_customer_road" placeholder="Road No Ex..Road # 06"
                                            value="{{ old('txt_customer_road') }}">
                                        @error('txt_customer_road')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-3 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_customer_house_no"
                                            name="txt_customer_house_no" placeholder="House No Ex..House # 522"
                                            value="{{ old('txt_customer_house_no') }}">
                                        @error('txt_customer_house_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_post_code"
                                            name="txt_post_code" placeholder="Post Code"
                                            value="{{ old('txt_post_code') }}">
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_city" name="txt_city"
                                            placeholder="City" value="{{ old('txt_city') }}">
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-md-6 mb-2">
                                        <input type="text" class="form-control" id="txt_country" name="txt_country"
                                            placeholder="Country" value="{{ old('txt_country') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                        <input type="text" class="form-control" id="txt_contact_person"
                                            name="txt_contact_person" placeholder="Contact Person"
                                            value="{{ old('txt_contact_person') }}">
                                        @error('txt_contact_person')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-8 col-sm-12 col-md-12 mb-2">
                                        <input type="mail" class="form-control" id="txt_customer_mail"
                                            name="txt_customer_mail" placeholder="Client Mail"
                                            value="{{ old('txt_customer_mail') }}">
                                        @error('txt_customer_mail')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-lg-10 col-sm-12 col-md-12">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Submit</button>
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
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <table id="data1" class="table table-border table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Client Phone</th>
                                        <th>Client Name</th>
                                        <th>Mail</th>
                                        <th>Contact Person</th>
                                        <th>Entry By</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->customer_phone }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->customer_email }}</td>
                                            <td>{{ $row->contact_person }}</td>
                                            <td>{{ $row->employee_name }}</td>
                                            <td>
                                                <a href="{{ route('temporary_customer_info_edit', $row->customer_id) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
        &nbsp;
    @endif
@endsection
