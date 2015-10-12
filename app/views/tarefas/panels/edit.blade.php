<div class="panel panel-primary">
        
    <div class="panel-heading">        
        <h3 class="panel-title title">
            <div class="pull-right">
               
            </div>           
            Tarefa nº {{$tarefa->id}}
        </h3>
    </div>


    {{ Form::model($tarefa, [ 'method' => 'PATCH', 'route' =>[ 'tarefas.update', $tarefa->id ] ] ) }}  
    <!-- <pre><?php print_r($tarefa); ?></pre> -->
        


<div class="panel-body form-horizontal ">
            
        @if ( !empty( $tarefa->cliente ) )    
            <div class="form-group">
                <label for="tipo" class="col-sm-3 control-label">Cliente:</label>        
                <div class="col-sm-9 well-sm bg-info">   
                    @include( 'clientes.panels.item', array( 'cliente' => $tarefa->cliente ) )   
                </div>
                
                <label for="tipo" class="col-sm-3 control-label">Conversas do cliente</label>        
                <div class="col-sm-9">   
                    @foreach ($tarefa->cliente->conversas as $conversa)
                        @include( 'conversas.panels.item', compact( 'conversa' ) )
                    @endforeach                                 
                </div>
            </div>
        @endif

        <div class="form-group">
            <label for="tipo" class="col-sm-3 control-label">Concluída</label>
            <div class="col-sm-9">
                
                <div class="checkbox">
                    
                    <input type="checkbox" name="done" value="1" class="primary" <?php if($tarefa->done) echo 'checked' ?> >
                    
                </div>

                <hr>
                
                
                <!-- <label class="toggle">
                    <input type="checkbox" checked="">
                    <span class="handle"></span>
                </label> -->


                <?php if( $tarefa->done ){ ?>

                    <!-- <h2 class="title success pull-left">Concluída</h2> -->
                <?php } else{ ?>
                    <!-- <h2 class="title danger">
                        <?php if( $tarefa->atrasada() ){ ?>
                            Atrasada {{$tarefa->dias()}} dias
                        <?php } ?>
                    </h2> -->
                <?php } ?>               
                
            </div>
        </div>  
            <div class="form-group">
                <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                <div class="col-sm-9">
                    {{ Form::select('tipo',
                                    array(
                                        '1' => 'Ligação', 
                                        '2' => 'Visita',
                                        '3' => 'Compromisso',
                                        '4' => 'Relatório'
                                    ),
                                    $tarefa->tipo,
                                    array( 'class'    => 'form-control' )) }}
                    <!-- <select class="form-control" name="tipo" id="tipo">
                        <option value="1">Ligação</option>
                        <option value="2">Visita</option>
                        <option value="3">Compromisso</option>
                        <option value="4">Relatório</option>
                    </select> -->
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Descrição</label>     
                <div class="col-sm-9">
                    <textarea class="form-control" id="title" name="title">{{$tarefa->title}}</textarea>
                </div>
            </div>        
            <div class="form-group">
                <label for="date" class="col-sm-3 control-label">Prazo</label>
                <div class="col-sm-9 form-inline">
                    <input type="date" class="form-control input-group-item" id="date" name="date" value="{{date('Y-m-d', strtotime($tarefa->date))}}">
                    <span class="prazo form-control-static input-group-item"></span>
                </div>
            </div>
        </div>       

        
        <div class="panel-footer clearfix">
            
            <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary">
                <i class="fa fa-chevron-left"></i> Voltar
            </a>                               
            
            <a class="btn btn-sm btn-primary" data-toggle="collapse" href='#tarefa_notifications'><i class="icon-bell-o"></i> Notificações</a>     
        


            <!-- <a href="{{ url('/tarefas/'.$tarefa->id.'/edit') }}" class="btn btn-primary btn-sm btn-brick">
                <i class="fa fa-edit"></i> Editar
            </a> -->                    
                    
            <button type="submit" class="btn btn-sm btn-success pull-right">
                <i class="icon-check"></i> SALVAR
            </button>                

        </div>
    
                        
    {{ Form::close() }}      
    
</div>



<div class="panel panel-primary">
    
    <div class="panel-heading">        
        <a class="btn btn-sm btn-success pull-right" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>    
        <h4 class="panel-title title">EDITAR Notificações da tarefa</h4>
    </div>
    <div class="collapse colapsed in panel-body navbar-inverse" id="tarefa_notifications">
        
        {{-- EDITA AS NOTIFICAÇÕES --}}
        @if ( count($tarefa->notifications) )                    

            @foreach ($tarefa->notifications as $notification)
                @include('notifications.panels.edit', ['notification'=>$notification])   
            @endforeach
        
        @else
            
            
        @endif
            
    </div>   
</div>


 
    @if ( !empty( $conversa ) )
        <!-- <div class="list-group" id="vinculo">
            <label>Vinculado à:</label>
            <div class="list-group-item">
                <a class="close" onclick="if(confirm('Remover o vínculo?'))getElementById('vinculo').remove()">&times;</a>
                <i class="icon-chat"></i> Conversa com <strong>{{$conversa->cliente->nome}} [{{$conversa->cliente->empresa}}]</strong>

                <input type="hidden" name="conversa_id" value="{{$conversa->id}}">

            </div>
            @include( 'conversas.panels.item', compact( 'conversa' ) )
        </div> -->
    @endif


@include('notifications.panels.create', array('notification'=>$tarefa->notification))
    
   



@section('scripts')
    <script>
    jQuery(document).ready(function() {

        $('#date').on('change',function(){
            var date = new Date();
            var x = $(this).val() + " " + date.getHours() + ':' + date.getMinutes() + ':' + (date.getSeconds() + 2) ;            
            $('.prazo').text( moment( x ).fromNow() );            
        })

        $('#notification-{{$tarefa->id}}').on('change',function(){
            var date = new Date();
            var x = $(this).val() + " " + date.getHours() + ':' + date.getMinutes() + ':' + (date.getSeconds() + 2) ;            
            $('#notification-dias').text( moment( x ).fromNow() );            
        })
    });
    </script>
@stop