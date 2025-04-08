@php
    $helper_list = DB::table('pro_helpers')
        ->where('task_id', $mt_task_assign->task_id)
        ->where('valid',1)
        ->get();
    
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SI NO</th>
                                <th>Team/Leader Name</th>
                                <th>Helper Name</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($helper_list as $key => $helper)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @php
                                            $leader = DB::table('pro_employee_info')
                                                ->where('employee_id', $helper->team_leader_id)
                                                ->first();
                                            $helper_name = DB::table('pro_employee_info')
                                                ->where('employee_id', $helper->helper_id)
                                                ->first();
                                        @endphp
                                         {{ $leader->employee_name }}
                                    </td>
                                    <td>{{ $helper_name->employee_name }}</td>
                                    <td><a href="{{route('elc_edit_helper',$helper->id)}}">Edit</a></td>
                                    <td><a href="{{route('elc_remove_helper',$helper->id)}}">Remove</a></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
