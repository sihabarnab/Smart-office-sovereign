@extends('layouts.inventory_app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <section class="content">
    <div class="container-fluid">
  @include('flash-message')
</div>
    @if(isset($m_product))
    <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
          <form method="post" action="{{ route('inventoryproductupdate',$m_product->product_id) }}">
            @csrf
            <div  class="">
              <div class="row mb-2">
                  <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                  <input type="hidden" class="form-control" id="txt_product_id" name="txt_product_id" value="{{ $m_product->product_id }}">

                <div class="col-10">
                  <input type="text" class="form-control"mid="txt_product_name" name="txt_product_name" placeholder="Product Name" value="{{ $m_product->product_name }}">
                    @error('txt_product_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-2">
                  <select name="sele_unit_id" id="sele_unit_id" class="from-control custom-select">
                      @php
                        $ci1_pro_units=DB::table('pro_units')->Where('unit_id',$m_product->unit_id)->orderBy('unit_name','asc')->get();
                      @endphp

                      @foreach($ci1_pro_units as $r_ci1_pro_units)
                      <option value="{{ $r_ci1_pro_units->unit_id }}">{{ $r_ci1_pro_units->unit_name }}</option>
                      @endforeach  

                    <option value="0">Select Unit</option>
                      @php
                        $ci_pro_units=DB::table('pro_units')->Where('valid','1')->orderBy('unit_name','asc')->get();
                      @endphp
                      @foreach($ci_pro_units as $r_ci_pro_units)
                      <option value="{{ $r_ci_pro_units->unit_id }}">{{ $r_ci_pro_units->unit_name }}</option>
                      @endforeach    
                  </select>
                    @error('sele_unit_id')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-6">
                  <select name="sele_size_id" id="sele_size_id" class="from-control custom-select">
                      @php
                        $ci1_pro_sizes=DB::table('pro_sizes')->Where('size_id',$m_product->size_id)->orderBy('size_name','asc')->get();
                      @endphp

                      @foreach($ci1_pro_sizes as $r_ci1_pro_sizes)
                      <option value="{{ $r_ci1_pro_sizes->size_id }}">{{ $r_ci1_pro_sizes->size_name }}</option>
                      @endforeach  

                    <option value="0">Select Size</option>
                      @php
                        $ci_pro_sizes=DB::table('pro_sizes')->Where('valid','1')->orderBy('size_name','asc')->get();
                      @endphp
                      @foreach($ci_pro_sizes as $r_ci_pro_sizes)
                      <option value="{{ $r_ci_pro_sizes->size_id }}">{{ $r_ci_pro_sizes->size_name }}</option>
                      @endforeach    
                  </select>
                    @error('sele_size_id')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                  <select name="sele_origin_id" id="sele_origin_id" class="from-control custom-select">
                      @php
                        $ci1_pro_origins=DB::table('pro_origins')->Where('origin_id',$m_product->origin_id)->orderBy('origin_name','asc')->get();
                      @endphp

                      @foreach($ci1_pro_origins as $r_ci1_pro_origins)
                      <option value="{{ $r_ci1_pro_origins->origin_id }}">{{ $r_ci1_pro_origins->origin_name }}</option>
                      @endforeach  

                    <option value="0">Select Origin</option>
                      @php
                        $ci_pro_origins=DB::table('pro_origins')->Where('valid','1')->orderBy('origin_name','asc')->get();
                      @endphp
                      @foreach($ci_pro_origins as $r_ci_pro_origins)
                      <option value="{{ $r_ci_pro_origins->origin_id }}">{{ $r_ci_pro_origins->origin_name }}</option>
                      @endforeach    
                  </select>
                    @error('sele_origin_id')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12">
                  <input type="text" class="form-control"mid="txt_product_des" name="txt_product_des" placeholder="Product Description" value="{{ $m_product->product_des }}">
                    @error('txt_product_des')
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
          <form method="post" action="{{ route('inventoryproductstore') }}">
            @csrf
            <div  class="">
              <div class="row mb-2">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                
                <div class="col-10">
                  <input type="text" class="form-control" id="txt_product_name" name="txt_product_name" value="{{ old('txt_product_name') }}" placeholder="Product Name">
                   @error('txt_product_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-2">
                <select name="sele_unit_id" id="sele_unit_id" class="from-control custom-select">
                    @php
                      $ci1_pro_units=DB::table('pro_units')->Where('unit_id',old('sele_unit_id'))->orderBy('unit_name','DESC')->get();
                    @endphp

                    @foreach($ci1_pro_units as $r_ci1_pro_units)
                    <option value="{{ $r_ci1_pro_units->unit_id }}">{{ $r_ci1_pro_units->unit_name }}</option>
                    @endforeach  

                  <option value="0">Select Unit</option>
                    @php
                      $ci_pro_units=DB::table('pro_units')->Where('valid','1')->orderBy('unit_name', 'DESC')->get();
                    @endphp
                    @foreach($ci_pro_units as $r_ci_pro_units)
                    <option value="{{ $r_ci_pro_units->unit_id }}">{{ $r_ci_pro_units->unit_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_unit_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-6">
                <select name="sele_size_id" id="sele_size_id" class="from-control custom-select">
                    @php
                      $ci1_pro_sizes=DB::table('pro_sizes')->Where('size_id',old('sele_size_id'))->orderBy('size_name','DESC')->get();
                    @endphp

                    @foreach($ci1_pro_sizes as $r_ci1_pro_sizes)
                    <option value="{{ $r_ci1_pro_sizes->size_id }}">{{ $r_ci1_pro_sizes->size_name }}</option>
                    @endforeach  

                  <option value="0">Select Size</option>
                    @php
                      $ci_pro_sizes=DB::table('pro_sizes')->Where('valid','1')->orderBy('size_name', 'DESC')->get();
                    @endphp
                    @foreach($ci_pro_sizes as $r_ci_pro_sizes)
                    <option value="{{ $r_ci_pro_sizes->size_id }}">{{ $r_ci_pro_sizes->size_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_size_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-6">
                <select name="sele_origin_id" id="sele_origin_id" class="from-control custom-select">
                    @php
                      $ci1_pro_origins=DB::table('pro_origins')->Where('origin_id',old('sele_origin_id'))->orderBy('origin_name','DESC')->get();
                    @endphp

                    @foreach($ci1_pro_origins as $r_ci1_pro_origins)
                    <option value="{{ $r_ci1_pro_origins->origin_id }}">{{ $r_ci1_pro_origins->origin_name }}</option>
                    @endforeach  

                  <option value="0">Select Origin</option>
                    @php
                      $ci_pro_origins=DB::table('pro_origins')->Where('valid','1')->orderBy('origin_name', 'DESC')->get();
                    @endphp
                    @foreach($ci_pro_origins as $r_ci_pro_origins)
                    <option value="{{ $r_ci_pro_origins->origin_id }}">{{ $r_ci_pro_origins->origin_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_origin_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
               
              </div>
              <div class="row mb-2">
                <div class="col-12">
                  <input type="text" class="form-control" id="txt_product_des" name="txt_product_des" value="{{ old('txt_product_des') }}" placeholder="Product Description / Remarks">
                   @error('txt_product_des')
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
@include('inventory.product_list')

@endsection