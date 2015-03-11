<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="panel-title title">PEDIDO nº {{$pedido->id}}</h3>
    </div>

        <!-- List group -->
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row ">
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row ">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">                 
                               <h4 class="title text-right">Vendedor</h4>
                            </div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4 border-left">                                     

                                <h3 class="title">{{$pedido->vendedor->nome}}</h3>      
                                <?php 
                                    echo ($pedido->vendedor->telefone) ? $pedido->vendedor->telefone.'<br />' : '';
                                    echo ($pedido->vendedor->celular) ? $pedido->vendedor->celular.'<br />' : '';
                                    echo '<br />';
                                    echo ($pedido->vendedor->ie) ? 'IE '.$pedido->vendedor->ie.'<br />' : '';                                
                                ?>
                            </div>                                

                            <div class="col-xs-2 col-sm-2 visible-xs-block visible-sm-block">                 

                            </div>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <strong>ENDEREÇO</strong>
                                <br>
                                <?php 
                                    echo ($pedido->vendedor->endereco) ? $pedido->vendedor->endereco.'<br />' : '';
                                    echo ($pedido->vendedor->bairro) ? 'Bairro '.$pedido->vendedor->bairro.'<br />' : '';
                                    echo ($pedido->vendedor->cidade) ? $pedido->vendedor->cidade.' - '.$pedido->vendedor->uf.'<br />' : '';
                                    echo ($pedido->vendedor->cep) ? $pedido->vendedor->cep.'<br />' : '';                                
                                ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </li>
    

        <li class="list-group-item">
            <div class="row ">
                
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    
                    <div class="well-lg bg-info">
                        <div class="row">

                            <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                               <h4 class="title text-right">Cliente</h4>
                            </div>
                            <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 border-left">

                                <h3 class="title">{{($pedido->cliente->empresa) ? $pedido->cliente->empresa : @$pedido->cliente->nome}}</h3>                      
                                <strong>
                                    <?php echo ($pedido->cliente->cnpj) ? "(".$pedido->cliente->cnpj . ")<br />" : "" ?>
                                    <?php echo ($pedido->cliente->empresa) ? $pedido->cliente->nome : "" ?>
                                </strong>
                                <p>
                                    <?php 
                                        echo ($pedido->cliente->telefone) ? $pedido->cliente->telefone.'<br />' : '';
                                        echo ($pedido->cliente->celular) ? $pedido->cliente->celular.'<br />' : '';
                                        echo '<br />';
                                        echo ($pedido->cliente->ie) ? 'IE '.$pedido->cliente->ie.'<br />' : '';                                
                                        echo ($pedido->cliente->endereco) ? $pedido->cliente->endereco.'<br />' : '';
                                        echo ($pedido->cliente->bairro) ? 'Bairro '.$pedido->cliente->bairro.'<br />' : '';
                                        echo ($pedido->cliente->cidade) ? $pedido->cliente->cidade.' - '.$pedido->cliente->uf.'<br />' : '';
                                        echo ($pedido->cliente->cep) ? $pedido->cliente->cep.'<br />' : '';                                
                                    ?>
                                </p>

                            </div>
                        </div>

                    </div>
                    
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                    <div class="row ">
                        <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                 
                           <h4 class="title text-right">Fornecedor</h4>
                        </div>
                        <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 border-left">        
                            
                            <h3 class="title">{{($pedido->fornecedor->empresa) ? $pedido->fornecedor->empresa : $pedido->fornecedor->nome}}</h3>                        
                            <p>
                                <?php 
                                    echo ($pedido->fornecedor->telefone) ? $pedido->fornecedor->telefone.'<br />' : '';
                                    echo ($pedido->fornecedor->celular) ? $pedido->fornecedor->celular.'<br />' : '';
                                    echo '<br />';
                                    echo ($pedido->fornecedor->ie) ? 'IE '.$pedido->fornecedor->ie.'<br />' : '';                                
                                    echo ($pedido->fornecedor->endereco) ? $pedido->fornecedor->endereco.'<br />' : '';
                                    echo ($pedido->fornecedor->bairro) ? 'Bairro '.$pedido->fornecedor->bairro.'<br />' : '';
                                    echo ($pedido->fornecedor->cidade) ? $pedido->fornecedor->cidade.' - '.$pedido->fornecedor->uf.'<br />' : '';
                                    echo ($pedido->fornecedor->cep) ? $pedido->fornecedor->cep.'<br />' : '';                                
                                ?>
                            </p>

                        </div>
                    </div>

                    
                    
                </div>
                
            </div>

        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="dados_entrega">
                            <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                                <h4 class="title text-right">ENTREGA</h4>
                            </div>
                            <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 border-left">                    
                                <h3 class="title">{{$pedido->entrega_data}}</h3>                                    
                                <small>{{ AboutDate::date($pedido->entrega_data, 'l') }}</small>   
                                <br>
                                <br>
                                <p>
                                    <strong>FRETE</strong>
                                    <br>
                                    <input type="checkbox" class="primary" value="CIF" <?php if($pedido->frete == "CIF"){ echo 'checked'; }else{ echo 'disabled'; } ?> > CIF 
                                    <input type="checkbox" class="primary" value="FOB" <?php if($pedido->frete == "FOB"){ echo 'checked'; }else{ echo 'disabled'; } ?> > FOB
                                </p>                  
                            </div>

                            <div class="clearfix"></div>

                            

                            <div class="clearfix"></div>

                            <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                               <h4 class="title text-right"></h4>
                            </div>            
                            <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">    

                            </div>          
                            &nbsp;
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                
                    <strong>ENDEREÇO</strong>
                    <br>
                    <p class="">{{$pedido->entrega_endereco}}</p>    
                           
                </div>
            </div>
        </li>        
        <li class="list-group-item">
            <!-- PRODUTOS -->
            <h4 class="title">Produtos</h4><br>


            <table class="table table-striped table-hover">
                <thead class="bg-info">
                    <tr>
                        <th width="75">Qtd.</th>    
                        <th width="50">Cód</th>    
                        <th>Itens</th>
                        <th width="130">Preço unitário</th>
                        <th width="130">Subtotal</th>
                    </tr>
                </thead>
                <tbody>       
                    <?php foreach ($pedido_itens as $item){ ?>
                    <tr>
                        <td>{{ $item['qtd'] }} {{ $item['unidade'] }}</td>
                        <td>{{ $item['produto']->cod }}</td>
                        <td>{{ $item['produto']->nome }}</td>
                        <td>R$ <span class="price">{{ $item['preco'] }}</span></td>
                        <td>R$ <span class="price">{{ $item['subtotal'] }}</span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                
                <em class="" style="margin: 0px 10px;font-size: 14px;">Total</em>
                <h3 class="title pull-right">R$ <span class="price">{{$pedido->total}}</span></h3>
                <br>
                <br>
                <em class="" style="margin: 0px 10px;font-size: 14px;">Pagamento</em>
                <p>{{$pedido->pgto}}</p>
                           
            </div>
            &nbsp;
        </li>    
        <li class="list-group-item">        
            <strong>Observações</strong><br>
            <p class="form-control-static">{{$pedido->obs}}</p>        
        </li>              
    </ul>   
    <ul class="list-group">
        <div class="list-group-item disabled">
            @include('pedidos.panels.observacoes')
        </li>      
    </ul>
    <div class="panel-body admin_obs bg-info hidden-print"> 
        Notas administrativas</strong> <small>(Não aparece no pedido)</small><br>
        <p class="form-control-static">{{$pedido->obs_adm}}</p>        
    </div>   

    <div class="panel-footer hidden-print">
        <div class="btn-group pull-left">
            <!-- <button type="submit" class="btn btn-primary">
                <i class="fa fa-envelope"></i> Enviar
            </button> -->
            <button type="button" class="btn btn-primary">
                <i class="fa fa-chevron-left"></i> Voltar
            </button>
        </div>
        <div class="btn-group pull-right">
            <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="btn btn-info">
                <i class="fa fa-eraser"></i> Editar
            </a>
            <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="btn btn-primary">
                <i class="fa fa-eye"></i> Preview
            </a>
            <a href="{{ url('/pedidos/send/'.$pedido->id ) }}" class="btn btn-primary">
                <span class="glyphicon glyphicon-send"></span> Enviar pedido
            </a>
        </div>   
        <div class="clearfix"></div>
    </div>

</div>