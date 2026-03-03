<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="panel-title"><i class="icon-calendar"></i> Adicionar</h3>
    </div>
    {{ Form::open(array('route' => 'tarefas.store', 'method' => 'POST', "class"=>"", "role"=>"form", "id"=>"tarefas_create" )) }}

    <div class="panel-body form-horizontal">

        <div class="btn-group btn-group-justified">
            <a href="{{ url( 'agenda/create' ) }}" class="btn btn-default text-uppercase" data-target="#modal">
                <i class="icon-edit"></i> Evento
            </a>                                
            <a href="{{ url( 'tarefas/create/' ) }}" class="btn btn-primary text-uppercase" data-target="#modal">
                <i class="fa fa-check-square-o"></i>  Tarefa
            </a>        
        </div>
        
        <br>

        <div class="form-group">
            <label for="input" class="col-sm-3 control-label">Título:</label>
            <div class="col-sm-9">              

                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" data-icon="fa fa-marker" role="iconpicker"></button>
                        <input type="hidden" name="icon" id="" class="form-control" value="fa-star">
                    </span>
                    <input type="text" class="form-control" name="title" placeholder="" aria-describedby="sizing-addon1" required="required">                 
                </div>                                          
            </div>
        </div>                      

        <div class="form-group">
            <label for="input" class="col-sm-3 control-label">Data:</label>
            <div class="col-sm-9 col-md-9 col-lg-9 form-inline">

                <div class="input-group">
                    <span class="input-group-addon bg-primary ">
                        <div class="icon-calendar"></div>
                    </span>
                    <input type="date" name="date" id="date" class="form-control datepicker" value="{{ date('Y-m-d') }}" required="required">

                    <span class="input-group-addon bg-primary ">
                        <i class="icon-clock"></i>
                    </span>
                    <input type="time" name="time" id="time" class="form-control" value="" >

                </div>      

                <a clas="btn btn-primary bnt-lg pull-right" data-toggle="collapse" href="#tarefas_moreinfo" aria-expanded="false" aria-controls="tarefas_moreinfo">
                    <i class="icon-circle-plus"></i> Detalhes
                </a>    

            </div>          
        </div>

        <div class="collapse" id="tarefas_moreinfo">


            <div class="form-group">
                <label for="input" class="col-sm-3 control-label">Descrição:</label>
                <div class="col-sm-9">
                    <textarea name="description" id="input" class="form-control text-uppercase" rows="5"></textarea>
                </div>
            </div>

            <!-- tabs left -->
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs col-xs-12 col-sm-3">
                    <li class="active">
                        <a href="#tarefa_notifications" data-toggle="tab">
                            <i class="icon-bell"></i> Notificações
                        </a>
                    </li>
                    <li class="">
                        <a href="#tarefa_cliente" data-toggle="tab">
                            <i class="icon icon-user"></i> Cliente
                        </a>
                    </li>
                    <li>
                        <a href="#tarefa_category" data-toggle="tab">
                            <i class="fa fa-star"></i> Categoria
                        </a>
                    </li>
                </ul>
                <div class="tab-content col-xs-12 col-sm-9">
                    <div class="tab-pane active" id="tarefa_notifications">
                        
                        <div class="list-group notifications-list"></div>               
                            
                        <div class="panel-body">

                            {{-- template --}}
                            <div class="list-group-item notifications-list-item animate template hidden">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span><i class="fa fa-envelope"></i> 30 minutos antes</span>
                                <input type="hidden" name="notifications[]" id="" class="form-control" value="">
                            </div>  


                            <div class="input-group" id="notifications_create">
                                <select class="form-control notification_type">
                                    <option value="email">E-mail</option>
                                    <option value="notification">Notificação</option>       
                                </select>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <select class="form-control notification_time">
                                    <option value="30min">30 minutos antes</option>
                                    <option value="1h">1 hora antes</option>
                                    <option value="2h">2 horas antes</option>
                                    <option value="3h">3 horas antes</option>
                                    <option value="4h">4 horas antes</option>
                                    <option value="5h">5 horas antes</option>
                                    <option value="6h">6 horas antes</option>
                                    <option value="1d">Um dia antes</option>        
                                    <option value="2d">2 dias antes</option>  
                                    <option value="3d">3 dias antes</option>
                                    <option value="7d">Uma semana antes</option>
                                    <option value="14d">Duas semanas antes</option>
                                    <option value="30d">Um mês antes</option>
                                </select>
                                <a class="input-group-addon btn btn-success btn-clone">
                                    <i class="fa fa-plus"></i> Adicionar
                                </a>
                            </div>  
                        </div>
                            
                        
                        <script>
                            $(function() {
                                $('#notifications_create a.btn-clone').click(function(e) {
                                    e.preventDefault();
                                    var data        = $('#notifications_create select').serialize();
                                    var timebefore  = $('#notifications_create select.notification_time option:selected').text();
                                    var clone       = $('.notifications-list-item.template').clone();

                                    if( $('#notifications_create select.notification_type').val() == 'email' ){
                                        var text = '<i class="fa fa-envelope"></i> ' + timebefore;
                                    }else{
                                        var text = '<i class="fa fa-bell"></i> ' + timebefore;
                                    }
                                    $('.notifications-list').append(clone);
                                    $('.notifications-list .notifications-list-item:last').addClass('slideInUp')
                                                                                          .removeClass('template')
                                                                                          .removeClass('hidden');
                                    $('.notifications-list .notifications-list-item:last span').html( text );
                                    $('.notifications-list .notifications-list-item:last input').val( data );                               
                                    
                                });

                            });
                        </script>       

                        <div class="alert alert-warning text-center"> 
                            <strong><i class="fa fa-warning"></i> Esta opção não está disponível</strong>
                        </div>              

                    </div>
                    <div class="tab-pane" id="tarefa_cliente">
                            
                        @if ( !empty( $cliente ) )                
                            <div class="list-group-item">
                                @include( 'clientes.panels.item', compact( 'cliente' ) )                
                                <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                            </div>
                        @endif
                        @if ( !empty( $conversa ) )
                            <div class="list-group-item">
                                @include( 'conversas.panels.item', compact( 'conversa' ) )
                                <input type="hidden" name="conversa_id" value="{{ $conversa->id }}">                
                            </div>
                        @endif

                    </div>
                    <div class="tab-pane" id="tarefa_category">
                        <div class="alert alert-warning text-center"> 
                            <strong><i class="fa fa-warning"></i> Indisponível</strong>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /tabs -->


        </div>


    </div>  

    <div class="panel-footer navbar-inverse">   

        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">                    
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
            </div>              
            <div class="btn-group" role="group">                    
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
            </div>
        </div>

    </div>  
    {{ Form::close() }}
</div>          


<script>
$(function() {

        /* MODAL RELOAD */ 
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

       /* DATEPICKER */     
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                language: "pt-BR",
                orientation: "top right",
                autoclose: true,
                todayHighlight: true
            });    


        /* ICONPICKER */
            $('[role=iconpicker]').iconpicker({
                arrowClass: 'btn-primary',
                arrowPrevIconClass: 'fa fa-chevron-left',
                arrowNextIconClass: 'fa fa-chevron-right',
                cols: 5,
                icon: '',
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
            params: {'owner_type':'tarefas'},
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