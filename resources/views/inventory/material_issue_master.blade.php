@extends('layouts.inventory_app')
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form action="{{ route('material_issue_master_store', $req_master->requisition_master_id) }}"
                            method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    @php
                                        $customer = DB::table('pro_customers')
                                            ->where('customer_id', $ms_task_assign->customer_id)
                                            ->first();
                                    @endphp
                                    <input type="text" name="txt_customer_id" id="txt_customer_id"
                                        value="{{ $customer->customer_name }}" class="form-control" readonly>
                                </div>
                                <div class="col-4">
                                    @php
                                        $project = DB::table('pro_projects')
                                            ->where('project_id', $ms_task_assign->project_id)
                                            ->first();
                                    @endphp
                                    <input type="text" name="txt_project_id" id="txt_project_id"
                                        value="{{ $project->project_name }}" class="form-control" readonly>
                                </div>
                                <div class="col-4">
                                    @php
                                        $lift = DB::table('pro_lifts')
                                            ->where('lift_id', $ms_task_assign->lift_id)
                                            ->first();
                                    @endphp
                                    <input type="text" name="txt_lift_id" id="txt_lift_id"
                                        value="{{ $lift->lift_name }} | {{ $lift->remark }}" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="txt_remark" id="txt_remark"
                                        value="{{ old('txt_remark') }}" placeholder="Remark">
                                    @error('txt_remark')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
