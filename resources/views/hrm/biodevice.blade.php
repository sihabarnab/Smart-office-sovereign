@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Bio Device Info</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_biodevice))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('hrmbackbio_deviceupdate',$m_biodevice->biodevice_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control"mid="txt_biodevice_name" name="txt_biodevice_name" placeholder="Place of Posting" value="{{ $m_biodevice->biodevice_name }}">
                  @error('txt_biodevice_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <select name="sele_placeofposting_id" id="sele_placeofposting_id" class="from-control custom-select">
                    @php
                      $ci1_pro_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$m_biodevice->placeofposting_id)->orderBy('placeofposting_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_placeofposting as $r_ci1_pro_placeofposting)
                    <option value="{{ $r_ci1_pro_placeofposting->placeofposting_id }}">{{ $r_ci1_pro_placeofposting->placeofposting_name }}</option>
                    @endforeach  

                  <option value="0">Select Place of Posting</option>
                    @php
                      $ci_pro_placeofposting=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_placeofposting as $r_ci_pro_placeofposting)
                    <option value="{{ $r_ci_pro_placeofposting->placeofposting_id }}">{{ $r_ci_pro_placeofposting->placeofposting_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_placeofposting_id')
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
            <form action="{{ route('hrmbackbio_devicestore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-6">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <input type="text" class="form-control"mid="txt_biodevice_name" name="txt_biodevice_name" placeholder="Biodevice ID / Terminal ID" value="{{ old('txt_placeofposting_name') }}">
                  @error('txt_biodevice_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <select name="sele_placeofposting_id" id="sele_placeofposting_id" class="from-control custom-select">
                    @php
                      $ci1_pro_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',old('sele_placeofposting_id'))->orderBy('placeofposting_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_placeofposting as $r_ci1_pro_placeofposting)
                    <option value="{{ $r_ci1_pro_placeofposting->placeofposting_id }}">{{ $r_ci1_pro_placeofposting->placeofposting_name }}</option>
                    @endforeach  

                  <option value="0">Select Place of Posting</option>
                    @php
                      $ci_pro_placeofposting=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_placeofposting as $r_ci_pro_placeofposting)
                    <option value="{{ $r_ci_pro_placeofposting->placeofposting_id }}">{{ $r_ci_pro_placeofposting->placeofposting_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_placeofposting_id')
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
@include('/hrm/biodevice_list')
&nbsp;
@endif
@endsection
