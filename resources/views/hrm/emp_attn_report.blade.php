@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Attendance Report</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

@foreach($ci_pro_attendance as $key1=>$row1)
@php

$ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row1->employee_id)->first();
$txt_employee_name=$ci_employee_info->employee_name;

$ci_desig=DB::table('pro_desig')->Where('desig_id',$row1->desig_id)->first();
$txt_desig_name=$ci_desig->desig_name;

$ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row1->placeofposting_id)->first();
$txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

// $ci_biodevice=DB::table('pro_biodevice')->Where('biodevice_name',$row1->nodeid)->first();
// $txt_biodevice_name=$ci_biodevice->biodevice_name;

@endphp
@endforeach


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="card-title"> --}}
                        <div class="row mb-2">
                            <div class="col-6">
                                {{ $txt_employee_name }}<br>{{ $txt_desig_name }}<br>{{ $txt_placeofposting_name }}
                            </div>
                            <div class="col-6">
                                {{ 'P=Present' }}, {{ 'W=Weekend' }}<br>{{ 'D=Late' }}, {{ 'A=Absent' }}<br>{{ 'H=Holiday'}},{{ 'L=Leave' }}
                            </div>
                        </div>
                        
                    {{-- </h3> --}}
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>

                                <th>SL No</th>
                                <th>Date</th>
                                <th>Day Name</th>
                                <th>Status</th>
                                <th>In Time</th>
                                <th>In Location</th>
                                <th>Out Time</th>
                                <th>Out Location</th>
                                <th>Late</th>
                                <th>Early/Over</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_pro_attendance as $key=>$row)
                            @php
                            if($row->nodeid_in=='0')
                            {
                              $txt_nodeid_in="N/A";
                            } else {
                            $m_biodevice_01=DB::table('pro_biodevice')->Where('biodevice_name',$row->nodeid_in)->Where('valid','1')->first();

                            // dd($row->nodeid_in);
                            $m_placeofposting_01=DB::table('pro_placeofposting')->Where('placeofposting_id',$m_biodevice_01->placeofposting_id)->first();

                            $txt_nodeid_in=$m_placeofposting_01->placeofposting_name;
                            // $txt_nodeid_in="aaa";
                            }
                            // echo "$row->nodeid_out --";
                            if($row->nodeid_out=='0')
                            {
                              $txt_nodeid_out="N/A";
                            } else {
                            $m_biodevice_02=DB::table('pro_biodevice')->Where('biodevice_name',$row->nodeid_out)->Where('valid','1')->first();
                            $m_placeofposting_02=DB::table('pro_placeofposting')->Where('placeofposting_id',$m_biodevice_02->placeofposting_id)->first();

                            $txt_nodeid_out=$m_placeofposting_02->placeofposting_name;
                            // $txt_nodeid_out="bbb";
                            }

                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->attn_date }}</td>
                                <td>{{ $row->day_name }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->in_time }}</td>
                                <td>{{ $txt_nodeid_in }}</td>
                                <td>{{ $row->out_time }}</td>
                                <td>{{ $txt_nodeid_out }}</td>
                                <td>{{ $row->late_min }}</td>
                                <td>{{ $row->early_min }}</td>
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