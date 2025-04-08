@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Material</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @php
        $ci_customers = DB::table('pro_customers')
            ->Where('customer_id', $complain->customer_id)
            ->first();
        $txt_customer_name = $ci_customers->customer_name;
        
        $ci_projects = DB::table('pro_projects')
            ->Where('project_id', $complain->project_id)
            ->first();
        $txt_project_name = $ci_projects->project_name;
        
        $ci_lifts = DB::table('pro_lifts')
            ->Where('lift_id', $complain->lift_id)
            ->first();
        $txt_lift_name = $ci_lifts->lift_name;
        $txt_lift_remark = $ci_lifts->remark;
        
        $ci_task_assign = DB::table('pro_task_assign')
            ->Where('complain_id', $complain->complaint_register_id)
            ->first();
        $ci_employee_info = DB::table('pro_employee_info')
            ->Where('employee_id', $ci_task_assign->team_leader_id)
            ->first();
        $txt_team_leader_name =  $ci_employee_info->employee_name;
        
    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-4">
                                Task/Date : {{ $complain->complaint_register_id }} | {{ $complain->entry_date }}
                            </div>
                            <div class="col-4">
                                Task Assign No/Date: {{ $ci_task_assign->task_id }} | {{ $ci_task_assign->entry_date }}
                            </div>
                            <div class="col-4">
                                Team Leader: {{ $txt_team_leader_name }}
                            </div>
                        </div>


                        <div class="row mb-1">
                            <div class="col-4">
                                Client : {{ $txt_customer_name }}
                            </div>
                            <div class="col-4">
                                Project : {{ $txt_project_name }}
                            </div>
                            <div class="col-4">
                                Lift : {{ $txt_lift_name }} | {{ $txt_lift_remark }}
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
                            <div class="col-3">
                                Product Group/Sub Group.
                            </div>
                            <div class="col-3">
                                Product Name
                            </div>
                            <div class="col-1">
                                Unit
                            </div>
                            <div class="col-1">
                                Total QTY
                            </div>
                            <div class="col-1">
                                Good QTY
                            </div>
                            <div class="col-1">
                                Damage QTY
                            </div>
                        </div>
                        @foreach ($product as $key => $row)
                            <form action="{{ route('store_return_material',['complain_id'=>$complain->complaint_register_id,'product_id'=>$row->product_id]) }}" method="post">
                                @csrf

                                @php
                                    $product_group = DB::table('pro_product_group')
                                        ->where('pg_id', $row->pg_id)
                                        ->first();
                                    $product_sub_group = DB::table('pro_product_sub_group')
                                        ->where('pg_sub_id', $row->pg_sub_id)
                                        ->first();
                                    $unit = DB::table('pro_units')
                                        ->where('unit_id', $row->unit_id)
                                        ->first();
                                    
                                    $total_qty = DB::table('pro_requisition_details')
                                        ->where('complain_id',$complain->complaint_register_id)
                                        ->where('product_id', $row->product_id)
                                        ->sum('product_qty');
                                    
                                @endphp

                                <div class="row mb-1">
                                    <div class="col-1">
                                        <p class="form-control">{{ $key + 1 }}</p>
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control"
                                            value="{{ $product_group->pg_name }}/{{ $product_sub_group->pg_sub_name }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" value="{{ $row->product_name }}" readonly>
                                    </div>
                                    <div class="col-1">
                                        <input class="form-control" value="{{ $unit->unit_name }}" readonly>
                                    </div>
                                    <div class="col-1">
                                        <input class="form-control" name="txt_total_qty" value="{{ $total_qty }}" readonly>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control" name="txt_good_qty">
                                        @error('txt_good_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control" name="txt_bad_qty">
                                        @error('txt_bad_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <button type="Submit" id="save_event" class="btn btn-primary btn-block">ADD</button>
                                    </div>

                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
