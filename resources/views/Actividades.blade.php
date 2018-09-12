@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
    @endcomponent
    <br>

    {{--Componente de la barra de busqueda--}}
    <div class="card">
        <div class="card-header">
                Busqueda por fecha
        </div>
        <div class="card-body">
            <div class="container">
                 <div class="form-group">
                <div class="row">
                    <div class="input-group input-daterange" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start" />
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <div class="input-group-addon border">Hasta:</div>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <input type="text" class="input-sm form-control" name="end" />
                    </div>
                </div>
            </div>    
            <div class="form-group">
                <div class="row justify-content-md-center">
                     <button class=" btn btn-primary" id="buscarFecha" name="buscarFecha">Buscar</button>
                </div>
            </div>
            </div>
           
        </div>
    </div>
 
    {{--Componente del panel para agregar nuevo registro--}}
    @component('componentes.paneladdnew')
        @slot('mod', $mod)
        @slot('inputs')
        <div class="container">
                        <br>
                        <div class="form-group">
                                <label for="search">Buscar Cliente</label>
                                <div class="input-group">
                                    <input type="search" id="search" name="search" class="form-control col-5" placeholder="Buscar" required>
                                    <span class="input-group-btn">
                                    <button type="submit" id="search_btn" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </span>
                                </div>
                        </div>
                        <div class="form-group">
                                <div class="row">
                                    <div class="col-5">
                                        <select class="form-control" name="cliente" id="cliente">
                                            <option value="">Escoger cliente</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Servicio</label>
                            <select class="form-control" name="servicio" id="servicio">
                                @foreach ($servicios as $servicio)
                                    <option value={{$servicio->id}}>{{$servicio->descripcion}}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <textarea name="descripcion" id="descripcion" cols="50" rows="5">descripción</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Tecnico</label>
                            <select class="form-control" name="tecnico" id="tecnico">
                                @foreach ($tecnicos as $tecnico)
                                    <option value={{$tecnico->id}}>{{$tecnico->name}}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label for='fechaIni'>Fecha</label>
                                    <div class="input-group date datepicker">
                                        <input name='fechaIni' id='fechaIni' placeholder="fecha inicio" type="text" class="form-control">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                            <input id="timepicker1" name="timepicker1" type="text" class="form-control input-small">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
        </div>
            
        @endslot
    @endcomponent
    <br>
    <table id="table" class="table table-striped table-bordered"
    width="100%" role="grid" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Orden</th>
                <th>Descripcion</th>
                <th>Servicio</th>
                <th>Cliente</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>

    {{--Componente para el view del panel--}}
    @component('componentes.panelview')
        @slot('mod', $mod);
    @endcomponent


        {{--Componente para el edit de un registro--}}
    {{--@component('componentes.paneledit')
        @slot('mod', $mod)
        @slot('inputs')
        @endslot
    @endcomponent--}}
    <script>
         $('#timepicker1').timepicker();
        $("#search_btn").on("click",function(e){
                    e.preventDefault();
                    $busqueda=$("#search").val();
    
                    $.ajax({
                        url: "{{ url('Clientes/busqueda')}}/"+$busqueda,
                        data: "&_token={{ csrf_token()}}",
                        type:'GET',
                        dataType: 'json',
                    }).done(function(data){
                        
                        console.log(data);
                        $('#cliente').html('<option value="">Escoger Usuario</option>');
                        data.cliente.forEach(element => {
                            var $aux=new Object();
                            $aux.cliente=element.id;
                            $aux.nombre=element.nombre;
                            console.log($aux);
                            $('#cliente').append('<option '+"value='"+JSON.stringify($aux)+"'>"+element.nombre+'</option>');
                        });
                        //$('#oculto').slideToggle('slow');
                        //$('#frm_add_new')[0].reset();
                    });
                });
        $('.input-daterange').datepicker({
            format: "dd-mm-yy",
            clearBtn: true,
            language: "es",
            orientation: "bottom auto",
            todayHighlight: true
        });
        $('.datepicker').datepicker({
            format: "dd-mm-yy",
            clearBtn: true,
            language: "es",
            orientation: "bottom auto",
            todayHighlight: true
        });
        $(document).ready(function(){
            $telefonos=[];
            $telefonosP=[];
            $servicios=[];
            function showTable(){
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    language: {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                    ,
                    ajax: "{{ url('Actividades/Ordenestable')}}",
                    type: 'GET',
                    columns: [
                        {data: 'id', name: 'id' },
                        {data:'descripcion',name:'descripcion'},
                        {data:'servicio.descripcion', name:'servicio.descripcion'},
                        {data:'cliente', name:'cliente'},
                        { data:'action', name: 'action', orderable: false, searchable: false }
                    ]   
                });
            }
            showTable();
        });
       
     </script>
   
@endsection
