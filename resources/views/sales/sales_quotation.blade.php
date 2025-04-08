@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION</h1>
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
                        <form action="{{ route('sales_quotation_initial_store') }}" method="post">
                            @csrf
                            <div class="row ">
                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2">
                                    <input type="text" class="form-control" id="txt_date" name="txt_date"
                                        value="{{ old('txt_date') }}" placeholder="Quotation Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2">
                                    <select name="cbo_customer" id="cbo_customer" class="form-control">
                                        <option value="">--Select Customer--</option>
                                        @foreach ($m_customer as $value)
                                            <option value="{{ $value->customer_id }}"
                                                {{ $value->customer_id == old('cbo_customer') ? 'selected' : '' }}>
                                                {{ $value->customer_name }} | {{ $value->customer_phone }}</option>
                                        @endforeach

                                    </select>
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-lg-6 col-sm-12 col-md-12 mb-2">
                                    <input type="text" id='txt_customer_address' name="txt_customer_address"
                                        class="form-control"  placeholder="Customer Address">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-2">
                                    <input type="text" id='txt_project_address' name="txt_project_address"
                                        class="form-control" value="House # 522, Road # 06, Block # H, Bashundhara R/A." placeholder="Project Address">
                                    @error('txt_project_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-2">
                                    <input type="text" id='txt_subject' name="txt_subject" class="form-control"
                                        value="Supply, Installation, Testing & Commissioning of 630kg 07 Stops Passenger Lift." placeholder="Subject" >
                                    @error('txt_subject')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Next</button>
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
        var cbo_customer = $('#cbo_customer').val();
        if (cbo_customer) {
            getCustomerDetails();
        }

        $(document).ready(function() {
            $('select[name="cbo_customer"]').on('change', function() {
                getCustomerDetails();
            });
        });

        function getCustomerDetails() {
            var cbo_customer = $('#cbo_customer').val();
            if (cbo_customer) {
                $.ajax({
                    url: "{{ url('/get/sales/customer_details') }}/" + cbo_customer,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#txt_customer_address').val(data);

                    },
                });

            } else {
                $('#txt_customer_address').val('');
            }
        }
    </script>
@endsection
