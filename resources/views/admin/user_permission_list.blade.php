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
                                <th>Module</th>
                                <th>Main Menu</th>
                                <th>Sub Menu</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $key=>$row)
                            @php

                            $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->emp_id)->first();
                            $txt_employee_name=$ci_employee_info->employee_name;


                            $ci_module=DB::table('pro_module')->Where('module_id',$row->module_id)->first();
                            $txt_module_name=$ci_module->module_name;

                            $ci_main_mnu=DB::table('pro_main_mnu')->Where('main_mnu_id',$row->main_mnu_id)->first();
                            $txt_main_mnu_title=$ci_main_mnu->main_mnu_title;

                            $ci_sub_mnu=DB::table('pro_sub_mnu')->Where('sub_mnu_id',$row->sub_mnu_id)->first();
                            $txt_sub_mnu_title=$ci_sub_mnu->sub_mnu_title;

                            // if ($ci_employee_info->psm_id == '')
                            // {
                            //     $txt_psm_id='N/A';
                            // } else {
                            //     $txt_psm_id=$ci_employee_info->psm_id;
                            // }

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_module_name }}</td>
                                <td>{{ $txt_main_mnu_title }}</td>
                                <td>{{ $txt_sub_mnu_title }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
