@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task Details</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @php
        $ci_customers = DB::table('pro_customers')
            ->Where('customer_id', $mt_task_assign->customer_id)
            ->first();
        $txt_customer_name = $ci_customers->customer_name;

        $ci_projects = DB::table('pro_projects')
            ->Where('project_id', $mt_task_assign->project_id)
            ->first();
        $txt_project_name = $ci_projects->project_name;

        $ci_complain = DB::table('pro_complaint_register')
            ->Where('complaint_register_id', $mt_task_assign->complain_id)
            ->first();

        $ci_lifts = DB::table('pro_lifts')
            ->Where('lift_id', $mt_task_assign->lift_id)
            ->first();
        $txt_lift_name = $ci_lifts->lift_name;
        $txt_lift_remark = $ci_lifts->remark;

        $ci_teams = DB::table('pro_teams')
            ->Where('team_id', $mt_task_assign->team_id)
            ->first();
        $txt_team_name = $ci_teams->team_name;

        $ci_employee_info = DB::table('pro_employee_info')
            ->Where('employee_id', $mt_task_assign->team_leader_id)
            ->first();
        $txt_team_leader_name = $ci_employee_info->employee_name;

        $journy = DB::table('pro_journey')
            ->where('task_id', $mt_task_assign->task_id)
            ->get();

        $helper = DB::table('pro_helpers')
            ->leftjoin('pro_employee_info', 'pro_helpers.helper_id', 'pro_employee_info.employee_id')
            ->select('pro_employee_info.employee_name')
            ->where('pro_helpers.task_id', $mt_task_assign->task_id)
            ->where('pro_helpers.valid', 1)
            ->get();

        $img_url = 'https://sovereign.shahrier.com/';
        // $img_url='https://103.78.54.174/smartoffice/';
        // $img_url = 'http://localhost/smartoffice_sovereign/';
    @endphp



    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4">Client</div>
                            <div class="col-4">Project</div>
                            <div class="col-4">Lift</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">{{ $txt_customer_name }}.</div>
                            <div class="col-4">{{ $txt_project_name }}.</div>
                            <div class="col-4">
                                {{-- {{ $ci_complain->complaint_description ? $ci_complain->complaint_description : '' }} | --}}
                                {{ $txt_lift_name }}.</div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                Complain :
                                {{ $ci_complain->complaint_description ? $ci_complain->complaint_description : '' }}.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                Team : {{ $txt_team_leader_name . '(L)' }}
                                @foreach ($helper as $value)
                                    {{ ',' . $value->employee_name }}
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>


                @foreach ($journy as $row)
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h2 class="text-center">Task Status</h2>
                                    <h6 class="text-center"> Date : {{ $row->start_journey_date }}, Time :
                                        {{ $row->start_journey_time }}</h6>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">Start Journey <br> {{ $row->start_journey_date }}
                                    {{ $row->start_journey_time }}</div>
                                <div class="col-4">
                                    End Journey <br>
                                    @isset($row->reached_date)
                                        {{ $row->reached_date }} {{ $row->reached_time }}
                                    @endisset
                                </div>
                                <div class="col-2">Transport Type</div>
                                <div class="col-2">Fare</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <button type="button"
                                        onclick="showmap('{{ $row->start_journey_lat }}','{{ $row->start_journey_long }}')"
                                        class="btn btn-primary" data-toggle="modal"
                                        data-target=".bd-example-modal-lg">Map</button>
                                </div>
                                <div class="col-4">
                                    <button type="button"
                                        onclick="showmap('{{ $row->reached_lat }}','{{ $row->reached_long }}')"
                                        class="btn btn-primary" data-toggle="modal"
                                        data-target=".bd-example-modal-lg">Map</button>
                                </div>
                                <div class="col-2">{{ $row->transport_type }}</div>
                                <div class="col-2">{{ $row->reached_fare }}</div>
                            </div>
                            @php
                                $work_start = DB::table('pro_work_start')
                                    ->where('task_id', $row->task_id)
                                    ->where('journey_id', $row->journey_id)
                                    ->first();
                            @endphp


                            @if (isset($work_start))
                                <div class="row mb-1">
                                    <div class="col-12">
                                        <h2 class="text-center">Start Task </h2>
                                        <h6 class="text-center"> Date : {{ $work_start->active_date }}, Time :
                                            {{ $work_start->active_time }}</h6>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-1"></div>
                                    <div class="col-10 d-flex justify-content-center">

                                        <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                            onclick="showimg('{{ $img_url . $work_start->image_1 }}')">
                                            <img src="{{ $img_url . $work_start->image_1 }}" alt="" width="150px"
                                                height="150px">&nbsp;
                                        </a>
                                        <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                            onclick="showimg('{{ $img_url . $work_start->image_2 }}')">
                                            <img src="{{ $img_url . $work_start->image_2 }}" alt="" width="150px"
                                                height="150px">&nbsp;
                                        </a>
                                        @if ($work_start->image_3)
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $work_start->image_3 }}')">
                                                <img src="{{ $img_url . $work_start->image_3 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                        @endif
                                        @if ($work_start->image_4)
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $work_start->image_4 }}')">
                                                <img src="{{ $img_url . $work_start->image_4 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                        @endif
                                        @if ($work_start->image_5)
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $work_start->image_5 }}')">
                                                <img src="{{ $img_url . $work_start->image_5 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            @endif


                            @php
                                $task_complite = DB::table('pro_work_end')
                                    ->where('task_id', $row->task_id)
                                    ->where('journey_id', $row->journey_id)
                                    ->first();
                                if (isset($task_complite)) {
                                    $quotaion_comment =
                                        $task_complite->quotation_status == null
                                            ? ''
                                            : "$task_complite->quotation_status";
                                } else {
                                    $quotaion_comment = '';
                                }
                            @endphp

                            @if (isset($task_complite))
                                @if ($task_complite->complete_date)
                                    <div class="row mb-1">
                                        <div class="col-12">
                                            <h2 class="text-center">Complete Task </h2>
                                            <h6 class="text-center"> Date: {{ $task_complite->complete_date }}, Time:
                                                {{ $task_complite->complete_time }}</h6>
                                            <h6 class="text-center"> Comment: {{ $quotaion_comment }}</h6>


                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-1"></div>
                                        <div class="col-10 d-flex justify-content-center">
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $task_complite->image_1 }}')">
                                                <img src="{{ $img_url . $task_complite->image_1 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $task_complite->image_2 }}')">
                                                <img src="{{ $img_url . $task_complite->image_2 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                            @if ($task_complite->image_3)
                                                <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                    onclick="showimg('{{ $img_url . $task_complite->image_3 }}')">
                                                    <img src="{{ $img_url . $task_complite->image_3 }}" alt=""
                                                        width="150px" height="150px">&nbsp;
                                                </a>
                                            @endif
                                            @if ($task_complite->image_4)
                                                <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                    onclick="showimg('{{ $img_url . $task_complite->image_4 }}')">
                                                    <img src="{{ $img_url . $task_complite->image_4 }}" alt=""
                                                        width="150px" height="150px">&nbsp;
                                                </a>
                                            @endif
                                            @if ($task_complite->image_5)
                                                <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                    onclick="showimg('{{ $img_url . $task_complite->image_5 }}')">
                                                    <img src="{{ $img_url . $task_complite->image_5 }}" alt=""
                                                        width="150px" height="150px">&nbsp;
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <h3 class="text-center"> Feedback </h3>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-6 d-flex justify-content-center">
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $task_complite->feedback }}')">
                                                <img src="{{ $img_url . $task_complite->feedback }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                        </div>
                                        <div class="col-3"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-left">{{ $task_complite->description }}</h6>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-1">
                                        <div class="col-12">
                                            <h2 class="text-center"> Partially Complete</h2>
                                            <h6 class="text-center"> Date: {{ $task_complite->incomplete_date }}, Time:
                                                {{ $task_complite->incomplete_time }} </h6>
                                            <h6 class="text-center">{{ $task_complite->description }}</h6>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-1"></div>
                                        <div class="col-10 d-flex justify-content-center">
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $task_complite->image_1 }}')">
                                                <img src="{{ $img_url . $task_complite->image_1 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                            <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                onclick="showimg('{{ $img_url . $task_complite->image_2 }}')">
                                                <img src="{{ $img_url . $task_complite->image_2 }}" alt=""
                                                    width="150px" height="150px">&nbsp;
                                            </a>
                                            @if ($task_complite->image_3)
                                                <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                    onclick="showimg('{{ $img_url . $task_complite->image_3 }}')">
                                                    <img src="{{ $img_url . $task_complite->image_3 }}" alt=""
                                                        width="150px" height="150px">&nbsp;
                                                </a>
                                            @endif
                                            @if ($task_complite->image_4)
                                                <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                    onclick="showimg('{{ $img_url . $task_complite->image_4 }}')">
                                                    <img src="{{ $img_url . $task_complite->image_4 }}" alt=""
                                                        width="150px" height="150px">&nbsp;
                                                </a>
                                            @endif
                                            @if ($task_complite->image_5)
                                                <a class="btn" data-toggle="modal" data-target=".bd-example-modal-lg2"
                                                    onclick="showimg('{{ $img_url . $task_complite->image_5 }}')">
                                                    <img src="{{ $img_url . $task_complite->image_5 }}" alt=""
                                                        width="150px" height="150px">&nbsp;
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                @endif
                            @endif


                        </div>
                    </div>
                @endforeach




                {{-- Map Show Modal  --}}
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Location</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <iframe id="ifrm" width="100%" height="430" frameborder="0" scrolling="no"
                                    marginheight="0" marginwidth="0" src=''>
                                </iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end modal  --}}

                {{-- Image Show Modal  --}}
                <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">

                        <div class="modal-body">
                            <img src="" alt="" width="100%" height="500" id="show_image">
                        </div>
                    </div>
                </div>
                {{-- end modal  --}}


            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        function showmap(x, y) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#ifrm').attr('src', '')
            var mapUrl = 'https://maps.google.com/maps?q=' + x + ',' + y + '&output=embed';
            $('#ifrm').attr('src', mapUrl)
        }

        function showimg(img) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#show_image').attr('src', img)
        }
    </script>
@endsection
