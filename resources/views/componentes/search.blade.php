<div class="card">
    <div class="card-body">
        <form method="POST" id="frm_search" role="form" data-toggle="validator" action="{{ url($mod.'/buscar') }}">
            {{csrf_field()}} {{ method_field('POST') }}
            <div class="input-group input-group-lg">
                <input type="search" id="search" name="query" class="form-control" placeholder="Buscar" required>
                <span class="input-group-btn">
                    <button type="submit" id="search_btn" class="btn btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </span>

            </div>
            {{ $inputs }}
        </form>
        <div class="content-search">

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#search_btn').click(function(e) {
            $frm = $('#frm_search');
            e.preventDefault();
            $url = $frm.attr('action');
            $token = $('input[name="_token"]').val();
            $query = $('#search').val();
            $.ajax({
                type:'POST',
                url:$url,
                dataType: 'json',
                data:$frm.serialize(),
            }).done(function(data){
                $('div.content-search').html(data);
                $('div.content-search').slideDown();
                bindItems();
            });
        });

        function bindItems(){
            $('.search-result').click(function(e){
                e.preventDefault();
                $('div.content-search').slideUp();
                $('#oculto_view').toggle('slow');
                var $id = $(this).attr('data-id');
                $('div.head-view').find('span.head').html('Registro '+ $id);
                getItem($id);
            });
        }

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
