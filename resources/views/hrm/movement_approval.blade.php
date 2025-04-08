@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Movement Approval</h1>
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
                                <th>Movement Type<br>Movement Date</th>
                                <th>Application<br>Date & Time</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ci_report as $key=>$row_late_app)
                            @php
                            $ci_list=DB::table('pro_late_inform_master')->Where('valid','1')->Where('status','1')->Where('employee_id',$row_late_app->employee_id)->orderBy('employee_id','asc')->get();
                            @endphp
                            @foreach($ci_list as $key=>$row_app)
                            @php
                            $ci_late_type=DB::table('pro_late_type')->Where('valid','1')->Where('late_type_id',$row_app->late_type_id)->first();
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_late_app->employee_id }}<br>{{ $row_late_app->employee_name }}<br>{{ $row_late_app->company_name }}</td>
                                <td>{{ $row_late_app->desig_name }}<br>{{ $row_late_app->department_name }}<br>{{ $row_late_app->mobile }}</td>
                                <td>{{ $ci_late_type->late_type }}<br>{{ $row_app->late_form }} to {{ $row_app->late_to }}</td>
                                <td>{{ $row_app->entry_date }}<br>{{ $row_app->entry_time }}</td>
                                <td>
                                    <a href="{{ route('hrmmove_app_approval',$row_app->late_inform_master_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
                    <div align="left" class=""><h5><?="Previous Movement Status"; ?></h5></div>
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>ID<br>Name<br>Company</th>
                                <th>Designation<br>Department<br>Mobile</th>
                                <th>Movement Type<br>Movement Date</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ci_report as $key=>$row_late_app)
                            @php
                            $ci_list=DB::table('pro_late_inform_master')->Where('valid','1')->Where('status','>','1')->Where('employee_id',$row_late_app->employee_id)->orderBy('employee_id','asc')->get();
                            @endphp
                            @foreach($ci_list as $key=>$row_app)
                            @php
                            $ci_late_type=DB::table('pro_late_type')->Where('valid','1')->Where('late_type_id',$row_app->late_type_id)->first();
                            
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
                                <td>{{ $row_late_app->employee_id }}<br>{{ $row_late_app->employee_name }}<br>{{ $row_late_app->company_name }}</td>
                                <td>{{ $row_late_app->desig_name }}<br>{{ $row_late_app->department_name }}<br>{{ $row_late_app->mobile }}</td>
                                <td>{{ $ci_late_type->late_type }}<br>{{ $row_app->late_form }} to {{ $row_app->late_to }}</td>
                                <td>{{ $row_app->g_late_total }} days<br>{{ $row_app->g_late_form }} to {{ $row_app->g_late_to }}</td>
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