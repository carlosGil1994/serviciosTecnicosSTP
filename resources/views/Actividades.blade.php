@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
        @slot('mostrarBoton', $mostrarBoton)
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
                            <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                        <input type="text" class="input-sm form-control" name="start" />
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
                       {{-- <div style="display: none" id="mostrarEstado" class="form-group">
                                <label for="estadoOrden">Estado:</label>
                                <input class="form-control" id="estadoOrden" name="estadoOrden" type="text">
                        </div>--}}
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
                <th>Cliente</th>
                <th>Direccion</th>
                <th>Descripción</th>
                <th>Servicio</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Estado</th>
                <th>Acción</th>
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
    function bindButtons(){
            $(document).on('click','.btn-table',function(e){
                e.preventDefault();
                $id = $(this).attr('data');
                console.log($id);
                if($(this).hasClass('crear')){
                    $('#oculto').toggle('slow');
                }
                if($(this).hasClass('completar')){
                    if(confirm("Desea completar la actividad")){
                    $.ajax({
                        url: "{{url('Actividades/completar')}}/"+$id,
                        data: "&_token={{ csrf_token()}}",
                        type:'PUT',
                        dataType: 'json',
                    }).done(function(data){
                        console.log(data);
                        showTable();
                    });
                    }
                }
                if($(this).hasClass('cerrarOrden')){
                    if(confirm("Desea cerrar la orden")){
                    $.ajax({
                        url: "{{url('Ordenes/cerrarOrden')}}/"+$id,
                        data: "&_token={{ csrf_token()}}",
                        type:'PUT',
                        dataType: 'json',
                    }).done(function(data){
                        console.log(data);
                        showTable();
                    });
                    }
                }
                    if($(this).hasClass('editar')){
                    $.ajax({
                        url: "{{url('Ordenes/show')}}/"+$id,
                        data: "&_token={{ csrf_token()}}",
                        type:'GET',
                        dataType: 'json',
                    }).done(function(data){
                        $('#send').html('editar');
                        $('#frm_add_new').attr('method',"PUT");
                        $('#frm_add_new').attr('action',"{{url('Ordenes/edit')}}/"+$id);
                        console.log(data.orden);
                        $('#servicio').val(data.orden.servicio.id);
                        if(data.orden.tecnico){
                            $('#tecnico').val(data.orden.tecnico.id);
                        }else{
                            $('#tecnico').append('<option selected disabled '+"value=''>"+"Escoger tecnico"+'</option>');
                        }
                        $('.datepicker').datepicker('setDate',data.orden.fecha_ini);
                        $('#timepicker1').timepicker('setTime',data.orden.fecha_ini);
                        $('#cliente').append('<option selected '+"value='"+JSON.stringify(data.orden.clientes)+"'>"+data.orden.clientes.nombre+'</option>');
                       // $('#estadoOrden').val(data.orden.estado);
                      //  $('#mostrarEstado').css('display','block');
                        /*$('#send').html('editar');
                        $('#frm_add_new').attr('method',"PUT");
                        $('#frm_add_new').attr('action',"{{url('Actividades/edit')}}/"+$id);
                        $('#accion').val(data.Actividades.accion.id);
                        $('#apellido').val(data.usuarios.apellido);
                        $('#email').val(data.usuarios.email);
                        $('#direccion').val(data.usuarios.direccion);
                        $('#password').val(data.usuarios.password);
                        $('#tipo').val(data.usuarios.tipo);
                        $('#tipo').change();
                        if(data.usuarios.tipo==2){
                            if(data.usuarios.especialidades.length>0){
                                console.log('aqui estan los servicios')
                                console.log($servicios);
                                
                                console.log('aqui se imprime el imput oculto');
                                console.log( $("#serviciosT").val());
                                data.usuarios.especialidades.forEach(element=>{
                                    console.log("se agrga un servicio al array");
                                    $servicios.push(element.descripcion);
                                    console.log($servicios);
                                    $('#tablaservicios > tbody:last-child').append('<tr><td>'+element.descripcion+'</td><td>'+'<button type="button" class="btn btn-primary borrartablaServicios" data='+element.descripcion+'>'+'borrar'+'</button>'+'</td></tr>');
                                });
                                $("#serviciosT").val($servicios);
                            }


                        }
                        if(data.usuarios.telefonos.length >0){
                            $telefonos=JSON.stringify(data.usuarios.telefonos);
                            console.log( $telefonos);
                            $("#telefonos").val($telefonos);
                            console.log('esto es lo que le estamos colocando a telefonos');
                            $tele=$("#telefonos").val();
                            console.log(data.usuarios.telefonos);
                            console.log();
                            data.usuarios.telefonos.forEach(element=>{
                                // $telefonos.push(element.numero);
                                $('#tablaTelefonos > tbody:last-child').append('<tr><td>'+element.numero+'</td><td>'+'<button type="button" class="btn btn-primary borrarTelefono" data='+element.numero+'>'+'borrar'+'</button>'+'</td></tr>');
                            });
                        }
                            //alert('Se ha guardado con exito');
                        console.log(data);
                        $('#oculto').toggle('slow');*/
                        // $('div.head-edit').find('span.head').html('Editar Registro '+ $id);
                        //$('form#frm_edit').attr('data-id', $id);
                        // data.servicios.forEach(element => {
                        // console.log(element);
                        //  $('#servicio').append('<option data='+element.descripcion+''+'value='+element.id+'>'+element.descripcion+'</option>');
                        // });
                $('#oculto').slideToggle('slow');
                //$('#frm_add_new')[0].reset();
                    });
                    
                }
            });
        }
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
                order: [ 5, 'asc' ],
                columns: [
                    {data: 'id', name: 'id' },
                    {data:'clientes.nombre', name:'clientes.nombre'},
                    {data:'clientes.direccion', name:'clientes.direccion'},
                    {data:'descripcion',name:'descripcion'},
                    {data:'servicio.descripcion', name:'servicio.descripcion'},
                    {data:'fecha_ini', name:'fecha_ini'},
                    {data:'fecha_fin', name:'fecha_fin'},
                    {data:'estado', name:'estado'},
                    { data:'action', name: 'action', orderable: false, searchable: false }
                ]   
            });
        }
          $(document).ready(function () {
            showTable();
            bindButtons();
        });
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
            orientation: "bottom auto",
            todayHighlight: true
        });
        $('.datepicker').datepicker({
            format: "dd-mm-yy",
            clearBtn: true,
            orientation: "bottom auto",
            todayHighlight: true
        }); 
     
        $(document).ready(function(){
            $telefonos=[];
            $telefonosP=[];
            $servicios=[];
            
        });
       
     </script>
   
@endsection
