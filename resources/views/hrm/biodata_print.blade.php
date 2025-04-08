<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public')}}/dist/css/adminlte.min.css">

    <title>Biodata</title>
    <style>
        .Biodata {
            margin-top: 10%;
            text-align: center;
            text-decoration: underline;
        }

        @media print {

            header,
            footer {
                display: none;
            }

            @page {
                size: auto;
                margin-top: 7%;
            }

            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */


        }


        .table td,
        .table th {
            padding: 0.20rem;
        }

        tr {
            font-size: 18px;
            margin: 0;
        }
    </style>
</head>

<body>
@php
$ci_gender=DB::table('pro_gender')->Where('gender_id',$employee_info->gender)->first();
$txt_gender_name=$ci_gender->gender_name;

$ci_blood=DB::table('pro_blood')->Where('blood_id',$employee_info->blood_group)->first();

$ci_marital_status=DB::table('pro_marital_status')->Where('marital_status_id',$e_biodata->marital_status_id)->first();

@endphp

    <h1 class="Biodata">BIODATA</h1>
    <div class="container mb-5">
        <div class="row mt-5 mb-5">
            <div class="col-8">
                <h4>{{ $e_biodata->employee_name }}</h4>
                <table style="border: none;" class="table table-borderless">
                    <tbody style="border: none;">
                        <tr>
                            <td style="width: 30%">Date of birth</td>
                            <td>:&nbsp;&nbsp;</td>
                            <td>{{ $e_biodata->dob }}</td>
                        </tr>
                        <tr>
                            <td>Father's Name</td>
                            <td>:</td>
                            <td>{{ $e_biodata->father_name }}</td>
                        </tr>
                        <tr>
                            <td>Mother's Name</td>
                            <td>:</td>
                            <td>{{ $e_biodata->mother_name }}</td>
                        </tr>
                        <tr>
                            <td>Present Address</td>
                            <td>:</td>
                            <td>{{ $e_biodata->present_add }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>:</td>
                            <td>{{ $e_biodata->permanent_add }}</td>
                        </tr>
                        <tr>
                            <td>RES Contact No</td>
                            <td>:</td>
                            <td>{{ $e_biodata->res_contact }}</td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:</td>
                            <td>
                                @if (isset($employee_info->gender))
                                    {{ $txt_gender_name }}
                                @else
                                    {{ 'None' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Height</td>
                            <td>:</td>
                            <td>{{ $e_biodata->height }}</td>
                        </tr>
                        <tr>
                            <td>Blood Group</td>
                            <td>:</td>
                            <td>
                                @if (isset($employee_info->blood_group))
                                    {{ $ci_blood->blood_name }}
                                @else
                                    {{ 'None' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Marital Status</td>
                            <td>:</td>
                            <td>{{ $ci_marital_status->marital_status_name }}</td>
                        </tr>
                        <tr>
                            <td>Spouse Name</td>
                            <td>:</td>
                            <td>{{ $e_biodata->spouse_name }}</td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td>:</td>
                            <td>{{ $e_biodata->nationality }}</td>
                        </tr>
                        <tr>
                            <td>NID</td>
                            <td>:</td>
                            <td>{{ $e_biodata->national_id_no }}</td>
                        </tr>
                        <tr>
                            <td>E-mail Personal</td>
                            <td>:</td>
                            <td>{{ $e_biodata->email_personal }}</td>
                        </tr>
                        <tr>
                            <td>E-mail Company</td>
                            <td>:</td>
                            <td>{{ $e_biodata->email_office }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-1"></div>
            <div class="col-3" style="margin-top: -10px;">
                @if (isset($e_biodata->emp_pic))
                    <img src="{{ asset("$e_biodata->emp_pic") }}" alt="" width="200px" height="200px">
                @else
                    <img src="" alt="" width="200px" height="200px">
                @endif
            </div>
        </div>

        @if (isset($e_edu))
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <h4>Educational Qualifications</h4>
                        <span style="display:block;border-bottom:2px solid black;width: 283px;"></span>
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width='20%'>Qualification</th>
                                        <th width='30%'>Institution</th>
                                        <th width='20%'>Group</th>
                                        <th width='15%'>Grades(GPA)</th>
                                        <th width='12%'>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e_edu as $raw)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $raw->exame_title }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->institute }}</td>
                                            <td style="vertical-align: middle;">
                                                @if (isset($raw->edu_group))
                                                    {{ $raw->edu_group }}
                                                @else
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle;">{{ $raw->result }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->passing_year }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (isset($e_experiance))
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <h4>Professional Experience</h4>
                        <span style="display:block;border-bottom:2px solid black;width: 256px;"></span>

                        <div class="mt-4">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th width='15%'>Position</th>
                                        <th width='15%'>Organization</th>
                                        <th width='25%'>Address</th>
                                        <th width='25%'>Responsibilities</th>
                                        <th width='10%'>Start Date</th>
                                        <th width='10%'>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e_experiance as $raw)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $raw->designation }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->organization }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->address }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->responsibilities }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->start_date }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->end_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (isset($e_training))
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <h4> Professional Traning</h4>
                        <span style="display:block;border-bottom:2px solid black;width: 219px;"></span>
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width='20%'>Organization</th>
                                        <th width='30%'>Topic Covered</th>
                                        <th width='25%'>Address</th>
                                        <th width='12%'>Start Date</th>
                                        <th width='12%'>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($e_training as $raw)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $raw->institute }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->traning_title }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->address }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->start_date }}</td>
                                            <td style="vertical-align: middle;">{{ $raw->end_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

<!-- AdminLTE App -->
<script src="{{ asset('public')}}/dist/js/adminlte.js"></script>


     <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
        setTimeout(function() {
            window.location.replace("{{ route('bio_data') }}");
        }, 2000);
    </script>


</body>

</html>
