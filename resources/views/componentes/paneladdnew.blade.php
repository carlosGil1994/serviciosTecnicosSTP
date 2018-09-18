<div class="container">
<div class="card text-white bg-primary" id="oculto" style="display: none">
    <div class="card-header">
        Agregar Nuevo
        <button id="cerrar" class="btn btn-danger" style="padding: 2px 8px;float: right">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="card-body">
        <form  method="POST" id="frm_add_new" role="form" data-toggle="validator" action="{{ url($mod.'/add_new') }}">
            {{csrf_field()}}

            {{ $inputs }}
            <button class="btn btn-danger float-right" id="send" >Guardar</button>
        </form>
    </div>
</div>

</div>

<script>
    $(document).ready(function(){
      
        $('button#cerrar').click(function() {
            $('#frm_add_new').trigger("reset");
            $('#send').html('guardar');
            $('#frm_add_new').attr('method',"POST");
            $('#frm_add_new').attr('action',"{{ url($mod.'/add_new') }}");
            $('div#oculto').toggle('slow');
        });

        $('#send').click(function(e) {
            $frm = $('#frm_add_new');
            e.preventDefault();
            $url = $frm.attr('action');
            $token = $('input[name="_token"]').val();
            $method= $frm.attr('method');
            $.ajax({
                type:$method,
                url:$url,
                dataType: 'json',
                data:$frm.serialize(),
            }).done(function(data){
                alert('Se ha guardado con exito');
                console.log(data);
                $('#oculto').slideToggle('slow');
                showTable();
                $('#frm_add_new').trigger("reset");
            });
        });

    });
</script>