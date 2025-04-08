@extends('layouts.hrm_app')
@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">BIODATA</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@php
$m_user_id=Auth::user()->emp_id;
@endphp                  

@if (isset($m_employee_biodata))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class="">
            <h5>{{ "Edit" }}</h5>
          </div>
            <form action="{{ route('hrmbio_dataupdate',$m_employee_biodata->biodata_id) }}" method="Post">
                @csrf

                <div class="row mb-2">
                    <div class="col-6">
                      <input type="hidden" class="form-control" id="txt_emp_id" name="txt_emp_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                      <input type="text" class="form-control" id="txt_company_id" name="txt_company_id" placeholder="--Company--" readonly value="{{ $m_employee_biodata->company_name }}">
                        @error('txt_company_id')
                          <div class="text-warning">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="txt_employee_id" name="txt_employee_id" placeholder="--Employee--" readonly value="{{ $m_employee_biodata->employee_id }} | {{ $m_employee_biodata->employee_name }}">
                          @error('txt_employee_id')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <input type="text" class="form-control" id="txt_father_name" name="txt_father_name" placeholder="Father's Name" value="{{ $m_employee_biodata->father_name }}">
                          @error('txt_father_name')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="txt_mother_name" name="txt_mother_name" placeholder="Mother's Name" value="{{ $m_employee_biodata->mother_name }}">
                          @error('txt_mother_name')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="txt_dob"
                            name="txt_dob" placeholder="DOB"
                            value="{{ $m_employee_biodata->dob }}" onfocus="(this.type='date')"
                            onblur="if(this.value==''){this.type='text'}">
                        @error('txt_dob')
                            <div class="text-warning">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-3">
                        <select name="cbo_marital_status" id="cbo_marital_status" class="form-control">
                          <option value="">--Marital Status--</option>
                            @foreach($marital_status as $marital_status)
                              <option value="{{$marital_status->marital_status_id}}"  {{$marital_status->marital_status_id == $m_employee_biodata->marital_status_id? 'selected':''}}>
                                  {{$marital_status->marital_status_id}} | {{$marital_status->marital_status_name}}
                              </option>
                            @endforeach
                        </select>
                          @error('cbo_marital_status')
                           <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>                
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <input type="text" class="form-control" id="txt_spouse_name" name="txt_spouse_name" placeholder="Spouse Name" value="{{ $m_employee_biodata->spouse_name }}">
                          @error('txt_spouse_name')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="txt_res_contact" name="txt_res_contact" placeholder="RES Contact No." value="{{ $m_employee_biodata->res_contact }}">
                          @error('txt_res_contact')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" id="txt_nationality" name="txt_nationality" placeholder="Nationality" value="{{ $m_employee_biodata->nationality }}">
                          @error('txt_nationality')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" id="txt_national_id_no" name="txt_national_id_no" placeholder="NID / BC" value="{{ $m_employee_biodata->national_id_no }}">
                          @error('txt_national_id_no')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" id="txt_height" name="txt_height" placeholder="Height" value="{{ $m_employee_biodata->height }}">
                          @error('txt_height')
                            <div class="text-warning">{{ $message }}</div>
                          @enderror
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                      <input type="text" class="form-control" id="txt_present_add"
                          name="txt_present_add" placeholder="Present Address"
                          value="{{ $m_employee_biodata->present_add }}">
                      @error('txt_present_add')
                          <div class="text-warning">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
              <div class="row mb-2">
                <div class="col-3">

                </div>
                <div class="col-6">
                    <a class="btn btn-primary" id='same' style="width: 100%;"
                        onclick="addressFunction()">Same as Above</a>
                </div>
                <div class="col-3">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12">
                    <input type="text" class="form-control" id="txt_permanent_add"
                        name="txt_permanent_add" placeholder="Permanent Address"
                        value="{{ $m_employee_biodata->permanent_add }}">
                    @error('txt_permanent_add')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_email_personal"
                        name="txt_email_personal" placeholder="E-mail Personal"
                        value="{{ $m_employee_biodata->email_personal }}">
                    @error('txt_email_personal')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_email_office"
                        name="txt_email_office" placeholder="E-mail Company"
                        value="{{ $m_employee_biodata->email_office }}">
                    @error('txt_email_office')
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
            <form action="{{ route('hrmbio_datastore') }}" method="Post">
            @csrf
              <div class="row mb-2">
                <div class="col-6">
                  <input type="hidden" class="form-control" id="txt_emp_id" name="txt_emp_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                  <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                    <option value="0">--Company--</option>
                    @foreach ($user_company as $company)
                        <option value="{{ $company->company_id }}">
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_company_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-6">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_father_name"
                      value="{{ old('txt_father_name') }}" name="txt_father_name"
                      placeholder="Father's Name">
                  @error('txt_father_name')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_mother_name"
                      value="{{ old('txt_mother_name') }}" name="txt_mother_name"
                      placeholder="Mother's Name">
                  @error('txt_mother_name')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="txt_dob"
                        name="txt_dob" placeholder="DOB"
                        value="{{ old('txt_dob') }}" onfocus="(this.type='date')"
                        onblur="if(this.value==''){this.type='text'}">
                    @error('txt_dob')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_marital_status" id="cbo_marital_status" class="form-control">
                    <option value="">--Marital Status--</option>
                    @foreach ($marital_status as $marital_status)
                        <option value="{{ $marital_status->marital_status_id }}">
                            {{ $marital_status->marital_status_id }} | {{ $marital_status->marital_status_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_marital_status')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror

                </div>                
              </div>
              <div class="row mb-2">
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_spouse_name"
                      value="{{ old('txt_spouse_name') }}" name="txt_spouse_name"
                      placeholder="Spouse Name">
                  @error('txt_spouse_name')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_res_contact"
                      value="{{ old('txt_res_contact') }}" name="txt_res_contact"
                      placeholder="RES Contact No.">
                  @error('txt_res_contact')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-2">
                  <input type="text" class="form-control" id="txt_nationality"
                      value="{{ old('txt_nationality') }}" name="txt_nationality"
                      placeholder="Nationality">
                  @error('txt_nationality')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-2">
                  <input type="text" class="form-control" id="txt_national_id_no"
                      value="{{ old('txt_national_id_no') }}" name="txt_national_id_no"
                      placeholder="NID / BC">
                  @error('txt_national_id_no')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-2">
                  <input type="text" class="form-control" id="txt_height"
                      value="{{ old('txt_national_id_no') }}" name="txt_height"
                      placeholder="Height">
                  @error('txt_height')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12">
                    <input type="text" class="form-control" id="txt_present_add"
                        name="txt_present_add" placeholder="Present Address"
                        value="{{ old('txt_present_add') }}">
                    @error('txt_present_add')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-3">

                </div>
                <div class="col-6">
                    <a class="btn btn-primary" id='same' style="width: 100%;"
                        onclick="addressFunction()">Same as Above</a>
                </div>
                <div class="col-3">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12">
                    <input type="text" class="form-control" id="txt_permanent_add"
                        name="txt_permanent_add" placeholder="Permanent Address"
                        value="{{ old('txt_permanent_add') }}">
                    @error('txt_permanent_add')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_email_personal"
                        name="txt_email_personal" placeholder="E-mail Personal"
                        value="{{ old('txt_email_personal') }}">
                    @error('txt_email_personal')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_email_office"
                        name="txt_email_office" placeholder="E-mail Company"
                        value="{{ old('txt_email_office') }}">
                    @error('txt_email_office')
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

@include('/hrm/bio_data_list')
@endif
@section('script')

@if(isset($m_employee_biodata))
<script type="text/javascript">
    $('select[name="cbo_employee_id"]').append('<option selected value="'+{{$m_employee_biodata->employee_id}}+'" >'+"{{ $m_employee_biodata->employee_id.' | '.$m_employee_biodata->employee_name}}"+'</option>');
</script>
@endif

    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                console.log('ok')
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/employee/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_employee_id"]').empty();
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="0">--Employee--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_employee_id"]').append(
                                    '<option value="' + value.employee_id + '">' +
                                    value.employee_id + ' | ' + value.employee_name + '</option>');
                            });
                        },
                    });

                }

            });
        });
    </script>
    <script>
        // Auto Fill up js code
        function addressFunction() {
            document.getElementById("txt_permanent_add").value = document.getElementById("txt_present_add").value;
        }
    </script>

<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $("select").select2();
});
</script>  
    
@endsection

@endsection
