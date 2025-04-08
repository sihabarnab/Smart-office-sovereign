<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Lift Name</th>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lifts as $key => $lift)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $lift->lift_name }}</td>
                                    <td>{{ $lift->project_name }}</td>
                                    <td>{{ $lift->remark }}</td>
                                    <td>
                                        <a href="{{ route('mech_lift_info_edit', $lift->lift_id) }}"class="btn btn-info btn-sm"><i
                                                class="fas fa-edit"></i>
                                        </a>
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
