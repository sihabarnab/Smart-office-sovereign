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




                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-12 mb-2">
                                    <strong>Ref:</strong> {{ $m_sales_quotation_master->quotation_no }} <br>
                                    <strong>
                                        To <br>
                                        {{ $m_sales_quotation_master->customer_name }} <br>
                                        {{ $m_sales_quotation_master->customer_desig }} <br>
                                    </strong>

                                    {{ "$m_sales_quotation_master->customer_house_no $m_sales_quotation_master->customer_road $m_sales_quotation_master->customer_city  $m_sales_quotation_master->customer_post_code  $m_sales_quotation_master->customer_country" }}

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-2">
                                    <strong>Project Address:</strong> {{ $m_sales_quotation_master->project_address }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-3">
                                    <strong>Subject</strong>: {{ $m_sales_quotation_master->subject }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 mb-2">
                                    <p>
                                        Dear Sir, <br>
                                        We have the pleasure in submitting our offer , subject to the terms of delivery
                                        enclosed here with, for <br>
                                        <input type="text" id='txt_lift' name="txt_lift" value="Passenger Lift"
                                            style="background-color: #343A40;color:white;"> with the following technical
                                        characteristics:

                                    </p>
                                </div>
                            </div>



                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <td width="40%">
                                            <h3 class="text-uppercase" style="text-decoration: underline;"> Basic
                                                Specifications
                                            </h3>
                                        </td>
                                        <td width="5%"></td>
                                        <td width="50%"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_lift_title' name="txt_lift_title"
                                                value="Type of Lift" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_lift' name="txt_type_of_lift"
                                                value="Full Collective Passenger Lift" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_quantity_title' name="txt_quantity_title"
                                                value="Quantity" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_lift' name="txt_lift" value="1 Unit"
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_brand_title' name="txt_brand_title"
                                                value="Brand Name & Origin" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_brand' name="txt_lift"
                                                value="SIGLEN, Made in China" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_capacity_title' name="txt_capacity_title"
                                                value="Capacity" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_capacity' name="txt_capacity"
                                                value="630 kg.(08 Passenger)" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_speed_title' name="txt_speed_title" value="Speed"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_speed' name="txt_speed" value="1.0 m/s"
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_drive_title' name="txt_drive_title" value="Drive"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_drive' name="txt_drive" value="AC-VVVF"
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_main_power_title' name="txt_main_power_title"
                                                value="Main Power" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_main_power' name="txt_main_power"
                                                value="380V/50Hz(± 5%)" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_main_power_title' name="txt_main_power_title"
                                                value="Lighting Power" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_main_power' name="txt_main_power"
                                                value="220V/50Hz(± 5%)" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_floor_opens_title' name="txt_floor_opens_title"
                                                value="Floors & Opens" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_floor_opens' name="txt_floor_opens"
                                                value="07 Floors / 07 Opening" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_floor_service_title'
                                                name="txt_floor_service_title" value="Floors Service"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_floor_service' name="txt_floor_service"
                                                value="G-1-2-3-4-5-6 (Opening at same line)" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_lom_achine_room_title'
                                                name="txt_lom_achine_room_title" value="Location of Machine-room"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_lom_achine_room' name="txt_lom_achine_room"
                                                value="Located above hoist-way" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_travel_height_title'
                                                name="txt_travel_height_title" value="Travel Height"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_travel_height' name="txt_travel_height"
                                                value="22 Meter (Approx.)" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_avr_title' name="txt_avr_title"
                                                value="Auto Voltage Regulator (AVR)" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_avr' name="txt_avr" value="Include"
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <input type="text" id='txt_avr_title' name="txt_avr_title"
                                                value="Auto Rescue Device (ARD)" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_ard' name="txt_ard" value="Include"
                                                class="form-control">
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <td width="40%">
                                            <h3 class="text-uppercase" style="text-decoration: underline;"> Control
                                                Specifications
                                            </h3>
                                        </td>
                                        <td width="5%"></td>
                                        <td width="50%"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_main_board_title' name="txt_main_board_title"
                                                value="Main Board" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_main_board' name="txt_main_board"
                                                value="Micro Processor System (MICOM)" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_drive_system_title'
                                                name="txt_drive_system_title" value="Drive System"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_drive_system' name="txt_drive_system"
                                                value="AC-VVVF" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <td width="40%">
                                            <h3 class="text-uppercase" style="text-decoration: underline;"> Motor
                                                Specifications
                                            </h3>
                                        </td>
                                        <td width="5%"></td>
                                        <td width="50%"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_motor_type_title' name="txt_motor_type_title"
                                                value="Motor Type" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_motor_type' name="txt_motor_type"
                                                value="Gearless Traction Motor" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_motor_capacity_title'
                                                name="txt_drive_system_title" value="Capacity"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_motor_capacity' name="txt_motor_capacity"
                                                value="As Per Design & requirement" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_motor_start_hour_title'
                                                name="txt_drive_system_title" value="Starts Hour"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_motor_start_hour' name="txt_motor_start_hour"
                                                value="180-240/h" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>

                            </table>


                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <td width="40%">
                                            <h3 class="text-uppercase" style="text-decoration: underline;"> CAR (Cabin)
                                                
                                            </h3>
                                        </td>
                                        <td width="5%"></td>
                                        <td width="50%"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_car_body_title' name="txt_car_body_title"
                                                value="Car Body" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_car_body_details' name="txt_car_body_details"
                                                value="Stainless Steel Mirror Eatching Finished" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_dimission_title'
                                                name="txt_dimission_title" value="Dimension (W x D x H )"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_dimission_details' name="txt_dimission_details"
                                                value="(1200 x 1150x 2300) or standard" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_car_celing_title'
                                                name="txt_car_celing_title" value="Car Ceiling"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_car_celing_descriptiing' name="txt_car_celing_descriptiing"
                                                value="Decorative ceiling with lighting" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_floor_title'
                                                name="txt_floor_title" value="Floor"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_floor_descripting' name="txt_floor_descripting"
                                                value="Synthetic Rubber Tiles or Standard" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_accessories_title'
                                                name="txt_accessories_title" value="Accessories"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_accessories_descripting' name="txt_accessories_descripting"
                                                value="Fans, Emergency Light, 2-ways Intercom Decorative Hand Rail" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <td width="40%">
                                            <h3 class="text-uppercase" style="text-decoration: underline;"> CAR (Cabin) DOOR
                                                
                                            </h3>
                                        </td>
                                        <td width="5%"></td>
                                        <td width="50%"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_car_door_title' name="txt_car_door_title"
                                                value="Door Type" class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_car_door_details' name="txt_car_door_details"
                                                value="Automatic 2-Panel Centre Opening" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_dimission_title'
                                                name="txt_dimission_title" value="Dimension (W x D x H )"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_dimission_details' name="txt_dimission_details"
                                                value="(1200 x 1150x 2300) or standard" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_car_celing_title'
                                                name="txt_car_celing_title" value="Car Ceiling"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_car_celing_descriptiing' name="txt_car_celing_descriptiing"
                                                value="Decorative ceiling with lighting" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_floor_title'
                                                name="txt_floor_title" value="Floor"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_floor_descripting' name="txt_floor_descripting"
                                                value="Synthetic Rubber Tiles or Standard" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id='txt_accessories_title'
                                                name="txt_accessories_title" value="Accessories"
                                                class="form-control border-0">
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id='txt_accessories_descripting' name="txt_accessories_descripting"
                                                value="Fans, Emergency Light, 2-ways Intercom Decorative Hand Rail" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>

                            </table>


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
@endsection
