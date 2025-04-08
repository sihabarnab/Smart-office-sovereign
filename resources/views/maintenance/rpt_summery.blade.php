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
                        <form action="{{ route('rpt_mt_summery_search') }}" method="GET">
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

    @if(isset($m_task_register))

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="maintenance_data"  class="table table-bordered table-striped table-sm ">
                            <thead class="bg-primary">
                                <tr>
                                    <th style="width: 5%">SL</th>
                                    <th style="width: 5%">TASK ID#</th>
                                    <th style="width: 30%">TASK DESCRRIPTION</th>
                                    <th style="width: 15%">CALL BACK</th>
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
                                    $quotaion_comment = '';
                                    $i=1;
                                @endphp

                                {{-- //task register ->red --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = '#FFA500'; //orange
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'Blue';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500';
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                    @else
                                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $task_id }} </td>
                                            <td>
                                                <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                <strong> Project: </strong> {{ $row->project_name }}.
                                            </td>
                                            <td>
                                                <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}. <br>
                                                <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                <strong> Time: </strong> {{ $row->entry_time }}
                                            </td>
                                            <td>
                                                <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                <strong> Time: </strong> {{ $task_entry_time }}
                                            </td>
                                            <td style="color:{{ $journy_color }}">

                                                <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                        <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                        <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                        <strong> Task Finish: </strong>{{ $task_finish_time }}
                                            </td>
                                            <td>
                                                @if (isset($m_task_assign))
                                                    <strong>
                                                        @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                            {{ 'JOURNEY START' }}
                                                        @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                            {{ 'JOURNEY END' }}
                                                        @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                            {{ 'TASK ACTIVE' }}
                                                        @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                            {{ 'TASK FINISH' }}
                                                        @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                            {{ 'TASK PARTIAL COMPLITE' }}
                                                        @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                            {{ 'CANCEL TASK' }}
                                                        @else
                                                            {{ 'PENDING' }}
                                                        @endif
                                                    </strong>
                                                @else
                                                    <strong>
                                                        {{ 'PENDING' }}
                                                    </strong>
                                                @endif

                                            </td>

                                            <td>

                                                {{ $comment }} <br>

                                                {{ $quotaion_comment }}

                                            </td>
                                            <td>
                                                @if (isset($m_task_assign))
                                                    <a target="__blanck"
                                                        href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                {{-- //task Assign ->orange --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = '#FFA500'; //orange
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'Blue';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500';
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                        @if (isset($m_task_assign) && $m_task_assign->status == null)
                                            <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $task_id }} </td>
                                                <td>
                                                    <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                    <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                    <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                    <strong> Project: </strong> {{ $row->project_name }}.
                                                </td>
                                                <td>
                                                    <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}.
                                                    <br>
                                                    <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                    <strong> Time: </strong> {{ $row->entry_time }}
                                                </td>
                                                <td>
                                                    <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                    <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                    <strong> Time: </strong> {{ $task_entry_time }}
                                                </td>
                                                <td style="color:{{ $journy_color }}">

                                                    <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                            <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                            <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                            <strong> Task Finish: </strong>{{ $task_finish_time }}
                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <strong>
                                                            @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                                {{ 'JOURNEY START' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                                {{ 'JOURNEY END' }}
                                                            @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                                {{ 'TASK ACTIVE' }}
                                                            @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                                {{ 'TASK FINISH' }}
                                                            @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                                {{ 'TASK PARTIAL COMPLITE' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                                {{ 'CANCEL TASK' }}
                                                            @else
                                                                {{ 'PENDING' }}
                                                            @endif
                                                        </strong>
                                                    @else
                                                        <strong>
                                                            {{ 'PENDING' }}
                                                        </strong>
                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $comment }} <br>

                                                    {{ $quotaion_comment }}

                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <a target="__blanck"
                                                            href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                                {{-- //Journey start ->blue  --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = 'blue'; //blue
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'Blue';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500'; //orange
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                        @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                            <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $task_id }} </td>
                                                <td>
                                                    <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                    <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                    <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                    <strong> Project: </strong> {{ $row->project_name }}.
                                                </td>
                                                <td>
                                                    <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}.
                                                    <br>
                                                    <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                    <strong> Time: </strong> {{ $row->entry_time }}
                                                </td>
                                                <td>
                                                    <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                    <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                    <strong> Time: </strong> {{ $task_entry_time }}
                                                </td>
                                                <td style="color:{{ $journy_color }}">

                                                    <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                            <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                            <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                            <strong> Task Finish: </strong>{{ $task_finish_time }}
                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <strong>
                                                            @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                                {{ 'JOURNEY START' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                                {{ 'JOURNEY END' }}
                                                            @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                                {{ 'TASK ACTIVE' }}
                                                            @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                                {{ 'TASK FINISH' }}
                                                            @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                                {{ 'TASK PARTIAL COMPLITE' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                                {{ 'CANCEL TASK' }}
                                                            @else
                                                                {{ 'PENDING' }}
                                                            @endif
                                                        </strong>
                                                    @else
                                                        <strong>
                                                            {{ 'PENDING' }}
                                                        </strong>
                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $comment }} <br>

                                                    {{ $quotaion_comment }}

                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <a target="__blanck"
                                                            href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                                {{-- //Journey End ->belvoiet --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = '#FFA500'; //orange
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'Blue';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500';
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                        @if ($m_task_assign->status == 'JOURNEY_END')
                                            <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $task_id }} </td>
                                                <td>
                                                    <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                    <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                    <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                    <strong> Project: </strong> {{ $row->project_name }}.
                                                </td>
                                                <td>
                                                    <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}.
                                                    <br>
                                                    <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                    <strong> Time: </strong> {{ $row->entry_time }}
                                                </td>
                                                <td>
                                                    <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                    <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                    <strong> Time: </strong> {{ $task_entry_time }}
                                                </td>
                                                <td style="color:{{ $journy_color }}">

                                                    <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                            <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                            <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                            <strong> Task Finish: </strong>{{ $task_finish_time }}
                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <strong>
                                                            @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                                {{ 'JOURNEY START' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                                {{ 'JOURNEY END' }}
                                                            @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                                {{ 'TASK ACTIVE' }}
                                                            @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                                {{ 'TASK FINISH' }}
                                                            @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                                {{ 'TASK PARTIAL COMPLITE' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                                {{ 'CANCEL TASK' }}
                                                            @else
                                                                {{ 'PENDING' }}
                                                            @endif
                                                        </strong>
                                                    @else
                                                        <strong>
                                                            {{ 'PENDING' }}
                                                        </strong>
                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $comment }} <br>

                                                    {{ $quotaion_comment }}

                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <a target="__blanck"
                                                            href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                                {{-- //Task Active ->olive --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = '#FFA500'; //orange
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'Blue';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500';
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                        @if ($m_task_assign->status == 'TASK_ACTIVE')
                                            <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $task_id }} </td>
                                                <td>
                                                    <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                    <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                    <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                    <strong> Project: </strong> {{ $row->project_name }}.
                                                </td>
                                                <td>
                                                    <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}.
                                                    <br>
                                                    <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                    <strong> Time: </strong> {{ $row->entry_time }}
                                                </td>
                                                <td>
                                                    <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                    <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                    <strong> Time: </strong> {{ $task_entry_time }}
                                                </td>
                                                <td style="color:{{ $journy_color }}">

                                                    <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                            <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                            <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                            <strong> Task Finish: </strong>{{ $task_finish_time }}
                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <strong>
                                                            @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                                {{ 'JOURNEY START' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                                {{ 'JOURNEY END' }}
                                                            @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                                {{ 'TASK ACTIVE' }}
                                                            @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                                {{ 'TASK FINISH' }}
                                                            @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                                {{ 'TASK PARTIAL COMPLITE' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                                {{ 'CANCEL TASK' }}
                                                            @else
                                                                {{ 'PENDING' }}
                                                            @endif
                                                        </strong>
                                                    @else
                                                        <strong>
                                                            {{ 'PENDING' }}
                                                        </strong>
                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $comment }} <br>

                                                    {{ $quotaion_comment }}

                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <a target="__blanck"
                                                            href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                                {{-- // TASK_PARTIALLY_COMPLETED ->black --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = '#FFA500'; //orange
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'black';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500';
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                        @if ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                            <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $task_id }} </td>
                                                <td>
                                                    <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                    <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                    <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                    <strong> Project: </strong> {{ $row->project_name }}.
                                                </td>
                                                <td>
                                                    <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}.
                                                    <br>
                                                    <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                    <strong> Time: </strong> {{ $row->entry_time }}
                                                </td>
                                                <td>
                                                    <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                    <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                    <strong> Time: </strong> {{ $task_entry_time }}
                                                </td>
                                                <td style="color:{{ $journy_color }}">

                                                    <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                            <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                            <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                            <strong> Task Finish: </strong>{{ $task_finish_time }}
                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <strong>
                                                            @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                                {{ 'JOURNEY START' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                                {{ 'JOURNEY END' }}
                                                            @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                                {{ 'TASK ACTIVE' }}
                                                            @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                                {{ 'TASK FINISH' }}
                                                            @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                                {{ 'TASK PARTIAL COMPLITE' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                                {{ 'CANCEL TASK' }}
                                                            @else
                                                                {{ 'PENDING' }}
                                                            @endif
                                                        </strong>
                                                    @else
                                                        <strong>
                                                            {{ 'PENDING' }}
                                                        </strong>
                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $comment }} <br>

                                                    {{ $quotaion_comment }}

                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <a target="__blanck"
                                                            href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                                {{-- // TASK_COMPLETED ->Green --}}
                                @foreach ($m_task_register as $key => $row)
                                    @php
                                        $task_prefar_by = DB::table('pro_employee_info')
                                            ->where('employee_id', $row->user_id)
                                            ->first();

                                        $m_task_assign = DB::table('pro_task_assign')
                                            ->where('complain_id', $row->complaint_register_id)
                                            ->first();

                                        if (isset($m_task_assign)) {
                                            $task_id = $m_task_assign->task_id;
                                            if ($m_task_assign->user_id) {
                                                $task_assign = DB::table('pro_employee_info')
                                                    ->where('employee_id', $m_task_assign->user_id)
                                                    ->first();
                                                $task_assign_by = $task_assign->employee_name;
                                                $task_entry_date = $m_task_assign->entry_date;
                                                $task_entry_time = $m_task_assign->entry_time;
                                            } else {
                                                $task_assign_by = '';
                                                $task_entry_date = '';
                                                $task_entry_time = '';
                                            }

                                            //leader name
                                            $ci_employee_info = DB::table('pro_employee_info')
                                                ->Where('employee_id', $m_task_assign->team_leader_id)
                                                ->first();
                                            if (isset($ci_employee_info)) {
                                                $txt_team_leader_name = $ci_employee_info->employee_name;
                                            } else {
                                                $txt_team_leader_name = '';
                                            }

                                            //journey
                                            $journey = DB::table('pro_journey')
                                                ->where('task_id', $task_id)
                                                ->orderByDesc('journey_id')
                                                ->first();

                                            //colore setup
                                            if (isset($journey)) {
                                                $cl = ''; //blink off

                                                if ($m_task_assign->status == 'JOURNEY_STARTED') {
                                                    $colore = '#FFA500'; //orange
                                                } elseif ($m_task_assign->status == 'JOURNEY_END') {
                                                    $colore = '#9400D3'; //belvoit
                                                } elseif ($m_task_assign->status == 'TASK_ACTIVE') {
                                                    $colore = '#808000'; //olive
                                                } elseif ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED') {
                                                    $colore = 'white';
                                                } else {
                                                    $colore = 'red';
                                                }
                                            } else {
                                                if ($m_task_assign->status == 'TASK_COMPLETED') {
                                                    $colore = 'Green';
                                                } else {
                                                    $colore = '#FFA500';
                                                }
                                                $cl = '';
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();

                                                if ($task_start) {
                                                    $task_start_time = "$task_start->active_date $task_start->active_time";
                                                } else {
                                                    $task_start_time = '';
                                                }

                                                $task_finish = DB::table('pro_work_end')
                                                    ->where('task_id', $task_id)
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
                                                    ->where('task_id', $task_id)
                                                    ->where('journey_id', $journey->journey_id)
                                                    ->first();
                                                if (isset($finish_comment)) {
                                                    $comment =
                                                        $finish_comment->description == null
                                                            ? ''
                                                            : "$finish_comment->description";
                                                    $quotaion_comment =
                                                        $finish_comment->quotation_status == null
                                                            ? ''
                                                            : "$finish_comment->quotation_status";
                                                } else {
                                                    //without Journey
                                                    $ober_phone_comment = DB::table('pro_work_end')
                                                        ->where('task_id', $task_id)
                                                        ->first();
                                                    if (isset($ober_phone_comment)) {
                                                        $comment =
                                                            $ober_phone_comment->description == null
                                                                ? ''
                                                                : "$ober_phone_comment->description";
                                                    } else {
                                                        $comment = '';
                                                    }

                                                    $quotaion_comment = '';
                                                }

                                                //End comment setup
                                            } else {
                                                $journey_start = '';
                                                $journey_end = '';
                                                $task_start_time = '';
                                                $task_finish_time = '';
                                                //description
                                                $comment = '';
                                                $quotaion_comment = '';
                                            }
                                            //End call time setup
                                        } else {
                                            $task_id = '';
                                            $task_assign_by = '';
                                            $task_entry_date = '';
                                            $task_entry_time = '';
                                            $txt_team_leader_name = '';

                                            $journey_start = '';
                                            $journey_end = '';
                                            $task_start_time = '';
                                            $task_finish_time = '';
                                            //description
                                            $comment = '';
                                            $quotaion_comment = '';
                                            //colore
                                            $colore = 'red';
                                            $cl = 'taskblink';
                                            $assign_clor = '';
                                            $journy_color = '';
                                        }
                                        //End Task setup
                                    @endphp
                                    @if (isset($m_task_assign))
                                        @if ($m_task_assign->status == 'TASK_COMPLETED')
                                            <tr class="{{ $cl }}" style="color: {{ $colore }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $task_id }} </td>
                                                <td>
                                                    <strong> Complain: </strong> {{ $row->complaint_description }}. <br>
                                                    <strong> Leader: </strong> {{ $txt_team_leader_name }}.<br>
                                                    <strong> Customer: </strong> {{ $row->customer_name }}. <br>
                                                    <strong> Project: </strong> {{ $row->project_name }}.
                                                </td>
                                                <td>
                                                    <strong> Prefer by: </strong> {{ $task_prefar_by->employee_name }}.
                                                    <br>
                                                    <strong> Date: </strong> {{ $row->entry_date }} <br>
                                                    <strong> Time: </strong> {{ $row->entry_time }}
                                                </td>
                                                <td>
                                                    <strong> Assign by: </strong> {{ $task_assign_by }}. <br>
                                                    <strong> Date: </strong> {{ $task_entry_date }} <br>
                                                    <strong> Time: </strong> {{ $task_entry_time }}
                                                </td>
                                                <td style="color:{{ $journy_color }}">

                                                    <strong> Journey Start: <strong> {{ $journey_start }} <br>
                                                            <strong> Journey End: </strong> {{ $journey_end }} <br>
                                                            <strong> Task Start: </strong>{{ $task_start_time }} <br>
                                                            <strong> Task Finish: </strong>{{ $task_finish_time }}
                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <strong>
                                                            @if ($m_task_assign->status == 'JOURNEY_STARTED')
                                                                {{ 'JOURNEY START' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_END')
                                                                {{ 'JOURNEY END' }}
                                                            @elseif ($m_task_assign->status == 'TASK_ACTIVE')
                                                                {{ 'TASK ACTIVE' }}
                                                            @elseif ($m_task_assign->status == 'TASK_COMPLETED')
                                                                {{ 'TASK FINISH' }}
                                                            @elseif ($m_task_assign->status == 'TASK_PARTIALLY_COMPLETED')
                                                                {{ 'TASK PARTIAL COMPLITE' }}
                                                            @elseif ($m_task_assign->status == 'JOURNEY_FAILED')
                                                                {{ 'CANCEL TASK' }}
                                                            @else
                                                                {{ 'PENDING' }}
                                                            @endif
                                                        </strong>
                                                    @else
                                                        <strong>
                                                            {{ 'PENDING' }}
                                                        </strong>
                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $comment }} <br>

                                                    {{ $quotaion_comment }}

                                                </td>
                                                <td>
                                                    @if (isset($m_task_assign))
                                                        <a target="__blanck"
                                                            href="{{ route('rpt_task_view', $task_id) }}">More</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
@endsection


@section('script')
<script>
    $(function() {
        $("#maintenance_data").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 100,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');

    });
</script>
@endsection