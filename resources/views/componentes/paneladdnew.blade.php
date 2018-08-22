<div class="card text-white bg-primary" id="oculto" style="display: none">
    <div class="card-header">
        Agregar Nuevo
        <button id="cerrar" class="btn btn-danger" style="padding: 2px 8px;float: right">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="card-body">
        <form  method="POST" id="frm_add_new" role="form" data-toggle="validator" action="{{ url($mod.'/add_new') }}">
            {{csrf_field()}} {{ method_field('POST') }}

            {{ $inputs }}

            <button class="btn btn-danger" id="send" >Agregar</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('button#cerrar').click(function() {
            $('div#oculto').toggle('slow');
        });

        $('#send').click(function(e) {
            $frm = $('#frm_add_new');
            e.preventDefault();
            $url = $frm.attr('action');
            $token = $('input[name="_token"]').val();
            $.ajax({
                type:'POST',
                url:$url,
                dataType: 'json',
                data:$frm.serialize(),
            }).done(function(data){
                console.log(data);
                $('#oculto').slideToggle('slow');
                showTable();
            });
        });

    });
</script>