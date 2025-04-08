@extends('layouts.sales_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Customer Information</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_customer))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('customer_info_update',$m_customer->customer_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_customer_id" name="txt_customer_id" placeholder="" readonly value="{{ $m_customer->customer_id }}">

                <input type="text" class="form-control"mid="txt_customer_name" name="txt_customer_name" placeholder="Customer Name" value="{{ $m_customer->customer_name }}">
                  @error('txt_customer_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-9">
                <input type="text" class="form-control"mid="txt_customer_add" name="txt_customer_add" placeholder="Customer Address" value="{{ $m_customer->customer_add }}">
                  @error('txt_customer_add')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-2">
                <input type="text" class="form-control"mid="txt_customer_phone" name="txt_customer_phone" placeholder="Contact Number" value="{{ $m_customer->customer_phone }}">
                  @error('txt_customer_phone')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control"mid="txt_customer_email" name="txt_customer_email" placeholder="Email" value="{{ $m_customer->customer_email }}">
                  @error('txt_customer_email')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control"mid="txt_contact_person" name="txt_contact_person" placeholder="Contact Person" value="{{ $m_customer->contact_person }}">
                  @error('txt_contact_person')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('customer_info_store') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_customer_name" name="txt_customer_name" placeholder="Customer Name" value="{{ old('txt_customer_name') }}">
                  @error('txt_customer_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror

              </div>
              <div class="col-9">
                <input type="text" class="form-control" id="txt_customer_add" name="txt_customer_add" placeholder="Customer Address" value="{{ old('txt_customer_add') }}">
                  @error('txt_customer_add')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-2">
                <input type="text" class="form-control" id="txt_customer_phone" name="txt_customer_phone" placeholder="Contact Number" value="{{ old('txt_customer_phone') }}">
                  @error('txt_customer_phone')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="txt_customer_email" name="txt_customer_email" placeholder="Email" value="{{ old('txt_customer_email') }}">
                  @error('txt_customer_email')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control" id="txt_contact_person" name="txt_contact_person" placeholder="Contact Person" value="{{ old('txt_contact_person') }}">
                  @error('txt_contact_person')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Submit</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@include('/sales/customer_info_list')
&nbsp;
@endif
@endsection
