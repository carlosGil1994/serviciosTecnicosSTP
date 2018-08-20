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
   
    <link  href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <table id="table" class="table table-striped table-bordered" 
    width="100%" role="grid" style="width: 100%;">
    <thead class="thead-dark">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>apellido</th>
            <th>email</th>
            <th>direccion</th>
            <th>accion</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

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

    <script>
        $(function() {
              $('#table').DataTable({
              processing: true,
              serverSide: true,
              
              ajax: '{!! route('Servicios.index') !!}',
              type: 'GET',
              columns: [
                       { data: 'id', name: 'id' },
                       { data: 'name', name: 'name' },
                       { data: 'apellido', name: 'apellido' },
                       { data: 'email', name: 'email' },
                       { data: 'direccion', name: 'direccion' },
                       {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
           });
        });
        </script>

@endsection
