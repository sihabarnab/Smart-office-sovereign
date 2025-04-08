<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Team Name</th>
                                <th>Team Leader Name</th>
                                <th>Department</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as  $key=>$team)
                                <tr>
                                    <td >{{ $key+1 }}</td>
                                    <td>{{ $team->team_name }}</td>
                                    <td>{{ $team->team_leader_id }}|{{ $team->employee_name }}</td>
                                    <td>{{ $team->department_name }}</td>
                                    <td>
                                        <a href="{{ route('TeamInfoEdit', $team->team_id) }}"class="btn btn-info btn-sm"><i
                                                class="fas fa-pencil-alt"></i></a>
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