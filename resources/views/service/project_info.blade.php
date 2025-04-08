@extends('layouts.service_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Projects Info</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>
    @if (isset($m_project))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>

                            <form name="" method="post"
                                action="{{ route('project_info_update', $m_project->project_id) }}">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="txt_project_id" name="txt_project_id"
                                            placeholder="" readonly value="{{ $m_project->project_id }}">

                                        <input type="text" class="form-control" id="txt_project_name"
                                            name="txt_project_name" placeholder="Project name"
                                            value="{{ $m_project->project_name }}">
                                        @error('txt_project_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                            <option value="0">--Select Customer--</option>
                                            @foreach ($m_customer as $row_customer)
                                                <option value="{{ $row_customer->customer_id }}"
                                                    {{ $row_customer->customer_id == $m_project->customer_id ? 'selected' : '' }}>
                                                    {{ $row_customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_pro_address"
                                            name="txt_pro_address" placeholder="Project address"
                                            value="{{ $m_project->project_address }}">
                                        @error('txt_pro_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="number" class="form-control" id="txt_pro_lift_quantity"
                                            name="txt_pro_lift_quantity" placeholder="Lift quantity"
                                            value="{{ $m_project->pro_lift_quantity }}">
                                        @error('txt_pro_lift_quantity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_pro_contact_date"
                                            name="txt_pro_contact_date" placeholder="Contact date"
                                            value="{{ $m_project->contact_date }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_pro_contact_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_pro_installation_date"
                                            name="txt_pro_installation_date" placeholder="Installation date"
                                            value="{{ $m_project->installation_date }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_pro_installation_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_pro_handover_date"
                                            name="txt_pro_handover_date" placeholder="Handover date"
                                            value="{{ $m_project->handover_date }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_pro_handover_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_warranty" name="txt_warranty"
                                            placeholder="Warranty" value="{{ $m_project->warranty }}">
                                        @error('txt_warranty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_owner"
                                            name="txt_owner" placeholder="Owner"
                                            value="{{ $m_project->owner }}">
                                        @error('txt_owner')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_owner_number"
                                            name="txt_owner_number" placeholder="Owner Number"
                                            value="{{ $m_project->owner_number }}">
                                        @error('txt_owner_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_persone"
                                            name="txt_contact_persone" placeholder="First Contact Person"
                                            value="{{ $m_project->contact_persone_01 }}">
                                        @error('txt_contact_persone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_number"
                                            name="txt_contact_number" placeholder="Contact Number"
                                            value="{{ $m_project->contact_number_01 }}">
                                        @error('txt_contact_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_persone2"
                                            name="txt_contact_persone2" placeholder="Second Contact Person"
                                            value="{{ $m_project->contact_persone_02 }}">
                                        @error('txt_contact_persone2')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_number2"
                                            name="txt_contact_number2" placeholder="Contact Number"
                                            value="{{ $m_project->contact_number_02 }}">
                                        @error('txt_contact_number2')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_service_warranty"
                                            name="txt_service_warranty" placeholder="Service Warranty"
                                            value="{{ $m_project->service_warranty }}">
                                        @error('txt_service_warranty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                            placeholder="Remarks" value="{{ $m_project->remark }}">
                                        @error('txt_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>

                            <form action="{{ route('ProjectInfoStore') }}" method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_project_name"
                                            name="txt_project_name" placeholder="Project name"
                                            value="{{ old('txt_project_name') }}">
                                        @error('txt_project_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                            <option value="">--Select Customer--</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->customer_id }}">
                                                    {{ $customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_pro_address"
                                            name="txt_pro_address" placeholder="Project address"
                                            value="{{ old('txt_pro_address') }}">
                                        @error('txt_pro_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="number" class="form-control" id="txt_pro_lift_quantity"
                                            name="txt_pro_lift_quantity" placeholder="Lift quantity"
                                            value="{{ old('txt_pro_lift_quantity') }}">
                                        @error('txt_pro_lift_quantity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_pro_contact_date"
                                            name="txt_pro_contact_date" placeholder="Contact date"
                                            value="{{ old('txt_pro_contact_date') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_pro_contact_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_pro_installation_date"
                                            name="txt_pro_installation_date" placeholder="Installation date"
                                            value="{{ old('txt_pro_installation_date') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_pro_installation_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_pro_handover_date"
                                            name="txt_pro_handover_date" value="{{ old('txt_pro_handover_date') }}"
                                            placeholder="Handover date" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_pro_handover_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_warranty" name="txt_warranty"
                                            placeholder="Warranty Period" value="{{ old('txt_warranty') }}">
                                        @error('txt_warranty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_persone"
                                            name="txt_contact_persone" placeholder="First Contact Person"
                                            value="{{ old('txt_contact_persone') }}">
                                        @error('txt_contact_persone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_number"
                                            name="txt_contact_number" placeholder="Contact Number"
                                            value="{{ old('txt_contact_number') }}">
                                        @error('txt_contact_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_persone2"
                                            name="txt_contact_persone2" placeholder="Second Contact Person"
                                            value="{{ old('txt_contact_persone2') }}">
                                        @error('txt_contact_persone2')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_contact_number2"
                                            name="txt_contact_number2" placeholder="Contact Number"
                                            value="{{ old('txt_contact_number2') }}">
                                        @error('txt_contact_number2')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_service_warranty"
                                            name="txt_service_warranty" placeholder="Service Period"
                                            value="{{ old('txt_service_warranty') }}">
                                        @error('txt_service_warranty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                            placeholder="Remarks" value="{{ old('txt_remark') }}">
                                        @error('txt_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('service.project_info_list')
    @endif
@section('script')
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
@endsection
