@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', 'Dashboard')
        @slot('count', '1')
    @endcomponent
    <br>
    {{--Componente de la barra de busqueda--}}
    @component('componentes.search')
        @slot('mod', 'Mod1')
        @slot('inputs')

        @endslot
    @endcomponent
    <br>

    {{--Componente del panel para agregar nuevo registro--}}
    @component('componentes.paneladdnew')
        @slot('mod', 'Mod1')
        @slot('inputs')
            

        @endslot
    @endcomponent

    {{--Componente para el view del panel--}}
    @component('componentes.panelview')
        @slot('mod', 'Mod1');
    @endcomponent


        {{--Componente para el edit de un registro--}}
    @component('componentes.paneledit')
        @slot('mod', 'Mod1')
        @slot('inputs')
            
        @endslot
    @endcomponent

@endsection
