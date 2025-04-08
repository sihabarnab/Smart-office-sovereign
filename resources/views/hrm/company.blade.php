@extends('layouts.hrm_app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Company</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


  <section class="content">
    <div class="container-fluid">
  @include('flash-message')
</div>
    @if(isset($m_company))
    <div class="container-fluid">  
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
          <form method="post" action="{{ route('hrmbackcompanyupdate') }}">
            @csrf
            <!-- {{ method_field('patch') }} -->
            <div align="center" class="">
              <div class="row mb-2">
                <div class="col-5">
                  <input type="hidden" class="form-control" id="txt_company_id" name="txt_company_id" value="{{ $m_company->company_id }}">
                  <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" value="{{ $m_company->company_name }}" placeholder="Company Name">
                   @error('txt_company_name')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-7">
                  <input type="text" class="form-control" name="txt_company_address" id="txt_company_address" value="{{ $m_company->company_add }}"  placeholder="Address">
                  @error('txt_company_address')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-3">
                  <input type="text" class="form-control" name="txt_company_zip" id="txt_company_zip" value="{{$m_company->company_zip }}"  placeholder="Postal Code">
                  @error('txt_company_zip')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" name="txt_company_city" id="txt_company_city" value="{{$m_company->company_city }}"  placeholder="City">
                  @error('txt_company_city')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-5">
                  <input type="text" class="form-control" name="txt_company_country" id="txt_company_country" value="{{$m_company->company_country}}"  placeholder="Country">
                  @error('txt_company_country')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-2">
                  <input type="text" class="form-control" name="txt_company_phone" id="txt_company_phone" value="{{$m_company->company_phone }}"  placeholder="Phone">
                  @error('txt_company_phone')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-2">
                  <input type="text" class="form-control" name="txt_company_mobile" id="txt_company_mobile" value="{{$m_company->company_mobile}}"  placeholder="Cell">
                  @error('txt_company_mobile')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" name="txt_company_email" id="txt_company_email" value="{{$m_company->company_email}}"  placeholder="E-mail">
                  @error('txt_company_email')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" name="txt_company_url" id="txt_company_url" value="{{$m_company->company_url }}" placeholder="URL">
                  @error('txt_company_url')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  &nbsp;
                </div>
                <div class="col-2">
                  <button type="submit" class="btn btn-primary btn-block">Update</button>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
  </section>
  @else
  <div class="container-fluid"> 
    <div class="row">
    <div class="col-12">
   
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>

          <form method="post" action="{{ route('hrmbackcompanystore') }}">
            @csrf
            <div align="center" class="">
              <div class="row mb-2">
                <div class="col-5">
                  <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" value="{{ old('txt_company_name') }}" placeholder="Company Name">
                   @error('txt_company_name')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-7">
                  <input type="text" class="form-control" name="txt_company_address" id="txt_company_address" value="{{ old('txt_company_address') }}"  placeholder="Address">
                  @error('txt_company_address')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-3">
                  <input type="text" class="form-control" name="txt_company_zip" id="txt_company_zip" value="{{ old('txt_company_zip') }}"  placeholder="Postal Code">
                  @error('txt_company_zip')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" name="txt_company_city" id="txt_company_city" value="{{ old('txt_company_city') }}"  placeholder="City">
                  @error('txt_company_city')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-5">
                  <input type="text" class="form-control" name="txt_company_country" id="txt_company_country" value="{{ old('txt_company_country') }}"  placeholder="Country">
                  @error('txt_company_country')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-2">
                  <input type="text" class="form-control" name="txt_company_phone" id="txt_company_phone" value="{{ old('txt_company_phone') }}"  placeholder="Phone">
                  @error('txt_company_phone')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-2">
                  <input type="text" class="form-control" name="txt_company_mobile" id="txt_company_mobile" value="{{ old('txt_company_mobile') }}"  placeholder="Cell">
                  @error('txt_company_mobile')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" name="txt_company_email" id="txt_company_email" value="{{ old('txt_company_email') }}"  placeholder="E-mail">
                  @error('txt_company_email')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" name="txt_company_url" id="txt_company_url" value="{{ old('txt_company_url') }}" placeholder="URL">
                  @error('txt_company_url')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  &nbsp;
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
  </div>
</div>
  </section>

@endif
@include('hrm.company_list')

@endsection
