<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMART OFFICE</title>


    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('public') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="hold-transition dark-mode login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{ route('home') }}" class="h1"><b>SMART</b>OFFICE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="emp_id" id="txt_emp_id"
                                placeholder="User Name" onchange="autosign(this.value)">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-users"></span>
                                </div>
                                @if (session('error'))
                                    {{ session('error') }}
                                @endif
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" id="txt_pssword"
                                placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a href="http://www.shahrier.com" class="small">Powered by Shahrier Enterprise</a>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->
    </div>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('public') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('public') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('public') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('public') }}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{ asset('public') }}/plugins/raphael/raphael.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset('public') }}/plugins/chart.js/Chart.min.js"></script>


    <script>
        function autosign(x) {
            if (x) {
                var psx = pad("00000000", x, true);
                $('#txt_emp_id').val(psx);
            } else {
                $('#txt_emp_id').val('');
            }
        }


        function pad(pad, str, padLeft) {
            if (typeof str === 'undefined')
                return pad;
            if (padLeft) {
                return (pad + str).slice(-pad.length);
            } else {
                return (str + pad).substring(0, pad.length);
            }
        }


        setInterval(function() {
            location.reload();
        }, 3600000); // Refresh every 10 minutes (60000 milliseconds)
    </script>


    </script>
</body>

</html>
