@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Attendance Report</h1>
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
                    
                    <table id="data2" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Description</th>
                                <th>Approved For</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_leave_info_master as $key=>$row_leave)
                            @php
                            $ci_leave_type=DB::table('pro_leave_type')->Where('valid','1')->Where('leave_type_id',$row_leave->leave_type_id)->first();

                            // $ci_leave_status=DB::table('pro_late_inform_master')->Where('late_inform_master_id',$row_late_app->late_inform_master_id)->first();

                            if($row_leave->status=='1')
                            {
                                $txt_leave_status="Pending";
                            }
                            else if($row_leave->status=='2')
                            {
                                $txt_leave_status="Approved";
                            }
                            else if($row_leave->status=='3')
                            {
                                $txt_leave_status="Cancel";
                            }
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ci_leave_type->leave_type }} | {{ $ci_leave_type->leave_type_sname }}</td>
                                <td>{{ $row_leave->entry_date }}<br>{{ $row_leave->entry_time }}</td>
                                <td>{{ $row_leave->leave_form }} to {{ $row_leave->leave_to }}<br>{{ $row_leave->total }} day</td>
                                <td>{{ $row_leave->purpose_leave }}</td>
                                <td>{{ $row_leave->g_leave_form }} to {{ $row_leave->g_leave_to }}<br>{{ $row_leave->g_leave_total }} day</td>
                                <td>{{ $txt_leave_status }}</td>
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