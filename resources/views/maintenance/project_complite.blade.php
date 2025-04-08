@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Project Complite</h1>
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

                        <form action="{{ route('project_complite_store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-6">
                                    <select class="form-control" id="cbo_project_id" name="cbo_project_id">
                                        <option value="0">--Select Project--</option>
                                        @foreach ($m_project as $value)
                                            <option value="{{ $value->project_id }}">
                                                {{ $value->customer_name .'|'. $value->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_pro_handover_date"
                                        name="txt_pro_handover_date" value="{{ old('txt_pro_handover_date') }}"
                                        placeholder="Project Complite date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_pro_handover_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
