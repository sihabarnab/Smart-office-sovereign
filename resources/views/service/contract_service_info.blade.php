@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Service Contact Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>
    @if (isset($m_ct_services))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>

                            <form action="{{ route('contract_service_info_update', $m_ct_services->ct_service_id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                            <option value="">--Select Project--</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->project_id }}"
                                                    {{ $project->project_id == $m_ct_services->project_id ? 'selected' : '' }}>
                                                    {{ $project->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_lift_id" name="cbo_lift_id">
                                            <option value="{{ $m_lift->lift_id }}">{{ $m_lift->lift_name }} | | {{ $m_lift->remark }}</option>
                                        </select>
                                        @error('cbo_lift_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="txt_ct_period_start"
                                            name="txt_ct_period_start" value="{{ $m_ct_services->ct_period_start }}"
                                            placeholder="Contact Period Start Date" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_ct_period_start')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="txt_ct_period_end"
                                            name="txt_ct_period_end" value="{{ $m_ct_services->ct_period_end }}"
                                            placeholder="Contact Period End Date" placeholder="Contact Period Start Date"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_ct_period_end')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2 ">
                                        <input type="text" class="form-control" id="txt_service_bill"
                                            name="txt_service_bill" value="{{ $m_ct_services->service_bill }}"
                                            placeholder="Service Bill">
                                        @error('txt_service_bill')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_bill_type_id" id="cbo_bill_type_id" class="form-control">
                                            <option value="">Select Bill Type</option>
                                            @foreach ($m_bill_type as $row_bill_type)
                                                <option value="{{ $row_bill_type->bill_type_id }}"
                                                    {{ $row_bill_type->bill_type_id == $m_ct_services->bill_type_id ? 'selected' : '' }}>
                                                    {{ $row_bill_type->bill_type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bill_type_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                                        <input type="text" name="txt_remark" id="txt_remark" class="form-control"
                                            value="{{ $m_ct_services->remark }}" placeholder="Remark">
                                        @error('txt_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <input type="text" name="txt_file" id="txt_file" class="form-control"
                                        onfocus="(this.type='file')"
                                        placeholder="Upload File" accept=".pdf">
                                    @error('txt_file')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-10 col-md-4 col-sm-3 mb-2 ">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-8 col-sm-9 mb-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </form>

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

                            <form action="{{ route('contract_service_info_store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                            <option value="">--Select Project--</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->project_id }}">
                                                    {{ $project->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select class="form-control" id="cbo_lift_id" name="cbo_lift_id">
                                            <option value="">--Select Lift--</option>
                                        </select>
                                        @error('cbo_lift_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="txt_ct_period_start"
                                            name="txt_ct_period_start" value="{{ old('txt_ct_period_start') }}"
                                            placeholder="Start Date" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_ct_period_start')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="txt_ct_period_end"
                                            name="txt_ct_period_end" value="{{ old('txt_ct_period_end') }}"
                                            placeholder="End Date" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_ct_period_end')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <input type="number" class="form-control" id="txt_service_bill"
                                            name="txt_service_bill" value="{{ old('txt_service_bill') }}"
                                            placeholder="Service Bill">
                                        @error('txt_service_bill')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <select name="cbo_bill_type_id" id="cbo_bill_type_id" class="form-control">
                                            <option value="">Select Bill Type</option>
                                            @foreach ($m_bill_type as $row_bill_type)
                                                <option value="{{ $row_bill_type->bill_type_id }}">
                                                    {{ $row_bill_type->bill_type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bill_type_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                        <input type="text" name="txt_file" id="txt_file" class="form-control"
                                            onfocus="(this.type='file')"
                                            placeholder="Upload File" accept=".pdf">
                                        @error('txt_file')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                            value="{{ old('txt_remark') }}" placeholder="Remarks">
                                        @error('txt_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-10 col-md-4 col-sm-3 mb-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-2 col-md-8 col-sm-9 mb-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('service.contract_service_info_list')
    @endif
@section('script')
    {{-- //Project to Lift Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_project_id"]').on('change', function() {
                console.log('ok')
                var cbo_project_id = $(this).val();
                if (cbo_project_id) {

                    $.ajax({
                        url: "{{ url('/get/lift/') }}/" + cbo_project_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_lift_id"]').empty();
                            $('select[name="cbo_lift_id"]').append(
                                '<option value="">--Select Lift--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_lift_id"]').append(
                                    '<option value="' + value.lift_id + '">' +
                                    value.lift_name + ' | ' +
                                    value.remark + '</option>');
                            });
                        },
                    });

                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>

    <script>
        function showPdf(url){
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            if(url){
                $('#setPdf').attr('src','');
                $('#setPdf').attr('src',url);
            }else{
                $('#setPdf').attr('src','');  
            }
                
        }
    </script>
@endsection

@endsection
