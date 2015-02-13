<!-- EXPERIMENTAL STYLES -->
    <style>
    #email > div > div > div > form > div > div.btn-group.btn-group-sm.pull-left > button{
        display: none;
    }
    </style>

    <div class="panel panel-primary" >
        <div class="panel-heading">
            <a href="{{url('pedidos/create')}}" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i>
                Novo pedido
            </a>
            <h3 class="title">PEDIDOS</h3>
        </div>
        
    <div class="table-responsive">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#naoenviados" role="tab" data-toggle="tab">
                    <strong>ABERTOS</strong>
                </a>
            </li>
            <li>
                <a href="#todos" role="tab" data-toggle="tab">
                    <strong>FECHADOS</strong>
                </a>
            </li>        
            <li>
                <a href="#emails" role="tab" data-toggle="tab">
                    <strong>E-MAILS</strong>
                </a>
            </li>
        </ul>


        <!-- <div class="panel-body">
            <div class="row">
                <div class="col-xs-3 col-md-3">
                    
                    <div class="panel status panel-danger">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">0</h1>
                        </div>
                        <div class="panel-body text-center">                        
                            <strong>Atrasadas</strong>
                        </div>
                    </div>

                </div>          
                <div class="col-xs-3 col-md-3">
                  
                    <div class="panel status panel-info">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">0</h1>
                        </div>
                        <div class="panel-body text-center">                        
                            <strong>Pra hoje</strong>
                        </div>
                    </div>

                </div>
                <div class="col-xs-3 col-md-3">
                   
                    <div class="panel status panel-info " >
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">0</h1>
                        </div>
                        <div class="panel-body text-center">                        
                            <strong>Essa semana</strong>
                        </div>
                    </div>
                 
                </div>
                <div class="col-xs-3 col-md-3">
                  
                    <div class="panel status panel-success">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">+</h1>
                        </div>
                        <div class="panel-body text-center">                        
                            <strong>ADICIONAR</strong>
                        </div>
                    </div>

                 
                </div>
            </div>
        </div> -->


        <!-- Tab panes -->
    <div class="tab-content">

        <!-- TAB PANE -->
        <div class="tab-pane active" id="naoenviados">
            
            <h4 class="title">{{count( $pedidos->aguardando )}} pedidos aguardando</h4>
            <br>
            <div class="table-responsive">
                <table id="pedidos_aguardando" class="table">
                    <thead class="bg-primary">
                        <tr>                            
                            <th width="20">Nº</th>   
                            <th width="80">Data</th>
                            <th>Cliente</th>                
                            <th>Fornecedor</th>
                            <th width="120" align="right">Total</th>                
                            <th width="160" align="right"></th>
                        </tr>
                    </thead>
                    <tbody class="fade in">
                        @foreach($pedidos->aguardando as $pedido)
                            <tr>
                                <!-- <td>
                                    <i class="fa fa-circle fa-led {{( @$pedido->status == '2' ) ? 'success' : 'danger'}}"></i>
                                </td> -->
                                <td>{{$pedido->id}}</td>
                                <td>{{ date( "d/m/Y", strtotime($pedido->created_at) ) }}</td>
                                <td>
                                    <a href="{{ url('/pedidos/'.$pedido->id) }}" >                                    
                                        {{ ($pedido->cliente['empresa']) ? $pedido->cliente['empresa'] : @$pedido->cliente['nome'] }}
                                    </a>
                                </td>
                                <td>{{($pedido->fornecedor->empresa)?$pedido->fornecedor->empresa: @$pedido->fornecedor->nome}}</td>
                                <td><span class="money">{{$pedido->total}}</span></td>
                                <td width="auto" align="right">
                                                                       
                                        
                                            {{ Form::open(array('url' => 'pedidos/' . $pedido->id, 'class' => 'text-right', 'style' => 'min-width:175px;' )) }}
                                            
                                                <a href="{{ url('/emails/create/?owner_type=pedido&owner_id='.$pedido->id) }}" class="btn btn-link btn-sm send" data-toggle="modal" data-target="#email">
                                                   <i class="fa fa-envelope"></i>
                                                </a> 

                                                <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                                    <i class="fa fa-print"></i>
                                                </a>  

                                                <div class="btn-group btn-group-sm">
                                                    {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm danger text-danger', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este pedido da lista?")', 'tabindex'=>"-1" )) }}
                                                </div> 

                                                {{ Form::hidden('_method', 'DELETE') }}

                                            {{ Form::close() }}  
                                        
                                            <!-- <a href="{{ url('/pedidos/'.$pedido->id) }}" role="menuitem" tabindex="-1" class="">
                                               <i class="fa fa-chevron-right"></i>
                                            </a>  --> 
                                    
                                </td>
                            </tr>
                        @endforeach                   
                        <?php // print_r($pedidos); exit; ?>
                    </tbody>
                </table>

            </div>

        </div>

        <!-- TAB PANE -->
        <div class="tab-pane" id="todos">
            <h4 class="title">{{count($pedidos->enviados)}} pedidos fechados e enviados</h4>
            <br>
            <div class="table-responsive">
                <table  id="pedidos_enviados" class="table" style="min-width:850px;">
                    <thead class="bg-primary">
                        <tr>                            
                            <th width="20">Nº</th>   
                            <th width="80">Data</th>
                            <th>Cliente</th>                
                            <th>Fornecedor</th>
                            <th width="120" align="right">Total</th>                
                            <th width="160" align="right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos->enviados as $pedido)
                            <tr>
                                <!-- <td>
                                    <i class="fa fa-circle fa-led {{( @$pedido->status == '2' ) ? 'success' : 'danger'}}"></i>
                                </td> -->
                                <td>{{$pedido->id}}</td>
                                <td>{{ date( "d/m/Y", strtotime($pedido->created_at) ) }}</td>
                                <td>
                                    <a href="{{ url('/pedidos/'.$pedido->id) }}" >                                    
                                        {{ ($pedido->cliente['empresa']) ? $pedido->cliente['empresa'] : @$pedido->cliente['nome'] }}
                                    </a>
                                </td>
                                <td>{{($pedido->fornecedor->empresa)?$pedido->fornecedor->empresa: @$pedido->fornecedor->nome}}</td>
                                <td><span class="money">{{$pedido->total}}</span></td>
                                <td align="right">
                                                                       
                                        {{ Form::open(array('url' => 'pedidos/' . $pedido->id, 'class' => 'text-right', 'style' => 'min-width:175px;' )) }}

                                                <a href="{{ url('/emails/create/?owner_type=pedido&owner_id='.$pedido->id) }}" class="btn btn-link btn-sm send" data-toggle="modal" data-target="#email">
                                                   <i class="fa fa-envelope"></i>
                                                </a> 

                                                <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                                    <i class="fa fa-print"></i>
                                                </a>  

                                                <div class="btn-group btn-group-sm">
                                                    {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este pedido da lista?")', 'tabindex'=>"-1" )) }}
                                                </div> 

                                                {{ Form::hidden('_method', 'DELETE') }}

                                            {{ Form::close() }}  

                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach                   
                        <?php // print_r($pedidos); exit; ?>
                    </tbody>
                </table>

            </div>
        </div>

        <!-- TAB PANE -->
        <div class="tab-pane" id="emails">
            <h4 class="title">{{count($pedidos->emails)}} e-mails enviados</h4>
            <br>
            @foreach ($pedidos->emails as $email)    

                <a class="{{$email->status}} list-group-item" data-toggle="collapse" data-parent="#emails" href="#email_{{$email->id}}">
                    <p class="list-group-item-text">
                        Pedido nº {{$email->resource_id}} enviado para <strong>{{$email->to}}</strong> <em class="timeago" title="{{$email->created_at}}"></em>
                    </p>                                    
                </a>

                <div id="email_{{$email->id}}" class="panel-collapse collapse collapsed bg-{{$email->status}}">                     

                    <div class="row panel-body">

                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                <strong>Para</strong>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                 <p>{{$email->to}}</p>
                            </div>                                   
                            
                            @if ( $email['cc'] )   
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                    <strong>CC</strong>
                                </div>
                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    <p>{{$email->cc}}</p>
                                </div>
                                
                            @endif

                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                <strong>Assunto</strong>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <p>{{$email->subject}}</p>
                            </div>
                            
                            
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                <strong>Mensagem</strong>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <p>{{$email->message}}</p>
                            </div>
                            

                            @if( $email['attachments'] )                        
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                    <strong><i class="fa fa-paperclip"></i></strong>
                                </div>
            
                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    <p>                                        
                                        @if ( $email->status == 'danger' )                                            
                                                <i class="fa fa-file-pdf-o"></i> 
                                                {{$email->attachments}}                                        
                                        @else
                                            <a href="{{asset('pdf/'.$email->attachments)}}">
                                                <i class="fa fa-file-pdf-o"></i> 
                                                {{$email->attachments}}
                                            </a>
                                        @endif
                                    </p>
                                </div>                        
                            @endif   

                            <div class="clearfix"></div>

                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                            @if( $email->status == '' )                        
                                <h1 class="title">ENVIADO</h1>
                                <p>
                                    <strong>Este e-mail foi enviado porém ainda não foi aberto por ninguém.</strong><br>                                    
                                </p>
                                
                            @endif

                            @if( $email->last_open == $email->to and $email->status == 'success' )                        
                                <h1 class="title">RECEBIDO</h1>
                                <p>
                                    Aberto por: <br>      
                                    <strong>{{$email->last_open}}</strong><br>
                                    <small><em class="timeago" title="{{$email->updated_at}}"></em></small>
                                </p>
                                
                            @endif

                            @if( $email->status == 'info' )                        
                                <h1 class="title">VISUALIZADO</h1>
                                <p>
                                    <strong>Este e-mail foi aberto <em class="timeago" title="{{$email->updated_at}}"></em> por {{$email->last_open}},<br> porém ainda não foi visto por {{$email->to}}</strong><br>                                    
                                </p>
                                
                            @endif

                            @if( $email->status == 'warning' )                        
                                <h1 class="title">PEDIDO ALTERADO</h1>
                                <p>
                                    <strong>Este e-mail é inválido pois o pedido nº {{$email->resource_id}} foi alterado.</strong><br>
                                    <small><em class="timeago" title="{{$email->updated_at}}"></em></small>
                                </p>
                                
                            @endif

                            @if( $email->status == 'danger' )                        
                                <h1 class="title">PEDIDO EXCLUÍDO</h1>
                                <p>
                                    <strong>Este e-mail é inválido pois o pedido nº {{$email->resource_id}} foi excluído.</strong><br>
                                    <small><em class="timeago" title="{{$email->updated_at}}"></em></small>
                                </p>
                                
                            @endif

                        </div>

                    </div>
                    
                </div>


            @endforeach


        </div>
    </div>
</div>               
    
    </div>

    










@section('scripts')
<script>
    // $('.send').click(function(){

      
    //     $('.modal-body').load( $(this).attr("href"), function(result){

    //         $('.modal').one('shown.bs.modal', function (e) {
    //             // this handler is detached after it has run once
    //             console.log('1');
    //         }).one('hidden.bs.modal', function(e) {
    //             // this handler is detached after it has run once
    //             console.log('2');
    //         }).modal({show:true});

    //     // $('.modal').modal({show:true});
    //     //(function($) {
    //         /**
    //          * WYSIWYG
    //          */
            
    //     //})(jQuery);
    //     //
    //     });
      
        
    // });

    jQuery(document).ready(function($) {
        $('#pedidos_enviados').dynatable();
        $('#pedidos_aguardando').dynatable();
    });

</script>
@stop