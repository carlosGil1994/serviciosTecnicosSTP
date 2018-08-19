@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
    @endcomponent
    <br>

    {{--Componente de la barra de busqueda--}}
    @component('componentes.search')
        @slot('mod', $mod)
        @slot('inputs')

        @endslot
    @endcomponent
    <br>

    {{--Componente del panel para agregar nuevo registro--}}
    @component('componentes.paneladdnew')
        @slot('mod', $mod)
        @slot('inputs')
            <div class="form-group">
                <label for="nombre">Nombre del banco</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del banco">
            </div>
        @endslot
    @endcomponent

    {{--Componente para el view del panel--}}
    @component('componentes.panelview')
        @slot('mod', $mod);
    @endcomponent


        {{--Componente para el edit de un registro--}}
    @component('componentes.paneledit')
        @slot('mod', $mod)
        @slot('inputs')
            <div class="form-group">
                <label for="nombre">Nombre del banco</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del banco">
            </div>
        @endslot
    @endcomponent

@endsection
