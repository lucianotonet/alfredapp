<tr>
    <td>
        @if ( $pedido->status == '2')
            <i class="fa fa-circle fa-led success" data-toggle="tooltip" data-placement="left" title="Enviado"></i>
        @else            
            <i class="fa fa-circle fa-led danger" data-toggle="tooltip" data-placement="left" title="Não enviado"></i>
        @endif
    </td>
    <td>{{$pedido->id}}</td>
    <td>{{$pedido->data}}</td>
    <td>
        <a href="{{ url('/pedidos/'.$pedido->id) }}" >                                    
            {{ ($pedido->cliente['empresa']) ? $pedido->cliente['empresa'] : @$pedido->cliente['nome'] }}
        </a>
    </td>
    <td>{{($pedido->fornecedor->empresa)?$pedido->fornecedor->empresa: @$pedido->fornecedor->nome}}</td>
    <td>R$ {{$pedido->total}}</td>
    
    <td align="right">
                                           
            <div class="dropdown btn-group btn-group-justified">
                <a href="{{ url('/emails/create/pedido/'.$pedido->id) }}" class="btn btn-primary btn-sm send" data-toggle="modal" data-target="#email">
                   <i class="fa fa-envelope"></i>
                </a>                                
                <a id="dLabel2" role="button" data-toggle="dropdown" data-target="#" href="" class="btn btn-primary btn-sm">
                    Opções <i class="fa fa-caret-down"></i>
                </a>

                
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel2">
                    <li role="presentation">
                        <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="btn btn-primary btn-sm send" data-toggle="modal" data-target="#email">
                           <i class="fa fa-eye"></i> Visualizar
                        </a>                                      
                    </li>
                    <li role="presentation">
                        <a href="{{ url('/pedidos/'.$pedido->id) }}" role="menuitem" tabindex="-1" class="">
                           <i class="fa fa-chevron-right"></i> Ver
                        </a>                                        
                    </li>
                    <li role="presentation">
                        <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="" role="menuitem" tabindex="-1" >
                            <i class="fa fa-edit"></i> Editar
                        </a>                                        
                    </li>                                    
                    <li role="presentation" class="divider"></li>
                    <!-- <li role="presentation">
                        <a href="{{ url('/pedidos/send/'.$pedido->id) }}" role="menuitem" tabindex="-1" class="">
                           <i class="fa fa-envelope"></i> Enviar agora
                        </a>                                        
                    </li> -->
                    <li role="presentation">
                        <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="" role="menuitem" tabindex="-1" >
                            <i class="fa fa-eye"></i> Visualizar impressão
                        </a>                                        
                    </li>                                    
                    <li role="presentation" class="divider"></li>
                    <li role="presentation">
                        {{ Form::open(array('url' => 'pedidos/' . $pedido->id, 'class' => '')) }}
                            {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger btn-block btn-sm', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Deseja excluir este pedido da lista?")', 'role'=>"menuitem", 'tabindex'=>"-1" )) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::close() }}                                         
                    </li>
                
                </ul>

            
        </div>
    </td>
</tr>