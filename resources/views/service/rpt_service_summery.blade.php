@extends('layouts.service_app')
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

    @php
        $data = ['00000101', '00000102', '00000103', '00000104', '00000184', '00000185', '00000186'];
        $worker = DB::table('pro_employee_info')->whereNotIn('employee_id', $data)->where('valid', 1)->get();
        $m_project = DB::table('pro_projects')->where('valid', 1)->get();

    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rpt_summery_search') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                        <option value="">--Select Employee--</option>
                                        @foreach ($worker as $row)
                                            <option value="{{ $row->employee_id }}"
                                                {{ $row->employee_id == $employee_01 ? 'selected' : '' }}>
                                                {{ $row->employee_id }}|{{ $row->employee_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_employee_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_projet_id" id="cbo_projet_id" class="form-control">
                                        <option value="">--Select Project--</option>
                                        @foreach ($m_project as $row)
                                            <option value="{{ $row->project_id }}"
                                                {{ $row->project_id == $project_01 ? 'selected' : '' }}>
                                                {{ $row->project_id }}|{{ $row->project_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_projet_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" onfocus="(this.type='date')" value="{{ $form }}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" onfocus="(this.type='date')" value="{{ $to }}">
                                    @error('txt_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-8 col-sm-3 mb-2">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-9 mb-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>


                        </form>

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
                        <table id="service_data" class="table table-bordered table-striped table-sm">
                            <thead class="bg-primary">
                                <tr>
                                    <th style="width: 5%">SL</th>
                                    <th style="width: 5%">TASK ID#</th>
                                    <th style="width: 30%">TASK DESCRRIPTION</th>
                                    <th style="width: 15%">ASSIGN</th>
                                    <th style="width: 20%">CALL ATTEND TIME</th>
                                    <th style="width: 10%">STATUS</th>
                                    <th style="width: 10%">COMMENT</th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-light">
                                @php
                                    $txt_team_leader_name = '';
                                    //color
                                    $colore = 'red';
                                    $cl = 'taskblink';
                                    $assign_clor = '';
                                    $journy_color = '';
                                    //time
                                    $journey_start = '';
                                    $journey_end = '';
                                    $task_start_time = '';
                                    $task_finish_time = '';
                                    //description
                                    $comment = '';
                                    $i = 1;
                                @endphp
                                {{-- //Task Assign ->Red --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_assign_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->assign_by)
                                            ->first();
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->team_leader_id)
                                            ->first();
                                        if (isset($ci_employee_info)) {
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                        } else {
                                            $txt_team_leader_name = '';
                                        }

                                        $journey = DB::table('pro_journey')
                                            ->where('task_id', $row->task_id)
                                            ->orderByDesc('journey_id')
                                            ->first();

                                        //colore setup
                                        if (isset($journey)) {
                                            $cl = ''; //blink off

                                            if ($row->status == 'JOURNEY_STARTED') {
                                                $colore = 'FFA500';
                                            } elseif ($row->status == 'JOURNEY_END') {
                                                $colore = '#9400D3'; //belvoit
                                            } elseif ($row->status == 'TASK_ACTIVE') {
                                                $colore = '#808000'; //olive
                                            } elseif ($row->status == 'TASK_COMPLETED') {
                                                $colore = 'Green';
                                            } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                                $colore = 'Blue';
                                            } else {
                                                $colore = 'red';
                                            }
                                        } else {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //end if colore setup

                                        //Call attend time setup
                                        if (isset($journey)) {
                                            if (isset($journey->reached_date)) {
                                                $journey_end = "$journey->reached_date $journey->reached_time";
                                            } else {
                                                $journey_end = '';
                                            }

                                            if (isset($journey->start_journey_date)) {
                                                $journey_start = "$journey->start_journey_date $journey->start_journey_time";
                                            } else {
                                                $journey_start = '';
                                            }

                                            $task_start = DB::table('pro_work_start')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();

                                            if ($task_start) {
                                                $task_start_time = "$task_start->active_date $task_start->active_time";
                                            } else {
                                                $task_start_time = '';
                                            }

                                            $task_finish = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->where('status', 1)
                                                ->first();

                                            if (isset($task_finish)) {
                                                $task_finish_time = "$task_finish->complete_date $task_finish->complete_time";
                                            } else {
                                                $task_finish_time = '';
                                            }

                                            //start comment setup
                                            $finish_comment = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();
                                            if (isset($finish_comment)) {
                                                $comment =
                                                    $finish_comment->description == null
                                                        ? ''
                                                        : "$finish_comment->description";
                                            } else {
                                                $comment = '';
                                            }

                                            //End comment setup
                                        } else {
                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                        }
                                        //End call time setup
                                    @endphp
                                    @if ($row->status == null)
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->task_id }}</td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                <strong>
                                                    @if ($row->status == 'JOURNEY_STARTED')
                                                        {{ 'JOURNEY START' }}
                                                    @elseif ($row->status == 'JOURNEY_END')
                                                        {{ 'JOURNEY END' }}
                                                    @elseif ($row->status == 'TASK_ACTIVE')
                                                        {{ 'TASK ACTIVE' }}
                                                    @elseif ($row->status == 'TASK_COMPLETED')
                                                        {{ 'TASK FINISH' }}
                                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                                        {{ 'TASK PARTIAL COMPLITE' }}
                                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                                        {{ 'CANCEL TASK' }}
                                                    @else
                                                        {{ 'PENDING' }}
                                                    @endif
                                                </strong>
                                            </td>

                                            <td> {{ $comment }}</td>
                                            <td>
                                                @if (isset($row))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $row->task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                {{-- //Journey Start ->orange --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_assign_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->assign_by)
                                            ->first();
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->team_leader_id)
                                            ->first();
                                        if (isset($ci_employee_info)) {
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                        } else {
                                            $txt_team_leader_name = '';
                                        }

                                        $journey = DB::table('pro_journey')
                                            ->where('task_id', $row->task_id)
                                            ->orderByDesc('journey_id')
                                            ->first();

                                        //colore setup
                                        if (isset($journey)) {
                                            $cl = ''; //blink off

                                            if ($row->status == 'JOURNEY_STARTED') {
                                                $colore = '#F47203';
                                            } elseif ($row->status == 'JOURNEY_END') {
                                                $colore = '#9400D3'; //belvoit
                                            } elseif ($row->status == 'TASK_ACTIVE') {
                                                $colore = '#808000'; //olive
                                            } elseif ($row->status == 'TASK_COMPLETED') {
                                                $colore = 'Green';
                                            } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                                $colore = 'Blue';
                                            } else {
                                                $colore = 'red';
                                            }
                                        } else {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //end if colore setup

                                        //Call attend time setup
                                        if (isset($journey)) {
                                            if (isset($journey->reached_date)) {
                                                $journey_end = "$journey->reached_date $journey->reached_time";
                                            } else {
                                                $journey_end = '';
                                            }

                                            if (isset($journey->start_journey_date)) {
                                                $journey_start = "$journey->start_journey_date $journey->start_journey_time";
                                            } else {
                                                $journey_start = '';
                                            }

                                            $task_start = DB::table('pro_work_start')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();

                                            if ($task_start) {
                                                $task_start_time = "$task_start->active_date $task_start->active_time";
                                            } else {
                                                $task_start_time = '';
                                            }

                                            $task_finish = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->where('status', 1)
                                                ->first();

                                            if (isset($task_finish)) {
                                                $task_finish_time = "$task_finish->complete_date $task_finish->complete_time";
                                            } else {
                                                $task_finish_time = '';
                                            }

                                            //start comment setup
                                            $finish_comment = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();
                                            if (isset($finish_comment)) {
                                                $comment =
                                                    $finish_comment->description == null
                                                        ? ''
                                                        : "$finish_comment->description";
                                            } else {
                                                $comment = '';
                                            }

                                            //End comment setup
                                        } else {
                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                        }
                                        //End call time setup
                                    @endphp
                                    @if ($row->status == 'JOURNEY_STARTED')
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->task_id }}</td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                <strong>
                                                    @if ($row->status == 'JOURNEY_STARTED')
                                                        {{ 'JOURNEY START' }}
                                                    @elseif ($row->status == 'JOURNEY_END')
                                                        {{ 'JOURNEY END' }}
                                                    @elseif ($row->status == 'TASK_ACTIVE')
                                                        {{ 'TASK ACTIVE' }}
                                                    @elseif ($row->status == 'TASK_COMPLETED')
                                                        {{ 'TASK FINISH' }}
                                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                                        {{ 'TASK PARTIAL COMPLITE' }}
                                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                                        {{ 'CANCEL TASK' }}
                                                    @else
                                                        {{ 'PENDING' }}
                                                    @endif
                                                </strong>
                                            </td>

                                            <td> {{ $comment }}</td>
                                            <td>
                                                @if (isset($row))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $row->task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                {{-- //Journey End ->Belvoit --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_assign_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->assign_by)
                                            ->first();
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->team_leader_id)
                                            ->first();
                                        if (isset($ci_employee_info)) {
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                        } else {
                                            $txt_team_leader_name = '';
                                        }

                                        $journey = DB::table('pro_journey')
                                            ->where('task_id', $row->task_id)
                                            ->orderByDesc('journey_id')
                                            ->first();

                                        //colore setup
                                        if (isset($journey)) {
                                            $cl = ''; //blink off

                                            if ($row->status == 'JOURNEY_STARTED') {
                                                $colore = '#F47203';
                                            } elseif ($row->status == 'JOURNEY_END') {
                                                $colore = '#9400D3'; //belvoit
                                            } elseif ($row->status == 'TASK_ACTIVE') {
                                                $colore = '#808000'; //olive
                                            } elseif ($row->status == 'TASK_COMPLETED') {
                                                $colore = 'Green';
                                            } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                                $colore = 'Blue';
                                            } else {
                                                $colore = 'red';
                                            }
                                        } else {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //end if colore setup

                                        //Call attend time setup
                                        if (isset($journey)) {
                                            if (isset($journey->reached_date)) {
                                                $journey_end = "$journey->reached_date $journey->reached_time";
                                            } else {
                                                $journey_end = '';
                                            }

                                            if (isset($journey->start_journey_date)) {
                                                $journey_start = "$journey->start_journey_date $journey->start_journey_time";
                                            } else {
                                                $journey_start = '';
                                            }

                                            $task_start = DB::table('pro_work_start')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();

                                            if ($task_start) {
                                                $task_start_time = "$task_start->active_date $task_start->active_time";
                                            } else {
                                                $task_start_time = '';
                                            }

                                            $task_finish = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->where('status', 1)
                                                ->first();

                                            if (isset($task_finish)) {
                                                $task_finish_time = "$task_finish->complete_date $task_finish->complete_time";
                                            } else {
                                                $task_finish_time = '';
                                            }

                                            //start comment setup
                                            $finish_comment = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();
                                            if (isset($finish_comment)) {
                                                $comment =
                                                    $finish_comment->description == null
                                                        ? ''
                                                        : "$finish_comment->description";
                                            } else {
                                                $comment = '';
                                            }

                                            //End comment setup
                                        } else {
                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                        }
                                        //End call time setup
                                    @endphp
                                    @if ($row->status == 'JOURNEY_END')
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->task_id }}</td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                <strong>
                                                    @if ($row->status == 'JOURNEY_STARTED')
                                                        {{ 'JOURNEY START' }}
                                                    @elseif ($row->status == 'JOURNEY_END')
                                                        {{ 'JOURNEY END' }}
                                                    @elseif ($row->status == 'TASK_ACTIVE')
                                                        {{ 'TASK ACTIVE' }}
                                                    @elseif ($row->status == 'TASK_COMPLETED')
                                                        {{ 'TASK FINISH' }}
                                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                                        {{ 'TASK PARTIAL COMPLITE' }}
                                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                                        {{ 'CANCEL TASK' }}
                                                    @else
                                                        {{ 'PENDING' }}
                                                    @endif
                                                </strong>
                                            </td>

                                            <td> {{ $comment }}</td>
                                            <td>
                                                @if (isset($row))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $row->task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                {{-- //TASK_ACTIVE ->Olive --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_assign_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->assign_by)
                                            ->first();
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->team_leader_id)
                                            ->first();
                                        if (isset($ci_employee_info)) {
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                        } else {
                                            $txt_team_leader_name = '';
                                        }

                                        $journey = DB::table('pro_journey')
                                            ->where('task_id', $row->task_id)
                                            ->orderByDesc('journey_id')
                                            ->first();

                                        //colore setup
                                        if (isset($journey)) {
                                            $cl = ''; //blink off

                                            if ($row->status == 'JOURNEY_STARTED') {
                                                $colore = '#F47203';
                                            } elseif ($row->status == 'JOURNEY_END') {
                                                $colore = '#9400D3'; //belvoit
                                            } elseif ($row->status == 'TASK_ACTIVE') {
                                                $colore = '#808000'; //olive
                                            } elseif ($row->status == 'TASK_COMPLETED') {
                                                $colore = 'Green';
                                            } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                                $colore = 'Blue';
                                            } else {
                                                $colore = 'red';
                                            }
                                        } else {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //end if colore setup

                                        //Call attend time setup
                                        if (isset($journey)) {
                                            if (isset($journey->reached_date)) {
                                                $journey_end = "$journey->reached_date $journey->reached_time";
                                            } else {
                                                $journey_end = '';
                                            }

                                            if (isset($journey->start_journey_date)) {
                                                $journey_start = "$journey->start_journey_date $journey->start_journey_time";
                                            } else {
                                                $journey_start = '';
                                            }

                                            $task_start = DB::table('pro_work_start')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();

                                            if ($task_start) {
                                                $task_start_time = "$task_start->active_date $task_start->active_time";
                                            } else {
                                                $task_start_time = '';
                                            }

                                            $task_finish = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->where('status', 1)
                                                ->first();

                                            if (isset($task_finish)) {
                                                $task_finish_time = "$task_finish->complete_date $task_finish->complete_time";
                                            } else {
                                                $task_finish_time = '';
                                            }

                                            //start comment setup
                                            $finish_comment = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();
                                            if (isset($finish_comment)) {
                                                $comment =
                                                    $finish_comment->description == null
                                                        ? ''
                                                        : "$finish_comment->description";
                                            } else {
                                                $comment = '';
                                            }

                                            //End comment setup
                                        } else {
                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                        }
                                        //End call time setup
                                    @endphp
                                    @if ($row->status == 'TASK_ACTIVE')
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->task_id }}</td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                <strong>
                                                    @if ($row->status == 'JOURNEY_STARTED')
                                                        {{ 'JOURNEY START' }}
                                                    @elseif ($row->status == 'JOURNEY_END')
                                                        {{ 'JOURNEY END' }}
                                                    @elseif ($row->status == 'TASK_ACTIVE')
                                                        {{ 'TASK ACTIVE' }}
                                                    @elseif ($row->status == 'TASK_COMPLETED')
                                                        {{ 'TASK FINISH' }}
                                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                                        {{ 'TASK PARTIAL COMPLITE' }}
                                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                                        {{ 'CANCEL TASK' }}
                                                    @else
                                                        {{ 'PENDING' }}
                                                    @endif
                                                </strong>
                                            </td>

                                            <td> {{ $comment }}</td>
                                            <td>
                                                @if (isset($row))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $row->task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                               

                                {{-- //TASK_PARTIALLY_COMPLETED ->Blue --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_assign_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->assign_by)
                                            ->first();
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->team_leader_id)
                                            ->first();
                                        if (isset($ci_employee_info)) {
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                        } else {
                                            $txt_team_leader_name = '';
                                        }

                                        $journey = DB::table('pro_journey')
                                            ->where('task_id', $row->task_id)
                                            ->orderByDesc('journey_id')
                                            ->first();

                                        //colore setup
                                        if (isset($journey)) {
                                            $cl = ''; //blink off

                                            if ($row->status == 'JOURNEY_STARTED') {
                                                $colore = '#F47203';
                                            } elseif ($row->status == 'JOURNEY_END') {
                                                $colore = '#9400D3'; //belvoit
                                            } elseif ($row->status == 'TASK_ACTIVE') {
                                                $colore = '#808000'; //olive
                                            } elseif ($row->status == 'TASK_COMPLETED') {
                                                $colore = 'Green';
                                            } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                                $colore = 'Blue';
                                            } else {
                                                $colore = 'red';
                                            }
                                        } else {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //end if colore setup

                                        //Call attend time setup
                                        if (isset($journey)) {
                                            if (isset($journey->reached_date)) {
                                                $journey_end = "$journey->reached_date $journey->reached_time";
                                            } else {
                                                $journey_end = '';
                                            }

                                            if (isset($journey->start_journey_date)) {
                                                $journey_start = "$journey->start_journey_date $journey->start_journey_time";
                                            } else {
                                                $journey_start = '';
                                            }

                                            $task_start = DB::table('pro_work_start')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();

                                            if ($task_start) {
                                                $task_start_time = "$task_start->active_date $task_start->active_time";
                                            } else {
                                                $task_start_time = '';
                                            }

                                            $task_finish = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->where('status', 1)
                                                ->first();

                                            if (isset($task_finish)) {
                                                $task_finish_time = "$task_finish->complete_date $task_finish->complete_time";
                                            } else {
                                                $task_finish_time = '';
                                            }

                                            //start comment setup
                                            $finish_comment = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();
                                            if (isset($finish_comment)) {
                                                $comment =
                                                    $finish_comment->description == null
                                                        ? ''
                                                        : "$finish_comment->description";
                                            } else {
                                                $comment = '';
                                            }

                                            //End comment setup
                                        } else {
                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                        }
                                        //End call time setup
                                    @endphp
                                    @if ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->task_id }}</td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                <strong>
                                                    @if ($row->status == 'JOURNEY_STARTED')
                                                        {{ 'JOURNEY START' }}
                                                    @elseif ($row->status == 'JOURNEY_END')
                                                        {{ 'JOURNEY END' }}
                                                    @elseif ($row->status == 'TASK_ACTIVE')
                                                        {{ 'TASK ACTIVE' }}
                                                    @elseif ($row->status == 'TASK_COMPLETED')
                                                        {{ 'TASK FINISH' }}
                                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                                        {{ 'TASK PARTIAL COMPLITE' }}
                                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                                        {{ 'CANCEL TASK' }}
                                                    @else
                                                        {{ 'PENDING' }}
                                                    @endif
                                                </strong>
                                            </td>

                                            <td> {{ $comment }}</td>
                                            <td>
                                                @if (isset($row))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $row->task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                {{-- //TASK_COMPLETED ->Green --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_assign_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->assign_by)
                                            ->first();
                                        $ci_employee_info = DB::table('pro_employee_info')
                                            ->Where('employee_id', $row->team_leader_id)
                                            ->first();
                                        if (isset($ci_employee_info)) {
                                            $txt_team_leader_name = $ci_employee_info->employee_name;
                                        } else {
                                            $txt_team_leader_name = '';
                                        }

                                        $journey = DB::table('pro_journey')
                                            ->where('task_id', $row->task_id)
                                            ->orderByDesc('journey_id')
                                            ->first();

                                        //colore setup
                                        if (isset($journey)) {
                                            $cl = ''; //blink off

                                            if ($row->status == 'JOURNEY_STARTED') {
                                                $colore = '#F47203';
                                            } elseif ($row->status == 'JOURNEY_END') {
                                                $colore = '#9400D3'; //belvoit
                                            } elseif ($row->status == 'TASK_ACTIVE') {
                                                $colore = '#808000'; //olive
                                            } elseif ($row->status == 'TASK_COMPLETED') {
                                                $colore = 'Green';
                                            } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                                $colore = 'Blue';
                                            } else {
                                                $colore = 'red';
                                            }
                                        } else {
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //end if colore setup

                                        //Call attend time setup
                                        if (isset($journey)) {
                                            if (isset($journey->reached_date)) {
                                                $journey_end = "$journey->reached_date $journey->reached_time";
                                            } else {
                                                $journey_end = '';
                                            }

                                            if (isset($journey->start_journey_date)) {
                                                $journey_start = "$journey->start_journey_date $journey->start_journey_time";
                                            } else {
                                                $journey_start = '';
                                            }

                                            $task_start = DB::table('pro_work_start')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();

                                            if ($task_start) {
                                                $task_start_time = "$task_start->active_date $task_start->active_time";
                                            } else {
                                                $task_start_time = '';
                                            }

                                            $task_finish = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->where('status', 1)
                                                ->first();

                                            if (isset($task_finish)) {
                                                $task_finish_time = "$task_finish->complete_date $task_finish->complete_time";
                                            } else {
                                                $task_finish_time = '';
                                            }

                                            //start comment setup
                                            $finish_comment = DB::table('pro_work_end')
                                                ->where('task_id', $row->task_id)
                                                ->where('journey_id', $journey->journey_id)
                                                ->first();
                                            if (isset($finish_comment)) {
                                                $comment =
                                                    $finish_comment->description == null
                                                        ? ''
                                                        : "$finish_comment->description";
                                            } else {
                                                $comment = '';
                                            }

                                            //End comment setup
                                        } else {
                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                        }
                                        //End call time setup
                                    @endphp
                                    @if ($row->status == 'TASK_COMPLETED')
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->task_id }}</td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                <strong>
                                                    @if ($row->status == 'JOURNEY_STARTED')
                                                        {{ 'JOURNEY START' }}
                                                    @elseif ($row->status == 'JOURNEY_END')
                                                        {{ 'JOURNEY END' }}
                                                    @elseif ($row->status == 'TASK_ACTIVE')
                                                        {{ 'TASK ACTIVE' }}
                                                    @elseif ($row->status == 'TASK_COMPLETED')
                                                        {{ 'TASK FINISH' }}
                                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                                        {{ 'TASK PARTIAL COMPLITE' }}
                                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                                        {{ 'CANCEL TASK' }}
                                                    @else
                                                        {{ 'PENDING' }}
                                                    @endif
                                                </strong>
                                            </td>

                                            <td> {{ $comment }}</td>
                                            <td>
                                                @if (isset($row))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $row->task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $("#service_data").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 100,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection
