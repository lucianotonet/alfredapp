<div class="panel panel-primary">

    <div class="panel-heading">       
        
        <h3 class="title">VER CONVERSA</h3>
             
    </div>
            
{{ Form::open(array('url' => 'conversas', 'id' => 'conversa_create', 'class' => '')) }}

    <fieldset disabled>

        <!-- List group -->
        <ul class="list-group">
                
            <li class="list-group-item">
                <div class="row ">            
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                        <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">                
                               <h4 class="title text-left">Cliente</h4>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 border-left">
                                <h3 class="title"><?php echo ($conversa->cliente->empresa) ? $conversa->cliente->empresa : $conversa->cliente->nome ?></h3>                
                                <strong>                                
                                    <?php echo ($conversa->cliente->empresa) ? $conversa->cliente->nome : "" ?>
                                </strong>
                                <p>
                                    <?php 
                                        echo @$conversa->cliente->telefone . ' | ' . @$conversa->cliente->cidade . '.' . $conversa->cliente->uf . ' <br />';                                  
                                    ?>
                                </p>
                                <!-- <pre>
                                    <?php print_r( $conversa->cliente ) ?>
                                </pre>     -->
            
                                <input type="hidden" name="cliente_id" value="{{$conversa->cliente->id}}" required>

                            </div>
                        </div>
                        
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                        <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">                
                               <h4 class="title text-left">Data</h4>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 border-left">                      
                                <input type="date" class="form-control input-lg h4 title" name="data" value="{{ $conversa->data }}" max="{{ $conversa->creadet_at }}">
                            </div>
                        </div>
                        
                    </div>
                    
                </div>

            </li>
        
            <li class="list-group-item">
                <div class="row ">
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">                
                       <h4 class="title text-left">RESUMO</h4>
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 border-left">   
                        <p class="form-control-static">{{$conversa->resumo}}</p>        
                    </div>
                </div>
                         
            </li>

            <li class="list-group-item disabled">
                <div class="row ">            
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">                
                               <h4 class="title text-left">Previsão de compra</h4>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 border-left">   
                                <input type="date" name="previsao_compra" class="form-control input-lg h4 title" value="{{$conversa->previsao_compra}}"/> 
                                <br>       
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">                
                               <h4 class="title text-left">Previsão de instalação</h4>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 border-left">    
                                <input type="date" name="previsao_instalacao" class="form-control input-lg h4 title" value="{{$conversa->previsao_instalacao}}"/>        
                                <br>
                            </div>
                        </div>
                    </div>
                </div>     
            </li>

             
        
        </ul>

    </fieldset>
{{ Form::close() }}
        
        <style>
            #amostras input[type="number"]{
                max-width: 70px;
                text-align: right;
            }
            #amostras .list-group-item {
                padding: 3px 0px;
            }
        </style>

        <div class="panel-footer">
            <div class="btn-group pull-left">
                <!-- <button type="submit" class="btn btn-primary">
                    <i class="fa fa-envelope"></i> Enviar
                </button> -->
                <button type="button" class="btn btn-primary" onclick="javascript: window.history.back();">
                    <i class="fa fa-chevron-left"></i> Voltar
                </button>
            </div>            

            {{ Form::open(array('url' => 'conversas/' . $conversa->id, 'class' => '')) }}
                <div class="btn-group pull-right">               
                    {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger btn-sm', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Deseja excluir esta conversa para sempre?")')) }}

                    {{ Form::hidden('_method', 'DELETE') }}

                    <a href="{{ url('/conversas/'.$conversa->id.'/edit') }}" class="btn btn-info btn-sm">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                
                </div>
            {{ Form::close() }} 
  
            <div class="clearfix"></div>
        </div>
    
    
</div>