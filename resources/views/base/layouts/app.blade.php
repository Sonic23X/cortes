<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css') }}">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Bienvenido {{ Auth::user()->name }}!
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Salir') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">        
        <a href="{{ url('home') }}" class="brand-link text-center">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Inicio
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url( '/flujo') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                Flujo financiero
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url( '/usuarios') }}" class="nav-link">
                            <i class="nav-icon fas fa-biking"></i>
                            <p>
                                Repartidores
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url( '/resumen') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                Resumen
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/pagos') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                Cobros
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url( '/configuracion') }}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Configuración
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">

        @yield('content')
        
    </div>
    
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap- 
    datepicker/1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
     
    @yield('script')

</body>
</html>
