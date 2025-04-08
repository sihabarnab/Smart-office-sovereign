@extends('layouts.admin_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">User Permission</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_user_permission))
{{-- {{ $m_user_permission->emp_id }} --}}

@php
$ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$m_user_permission->emp_id)->first();
$txt_employee_name=$ci_employee_info->employee_name;
@endphp

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ $txt_employee_name }} | {{ $m_user_permission->emp_id }}</h5></div>
            <form name="" method="post" action="" >
            @csrf
            <div class="row mb-2">
              <div class="col-5">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                <select name="sele_module_id" id="sele_module_id" class="from-control custom-select">
                    {{-- @php
                      $ci1_pro_module=DB::table('pro_module')->Where('valid','1')->orderBy('module_id','asc')->get();
                    @endphp

                    @foreach($ci1_pro_module as $r_ci1_pro_module)
                    <option value="{{ $r_ci1_pro_module->module_id }}">{{ $r_ci1_pro_module->module_name }}</option>
                    @endforeach   --}}

                  <option value="0">Select Module</option>
                    @php
                      $ci_pro_module=DB::table('pro_module')->Where('valid','1')->orderBy('module_id', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_module as $r_ci_pro_module)
                    <option value="{{ $r_ci_pro_module->module_id }}">{{ $r_ci_pro_module->module_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_module_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="sele_main_mnu_id" id="moduleWiseMainMenu" class="form-control">
                    <option value="0">Main Menu</option>
                </select>
                  @error('sele_main_mnu_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <input type="text" class="form-control" id="txt_password" name="txt_password" placeholder="Password" value="{{ old('txt_password') }}">
                  @error('txt_password')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_valid" id="sele_valid" class="from-control custom-select">
                    @php
                      $ci1_pro_yesno=DB::table('pro_yesno')->Where('yesno_id',$m_user_permission->valid)->orderBy('yesno_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_yesno as $r_ci1_pro_yesno)
                    <option value="{{ $r_ci1_pro_yesno->yesno_id }}">{{ $r_ci1_pro_yesno->yesno_name }}</option>
                    @endforeach  

                  <option value="0">Select Valid</option>
                    @php
                      $ci_pro_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_yesno as $r_ci_pro_yesno)
                    <option value="{{ $r_ci_pro_yesno->yesno_id }}">{{ $r_ci_pro_yesno->yesno_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_valid')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-7">
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
@include('/admin/user_permission_list')
@else
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-5">
              </div>
              <div class="col-7">
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
{{-- @include('/admin/user_permission_list') --}}
&nbsp;
@endif
@endsection

@section('script')
  <script type="text/javascript">
   
    $('#sele_module_id').on('change', function(){
        var module_id = $(this).val();
        $('#moduleWiseMainMenu').find('option').not(':first').remove();
        $.ajax({

          url:'moduleMainMenu/'+module_id,
          type:'get',
          dataType:'json',
          error: function(xhr, status, error) {
             alert(error);
            console.log(xhr.responseText);
          },
          success:function (response) {
              var len = 0;
              if (response.data != null) {
                len = response.data.length;
              }
              if (len>0) {

                  for (var i = 0; i<len; i++) {
                       var id = response.data[i].main_mnu_id;
                       var name = response.data[i].main_mnu_title;
                       var option = "<option value='"+id+"'>"+name+"</option>"; 
                       $("#moduleWiseMainMenu").append(option);
                  }

              }

          }

      })
    });
    
  </script>
@endsection
