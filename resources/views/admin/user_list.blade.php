<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Company Name<br />Employee ID<br />Name</th>
                                <th>Designation<br />Department<br />Posting</th>
                                <th>Mobile<br>PSM ID</th>
                                <th>Valid</th>
                                <th>ACTION</th>
                                <th>Permission</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $key=>$row)
                            @php

                            $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->emp_id)->first();
                            $txt_employee_name=$ci_employee_info->employee_name;


                            $ci_company=DB::table('pro_company')->Where('company_id',$ci_employee_info->company_id)->first();
                            $txt_company_name=$ci_company->company_name;

                            $ci_desig=DB::table('pro_desig')->Where('desig_id',$ci_employee_info->desig_id)->first();
                            $txt_desig_name=$ci_desig->desig_name;

                            $ci_department=DB::table('pro_department')->Where('department_id',$ci_employee_info->department_id)->first();
                            $txt_department_name=$ci_department->department_name;

                            $ci_section=DB::table('pro_section')->Where('section_id',$ci_employee_info->section_id)->first();
                            $txt_section_name=$ci_section->section_name;

                            $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_employee_info->placeofposting_id)->first();
                            $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

                            $ci_yesno=DB::table('pro_yesno')->Where('yesno_id',$row->valid)->first();
                            $txt_yesno_name=$ci_yesno->yesno_name;

                            // if ($ci_employee_info->psm_id == '')
                            // {
                            //     $txt_psm_id='N/A';
                            // } else {
                            //     $txt_psm_id=$ci_employee_info->psm_id;
                            // }

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_company_name }}<BR>{{ $row->emp_id }}<BR>{{ $txt_employee_name }}</td>
                                <td>{{ $txt_desig_name }}<BR>{{ $txt_department_name }}<BR>{{ $txt_placeofposting_name }}</td>
                                <td>{{ $ci_employee_info->mobile }}</td>
                                <td>{{ $txt_yesno_name }}</td>
                                <td>
                                    <a href="{{ route('admincuseredit',$row->emp_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admincuser_permission',$row->emp_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
