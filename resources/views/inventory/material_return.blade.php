@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Return</h1>
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
                        <form action="{{ route('material_return_store') }}" method="post">
                            @csrf

                            <div class="row mb-1">
                                <div class="col-4">
                                    <select name="cbo_challan_no" id="cbo_challan_no" class="form-control">
                                        <option value="">--Select Challan No--</option>
                                        @foreach ($d_challan as $row)
                                            <option value="{{ $row->chalan_no }}">
                                                {{ $row->chalan_no }}| {{ $row->dc_date }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="txt_req_no" id="txt_req_no"
                                        placeholder="Requisition No">
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" name="txt_req_date" id="txt_req_date"
                                        placeholder="Requisition Date">
                                </div>
                            </div>


                            <div class="row mb-1">
                                <div class="col-5">
                                    <input type="text" class="form-control" name="txt_project_id" id="txt_project_id"
                                        placeholder="Project Name">
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_store_id" name="cbo_store_id">
                                        <option value="">-Warehouse-</option>
                                        @foreach ($m_store as $value)
                                            <option value="{{ $value->store_id }}">{{ $value->store_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_store_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_return_date" name="txt_return_date"
                                        value="{{ old('txt_return_date') }}" placeholder="Return Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_return_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                        value="{{ old('txt_remark') }}" placeholder="Remark">
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Materil Return Not Final</h1>
                <div class="card">
                    <div class="card-body">
                        <table id='data1' class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL</th>
                                    <th class="text-left align-top">Return No <br> date</th>
                                    <th class="text-left align-top">Challan No & date</th>
                                    <th class="text-left align-top">Project Name</th>
                                    <th class="text-left align-top">Remark</th>
                                    <th class="text-left align-top">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_material_return as $key => $value)
                                    <tr>
                                        <td class="text-left align-top">{{ $key + 1 }}</td>
                                        <td class="text-left align-top">{{ $value->return_no }} <br> {{$value->return_date}}</td>
                                        <td class="text-left align-top">{{ $value->chalan_no }} <br> {{$value->dc_date}}</td>
                                        <td class="text-left align-top">{{ $value->project_name }}</td>
                                        <td class="text-left align-top">{{ $value->remark }}</td>
                                        <td class="text-left align-top">  <a href="{{route('material_return_details',$value->return_no )}}"
                                            class="btn btn-primary btn-block">Next</a></td>
                                    </tr>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cbo_challan_no').on('change', function() {
                var cbo_challan_no = $(this).val();
                if (cbo_challan_no) {
                    $.ajax({
                        url: "{{ url('/get/delivery_challan_details/') }}/" + cbo_challan_no,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            
                            if (data != 0) {
                                $('#txt_req_no').val(data.req_no);
                                $('#txt_req_date').val(data.req_date);
                                $('#txt_project_id').val(data.project_name);
                            } else {
                                $('#txt_req_no').val('');
                                $('#txt_req_date').val('');
                                $('#txt_project_id').val('');
                            }


                        },
                    });

                } else {
                    $('#txt_req_no').val('');
                    $('#txt_req_date').val('');
                    $('#txt_project_id').val('');
                }

            });
        });
    </script>
@endsection
