@extends('layouts.service_app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Team Information</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    @include('flash-message')
</div>


@if(isset($edit_teams))


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                  <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
                    <form action="{{ route('TeamInfoUpdate',$edit_teams->team_id) }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <input type="text" class="form-control" id="txt_team_name" name="txt_team_name"
                                    value="{{$edit_teams->team_name }}" placeholder="Team name">
                                @error('txt_team_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <select name="cbo_leader_id" id="cbo_leader_id" class="form-control">
                                    <option value="">--Select Leader--</option>
                                    @foreach ($leaders as $leader)
                                        <option value="{{ $leader->employee_id }}" {{$edit_teams->team_leader_id == $leader->employee_id?"selected":"" }}>
                                            {{ $leader->employee_id }} | {{ $leader->employee_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_leader_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-10 col-md-8 col-sm-3">
                            &nbsp;
                          </div>
                          <div class="col-lg-2 col-md-4 col-sm-9">
                            <button type="Submit" id="save_event" class="btn btn-primary btn-block float-right">Update</button>
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
        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                  <div align="left" class=""><h5>{{ "Add" }}</h5></div>
                    <form action="{{ route('TeamInfoStore') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <input type="text" class="form-control" id="txt_team_name" name="txt_team_name"
                                    value="{{ old('txt_team_name') }}" placeholder="Team name">
                                @error('txt_team_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <select name="cbo_leader_id" id="cbo_leader_id" class="form-control">
                                    <option value="">--Select Leader--</option>
                                    @foreach ($leaders as $leader)
                                        <option value="{{ $leader->employee_id }}">
                                            {{ $leader->employee_id }} | {{ $leader->employee_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_leader_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-10 col-md-8 col-sm-3">
                            &nbsp;
                          </div>
                          <div class="col-lg-2 col-md-4 col-sm-9">
                            <button type="Submit" id="save_event" class="btn btn-primary btn-block float-right">Submit</button>
                          </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@include('service.team_info_list')

@endif

@endsection
