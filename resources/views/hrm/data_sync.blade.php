@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Data Synchronization</h1>
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
          <div align="left" class=""><h5></h5></div>
            <form action="{{ route('hrmbackdata_syncstore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_sync_date"
                    name="txt_sync_date" placeholder="Synchronization Date"
                    value="{{ old('txt_sync_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_sync_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-6">&nbsp;
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

@endsection
