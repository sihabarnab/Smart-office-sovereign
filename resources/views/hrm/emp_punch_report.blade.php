@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Punch Report</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

@foreach($ci_tmp_log as $key1=>$row1)
@php

$ci_biodevice=DB::table('pro_biodevice')->Where('biodevice_name',$row1->nodeid)->first();
$txt_biodevice_name=$ci_biodevice->biodevice_name;

$ci_punch_location=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_biodevice->placeofposting_id)->first();
$txt_punch_location=$ci_punch_location->placeofposting_name;


// $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_biodevice->placeofposting_id)->first();
//$txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

@endphp
@endforeach


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Punch Location</th>
                                <th>Punch Date</th>
                                <th>Punch Time</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_tmp_log as $key=>$row)
                            @php
                                $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->emp_id)->first();
                                $txt_employee_id=$ci_employee_info->employee_id;
                                $txt_employee_name=$ci_employee_info->employee_name;
                                // $txt_placeofposting_id=$ci_employee_info->placeofposting_id;

                                $ci_desig=DB::table('pro_desig')->Where('desig_id',$ci_employee_info->desig_id)->first();
                                $txt_desig_name=$ci_desig->desig_name;

                                $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_employee_info->placeofposting_id)->first();
                                $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;


                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->emp_id }}<br>{{ $txt_placeofposting_name }}</td>
                                <td>{{ $txt_employee_name }}<br>{{ $txt_desig_name }}</td>
                                <td>{{ $txt_punch_location }}</td>
                                <td>{{ $row->logdate }}</td>
                                <td>{{ $row->logtime }}</td>
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