<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID/Name<br>Desig/Company</th>
                                <th>Basic/House Rent<br>Medical/Other</th>
                                <th>Gross</th>
                                <th>Bank/AIT<br>Cash/PF/Insurance</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_salary as $key=>$row_salary)
                            @php
                            //$aa='yyyy';
                            // $txt_joinning_date=date("d-m-Y",strtotime("$row->joinning_date"));

                            // $ci_company=DB::table('pro_company')->Where('company_id',$row->company_id)->first();
                            // $txt_company_name=$ci_company->company_name;

                            // $ci_desig=DB::table('pro_desig')->Where('desig_id',$row->desig_id)->first();
                            // $txt_desig_name=$ci_desig->desig_name;

                            // $ci_department=DB::table('pro_department')->Where('department_id',$row->department_id)->first();
                            // $txt_department_name=$ci_department->department_name;

                            // $ci_section=DB::table('pro_section')->Where('section_id',$row->section_id)->first();
                            // $txt_section_name=$ci_section->section_name;

                            // $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row->placeofposting_id)->first();
                            // $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

                            // $ci_blood=DB::table('pro_blood')->Where('blood_id',$row->blood_group)->first();
                            // $txt_blood_name=$ci_blood->blood_name;

                            // $ci_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$row->att_policy_id)->first();
                            // $txt_att_policy_name=$ci_att_policy->att_policy_name;

                            // $ci_yesno=DB::table('pro_yesno')->Where('yesno_id',$row->working_status)->first();
                            // $txt_yesno_name=$ci_yesno->yesno_name;

                            // $ci_employee_info=DB::table('pro_employee_info')->Where('employee_info_id',$row->report_to_id)->first();
                            // $txt_report_name=$ci_employee_info->employee_name;

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_salary->employee_id }}<BR>{{ $row_salary->employee_name }}<BR>{{ $row_salary->employee_name }}<BR>{{ $row_salary->employee_name }}</td>
                                <td>{{ $row_salary->basic_salary }}<BR>{{ $row_salary->house_rent }}<BR>{{ $row_salary->medical }}<BR>{{ $row_salary->other }}</td>
                                <td>{{ $row_salary->gross_salary }}</td>
                                <td>{{ $row_salary->bank_payment }}<BR>{{ $row_salary->ait }}<BR>{{ $row_salary->cash_amount }}<BR>{{ $row_salary->pf_insurance }}</td>
                                <td>
                                    <a href="" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
