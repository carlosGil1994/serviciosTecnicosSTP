<div class="card">
    <div class="dashbox panel panel-default">
        <div class="card-body">
            <div class="row">
                    <div style='text-align: center' class="col offset-2">
                        <h3>{{ $header }}</h3>
                    </div>
                    @if(Auth::user()->tipo!=4)
                        @if($mostrarBoton)
                            <div  class="col-2">
                                <button type="button" id="btn-add-new" class="btn btn-primary btn-lg">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            @else
                            <div  class="col-2">
                            </div>
                        @endif
                    @else
                    <div  class="col-2">
                    </div>
                    @endif
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