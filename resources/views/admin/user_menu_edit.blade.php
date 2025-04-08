@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Menu Edit</h1>
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

                        <form action="{{ route('user_menu_update',$m_sub_menu_edit->sub_mnu_id) }}" method="Post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="cbo_module_id" id="cbo_module_id" class="form-control">
                                                <option value="{{$m_module->module_id}}">{{$m_module->module_name}}</option>
                                            </select>
                                            @error('cbo_module_id')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <select name="cbo_main_menu_id" id="cbo_main_menu_id" class="form-control">
                                                <option value="{{$m_main_menu->main_mnu_id}}">{{$m_main_menu->main_mnu_title}}</option>
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
                                                class="form-control" value="{{ $m_sub_menu_edit->sub_mnu_title }}"
                                                placeholder="Title">
                                            @error('txt_sub_menu_title')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-5">
                                            <input type="text" name="txt_sub_menu_link" id="txt_sub_menu_link"
                                                class="form-control" value="{{ $m_sub_menu_edit->sub_mnu_link }}"
                                                placeholder="Link">
                                            @error('txt_sub_menu_link')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-3">
                                            <input type="number" name="txt_menu_serial" id="txt_menu_serial"
                                                class="form-control" placeholder="Menu SI" value="{{ $m_sub_menu_edit->menu_sl }}">
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
                                    <button type="Submit" id="save_event" class="btn btn-primary btn-block">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
