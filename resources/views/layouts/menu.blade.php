<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.slim.min.map') }}"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body background="{{asset('img/login.png')}}">
    
<div id="app">

    <h-menu>
        <div slot="options">
            {{-- Aqui puedes meter vainas --}}
            <button class="btn btn-primary">Hola mundo</button>
        </div>

        <div slot="sesion">
            @if(session()->has('permiso'))
                <div class="alert alert-danger">{{ session('permiso') }}</div>
            @endif
        </div>
    </h-menu>
        


    <div class="container-fluid" style="float: left;">
        <div class="row">
            {{---------------div para el menu------------------}}
            <list-menu>                
                <div slot="items">
                    {{-- El list menu es el menu como tal y los items son las opciones de dicho menu
                    Route la ruta ala que va dirigida, le metes un Route('nombre') y listo
                    El mensaje es el mensajito que tendra la opcion
                    Este componente tiene un 3er parametro que es un icono de bootstrap --}}
                    <item :route="'{{ route('home') }}'" :mensaje="'Inicio'"></item>
                </div>
            </list-menu>            
            {{-- -------------------------------------------- --}}


            {{------------div para el resto-----------------}}
            <div class="col-9">
                @yield('content')
            </div>
            {{------------------------------------------------}}
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>