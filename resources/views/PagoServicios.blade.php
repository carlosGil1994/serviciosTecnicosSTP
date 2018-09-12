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
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                            <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                        <div class="input-group-addon border">Hasta:</div>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <input type="text" class="input-sm form-control" name="end" />
                        <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
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
 
            
        @endslot
    @endcomponent
    <br>
    <table id="table" class="table table-striped table-bordered"
    width="100%" role="grid" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Orden</th>
                <th>Servicio</th>
                <th>Cliente</th>
                <th>Pago</th>
                <th>Estado</th>
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
                    ajax: "{{ url('PagoServicios/PagoServiciosTable')}}",
                    type: 'GET',
                    columns: [
                        {data: 'id', name: 'id' },
                        {data:'clientes.nombre', name:'clientes.nombre'},
                        {data:'servicio.descripcion', name:'servicio.descripcion'},
                        {data:'pago_servicio.pago_total', name:'pagoServicio.pago_total'},
                        {data:'pago_servicio.estado',name:'pago_servicio.estado'},
                        { data:'action', name: 'action', orderable: false, searchable: false }
                    ]   
                });
            }
            showTable();
        });
       
     </script>
   
@endsection