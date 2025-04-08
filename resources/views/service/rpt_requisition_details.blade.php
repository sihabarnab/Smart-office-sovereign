@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Issue</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @php
        $ci_complaint_register = DB::table('pro_complaint_register')
            ->Where('complaint_register_id', $m_requisition_master->complain_id)
            ->first();
        $txt_complaint_description = $ci_complaint_register->complaint_description;
        $txt_complain_date = $ci_complaint_register->entry_date;
        
        $ci_task_assign = DB::table('pro_task_assign')
            ->Where('task_id', $m_requisition_master->task_id)
            ->first();
        $txt_task_date = $ci_task_assign->entry_date;
        $txt_task_remark= $ci_task_assign->remark;
        
        $ci_customers = DB::table('pro_customers')
            ->Where('customer_id', $ci_complaint_register->customer_id)
            ->first();
        $txt_customer_name = $ci_customers->customer_name;
        
        $ci_projects = DB::table('pro_projects')
            ->Where('project_id', $ci_complaint_register->project_id)
            ->first();
        $txt_project_name = $ci_projects->project_name;
        
        $ci_lifts = DB::table('pro_lifts')
            ->Where('lift_id', $ci_complaint_register->lift_id)
            ->first();
        $txt_lift_name = $ci_lifts->lift_name;
        $txt_lift_remark = $ci_lifts->remark;
        
        $ci_teams = DB::table('pro_teams')
            ->Where('team_leader_id', $m_requisition_master->team_leader_id)
            ->first();
        $txt_team_name = $ci_teams->team_name;
        
        $ci_employee_info = DB::table('pro_employee_info')
            ->Where('employee_id', $m_requisition_master->team_leader_id)
            ->first();
        $txt_team_leader_name = $ci_employee_info->employee_name;
    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-4">
                                Req No/Date : {{ $m_requisition_master->smi_master_id }} |
                                {{ $m_requisition_master->entry_date }}.
                            </div>
                            <div class="col-4">
                                Task Assign No/Date: {{ $m_requisition_master->task_id }} | {{ $txt_task_date }}.
                            </div>
                            <div class="col-4">
                                Client : {{ $txt_customer_name }}.
                            </div>
                        </div>


                        <div class="row mb-1">
                            <div class="col-6">
                                Project : {{ $txt_project_name }}.
                            </div>
                            <div class="col-6">
                                Lift : {{ $txt_lift_name }} | {{ $txt_lift_remark }}.
                            </div>
                        </div>
                        <div class="row mb-1">
                           <div class="col">
                            Remark: {{   $txt_task_remark }}.
                           </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                SL No
                            </div>
                            {{-- <div class="col-2">
                                Product Group
                            </div>
                            <div class="col-2">
                                Product Sub Group
                            </div> --}}
                            <div class="col-5">
                                Product Name
                            </div>
                            <div class="col-3">
                                QTY
                            </div>
                            <div class="col-3">
                                Unit
                            </div>
                        </div>
                        @foreach ($m_requisition_details as $key => $row)
                            {{-- <form action="" method="post">
                                @csrf --}}

                            <div class="row mb-1">
                                <div class="col-1">
                                        <p class="form-control">{{ $key + 1 }}</p>
                                </div>
                                {{-- <div class="col-2">
                                    @php
                                        $product_group = DB::table('pro_product_group')
                                            ->where('pg_id', $row->pg_id)
                                            ->first();
                                    @endphp
                                        <input class="form-control" value="{{ $product_group->pg_name }}" readonly>
                                </div>
                                <div class="col-2">
                                    @php
                                        $product_sub_group = DB::table('pro_product_sub_group')
                                            ->where('pg_sub_id', $row->pg_sub_id)
                                            ->first();
                                    @endphp
                                        <input class="form-control" value="{{ $product_sub_group->pg_sub_name }}" readonly>
                                </div> --}}
                                <div class="col-5">
                                    @php
                                        $product = DB::table('pro_product')
                                            ->where('product_id', $row->product_id)
                                            ->first();
                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', $product->unit_id)
                                            ->first();
                                    @endphp
                                        <input class="form-control" value="{{ $product->product_name }}" readonly>
                                </div>
                                <div class="col-3">
                                        <input class="form-control" value="{{ $row->product_qty }}" readonly>
                                </div>
                                <div class="col-3">
                                        <input class="form-control" value="{{  $unit->unit_name }}" readonly>
                                </div>

                            </div>
                            {{-- </form> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
