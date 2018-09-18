@extends('layouts.menu')

@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
        @slot('mostrarBoton', $mostrarBoton)
    @endcomponent
    <br>
    <table id="table" class="table table-striped table-bordered"
    width="100%" role="grid" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>name</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>

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

    <script type="text/javascript">
        $(document).ready(function () {
            showTable();
            bindButtons();
        });

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
                    ajax: "{{ route('bancos.bancosTable') }}",
                    type: 'GET',
                    columns: [
                        { data: 'nombre', name: 'nombre' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            }

            function bindButtons(){
                $(document).on('click','.btn-table',function(){
                    $id = $(this).attr('id');
                    console.log($id);
                    if($(this).hasClass('eliminar')){
                        if(confirm('¿Seguro que desea eliminar el registro?')){
                            $.ajax({
                            type:'GET',
                            url: "{{ route('bancos.delete') }}",
                            dataType: 'json',
                            data: {id : $id}
                            }).done((data)=>{
                                showTable();
                            });
                        }
                        
                    }
                    else if($(this).hasClass('editar')){
                        $id = $(this).attr('data');
                        $.ajax({
                            type:'GET',
                            url: "{{url('Bancos/show')}}/"+$id,
                            data: "&_token={{ csrf_token()}}",
                            dataType: 'json',
                            }).done((data)=>{
                                $('#send').html('editar');
                            $('#frm_add_new').attr('method',"PUT");
                            $('#frm_add_new').attr('action',"{{url('Bancos/edit')}}/"+$id);
                            $('#nombre').val(data.banco.nombre);
                            $('#oculto').slideToggle('slow');
                            });
                      
                    }
                });
            }
    </script>

@endsection

