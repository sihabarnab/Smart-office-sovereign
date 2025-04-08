@extends('layouts.admin_app')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @php
                    $employee = DB::table('pro_employee_info')->where('employee_id',$emp_id)->first();                      
                    @endphp
                    <h1 class="m-0">{{ $employee->employee_name }} <br> {{ $employee->employee_id }}</h1>
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">Company Name</th>
                                    <th class="text-left align-top">Valid</th>
                                    <th class="text-left align-top"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_company as $key => $value)
                                    <tr>
                                        <form action="{{ route('user_company_update', $emp_id) }}" method="post">
                                            @csrf

                                            <input type="hidden" name="txt_employee_id" id="txt_employee_id" value="{{$emp_id}}">
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top ">
                                                <input type="hidden" name="txt_company_id" id="txt_company_id" value="{{$value->company_id}}">
                                                {{ $value->company_name }}
                                            </td>
                                            <td class="text-left align-top ">
                                            @php
                                                $user_module = DB::table('pro_user_company')
                                                    ->where('employee_id',$emp_id)
                                                    ->where('company_id', $value->company_id)
                                                    ->where('valid', 1)
                                                    ->first();
                                            @endphp
                                            <div class="form-check">
                                                @if (isset($user_module->valid))
                                                    @if ($user_module->valid == 1)
                                                        <input class="form-check-input" type="checkbox" name="txt_valid"
                                                            id="txt_valid" checked>
                                                    @else
                                                        <input class="form-check-input" type="checkbox" name="txt_valid"
                                                            id="txt_valid">
                                                    @endif
                                                @else
                                                    <input class="form-check-input" type="checkbox" name="txt_valid"
                                                        id="txt_valid">
                                                @endif
                                                <label class="form-check-label" for="txt_valid">Valid</label>
                                            </div>
                                            </td>

                                            <td class="text-left align-top">
                                                <button type="submit" class="btn bg-primary">Submit</button>
                                            </td>

                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
