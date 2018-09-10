@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
    @endcomponent
    <br>

    {{--Componente de la barra de busqueda--}}
   
    <br>
    <table id="table" class="table table-striped table-bordered"
    width="100%" role="grid" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>nombre</th>
                <th>apellido</th>
                <th>direccion</th>
                <th>action</th>
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
                    <li id='propId' class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Usuarios</a>
                    </li>
                    <li id='especialidadId' class="nav-item" style="display:none">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Fallas</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div id='home' class="container tab-pane active">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombreP" name="nombreP" placeholder="Nombre deL bien">
                        </div>
                        <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" name="tipo" id="tipo">
                                        <option value='Residencial'>Residencial</option>
                                        <option value='Empresa'>Comercio</option>
                                        <option value='Industrial'>Industrial</option>
                                    </select>
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
                    <div id='menu1' class="container tab-pane fade">
                            <div class="form-group">
                                    <label for="search">Buscar usuario</label>
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
                                        <select class="form-control" name="usuario" id="usuario">
                                            <option value="">Escoger usuario</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button class=" btn btn-danger" id="agregarUsuario" name="agregarUsuario">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <table id="tablaUsuarios" name="tablaUsuarios" class="table">
                                        <thead class="">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Borrar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>  
                                </div>
                                <input id="usuariosT" name="usuariosT" type="hidden">
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
        function showTable(){
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url('Clientes/clienteTable')}}",
                    type: 'GET',
                    columns: [
                        {data: 'nombre', name: 'nombre' },
                        {data:'direccion',name:'direccion'},
                        {data:'tipo',name:'tipo'},
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]   
                });
        }
        $(document).ready(function(){
            $telefonos=[];
            $telefonosP=[];
            $usuarios=[];

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
                         if($(this).hasClass('editar')){
                            $.ajax({
                                url: "{{url('Actividades/show')}}/"+$id,
                                data: "&_token={{ csrf_token()}}",
                                type:'GET',
                                dataType: 'json',
                            }).done(function(data){
                                $('#send').html('editar');
                                $('#frm_add_new').attr('method',"PUT");
                                $('#frm_add_new').attr('action',"{{url('Actividades/edit')}}/"+$id);
                                console.log(data.actividad);
                                $('#accion').val(data.actividad.accion.id);
                                $('#horas').val(data.actividad.horas);
                                if(data.actividad.equipos){
                                    $equipos=[];
                                    console.log('si hay equipos');
                                    data.actividad.equipos.forEach(element=>{
                                        let $aux=new Object();
                                        $aux.equipo_id=element.id;
                                        $aux.cantidad=element.pivot.cantidad;
                                        $equipos.push($aux);
                                        $('#tablaEquipos > tbody:last-child').append('<tr><td>'+element.descripcion+" modelo "+element.modelo+'</td>'+'<td>'+element.pivot.cantidad+'</td>'+'<td><button type="button" class="btn btn-primary borrarEquipo"'+"value='"+JSON.stringify($aux)+"'data='"+element.id+"'"+'>'+'borrar'+'</button>'+'</td></tr>');
                                    });
                                }
                                if(data.actividad.materiales){
                                    $materiales=[];
                                    data.actividad.materiales.forEach(element=>{
                                        let $aux=new Object();
                                        $aux.material=element.nombre;
                                        $aux.material_id=element.id;
                                        if(element.pivot.cantidad!=null && element.pivot.cantidad!=''){
                                            $aux.cantidad=element.pivot.cantidad;
                                            $aux.metros='';
                                        }
                                        if(element.pivot.metros!=null && element.pivot.metros!=''){
                                            $aux.metros=element.pivot.metros;
                                            $aux.cantidad='';
                                        }
                                        $materiales.push($aux);
                                        $("#materialesT").val(JSON.stringify($materiales));
                                        console.log( $("#materialesT").val());
                                        //console.log( $("#telefonos").val());
                                        $('#tablaMateriales > tbody:last-child').append('<tr><td>'+$aux.material+'</td>'+'<td>'+$aux.cantidad+'</td>'+'<td>'+$aux.metros+'</td>'+'<td><button type="button" class="btn btn-primary borrarMaterial" data='+$aux.material_id+'>'+'borrar'+'</button>'+'</td></tr>');
                                    });
                                }
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
                showTable();
                bindButtons();

            $("#search_btn").on("click",function(e){
                    e.preventDefault();
                    $busqueda=$("#search").val();
    
                    $.ajax({
                        url: "{{ url('Usuarios/busqueda')}}/"+$busqueda,
                        data: "&_token={{ csrf_token()}}",
                        type:'GET',
                        dataType: 'json',
                    }).done(function(data){
                        
                        console.log(data);
                        $('#usuario').html('<option value="">Escoger Usuario</option>');
                        data.usuarios.forEach(element => {
                            var $aux=new Object();
                            $aux.usuario_id=element.id;
                            $aux.name=element.name;
                            $aux.apellido=element.apellido;
                            console.log($aux);
                            $('#usuario').append('<option data="'+element.id+' modelo '+element.modelo+'"'+"value='"+JSON.stringify($aux)+"'>"+element.name+' '+element.apellido+'</option>');
                        });
                        //$('#oculto').slideToggle('slow');
                        //$('#frm_add_new')[0].reset();
                    });
                });
                $("#agregarUsuario").on("click", function(e){
                     e.preventDefault();
                     console.log($("#usuario").val());
                    if($("#usuario").val()!=''){
                        let $aux=new Object();
                        $usuarioJson=JSON.parse($("#usuario").val());
                        $aux.usuario_id=$usuarioJson.usuario_id;
                        $aux.name=$usuarioJson.name;
                        $aux.apellido=$usuarioJson.apellido;
                        $usuarios.push($aux);
                        $("#usuariosT").val(JSON.stringify($usuarios));
                        console.log($aux);
                       // console.log( $("#materialesT").val());
                        //console.log( $("#telefonos").val());
                        $('#tablaUsuarios > tbody:last-child').append('<tr><td>'+$aux.name+'</td>'+'<td>'+$aux.apellido+'</td>'+'<td><button type="button" class="btn btn-primary borrarusuario" data='+$aux.usuario_id+'>'+'borrar'+'</button>'+'</td></tr>');
                    }
                });
                $("#tablaUsuarios").on("click",'.borrarusuario',function(e){
                    e.preventDefault();
                    $indice=0
                    $usuarioAborrar=JSON.parse($(this).attr('data'));
                    console.log($usuarioAborrar);
                    for (let index = 0; index < $usuarios.length; index++) {
                        if($usuarios[index].usuario_id==$usuarioAborrar){
                            console.log('lo encontre index: '+index);
                            $indice=index;
                        }
                    }
                    console.log($indice);
                   if($indice>-1){
                    $usuarios.splice($indice, 1);
                    $("#usuariosT").val($usuarios);
                    $(this).closest('tr').remove();
                   console.log('borrado');
                    console.log($usuarios);
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
           
        });

         
       
     </script>
   
@endsection
