@extends('layouts.maintenance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer Summery</h1>
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
                        <form action="{{ route('rpt_all_report_summery_list') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_customer_id" id="cbo_customer_id" class="form-control">
                                        <option value="">--Select Customer--</option>
                                        @foreach ($m_customer as $row)
                                            <option value="{{ $row->customer_id }}"
                                                {{ $row->customer_id == old('cbo_customer_id') ? 'selected' : '' }}>
                                                {{ $row->customer_id }}|{{ $row->customer_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                    <select name="cbo_projet_id" id="cbo_projet_id" class="form-control">
                                        <option value="">--Select Project--</option>
                                     
                                    </select>
                                    @error('cbo_projet_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_from" id="txt_from"
                                        placeholder="Form" onfocus="(this.type='date')" value="{{ old('txt_from') }}">
                                    @error('txt_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <input type="text" class="form-control" name="txt_to" id="txt_to"
                                        placeholder="To" onfocus="(this.type='date')" value="{{ old('txt_to') }}">
                                    @error('txt_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 col-md-8 col-sm-3 mb-2">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-9 mb-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Search</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var cbo_customer_id = $('select[name="cbo_customer_id"]').val();
            if (cbo_customer_id) {
                getClientProject();
            }
            $('select[name="cbo_customer_id"]').on('change', function() {
                getClientProject();

            });
        });

        function getClientProject() {
            var cbo_customer_id = $('select[name="cbo_customer_id"]').val();
            if (cbo_customer_id) {
                $.ajax({
                    url: "{{ url('/get/summery/project_list/') }}/" + cbo_customer_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_projet_id"]').empty();
                        $('select[name="cbo_projet_id"]').append(
                            '<option value="">--Select Project--</option>');
                        //
                        $.each(data, function(key, value) {
                            $('select[name="cbo_projet_id"]').append(
                                '<option value="' + value.project_id + '">' +
                                value.project_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_projet_id"]').empty();
            }
        }
    </script>

@endsection
