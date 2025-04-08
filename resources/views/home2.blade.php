@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php
    $txt_emp_id=Auth::user()->emp_id;
    // echo $txt_emp_id;

    $data_pro_module_user=DB::table('pro_module_user')->Where('emp_id',$txt_emp_id)->where('valid','1')->get();
    
    @endphp

	<div class="container-fluid">
	    <div class="row">
        	@foreach($data_pro_module_user as $key=>$row_pro_module_user)
	            @php
	            $txt_module_id=$row_pro_module_user->module_id;

	            $data_pro_module=DB::table('pro_module')->where('module_id',$txt_module_id)->Where('valid','1')->first();

// dd($data_pro_module);

	            $txt_module_name=$data_pro_module->module_name;
	            $txt_module_link=$data_pro_module->module_link;
	            $txt_module_icon=$data_pro_module->module_icon;
	            // $aa="fas fa-cogs";
	            @endphp

		        <div class="col-12 col-sm-6 col-md-3">
		            <a href="{{ route($txt_module_link) }}">
		            <div class="info-box">
		                <span class="info-box-icon bg-info elevation-1"><i class="{{ $txt_module_icon }}"></i></span>
		                <div class="info-box-content">
		                    <span class="info-box-text">{{ $txt_module_name }}</span>
		                    {{-- <span class="info-box-number">05</span> --}}
		                </div>
		            </div>
		            </a>
		        </div>
	    	@endforeach
	    </div>
	</div>


	
@endsection
@section('img')
    <div class="row">
        <div class="col-12" style="position: relative">
            <img src="{{asset('public/image/logo.jpg')}}"  class="" style="position: absolute; top:-124px; right:33%; background-color: white;" height="100px" width="300px">
        </div>
        
    </div>
@endsection