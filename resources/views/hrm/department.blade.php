@extends('layouts.hrm_app')

@section('content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Department</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <section class="content">
    <div class="container-fluid">
  @include('flash-message')
</div>
    @if(isset($m_dept))
    <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
          <form method="post" action="{{ route('hrmbackdepartmentupdate') }}">
            @csrf
            <div align="center" class="">
              <div class="row mb-2">
                <div class="col-12">
                  <input type="hidden" class="form-control" id="txt_department_id" name="txt_department_id" value="{{ $m_dept->department_id }}">
                  <input type="text" class="form-control" id="txt_department_name" name="txt_department_name" value="{{$m_dept->department_name }}">
                   @error('txt_department_name')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
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
  </section>
  @else
  <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
          <form method="post" action="{{ route('hrmbackdepartmentstore') }}">
            @csrf
            <div align="center" class="">
              <div class="row mb-2">
                <div class="col-12">
                  <input type="text" class="form-control" id="txt_department_name" name="txt_department_name" value="{{ old('txt_department_name') }}" placeholder="Department Name">
                   @error('txt_department_name')
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
@include('hrm.department_list')

@endsection
