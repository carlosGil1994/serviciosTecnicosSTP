<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>STP</title>

    <!-- Bootstrap CSS CDN
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.min.css') }}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS 
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <link  href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                    <img id="logo" src="{{asset('img/Captura.png')}}" alt="" width="200" height="70">
            </div>
            {{-- <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span>Sidebar</span>
            </button> --}}
            <ul class="list-unstyled components">
                <p>Menu!</p>
               {{--  <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home!!</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Home 1</a>
                        </li>
                        <li>
                            <a href="#">Home 2</a>
                        </li>
                        <li>
                            <a href="#">Home 3</a>
                        </li>
                    </ul>
                </li>--}}
                <li>
                    @if(Auth::user()->tipo==1)
                    <a href="{{ route('Usuarios.index') }}">Usuarios</a>
                    <a href="{{ route('Clientes.index') }}">Clientes</a>
                    <a href="{{ route('Acciones.index') }}">Acciones</a>
                    <a href="{{ route('Equipos.index') }}">Equipos</a>
                    <a href="{{ route('Materiales.index') }}">Materiales</a>
                    <a href="{{ route('Actividades.index') }}">ordenes</a>
                    @endif
                    @if(Auth::user()->tipo==2)
                    <a href="{{ route('Equipos.index') }}">Equipos</a>
                    <a href="{{ route('Materiales.index') }}">Materiales</a>
                    <a href="{{ route('Actividades.index') }}">ordenes</a>
                    @endif
                    @if(Auth::user()->tipo==3)
                    <a href="{{ route('PagoServicios.estadisticas') }}">Estadisticas</a>
                    <a href="{{ route('bancos.index') }}">Bancos</a>
                    <a href="{{ route('Usuarios.index') }}">Usuarios</a>
                    <a href="{{ route('Clientes.index') }}">Clientes</a>
                    <a href="{{ route('Acciones.index') }}">Acciones</a>
                    <a href="{{ route('Equipos.index') }}">Equipos</a>
                    <a href="{{ route('Materiales.index') }}">Materiales</a>
                    <a href="{{ route('Actividades.index') }}">ordenes</a>
                    <a href="{{ route('PagoServicios.index') }}">Pago servicios</a>
                    @endif
                    @if(Auth::user()->tipo==4)
                    <a href="{{ route('Actividades.index') }}">ordenes</a>
                    <a href="{{ route('PagoServicios.index') }}">Pago servicios</a>
                    @endif
                    @if(Auth::user()->tipo==5)
                    <a href="{{ route('Usuarios.index') }}">Usuarios</a>
                    <a href="{{ route('Clientes.index') }}">Clientes</a>
                    <a href="{{ route('Actividades.index') }}">Ordenes</a>
                    @endif
                    <a href="{{ route('cerrarSecion') }}">Cerrar Sesión</a>

                  <!--  <a href="{{ route('bancos.index') }}">Bancos</a>
                    <a href="{{ route('Usuarios.index') }}">Crear Usuarios</a>
                    <a href="{{ route('Actividades.index') }}">ordenes</a>
                    <a href="{{ route('Clientes.index') }}">Clientes</a>
                    <a href="{{ route('PagoServicios.index') }}">Pago servicios</a>
                    <a href="{{ route('Equipos.index') }}">Equipos</a>
                    <a href="{{ route('Materiales.index') }}">Materiales</a>
                    <a href="{{ route('Servicios.index') }}">Servicios</a>
                    <a href="{{ route('Acciones.index') }}">Acciones</a>-->
                </li>
            </ul>
        </nav>
    
        <!-- Page Content  -->
        <div id="content">
            <div id="app">
                @yield('contenido')
            </div>
        </div>
    </div>

    
    
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
            $('#btnCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>

</html>