@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Punch Time</h1>
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
          <div align="left" class=""></div>
            <form action="{{ route('hrmbackdaily_punch_report') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                <select name="sele_placeofposting" id="sele_placeofposting" class="from-control custom-select">
                    @php
                      $ci1_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',old('sele_placeofposting'))->orderBy('placeofposting_name','asc')->get();
                    @endphp

                    @foreach($ci1_placeofposting as $r_ci1_placeofposting)
                    <option value="{{ $r_ci1_placeofposting->placeofposting_id }}">{{ $r_ci1_placeofposting->placeofposting_name }}</option>
                    @endforeach  

                  <option value="0">Select Place of Posting</option>
                    @php
                      $ci_placeofposting=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_name', 'asc')->get();
                    @endphp
                    @foreach($ci_placeofposting as $r_ci_placeofposting)
                    <option value="{{ $r_ci_placeofposting->placeofposting_id }}">{{ $r_ci_placeofposting->placeofposting_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_placeofposting')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_emp_id" id="postingWiseEmployee" class="form-control">
                    <option value="0">Select Employee</option>
                </select>
                  @error('sele_emp_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date" placeholder="Start Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_from_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date" placeholder="End Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_to_date')
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
&nbsp;
@endsection
@section('script')
  <script type="text/javascript">
   
    $('#sele_placeofposting').on('change', function(){
        var placeofposting_id = $(this).val();
        $('#postingWiseEmployee').find('option').not(':first').remove();
        $.ajax({

          url:'postingEmployee/'+placeofposting_id,
          type:'get',
          dataType:'json',
          error: function(xhr, status, error) {
            // alert(status);
            console.log(xhr.responseText);
          },
          success:function (response) {
              var len = 0;
              if (response.data != null) {
                len = response.data.length;
              }
              if (len>0) {

                  for (var i = 0; i<len; i++) {
                       var id = response.data[i].employee_id;
                       var name = response.data[i].employee_name;
                       var option = "<option value='"+id+"'>"+name+"</option>"; 
                       $("#postingWiseEmployee").append(option);
                  }

              }

          }

      })
    });
    
  </script>
@endsection
