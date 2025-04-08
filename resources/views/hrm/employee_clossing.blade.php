@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Clossing</h1>
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('hrmemp_closingstore') }}" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-4">
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
              <div class="col-5">
                <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                  <option value="0">--Employee--</option>
                </select>
                @error('cbo_employee_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <select name="cbo_yesno_id" id="cbo_yesno_id" class="form-control">
                  <option value="0">Working Status</option>
                  @foreach ($m_yesno as $row)
                      <option value="{{ $row->yesno_id }}">
                          {{ $row->yesno_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_yesno_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-9">
                <input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Description" value="{{ old('txt_remarks') }}">
                  @error('txt_remarks')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_closing_date"
                    name="txt_closing_date" placeholder="Closing Date"
                    value="{{ old('txt_closing_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_closing_date')
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
{{-- @include('/hrm/salary_info_list') --}}
&nbsp;


@section('script')
  {{-- //Company to Employee Use Ajax --}}
  <script type="text/javascript">
      $(document).ready(function() {
          $('select[name="cbo_company_id"]').on('change', function() {
              // console.log('ok')
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
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  
  @endsection
@endsection
