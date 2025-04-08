@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Product Stock Month Close</h1>
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
                        <div align="left" class=""></div>
                        <form action="{{ route('product_stock_month_close') }}" method="Post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="input-group date" id="sedate3" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_month"
                                            name="txt_month" placeholder="Year Month" value="{{ old('txt_month') }}"
                                            data-target="#sedate3">
                                        <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('txt_month')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
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
    &nbsp;
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
    <script>
        $('#sedate3').datetimepicker({
            format: 'YYYY-MM'
        });
    </script>
@endsection
