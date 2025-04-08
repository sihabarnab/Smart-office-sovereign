<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="card-title"></h3> --}}
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Project Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($fund_requisition_project as $key=>$row)
                            @php
                                 $m_projects = DB::table('pro_projects')->where('project_id',$row->project_id)->first();
                                 $project_name = $m_projects->project_name
                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $project_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
