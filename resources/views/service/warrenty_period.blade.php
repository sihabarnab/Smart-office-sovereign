@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Warrenty & Fee Service Period</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width ="5%">SL</th>
                                    <th width ="40%">Project Description</th>
                                    <th width ="30%">Lift</th>
                                    <th width ="25%">Period</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $current_date = date('Y-m-d');
                                    $contact_date = '';
                                @endphp
                                @foreach ($contact_service as $key => $row)
                                    @php

                                        if (isset($row->ct_period_end)) {
                                            $contact_date = date('Y-m-d', strtotime($row->ct_period_end . ' - 2 months'));
                                        } else {
                                            $contact_date = '';
                                        }
                                    @endphp

                                    @if (isset($contact_date) && $contact_date < $current_date)
                                    @php
                                       $project = DB::table('pro_projects')
                                        ->join('pro_customers', 'pro_projects.customer_id', 'pro_customers.customer_id')
                                        ->select('pro_projects.*', 'pro_customers.customer_name')
                                        ->where('pro_projects.project_id',$row->project_id)
                                        ->first();

                                        $m_lift = DB::table('pro_lifts')
                                        ->where('lift_id', $row->lift_id)
                                        ->where('valid', '1')
                                        ->first();
                                    @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>Customer:</strong> {{ $project->customer_name }} <br>
                                                <strong>Project Name:</strong> {{ $project->project_name }} <br>
                                                <strong>Project Address:</strong> {{ $project->project_address }} <br>
                                                @if (isset($project->contact_persone_01))
                                                <strong>Contact Persone 01:</strong> {{ $project->contact_persone_01 }} | {{$project->contact_number_01}} <br>
                                                @endif
                                                @if (isset($project->contact_persone_02))
                                                <strong>Contact Persone 02:</strong> {{ $project->contact_persone_02 }} | {{$project->contact_number_02}}
                                                @endif
                                            </td>
                                            <td>
                                               {{ $m_lift->lift_name }} <br> {{ $m_lift->remark }}
                                            </td>
                                            <td>
                                                <strong>Contact Start Date:</strong>
                                                {{ $row->ct_period_start }} <br>
                                                <strong>Contact End Date:</strong> {{ $row->ct_period_end }}

                                                @if ($current_date > $row->ct_period_end)
                                                    <br> <strong class="taskblink"
                                                        style="color: yellow;">{{ 'DATE OVER.' }}</strong>
                                                @endif
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
