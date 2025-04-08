@extends('layouts.inventory_app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Origin</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <section class="content">
    <div class="container-fluid">
  @include('flash-message')
</div>
    @if(isset($m_origin))
    <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
          <form method="post" action="{{ route('prooriginupdate',$m_origin->origin_id) }}">
            @csrf
            <div  class="">
              <div class="row mb-2">
                <div class="col-12">
                  <input type="hidden" class="form-control" id="txt_origin_id" name="txt_origin_id" value="{{ $m_origin->origin_id }}">
                  <input type="text" class="form-control" id="txt_origin_name" name="txt_origin_name" value="{{$m_origin->origin_name }}">
                   @error('txt_origin_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Update</button>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
  @else
  <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
          <form method="post" action="{{ route('originstore') }}">
            @csrf
            <div a class="">
              <div class="row mb-2">
                <div class="col-12">
                  <input type="text" class="form-control" id="txt_origin_name" name="txt_origin_name" value="{{ old('txt_origin_name') }}" placeholder="Country Name">
                   @error('txt_origin_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Save</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

@endif
@include('inventory.product_origin_list')

@endsection