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
                                <th>Date</th>
                                <th>Day Name</th>
                                <th>Status</th>
                                <th>In Time</th>
                                <th>&nbsp;</th>
                                <th>Out Time</th>
                                <th>&nbsp;</th>
                                <th>Late</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_attendance as $key=>$row)
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
                                <td>&nbsp;</td>
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