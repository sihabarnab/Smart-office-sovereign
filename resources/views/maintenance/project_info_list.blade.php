<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Project Name</th>
                                <th>Client Name</th>
                                <th>Project Address</th>
                                <th>Lift Quantity</th>
                                <th>Contact Date</th>
                                <th>Install Date</th>
                                <th>Handover Date</th>
                                <th>Warranty</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $key=>$project)
                                <tr>
                                    <td >{{ $key+1 }}</td>
                                    <td >{{ $project->project_name }}</td>
                                    <td >{{ $project->customer_name }} </td>
                                    <td >{{ $project->project_address }}</td>
                                    <td >{{ $project->pro_lift_quantity }}</td>
                                    <td >{{ $project->contact_date }}</td>
                                    <td >{{ $project->installation_date }}</td>
                                    <td >{{ $project->handover_date }}</td>
                                    <td >{{ $project->warranty }}</td>
                                    <td>
                                        <a href="{{route('mt_project_info_edit',$project->project_id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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