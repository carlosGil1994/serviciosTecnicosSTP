@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
    @endcomponent
  
    <br>
    <table id="table" class="table table-striped table-bordered"
    width="100%" role="grid" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Orden</th>
                <th>estado</th>
                <th>horas</th>
                <th>fecha</th>
                <th>Accion</th>
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
                        <a class="nav-link" data-toggle="tab" href="#menu1">Equipos</a>
                    </li>
                    <li id='propId' class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu2">materiales</a>
                        </li>
                    <li id='especialidadId' class="nav-item" style="display:none">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Fallas</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div id='home' class="container tab-pane active">
                        <div class="form-group">
                            <label for="accion">Acción</label>
                            <select class="form-control col-5" name="accion" id="accion">
                            @foreach ($acciones as $accion)
                                <option value={{$accion->id}}>{{$accion->nombre}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div id='menu1' class="container tab-pane fade">
                        <div class="form-group">
                                <label for="search">Buscar Equipo</label>
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
                                    <select class="form-control" name="equipos" id="equipos">
                                        <option value="">Escoger Equipos</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="cantidadE" name="cantidadE" placeholder="cantidad del equipo">
                                </div>
                                <div class="col">
                                    <button class=" btn btn-danger" id="agregarEquipo" name="agregarEquipo">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <table id="tablaEquipos" class="table">
                                    <thead class="">
                                        <tr>
                                            <th>Equipos</th>
                                            <th>Cantidad</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>  
                            </div>
                            <input id="equiposT" name="equiposT" type="hidden">
                        </div>
                    </div>
                    <div id='menu2' class="container tab-pane fade">
                        <div class="form-group">
                                <label for="search">Buscar Material</label>
                                <div class="input-group">
                                    <input type="search" id="searchM" name="searchM" class="form-control col-5" placeholder="Buscar" required>
                                    <span class="input-group-btn">
                                    <button type="submit" id="search_btn2" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </span>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-5">
                                    <select class="form-control" name="materiales" id="materiales">
                                        <option value="">Escoger materiales</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2" style="top: 4px">
                                    <label class="radio-inline"><input type="radio" value='cantidad' id='optradio' name="optradio" checked>Cantidad</label>
                                </div>
                                <div class="col-2" style="top: 4px">
                                    <label class="radio-inline"><input type="radio" value='metros' id='optradio' name="optradio">Metros</label>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="cantidadOmetros" name="cantidadOmetros" placeholder="Cantidad o Metros">
                                </div>
                                <div class="col-3">
                                        <button class=" btn btn-danger" id="agregarMaterial" name="agregarMaterial">Agregar</button>
                                    </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <table id="tablaMateriales" class="table">
                                    <thead class="">
                                        <tr>
                                            <th>Materiales</th>
                                            <th>Cantidad</th>
                                            <th>Metros</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>  
                            </div>
                            <input id="materialesT" name="materialesT" type="hidden">
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
        $(document).ready(function(){
            $equipos=[];
            $materiales=[];
            $servicios=[];
            function showTable(){
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url('Actividades/ActividadesTable')}}"+"/"+"{{$id}}",
                    type: 'GET',
                    columns: [
                        {data: 'id', name: 'id' },
                        {data:'estado',name:'estado'},
                        {data:'horas',name:'horas'},
                        {data:'fechaCreacion',name:'fechaCreacion'},
                        { data:'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            }

           /* function bindButtons(){
                $(document).on('click','.btn-table',function(e){
                    e.preventDefault();
                    $id = $(this).attr('data');
                    console.log($id);
                   if($(this).hasClass('crear')){
                        $('#oculto').toggle('slow');
                   }
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
                            $('#oculto').toggle('slow');
                            // $('div.head-edit').find('span.head').html('Editar Registro '+ $id);
                            //$('form#frm_edit').attr('data-id', $id);
                           // data.servicios.forEach(element => {
                            // console.log(element);
                           //  $('#servicio').append('<option data='+element.descripcion+''+'value='+element.id+'>'+element.descripcion+'</option>');
                           // });
                    //$('#oculto').slideToggle('slow');
                    //$('#frm_add_new')[0].reset();
                        });
                       
                    }
                });
            }*/

            showTable();
            //buscar equipos
            $("#search_btn").on("click",function(e){
                e.preventDefault();
                $busqueda=$("#search").val();

                $.ajax({
                    url: "{{ url('Equipos/busqueda')}}/"+$busqueda,
                    data: "&_token={{ csrf_token()}}",
                    type:'GET',
                    dataType: 'json',
                }).done(function(data){
                    
                    console.log(data);
                    $('#equipos').html('<option value="">Escoger Equipos</option>');
                    data.Equipos.forEach(element => {
                        let $aux=new Object();
                        $aux.descripcion=element.descripcion;
                        $aux.modelo=element.modelo;
                       // console.log(element);
                        $('#equipos').append('<option data="'+element.descripcion+' modelo '+element.modelo+'"'+'value='+element.id+'>'+element.descripcion+' modelo '+element.modelo+'</option>');
                    });
                    //$('#oculto').slideToggle('slow');
                    //$('#frm_add_new')[0].reset();
                });
            });
            // para agregar equipos //////////////////////////
            $("#tablaEquipos").on("click",'.borrarEquipo',function(e){
                e.preventDefault();
                console.log('vhjvjh');
                console.log($(this).val());
                /*for (let index = 0; index < $equipos.length; index++) {
                    if($equipos[index].equipo==){

                    }
                    
                }*/
                console.log(JSON.parse($(this).val()));
                $indice=$equipos.indexOf(JSON.parse($(this).val()));
                console.log($indice);
               if($indice>-1){
                $equipos.splice($indice, 1);
               }
               $(this).closest('tr').remove();
                //console.log($telefonosP);
            });
            $("#agregarEquipo").on("click", function(e){
                 e.preventDefault();
                // console.log($("#servicio").val());
                if($("#equipos").val()!='' && $("#cantidadE").val()!=''){
                    let $aux=new Object();
                    $aux.equipo=$("#equipos").val();
                    $aux.cantidad=$("#cantidadE").val();
                    $equipos.push($aux);
                    console.log('aqui se agrego al array equipos')
                    console.log( $equipos);

                    $("#equiposT").val(JSON.stringify($equipos));
                    console.log($("#equiposT").val());
                   $('#tablaEquipos > tbody:last-child').append('<tr><td>'+$("#equipos").attr('data')+'</td>'+'<td>'+$("#cantidadE").val()+'</td>'+'<td><button type="button" class="btn btn-primary borrarEquipo"'+"value='"+JSON.stringify($aux)+"'data='"+$aux.equipo+"'"+'>'+'borrar'+'</button>'+'</td></tr>');
                }
            });
            ////////////////////////////////////////////////////////
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
            ////////////////////materiales
            $("#search_btn2").on("click",function(e){
                e.preventDefault();
                $busqueda=$("#searchM").val();

                $.ajax({
                    url: "{{ url('Materiales/busqueda')}}/"+$busqueda,
                    data: "&_token={{ csrf_token()}}",
                    type:'GET',
                    dataType: 'json',
                }).done(function(data){
                    
                    console.log(data);
                    $('#materiales').html('<option value="">Escoger Material</option>');
                    if(data.Materiales){
                        data.Materiales.forEach(element => {
                       // console.log(element);
                        $('#materiales').append('<option data='+element.id+''+'value='+element.id+'>'+element.nombre+'</option>');
                        });
                    }
                    
                    //$('#oculto').slideToggle('slow');
                    //$('#frm_add_new')[0].reset();
                });
            });

            $("#agregarMaterial").on("click", function(e){
                 e.preventDefault();
                if($("#materiales").val()!='' && $("#cantidadOmetros").val()){
                    let $aux=new Object();
                    $aux.material=$("#materiales").val();
                    console.log('aqui lo que tiene el box');
                    console.log($('optradio').val());
                    console.log($('input[name=optradio]:checked').val());
                    if($('input[name=optradio]:checked').val()=='cantidad'){
                        $aux.cantidad=$('#cantidadOmetros').val();
                        $aux.metros='';
                    }
                    if($('input[name=optradio]:checked').val()=='metros'){
                        $aux.metros=$('#cantidadOmetros').val();
                        $aux.cantidad='';
                    }
                    $materiales.push($aux);
                    $("#materialesT").val(JSON.stringify($materiales));
                    console.log( $("#materialesT").val());
                    //console.log( $("#telefonos").val());
                    $('#tablaMateriales > tbody:last-child').append('<tr><td>'+$aux.material+'</td>'+'<td>'+$aux.cantidad+'</td>'+'<td>'+$aux.metros+'</td>'+'<td><button type="button" class="btn btn-primary borrarEquipo" data='+$("#equipo").val()+'>'+'borrar'+'</button>'+'</td></tr>');
                }
            });
            $("#tablaMateriales").on("click",'.borrartablaMateriales',function(e){
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
            ///////////////////////////////

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
            $('#tipo').change(function(){
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
                    data.servicios.forEach(element => {
                       // console.log(element);
                        $('#servicio').append('<option data='+element.descripcion+''+'value='+element.id+'>'+element.descripcion+'</option>');
                    });
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
        });
       
     </script>
   
@endsection
