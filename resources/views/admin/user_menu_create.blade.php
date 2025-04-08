@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Menu Create</h1>
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
                            <h5>{{ 'Add' }}</h5>
                        </div>

                        <form action="{{ route('user_menu_store') }}" method="get">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="cbo_module_id" id="cbo_module_id" class="form-control">
                                                <option value="">--Select Module--</option>
                                                @foreach ($m_modules as $module)
                                                    <option value="{{ $module->module_id }}">
                                                        {{ $module->module_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cbo_module_id')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <select name="cbo_main_menu_id" id="cbo_main_menu_id" class="form-control">
                                                <option value="">--Select Main Menu--</option>
                                            </select>
                                            @error('cbo_main_menu_id')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" name="txt_sub_menu_title" id="txt_sub_menu_title"
                                                class="form-control" value="{{ old('txt_sub_menu_title') }}"
                                                placeholder="Title">
                                            @error('txt_sub_menu_title')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-5">
                                            <input type="text" name="txt_sub_menu_link" id="txt_sub_menu_link"
                                                class="form-control" value="{{ old('txt_sub_menu_link') }}"
                                                placeholder="Link">
                                            @error('txt_sub_menu_link')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-3">
                                            <input type="number" name="txt_menu_serial" id="txt_menu_serial"
                                                class="form-control" placeholder="Menu SI">
                                            @error('txt_menu_serial')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Save</button>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-body">
                        <table id="data1" class="table table-border table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Module</th>
                                    <th>Main Menu</th>
                                    <th>Sub Menu Title</th>
                                    <th>Sub Menu Link</th>
                                    <th>Menu SI</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_sub_menu as $key => $row)
                                    @php
                                        $m_module = DB::table('pro_module')
                                            ->where('module_id', $row->module_id)
                                            ->first();
                                        $m_main_menu = DB::table('pro_main_mnu')
                                            ->where('main_mnu_id', $row->main_mnu_id)
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $m_module->module_name }}</td>
                                        <td>{{ $m_main_menu->main_mnu_title }}</td>
                                        <td>{{ $row->sub_mnu_title }}</td>
                                        <td>{{ $row->sub_mnu_link }}</td>
                                        <td>{{ $row->menu_sl }}</td>
                                        <td><a class="btn btn-primary btn-block" href="{{route('user_menu_edit',$row->sub_mnu_id)}}">Edit</a></td>
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
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_module_id"]').on('change', function() {
                var cbo_module_id = $(this).val();
                if (cbo_module_id) {

                    $.ajax({
                        url: "{{ url('/get/main_menu/') }}/" + cbo_module_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_main_menu_id"]').empty();
                            $('select[name="cbo_main_menu_id"]').append(
                                '<option value="0">--Select Main Menu--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_main_menu_id"]').append(
                                    '<option value="' + value.main_mnu_id + '">' +
                                    value.main_mnu_title + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_main_menu_id"]').empty();
                }

            });
        });
    </script>


    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
