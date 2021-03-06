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
                    ajax: "{{ route('bancos.show') }}",
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
                        $('#oculto_edit').toggle('slow');
                        $('div.head-edit').find('span.head').html('Editar Registro '+ $id);
                        $('form#frm_edit').attr('data-id', $id);
                        $('#cerrar_edit').click(function() {
                            $('#oculto_edit').toggle('slow');
                        });
                    }
                });
            }
    </script>

@endsection

