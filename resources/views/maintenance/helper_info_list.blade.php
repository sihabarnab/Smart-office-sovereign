<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SI NO</th>
                                <th>Team/Leader Name</th>
                                <th>Helper Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($helpers as $key => $helper)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @php
                                            $leader = DB::table('pro_employee_info')
                                                ->where('employee_id', $helper->team_leader_id)
                                                // ->where('valid',1)
                                                ->first();
                                        @endphp
                                        {{ $helper->team_name }} | {{ $leader->employee_name }}
                                    </td>
                                    <td>{{ $helper->employee_name }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
