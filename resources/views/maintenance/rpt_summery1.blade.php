@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Summery</h1>
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
                                    <th>SL</th>
                                    <th>Com. No.</th>
                                    <th>Client<br>Project</th>
                                    <th>Complain</th>
                                    <th>Task Register</th>
                                    <th>Task Assign</th>
                                    <th>Call Attend Time</th>
                                    <th>Remark</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $colore = 'red';
                                    $cl = 'taskblink';
                                    $assign_clor = '';
                                    $journy_color = '';
                                @endphp
                                @foreach ($m_task_register as $key => $row)
                                    @php

                                        //Task Assign
                                        $task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($task_assign)) {
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $task_assign->team_leader_id)
                                                ->first();
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                            $task_complite = $task_assign->complete_task == 1 ? '1' : '0';
                                        } else {
                                            $txt_team_leader_name = '';
                                            $task_complite = '0';
                                        }

                                        //Colore status
                                        if ($row->status == 1) {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                        } elseif ($row->status == 2 && $task_complite == '0') {
                                            $colore = 'Yellow';
                                            $cl = '';
                                        } elseif ($task_complite == '1') {
                                            $colore = 'Green';
                                            $cl = '';
                                        }

                                        //Register to Assign time
                                        date_default_timezone_set('Asia/Dhaka');

                                        $register_date = strtotime("$row->entry_date $row->entry_time");
                                        if (isset($task_assign)) {
                                            $current_date = strtotime("$task_assign->entry_date $task_assign->entry_time");
                                        } else {
                                            $current_date = strtotime(date('Y-m-d h:i:s'));
                                        }
                                        $diff = abs($current_date - $register_date);
                                        $day = floor($diff / (60 * 60 * 24));
                                        $hour = floor(($diff - $day * 60 * 60 * 24) / (60 * 60));
                                        $minit = floor(($diff - $day * 60 * 60 * 24 - $hour * 60 * 60) / 60);
                                        $second = floor($diff - $day * 60 * 60 * 24 - $hour * 60 * 60 - $minit * 60);

                                        if ($diff < 60) {
                                            $registerToassign = "0 day 0 hour 0 minit $diff second";
                                        } elseif ($diff < 60 * 60) {
                                            $registerToassign = "0 day 0 hour $minit minit $second second";
                                        } elseif ($diff < 60 * 60 * 24) {
                                            $registerToassign = "0 day $hour hour $minit minit $second second";
                                        } else {
                                            $registerToassign = "$day day $hour hour $minit minit $second second";
                                        }

                                        //End Register to Assign time

                                        // Assign to task start
                                        if (isset($task_assign)) {
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_assign->task_id)
                                                ->first();
                                            if ($journey) {
                                                $assign_clor = 'yellow';
                                                $current_date2 = strtotime("$journey->start_journey_date $journey->start_journey_time");
                                            } else {
                                                $assign_clor = 'red';
                                                $current_date2 = strtotime(date('Y-m-d h:i:s'));
                                            }
                                            $assign_date = strtotime("$task_assign->entry_date $task_assign->entry_time");
                                            $assign_diff = abs($current_date2 - $assign_date);
                                            $day = floor($assign_diff / (60 * 60 * 24));
                                            $hour = floor(($assign_diff - $day * 60 * 60 * 24) / (60 * 60));
                                            $minit = floor(($assign_diff - $day * 60 * 60 * 24 - $hour * 60 * 60) / 60);
                                            $second = floor($assign_diff - $day * 60 * 60 * 24 - $hour * 60 * 60 - $minit * 60);

                                            if ($assign_diff < 60) {
                                                $assignTotaskstart = "0 day 0 hour 0 minit $assign_diff second";
                                            } elseif ($assign_diff < 60 * 60) {
                                                $assignTotaskstart = "0 day 0 hour $minit minit $second second";
                                            } elseif ($assign_diff < 60 * 60 * 24) {
                                                $assignTotaskstart = "0 day $hour hour $minit minit $second second";
                                            } else {
                                                $assignTotaskstart = "$day day $hour hour $minit minit $second second";
                                            }
                                            //
                                        } else {
                                            $assignTotaskstart = '';
                                        }
                                        //End Assign to Task start
                                        // echo date('Y-m-d h:i:sa');
                                        //Task Start to Complite
                                        if (isset($task_assign)) {
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_assign->task_id)
                                                ->first();
                                            if (isset($journey)) {
                                                $journey_start = strtotime("$journey->start_journey_date $journey->start_journey_time");

                                                $work_end = DB::table('pro_work_end')
                                                    ->where('task_id', $task_assign->task_id)
                                                    ->where('status', 1) // status 1 complite
                                                    ->first();

                                                if (isset($work_end)) {
                                                    $journy_color = 'green';
                                                    $current_date3 = strtotime("$work_end->complete_date $work_end->complete_time");
                                                } else {
                                                    $journy_color = 'red';
                                                    $current_date3 = strtotime(date('Y-m-d h:i:sa'));
                                                }

                                                $journey_diff = abs($current_date3 - $journey_start);
                                                $day = floor($journey_diff / (60 * 60 * 24));
                                                $hour = floor(($journey_diff - $day * 60 * 60 * 24) / (60 * 60));
                                                $minit = floor(($journey_diff - $day * 60 * 60 * 24 - $hour * 60 * 60) / 60);
                                                $second = floor($journey_diff - $day * 60 * 60 * 24 - $hour * 60 * 60 - $minit * 60);
                                                if ($journey_diff < 60) {
                                                    $journeyToComplite = "0 day 0 hour 0 minit $journey_diff second";
                                                } elseif ($journey_diff < 60 * 60) {
                                                    $journeyToComplite = "0 day 0 hour $minit minit $second second";
                                                } elseif ($journey_diff < 60 * 60 * 24) {
                                                    $journeyToComplite = "0 day $hour hour $minit minit $second second";
                                                } else {
                                                    $journeyToComplite = "$day day $hour hour $minit minit $second second";
                                                }
                                                //
                                            } else {
                                                $journeyToComplite = '';
                                            }
                                        } else {
                                            $journeyToComplite = '';
                                        }
                                        //End Task Start to Complite
                                    @endphp
                                    <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->complaint_register_id }} <br> {{ $row->entry_date }} <br>
                                            {{ $row->entry_time }}</td>
                                        <td>{{ $row->customer_name }} <br>{{ $row->project_name }}</td>
                                        <td>{{ $row->complaint_description }}</td>
                                        <td>{{ $registerToassign }}</td>
                                        <td style="color:{{ $assign_clor }}">{{ $assignTotaskstart }}</td>
                                        <td style="color:{{ $journy_color }}">{{ $journeyToComplite }}</td>
                                        <td>
                                            @if ($task_complite == '1')
                                                {{ 'Job Done' }}
                                            @else
                                                {{ 'Pending' }}
                                            @endif
                                            <br>
                                            @if ($row->status == 2)
                                                {{ $txt_team_leader_name }}
                                            @endif

                                        </td>
                                        <td>
                                            @if (isset($task_assign))
                                                <a target="__blanck"
                                                    href="{{ route('rpt_task_view', $task_assign->task_id) }}">More</a>
                                            @endif
                                        </td>
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
