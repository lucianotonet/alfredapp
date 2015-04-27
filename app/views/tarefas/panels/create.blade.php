<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="title">NOVA TAREFA</h3>
    </div>

    {{ Form::open(array('url' => 'tarefas', 'id' => 'tarefa_create', 'method' => 'post')) }}

    <div class="panel-body">
        <div class="btn-group btn-group-justified">
            <a href="{{ url( 'agenda/create' ) }}" class="btn btn-default text-uppercase" data-target="#modal">
                <i class="icon-edit"></i> Evento
            </a>                                
            <a href="{{ url( 'tarefas/create/' ) }}" class="btn btn-primary text-uppercase" data-target="#modal">
                <i class="fa fa-check-square-o"></i>                        
                Tarefa
            </a>        
        </div>
    </div>
    
        <div class="panel-body form-horizontal ">
            @if ( !empty( $cliente ) )                
                <div class="form-group">
                    <label for="tipo" class="col-sm-3 control-label">Cliente</label>
                    <div class="col-sm-9">
                        @include( 'clientes.panels.item', compact( 'cliente' ) )                
                        <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                    </div>
                </div>
            @endif
            @if ( !empty( $conversa ) )
                @include( 'conversas.panels.item', compact( 'conversa' ) )
                <input type="hidden" name="conversa_id" value="{{$conversa->id}}">                
            @endif

            <div class="form-group">
                <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                <div class="col-sm-9">
                    <select class="form-control" name="tipo" id="tipo">
                        <option value="1">Ligação</option>
                        <option value="2">Visita</option>
                        <option value="3">Compromisso</option>
                        <option value="4">Relatório</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Descrição</label>     
                <div class="col-sm-9">
                    <textarea class="form-control" id="title" name="title"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="start" class="col-sm-3 control-label">Prazo</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="start" name="start" value="{{date('Y-m-d')}}">
                </div>
            </div>
        </div>        

        <div class="panel-footer">
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group-sm pull-right">

                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-check"></i> Salvar
                    </button>

                </div>
            </div>
        </div>

    {{ Form::close() }}

</div>

<script>
    $(function() {

        /*
            MODAL RELOAD    
         */ 
        $.each( $("#modal [data-target=#modal]"), function(index, val) {
            $(this).removeAttr('data-toggle');
        });
        
        $("#modal [data-target=#modal]").click(function(ev) {
            // alert();
            ev.preventDefault();
            $("#modal .modal-content").html( $('.loading-splash').html() );

            var target = $(this).attr("href");
            $("#modal .modal-content").load(target, function() { 
                $("#modal").modal("show"); 
            })
            
        });

        /*
            DATEPICKER
        */
        $('input[type="text"].datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            orientation: "top right",
            autoclose: true,
            todayHighlight: true
        });    

        /*
            ICONPICKER
         */
        $('[role=iconpicker]').iconpicker({
            arrowClass: 'btn-primary',
            arrowPrevIconClass: 'fa fa-chevron-left',
            arrowNextIconClass: 'fa fa-chevron-right',
            cols: 5,
            icon: 'fa-star',
            iconset: 'fontawesome',   
            labelHeader: 'pág {0}',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom',
            rows: 5,
            search: false,
            searchText: 'Search',
            selectedClass: 'btn-success',
            unselectedClass: ''
        }).on('change', function(e) { 
            $("input[name=icon]").val(e.icon);
            console.log(e.icon);
        });

        

        // AUTOCOMPLETE
        $('input.autocomplete').autocomplete({            
            serviceUrl: "/categories",            
            params: {'owner_type':'tarefa'},
            onSelect: function (suggestion) {
                $(this).val( suggestion.value );
            },
            onSearchStart: function (query) {
                $(this).next('.form-control-feedback').removeClass('hidden');
            },
            onSearchComplete: function (query, suggestions) {
                $(this).next('.form-control-feedback').addClass('hidden')
            }
        });

    }); 
</script>