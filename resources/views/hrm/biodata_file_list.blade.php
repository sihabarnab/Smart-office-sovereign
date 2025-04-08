<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Picture</th>
                                <th>NID Front</th>
                                <th>NID Back</th>
                                <th>Birth certificate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $ci_employee_biodata=DB::table('pro_employee_biodata')
                            ->Where('employee_id',$emp_id)
                            ->Where('valid','1')
                            ->get();
                            // dd ($ci_employee_biodata);
                            @endphp
                            @foreach($ci_employee_biodata as $xy=>$row)
                           
                            <tr>
                                <td>{{ $xy+1 }}</td>
                                <td>
                                    @isset($row->emp_pic)
                                    <img align="left" src="{{ asset("$row->emp_pic") }}" alt="Pic" width="150" height="125">
                                    @endisset
                                </td>
                                <td>
                                    @isset($row->nid_front)
                                    <img align="left" src="{{ asset("$row->nid_front") }}" alt="Pic" width="150" height="125">
                                    @endisset
                                </td>
                                <td>
                                    @isset($row->nid_back)
                                    <img align="left" src="{{ asset("$row->nid_back") }}" alt="Pic" width="150" height="125">
                                    @endisset
                                </td>
                                <td>
                                    @isset($row->bc_img)
                                    <img align="left" src="{{ asset("$row->bc_img") }}" alt="Pic" width="150" height="125">
                                    @endisset
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
