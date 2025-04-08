<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMART OFFICE</title>
    <link rel="icon" href="{{ asset('public') }}/dist/img/AdminSELogo.png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/fontawesome-free/css/fonts-googleapis-css.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('public') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">

    {{-- page animation  --}}
    <link href="{{ asset('public') }}/css/ani_02.css" rel="stylesheet">
    
    <style>
        .footer-cus {

            position: fixed;
            padding: 10px 10px 0px 10px;
            bottom: 0;
            width: 70%;
            /* Height of the footer*/
            height: 40px;
            background: #343a40;
        }

        .swal-popup {
            font-size: 0.6rem !important;
        }
    </style>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="">


        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
            @php
                $m_user_id = Auth::user()->emp_id;

                $ci_employee_info = DB::table('pro_employee_info')->Where('employee_id', $m_user_id)->first();

                $ci_desig = DB::table('pro_desig')
                    ->Where('desig_id', $ci_employee_info->desig_id)
                    ->first();
                $txt_desig_name = $ci_desig->desig_name;

                $ci_company = DB::table('pro_company')
                    ->Where('company_id', $ci_employee_info->company_id)
                    ->first();
                $txt_company_name = $ci_company->company_name;

            @endphp

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-md-inline">{{ Auth::user()->full_name }} | {{ Auth::user()->emp_id }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <p>
                                {{ Auth::user()->full_name }} {{ Auth::user()->emp_id }}
                                {{-- <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small> --}}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                            <a href="{{ route('changepass') }}" class="btn btn-default btn-flat">Password</a>

                            <a href="#" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="ctm_anim">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('public') }}/dist/img/AdminSELogo.png" alt="AdminSE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class=""><small>Shahrier Enterprise</small></span>
            </a>

            <!-- Sidebar -->
            @include('admin_sidebar')
            <!-- /.sidebar -->
        </aside>


    </div>

    <!-- Main Footer -->

    <footer class="main-footer"><small>
            <strong>Copyright &copy; 2015-{{ date('Y') }} <a href="https://shahrier.com">Shahrier
                    Enterprise</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </small>
    </footer>

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('public') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('public') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('public') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <script src="{{ asset('public') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="{{ asset('public') }}/plugins/sweetalert.min.js"></script>
    <!-- jQuery Mapael -->
    <script src="{{ asset('public') }}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{ asset('public') }}/plugins/raphael/raphael.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jquery-mapael/maps/usa_states.min.js"></script>

    <!--Select2JS-->
    <script src="{{ asset('public') }}/plugins/select2/js/select2.min.js"></script>

    <!-- ChartJS -->
    <script src="{{ asset('public') }}/plugins/chart.js/Chart.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('public') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('public') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('public') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('public') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- InputMask -->
    <script src="{{ asset('public') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('public') }}/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('public') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('public')}}/dist/js/demo.js"></script> --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('public')}}/dist/js/pages/dashboard2.js"></script> --}}

    {{-- <script src="{{ asset('public')}}/plugins/popper/popper.js"></script> --}}

    @yield('script')

    <script>
        $(function() {
            $("#data1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            swal({

                    title: "Are You Want to Inactive?",
                    text: "Once Inactive, You won't be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = link;
                    } else {
                        swal("Safe Data!");
                    }
                });
        });
    </script>

    {{-- select option  --}}
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>

<script>
    setTimeout(() => {
        closeAnimFixModal();
    }, "1500")

    function closeAnimFixModal() {
        var element = document.querySelector(".ctm_anim");
        if (element) {
            element.classList.remove("ctm_anim");
        }
    }
</script>

</body>

</html>
