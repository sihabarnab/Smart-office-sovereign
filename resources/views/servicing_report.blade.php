<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    {{-- After 1 minit duration reload page --}}
    <meta http-equiv="refresh" content="59">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMART OFFICE</title>

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

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">

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

        .alert-container .alert-soundplayer {
            display: none;
            visibility: hidden;
        }

        .taskblink {
            animation: blinker 5s linear infinite;
            /* color: red; */
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="row">
        <div class="col-12">
            <h2 class="text-center">{{ 'Servicing' }}</h2>
            <table class="table table-bordered table-striped table-sm">
                <thead class="bg-primary">
                    <tr>
                        <th style="width: 5%">SL</th>
                        <th style="width: 5%">TASK</th>
                        <th style="width: 25%">PROJECT</th>
                        <th style="width: 35%">COMPLAIN</th>
                        <th style="width: 20%">COMMENT</th>
                        <th style="width: 10%">STATUS</th>
                    </tr>
                </thead>
                <tbody class="bg-dark">
                    @php
                        //color
                        $colore = 'red';
                        $cl = 'taskblink';
                        //description
                        $comment = '';
                    @endphp
                    @foreach ($m_task_register as $key => $row)
                        @php
                            $journey = DB::table('pro_journey')
                                ->where('task_id', $row->task_id)
                                ->orderByDesc('journey_id')
                                ->first();

                            //colore setup
                            if (isset($journey)) {
                                $cl = ''; //blink off

                                if ($row->status == 'JOURNEY_STARTED') {
                                    $colore = 'Yellow';
                                } elseif ($row->status == 'JOURNEY_END') {
                                    $colore = '#9400D3'; //belvoit
                                } elseif ($row->status == 'TASK_ACTIVE') {
                                    $colore = '#808000'; //olive
                                } elseif ($row->status == 'TASK_COMPLETED') {
                                    $colore = 'Green';
                                } elseif ($row->status == 'TASK_PARTIALLY_COMPLETED') {
                                    $colore = 'Blue';
                                } else {
                                    $colore = 'red';
                                }
                            } else {
                                $colore = 'red';
                                $cl = 'taskblink';
                                $assign_clor = '';
                                $journy_color = '';
                            }
                            //end if colore setup

                            //Call attend time setup
                            if (isset($journey)) {
                                //start comment setup
                                $finish_comment = DB::table('pro_work_end')
                                    ->where('task_id', $row->task_id)
                                    ->where('journey_id', $journey->journey_id)
                                    ->first();
                                if (isset($finish_comment)) {
                                    $comment =
                                        $finish_comment->description == null ? '' : "$finish_comment->description";
                                } else {
                                    $comment = '';
                                }

                                //End comment setup
                            } else {
                                //description
                                $comment = '';
                            }
                            //End call time setup
                        @endphp

                        <tr class="{{ $cl }}" style="color: {{ $colore }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row->task_id }}</td>
                            <td>
                                {{ $row->project_name }}
                            </td>
                            <td>
                                {{ $row->complaint_description }}
                            </td>
                            <td> {{ $comment }}</td>
                            <td>
                                <strong>
                                    @if ($row->status == 'JOURNEY_STARTED')
                                        {{ 'JOURNEY START' }}
                                    @elseif ($row->status == 'JOURNEY_END')
                                        {{ 'JOURNEY END' }}
                                    @elseif ($row->status == 'TASK_ACTIVE')
                                        {{ 'TASK ACTIVE' }}
                                    @elseif ($row->status == 'TASK_COMPLETED')
                                        {{ 'TASK FINISH' }}
                                    @elseif ($row->status == 'TASK_PARTIALLY_COMPLETED')
                                        {{ 'TASK PARTIAL COMPLITE' }}
                                    @elseif ($row->status == 'JOURNEY_FAILED')
                                        {{ 'CANCEL TASK' }}
                                    @else
                                        {{ 'PENDING' }}
                                    @endif
                                </strong>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
    <script src="{{ asset('public') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="{{ asset('public') }}/plugins/sweetalert.min.js"></script>
    <!-- jQuery Mapael -->
    <script src="{{ asset('public') }}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{ asset('public') }}/plugins/raphael/raphael.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{ asset('public') }}/plugins/jquery-mapael/maps/usa_states.min.js"></script>
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

    {{-- <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('public') }}/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('public') }}/dist/js/pages/dashboard2.js"></script> --}}

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
        $(function() {
            $("#data3").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data1_wrapper .col-md-6:eq(0)');

        });
    </script>

</body>

</html>
