@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Approval</h1>
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
                    <div align="left" class=""><h5><?="New Application"; ?></h5></div>
                    <table id="data2" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>ID<br>Name<br>Company</th>
                                <th>Designation<br>Department<br>Mobile</th>
                                <th>Leave Type<br>Leave Date</th>
                                <th>Application<br>Date & Time</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ci_report as $key=>$row_leave_app)
                            @php
                            $ci_list=DB::table('pro_leave_info_master')->Where('valid','1')->Where('status','1')->Where('employee_id',$row_leave_app->employee_id)->orderBy('employee_id','asc')->get();
                            @endphp
                            @foreach($ci_list as $key=>$row_app)
                            @php
                            $ci_leave_type=DB::table('pro_leave_type')->Where('valid','1')->Where('leave_type_id',$row_app->leave_type_id)->first();
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_leave_app->employee_id }}<br>{{ $row_leave_app->employee_name }}<br>{{ $row_leave_app->company_name }}</td>
                                <td>{{ $row_leave_app->desig_name }}<br>{{ $row_leave_app->department_name }}<br>{{ $row_leave_app->mobile }}</td>
                                <td>{{ $ci_leave_type->leave_type }}<br>{{ $row_app->leave_form }} to {{ $row_app->leave_to }}</td>
                                <td>{{ $row_app->entry_date }}<br>{{ $row_app->entry_time }}</td>
                                <td>
                                    <a href="{{ route('hrmleave_app_approval',$row_app->leave_info_master_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class=""><h5><?="Previous Leave Status"; ?></h5></div>
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>ID<br>Name<br>Company</th>
                                <th>Designation<br>Department<br>Mobile</th>
                                <th>Leave Type<br>Leave Date</th>
                                <th>Grant<br>Leave Date</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ci_report as $key=>$row_leave_app)
                            @php
                            $ci_list=DB::table('pro_leave_info_master')->Where('valid','1')->Where('status','>','1')->Where('employee_id',$row_leave_app->employee_id)->orderBy('employee_id','asc')->get();
                            @endphp
                            @foreach($ci_list as $key=>$row_app)
                            @php
                            $ci_leave_type=DB::table('pro_leave_type')->Where('valid','1')->Where('leave_type_id',$row_app->leave_type_id)->first();
                            
                            if($row_app->status=='2')
                            {
                                $txt_app_status="Approved";
                            } 
                            elseif ($row_app->status=='3')
                            {
                                $txt_app_status="Cancel";
                            }
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_leave_app->employee_id }}<br>{{ $row_leave_app->employee_name }}<br>{{ $row_leave_app->company_name }}</td>
                                <td>{{ $row_leave_app->desig_name }}<br>{{ $row_leave_app->department_name }}<br>{{ $row_leave_app->mobile }}</td>
                                <td>{{ $ci_leave_type->leave_type }}<br>{{ $row_app->leave_form }} to {{ $row_app->leave_to }}</td>
                                <td>{{ $row_app->g_leave_total }} days<br>{{ $row_app->g_leave_form }} to {{ $row_app->g_leave_to }}</td>
                                <td>{{ $txt_app_status }}</td>
                            </tr>
                            @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection