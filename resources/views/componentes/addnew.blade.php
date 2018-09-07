<div class="card">
    <div class="dashbox panel panel-default">
        <div class="card-body">
            <div class="row">
                    <div class="col">
                        <h3>{{ $count }}</h3>
                    </div>
                    <div class="col">
                        <h3>{{ $header }}</h3>
                    </div>
                    <div class="col">
                        <button type="button" id="btn-add-new" class="btn btn-primary btn-lg">
                            <i class="fa fa-plus"></i>
                            Agregar nuevo
                        </button>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#btn-add-new').click(function() {
           // $('#send').html('editar');
           // $('#frm_add_new').attr('action','{{ url('Servicios/index')}}');
            $('div#oculto').toggle('slow');
            $('div.content-search').html('');
        });
    });
</script>