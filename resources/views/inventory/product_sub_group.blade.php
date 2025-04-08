@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Sub Group</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            @include('flash-message')
        </div>
        @if (isset($m_pg_sub))
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Edit' }}</h5>
                        </div>
                        <form method="post" action="{{ route('inventorypgsubupdate', $m_pg_sub->pg_sub_id) }}">
                            @csrf
                            <div  class="">
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id"
                                            placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                                        <input type="hidden" class="form-control" id="txt_pg_sub_id" name="txt_pg_sub_id"
                                            value="{{ $m_pg_sub->pg_sub_id }}">

                                        <select name="sele_pg_id" id="sele_pg_id" class="from-control custom-select">
                                            @php
                                                $ci1_pro_product_group = DB::table('pro_product_group')
                                                    ->Where('pg_id', $m_pg_sub->pg_id)
                                                    ->orderBy('pg_name', 'asc')
                                                    ->get();
                                            @endphp

                                            @foreach ($ci1_pro_product_group as $r_ci1_pro_product_group)
                                                <option value="{{ $r_ci1_pro_product_group->pg_id }}">
                                                    {{ $r_ci1_pro_product_group->pg_name }}</option>
                                            @endforeach

                                            <option value="0">Select Product Group</option>
                                            @php
                                                $ci_pro_product_group = DB::table('pro_product_group')
                                                    ->Where('valid', '1')
                                                    ->orderBy('pg_name', 'asc')
                                                    ->get();
                                            @endphp
                                            @foreach ($ci_pro_product_group as $r_ci_pro_product_group)
                                                <option value="{{ $r_ci_pro_product_group->pg_id }}">
                                                    {{ $r_ci_pro_product_group->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sele_pg_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control"mid="txt_pg_sub_name"
                                            name="txt_pg_sub_name" placeholder="Sub Group Name"
                                            value="{{ $m_pg_sub->pg_sub_name }}">
                                        @error('txt_pg_sub_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-10">

                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
@else
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div align="left" class="">
                    <h5>{{ 'Add' }}</h5>
                </div>
                <form method="post" action="{{ route('inventorypgsubstore') }}">
                    @csrf
                    <div  class="">
                        <div class="row mb-2">
                            <div class="col-5">
                                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id"
                                    placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                                <select name="sele_pg_id" id="sele_pg_id" class="from-control custom-select">
                                    @php
                                        $ci1_pro_product_group = DB::table('pro_product_group')
                                            ->Where('pg_id', old('sele_pg_id'))
                                            ->orderBy('pg_name', 'asc')
                                            ->get();
                                    @endphp

                                    @foreach ($ci1_pro_product_group as $r_ci1_pro_product_group)
                                        <option value="{{ $r_ci1_pro_product_group->pg_id }}">
                                            {{ $r_ci1_pro_product_group->pg_name }}</option>
                                    @endforeach

                                    <option value="0">Select Product Group</option>
                                    @php
                                        $ci_pro_product_group = DB::table('pro_product_group')
                                            ->Where('valid', '1')
                                            ->orderBy('pg_name', 'DESC')
                                            ->get();
                                    @endphp
                                    @foreach ($ci_pro_product_group as $r_ci_pro_product_group)
                                        <option value="{{ $r_ci_pro_product_group->pg_id }}">
                                            {{ $r_ci_pro_product_group->pg_name }}</option>
                                    @endforeach
                                </select>
                                @error('sele_pg_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" id="txt_pg_sub_name" name="txt_pg_sub_name"
                                    value="{{ old('txt_pg_sub_name') }}" placeholder="Sub Group Name">
                                @error('txt_pg_sub_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-10">

                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </section>
    @endif
    @include('inventory.product_sub_group_list')
@section('script')
    {{-- select option  --}}
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
@endsection
