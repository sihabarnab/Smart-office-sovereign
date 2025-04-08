@extends('layouts.admin_app')

@section('content')

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Module and Company</h1>
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
                        {{-- <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div> --}}
                        <form action="{{ route('user_mc_list') }}" method="post">
                            @csrf
                              <div class="row mb-2">
                                <div class="col-4">
                                  <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="0">--Company--</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->company_id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                  </select>
                                  @error('cbo_company_id')
                                      <div class="text-warning">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-4">
                                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                        <option value="0">--Select Employee--</option>
                                    </select>
                                    @error('cbo_employee_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="cbo_blade" id="cbo_blade" class="form-control">
                                        <option value="1">User Module List</option>
                                        <option value="2">User Company List</option>
                                    </select>
                                    @error('cbo_blade')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                console.log('ok')
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/employee1/') }}/" + cbo_company_id,
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
@endsection