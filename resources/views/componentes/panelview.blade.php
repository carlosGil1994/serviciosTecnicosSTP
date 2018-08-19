<div class="card text-white bg-success" id="oculto_view" style="display: none">
    <div class="card-header head-view">
        <span class="head"></span>
        <button id="cerrar_view" class="btn btn-danger" style="padding: 2px 8px;float: right">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="card-body body-view">
        <div class="content">

        </div>
        <div class="buttons">
            <button class="btn btn-danger" id="delete-register">Eliminar Registro</button>
            <button class="btn btn-warning" id="edit-register">Editar Registro</button>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        $('button#delete-register').click(function(e){
           if(confirm('¿Seguro que desea eliminar este registro?')){
               e.preventDefault();
               var $id = $(this).attr('data-id');
               $.ajax({
                   type:'GET',
                   url: "{{url($mod.'/delete_item')}}",
                   dataType: 'json',
                   data:{id: $id},
               }).done(function(data){
                   alert('Se ha eliminado el registro '+data);
                   $('#oculto_view').slideToggle('slow');
               });
           }
           else{
               alert('No lo elimine ps :V');
           }

        });

        $('button#edit-register').click(function(e){
            e.preventDefault();
            $('div.body-view').slideUp();
            $('#oculto_edit').toggle('slow');
            var $id = $(this).attr('data-id');
            $('div.head-edit').find('span.head').html('Editar Registro '+ $id);
            $('form#frm_edit').attr('data-id', $id);
            $('#cerrar_edit').click(function() {
                $('#oculto_edit').toggle('slow');
            });
        });
    });
</script>