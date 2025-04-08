@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Place of Posting</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_placeofposting))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('hrmbackplace_postingupdate',$m_placeofposting->placeofposting_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-12">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control"mid="txt_placeofposting_name" name="txt_placeofposting_name" placeholder="Place of Posting" value="{{ $m_placeofposting->placeofposting_name }}">
                  @error('txt_placeofposting_name')
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
            <form action="{{ route('hrmbackplace_postingstore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-12">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control"mid="txt_placeofposting_name" name="txt_placeofposting_name" placeholder="Place of Posting" value="{{ old('txt_placeofposting_name') }}">
                  @error('txt_placeofposting_name')
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
@include('/hrm/placeposting_list')
&nbsp;
@endif
@endsection
