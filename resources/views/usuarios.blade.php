@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
        @slot('mostrarBoton', $mostrarBoton)
    @endcomponent
    <br>

    {{--Componente de la barra de busqueda--}}
    @component('componentes.search')
        @slot('mod', $mod)
        @slot('inputs')

        @endslot
    @endcomponent
    <br>
    <table id="table" class="table table-striped table-bordered"
    width="100%" role="grid" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>
    {{--Componente del panel para agregar nuevo registro--}}
    @component('componentes.paneladdnew')
        @slot('mod', $mod)
        @slot('inputs')
        <div class="container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Datos principales</a>
                    </li>
                   
                    <li id='especialidadId' class="nav-item" style="display:none">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Especialidad</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id='home' class="container tab-pane active">
                        <br>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del usuario">
                        </div>
                        <div class="form-group">
                            <label for="apellido">apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del usuario">
                        </div>
                        <div class="form-group">
                            <label for="email">correo</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="correo del usuario">
                        </div>
                        <div class="form-group">
                            <label for="password">contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="contraseña del usuario">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class ='col'>
                                    <textarea name="direccion" id="direccion" cols="50" rows="5">Direccion</textarea>
                                </div>
                                <div class="col">
                                    <label for="tipo">Tipo</label>
                                    <select name="tipo" id="tipo">
                                        <option value=4>Cliente</option>
                                        <option value=2>Tecnico</option>
                                        <option value=3>Administrador contable</option>
                                        <option value=5>Operador</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="agregar telefono del usuario">
                                </div>
                                <div class="col">
                                    <button class=" btn btn-danger" id="agregarTlfn" name="agregarTlfn">Agregar</button>
                                </div>
                            </div>
                            <input id="telefonos" name="telefonos" type="hidden">
                        </div>
                        <div class="form-group">
                            <table id="tablaTelefonos" class="table">
                                <thead class="">
                                    <tr>
                                        <th>Telefono</th>
                                        <th>borrar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>  
                        </div>
                    </div>
                    <div id='menu1' class="container tab-pane fade">
                        <br>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombreP" name="nombreP" placeholder="Nombre deL bien">
                        </div>
                        <div class="form-group">
                            <textarea name="direccionP" id="direccionP" cols="50" rows="5">Direccion</textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" id="telefonoP" name="telefonoP" placeholder="agregar telefono del bien">
                                </div>
                                <div class="col">
                                    <button class=" btn btn-danger" id="agregarTlfnP" name="agregarTlfnP">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <table id="tablaTelefonosP" class="table">
                                <thead class="">
                                    <tr>
                                        <th>Telefono</th>
                                        <th>borrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <input id="telefonosP" name="telefonosP" type="hidden">  
                        </div>
                    </div>
                    <div id='menu2' class="container tab-pane fade">
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="servicio">Nombre</label>
                                    <select name="servicio" id="servicio">
                                        @foreach ($servicios as $servicio)
                                        <option value={{$servicio->id}}>{{$servicio->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <button class=" btn btn-danger" id="agregarServicio" name="agregarServicio">Agregar</button>
                                </div>
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <table id="tablaservicios" name='tablaservicios' class="table">
                                <thead class="">
                                    <tr>
                                        <th>servicio</th>
                                        <th>borrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <input id="serviciosT" name="serviciosT" type="hidden">   
                        </div>
                    </div>
                   
                </div>
        </div>
            
        @endslot
    @endcomponent

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

        function bindTipo(elemento){
            elemento.change(function(){
                let valorCambiado =$(this).val();
                console.log(valorCambiado);
                if(valorCambiado == 4){
                    $('#especialidadId').css('display','none');
                    $('#propId').css('display','block');
                }
                if(valorCambiado == 2){
                    //console.log($frm.attr('action'));
                    $.ajax({
                        url: "{{ url('Servicios/index')}}",
                        data: "&_token={{ csrf_token()}}",
                        type:'GET',
                        dataType: 'json',
                }).done(function(data){
                    //alert('Se ha guardado con exito');
                    console.log(data);
                    if(data.servicios){
                        data.servicios.forEach(element => {
                            // console.log(element);
                            $('#servicio').append('<option data='+element.descripcion+''+'value='+element.id+'>'+element.descripcion+'</option>');
                         });
                    }
                    //$('#oculto').slideToggle('slow');
                    //$('#frm_add_new')[0].reset();
                });
                    //$('#servicio').
                    $('#propId').css('display','none');
                    $('#especialidadId').css('display','block');
                }
                if(valorCambiado == 3){
                    $('#propId').css('display','none');
                    $('#especialidadId').css('display','none');
                }
            });
        }

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
                    ajax: "{{ url('Usuarios/usertable')}}",
                    type: 'GET',
                    columns: [
                        {data: 'name', name: 'name' },
                        {data:'apellido',name:'apellido'},
                        {data:'direccion',name:'direccion'},
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]   
                });
            }

            function bindButtons(){
                $(document).on('click','.btn-table',function(e){
                    e.preventDefault();
                    $id = $(this).attr('data');
                    console.log($id);
                  
                     if($(this).hasClass('editar')){
                        $.ajax({
                            url: "{{url('Usuarios/show')}}/"+$id,
                            data: "&_token={{ csrf_token()}}",
                            type:'GET',
                            dataType: 'json',
                        }).done(function(data){
                            $('#send').html('editar');
                            $('#frm_add_new').attr('method',"PUT");
                            $('#frm_add_new').attr('action',"{{url('Usuarios/edit')}}/"+$id);
                            $('#tablaTelefonos').html('<table id="tablaTelefonos" class="table"><thead class=""><tr><th>Telefono</th><th>borrar</th></tr></thead><tbody></tbody></table>');
                            $('#name').val(data.usuarios.name);
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
                                data.usuarios.telefonos.forEach(element => {
                                    $telefonos.push(element.numero);
                                });
                               // $telefonos=JSON.stringify(data.usuarios.telefonos);
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
                            $('#oculto').toggle('slow');
                            // $('div.head-edit').find('span.head').html('Editar Registro '+ $id);
                            //$('form#frm_edit').attr('data-id', $id);
                           /* data.servicios.forEach(element => {
                            // console.log(element);
                             $('#servicio').append('<option data='+element.descripcion+''+'value='+element.id+'>'+element.descripcion+'</option>');
                            });*/
                    //$('#oculto').slideToggle('slow');
                    //$('#frm_add_new')[0].reset();
                        });
                       
                    }
                });
            }

            showTable();
            bindButtons();
            /*$('#cerrar_edit').click(function(e) {
                e.preventDefault();
                console.log('safsaf');
                $('#oculto_edit').toggle('slow');
            });*/
            // para agregar telefonos y servicios (y eliminar) 
            $("#tablaTelefonos").on("click",'.borrarTelefono',function(e){
                e.preventDefault();
                console.log('vhjvjh');
                console.log($(this).attr('data'));
                $indice=$telefonos.indexOf($(this).attr('data'));
                console.log($indice);
               if($indice>-1){
                $telefonos.splice($indice, 1);
               }
               $(this).closest('tr').remove();
                console.log($telefonos);
            });
            $("#tablaTelefonosP").on("click",'.borrarTelefonoP',function(e){
                e.preventDefault();
                console.log('vhjvjh');
                console.log($(this).attr('data'));
                $indice=$telefonosP.indexOf($(this).attr('data'));
                console.log($indice);
               if($indice>-1){
                $telefonosP.splice($indice, 1);
               }
               $(this).closest('tr').remove();
                console.log($telefonosP);
            });
            $("#tablaservicios").on("click",'.borrartablaServicios',function(e){
                e.preventDefault();
                $indice=$servicios.indexOf($(this).attr('data'));
                console.log($indice);
               if($indice>-1){
                $servicios.splice($indice, 1);
                $("#serviciosT").val($servicios);
               }
               $(this).closest('tr').remove();
               console.log('borrado');
                console.log($servicios);
            });
            $("#agregarServicio").on("click", function(e){
                 e.preventDefault();
                // console.log($("#servicio").val());
                if($("#servicio").val()!=''){
                    $servicios.push($("#servicio").val());
                    console.log('aqui se agrego al array servicios')
                    console.log( $servicios);
                    $("#serviciosT").val($servicios);
                    console.log($("#serviciosT").val());
                   $('#tablaservicios > tbody:last-child').append('<tr><td>'+$("#servicio").val()+'</td><td>'+'<button type="button" class="btn btn-primary borrartablaServicios" data='+$("#servicio").val()+'>'+'borrar'+'</button>'+'</td></tr>');
                }
            });
            $("#agregarTlfn").on("click", function(e){
                 e.preventDefault();
                if($("#telefono").val()!=''){
                    // let $telefono= new Object();
                    // $telefono['numero']=$("#telefono").val()
                    $telefonos.push($("#telefono").val());
                    $("#telefonos").val($telefonos);
                    //console.log( $("#telefonos").val());
                    $('#tablaTelefonos > tbody:last-child').append('<tr><td>'+$("#telefono").val()+'</td><td>'+'<button type="button" class="btn btn-primary borrarTelefono" data='+$("#telefono").val()+'>'+'borrar'+'</button>'+'</td></tr>');
                }
            });
            $("#agregarTlfnP").on("click", function(e){
                 e.preventDefault();
                if($("#telefonoP").val()!=''){
                    $telefonosP.push($("#telefonoP").val());
                    $("#telefonosP").val($telefonosP);
                    console.log($telefonosP);
                    $('#tablaTelefonosP > tbody:last-child').append('<tr><td>'+$("#telefonoP").val()+'</td><td>'+'<button type="button"  class="btn btn-primary borrarTelefonoP" data='+$("#telefonoP").val()+'>'+'borrar'+'</button>'+'</td></tr>');
                }
            });
            // para que funciones el tab
            console.log($('select[name="tipo"]'));
            $('select[name="tipo"]').each(function(i,o){
                bindTipo($(o));
            });
            
        });
       
     </script>
   
@endsection
