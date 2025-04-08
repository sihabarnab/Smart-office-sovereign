@extends('layouts.service_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Review</h1>
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
                        <form action="{{ route('review_final') }}" method="post">
                            @csrf

                            {{-- // --}}
                            <input type="hidden" name="txt_bill_assign_id" value="{{ $bill_assign_id }}">

                            <div class="row mb-2">
                                <div class="col-12">
                                    <textarea  id="txt_remark" name="txt_remark" class="form-control" cols="30" rows="3" placeholder="Description"></textarea>
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2 ">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary float-right" >
                                        Final
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

