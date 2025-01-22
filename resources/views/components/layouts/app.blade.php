<!DOCTYPE html>
<html lang="en">
    

<head>
    <style>
        .sidebar, .topbar, .footer, .container-fluid {
            color: black !important;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengeluaran Barang</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Data Tables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/plugins/fontawesome/css/all.min.css') }}">
    
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/dist/css/adminlte.min.css') }}">
    
    <!-- Swing Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/logo C YMI - 2017.png') }}">
    

    <!-- Charset and Title -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    <!-- Custom Header Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Style/Header_style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>






    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/adminlte3.2/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/adminlte3.2/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/adminlte3.2/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/adminlte3.2/plugins/moment/moment.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/adminlte3.2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/adminlte3.2/dist/js/adminlte.js') }}"></script>

    <script src="{{ asset('assets/adminlte3.2/dist/js/pages/dashboard.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>

    {{-- <script src="{{ asset('assets/adminlte3.2/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script> --}}
    <!-- Ekko Lightbox -->
    <script src="{{ asset('assets/adminlte3.2/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

    <script src="{{ asset('assets/adminlte3.2/plugins/fontawesome/js/fontawesome.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/adminlte3.2/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">



    <!-- Custom styles for this page -->

    <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap4.min.css">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>

    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    @include('layouts.topbar')
                    <!-- End of Topbar -->

                    <!-- Page Content -->
                    <div class="container-fluid">
                        {{ $slot }}
                    </div>
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                @include('layouts.footer')
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
    </div>
    @livewireScripts
    
</body>

</html>
