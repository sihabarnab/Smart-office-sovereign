<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="align-top">SL</th>
                                <th>ID<br>Name<br>Company</th>
                                <th>Father<br>Mother<br>Spouse</th>
                                <th class="align-top">Contact #</th>
                                <th class="align-top">E-mail</th>
                                <th class="align-top">&nbsp;</th>
                                <th class="align-top">&nbsp;</th>
                                <th class="align-top">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp

                            @foreach($user_company as $row_company)
                            {{-- {{ $row_company->company_id}} --}}
                            @php

                            $m_employee_biodata=DB::table('pro_employee_biodata')
                            ->Where('company_id',$row_company->company_id)
                            ->Where('valid',1)
                            ->get();
                            @endphp
                            @foreach($m_employee_biodata as $key=>$row_biodata)
                            @php

                            $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row_biodata->employee_id)->first();

                            @endphp
                            
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row_biodata->employee_id }}<BR>{{ $row_biodata->employee_name }}<BR>{{ $row_company->company_name }}</td>
                                <td>{{ $row_biodata->father_name }}<BR>{{ $row_biodata->mother_name }}<BR>{{ $row_biodata->spouse_name }}</td>
                                <td>{{ $row_biodata->res_contact }}</td>
                                <td>{{ $row_biodata->email_personal }}<BR>{{ $row_biodata->email_office }}</td>
                                <td>
                                    <a href="{{ route('hrmbio_dataedit',$row_biodata->biodata_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('biodata_file',$row_biodata->employee_id) }}" class="btn btn-info btn-sm"><i class="fas fa-upload"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('biodata_print',$row_biodata->employee_id) }}" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>
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
