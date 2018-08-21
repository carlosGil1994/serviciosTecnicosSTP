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
            function showTable(){
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    
                    ajax: "{{ route('bancos.show') }}",
                    type: 'GET',
                    columns: [
                        { data: 'nombre', name: 'nombre' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
                setTimeout(()=>{
                    bindButtons();
                },1500);
            }

            function bindButtons(){
                $('button').click(function(){
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
                
                            });
                        }
                        
                    }
                    else if($(this).hasClass('editar')){
                        
                    }
                        
                });
            }
            
        });
    </script>

@endsection

