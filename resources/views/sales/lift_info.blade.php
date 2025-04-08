@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lifts Info</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

@if (isset($m_lifts))
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h5>{{ 'Edit' }}</h5>
                    </div>

                    <form action="{{ route('sales_lift_info_update',$m_lifts->lift_id) }}" method="post">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-5">
                                <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                    <option value="0">--Select Project--</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->project_id }}"
                                            {{ $project->project_id == $m_lifts->project_id ? 'selected' : '' }}>
                                            {{ $project->project_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_project_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" id="txt_lift_name" name="txt_lift_name"
                                    placeholder="Lift name" value="{{ $m_lifts->lift_name }}">
                                @error('txt_lift_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <input type="text" name="txt_remark" id="txt_remark" class="form-control" placeholder="Remark" value="{{ $m_lifts->remark }}">
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
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Update</button>
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

                    <form action="{{ route('sales_lift_info_store') }}" method="post">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-5">
                                <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                    <option value="0">--Select Project--</option>
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
                            <div class="col-7">
                                <input type="text" class="form-control" id="txt_lift_name" name="txt_lift_name"
                                    placeholder="Lift name" value="{{ old('txt_lift_name') }}">
                                @error('txt_lift_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                    placeholder="Remark" value="{{ old('txt_remark') }}">
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
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@include('sales.lift_info_list')
@endif

  @section('script')
  <script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  
  @endsection


@endsection
