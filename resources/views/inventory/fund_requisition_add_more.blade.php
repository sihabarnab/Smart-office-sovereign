@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Requisition</h1>
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
                        <form action="{{ route('fund_requisition_add_more_store',$fund_requisition_master->fund_requisition_master_id) }}" method="post">
                            @csrf

                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                   <input type="text" class="form-control" value="{{ $m_teams->team_name .'|'. $m_teams->employee_name."($m_teams->department_name)"}}" redonly>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                        <option value="">--Select Project--</option>
                                        @foreach ($m_projects as $row)
                                            <option value="{{ $row->project_id }}">
                                                {{ $row->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Add More</button>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <a href="{{route('fund_requisition_details',$fund_requisition_master->fund_requisition_master_id)}}" class="btn btn-primary btn-block">Continue</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
   @include('inventory.fund_requisition_project_list')

@endsection
