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
                                <th>Company Name<br />Employee ID/Name</th>
                                <th>Designation/Department<br />Posting</th>
                                <th>Joining Date/Policy/Working<br />Mobile/Blood Group/PSM ID</th>
                                <th>Report To</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach($user_company as $xy=>$row_company)
                            {{-- {{ $row_company->company_id}} --}}

                            @php

                            $ci_employee_info_01=DB::table('pro_employee_info')
                            ->Where('company_id',$row_company->company_id)
                            ->Where('working_status','1')
                            ->Where('valid','1')
                            ->get();

                            @endphp

                            @foreach($ci_employee_info_01 as $key=>$row_basic_info)

                            @php

                            $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row_basic_info->employee_id)->first();
                            //$aa='yyyy';
                            $txt_joinning_date=date("d-m-Y",strtotime("$ci_employee_info->joinning_date"));

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

                            $ci_blood=DB::table('pro_blood')->Where('blood_id',$ci_employee_info->blood_group)->first();
                            $txt_blood_name=$ci_blood->blood_name;

                            $ci_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$ci_employee_info->att_policy_id)->first();
                            $txt_att_policy_name=$ci_att_policy->att_policy_name;

                            $ci_yesno=DB::table('pro_yesno')->Where('yesno_id',$ci_employee_info->working_status)->first();
                            $txt_yesno_name=$ci_yesno->yesno_name;

                            if ($ci_employee_info->report_to_id == '0000000')
                            {
                                $txt_report_name='N/A';
                            } else {
                                $ci_employee_info_02=DB::table('pro_employee_info')->Where('employee_id',$ci_employee_info->report_to_id)->first();
                                $txt_report_name=$ci_employee_info_02->employee_name;
                            }
                            @endphp
                            
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $txt_company_name }}<BR>{{ $ci_employee_info->employee_id }}<BR>{{ $ci_employee_info->employee_name }}</td>
                                <td>{{ $txt_desig_name }}<BR>{{ $txt_department_name }}<BR>{{ $txt_placeofposting_name }}</td>
                                <td>{{ $txt_joinning_date }}/{{ $txt_att_policy_name }}/{{ $txt_yesno_name }}<BR>{{ $ci_employee_info->mobile }}/{{ $txt_blood_name }}<BR>{{ $ci_employee_info->staff_id }}</td>
                                <td>{{ $txt_report_name }}</td>
                                <td>
                                    <a href="{{ route('hrmbackbasic_infoedit',$ci_employee_info->employee_info_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @php
                            $i++;
                            @endphp
                            @endforeach

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
