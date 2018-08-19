<div class="card text-white bg-warning" id="oculto_edit" style="display: none">
    <div class="card-header head-edit">
        <span class="head"></span>
        <button id="cerrar_edit" class="btn btn-danger" style="padding: 2px 8px;float: right">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="card-body body-edit">
        <form  method="POST" id="frm_edit" role="form" data-toggle="validator" action="{{ url($mod.'/edit') }}">
            {{csrf_field()}} {{ method_field('POST') }}
            {{ $inputs }}
            <input type="hidden" name="item_id" id="item_id">
            <button class="btn btn-primary" id="edit" >Editar</button>
        </form>
    </div>

</div>

<script>
    $(document).ready(function(){
        $('#edit').click(function(e) {
            $frm = $('#frm_edit');
            $id = $frm.attr('data-id');
            $('input#item_id').val($id);
            e.preventDefault();
            $url = $frm.attr('action');
            $.ajax({
                type:'POST',
                url:$url,
                dataType: 'json',
                data:$frm.serialize(),
            }).done(function(data){
                $('div.body-view').toggle('fast');
                getItem($id);
            });
        });

        function getItem($id) {
            console.log('hey desde el get item');
            $.ajax({
                type:'GET',
                url: "{{url($mod.'/get_item')}}",
                dataType:'json',
                data: {id: $id}
            }).done(function(data) {
                $('div.body-view').find('div.content').html(data);
                $('button#delete-register').attr('data-id', $id);
                $('button#edit-register').attr('data-id', $id);
                $('#cerrar_view').click(function() {
                    $('#oculto_view').toggle('slow');
                });
            });
        }
    });
</script>