<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="pull-right hidden-print">
            <a href="{{url('clientes/'.$cliente->id.'/edit')}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                   
            {{ Form::open(array('url' => 'clientes/' . $cliente->id, 'class' => 'btn-group')) }}
                <button type="submit" class="btn btn-danger" onclick="return confirm('Excluir permanetemente o cliente {{$cliente->nome}}?')" role="menuitem">
                    <i class="fa fa-times"></i>
                </button>
                <input type="hidden" name="_method" value="DELETE">
            {{ Form::close()}}               
        </div>                                   
         <h3 class="panel-title title">Cliente {{$cliente->id}}</h3>
    </div>
    <div class="panel-body tabbable tabs-left">        
        <div class="row">
            <div class="col-xs-4 col-sm-2 text-center pull-left">
                <img src="http://placekitten.com/g/250/250" alt="" class="img-thumbnail img-responsive">
            </div>        
            <div class="panel-heading">
                
                <div class="col-xs-8 col-sm-10">
                        
                    <h1 class="title">{{$cliente->nome}} <small></small></h1>                                         

                    <div class="visible-xs-block">
                        <table class="well table table-condensed">
                            <tbody class="bg-info">
                                <tr>
                                    <td class="text-right"><strong>Telefone</strong></td>
                                    <td>
                                        <h3 class="title">{{$cliente->telefone}}  </h3>                                               
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>Celular</strong></td>
                                    <td><h3 class="title">{{$cliente->celular}}</h3></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>E-mail</strong></td>
                                    <td>{{$cliente->email}}</td>
                                </tr>
                                             
                            </tbody>
                        </table>
                    </div>
                                

                </div>            
            </div>

            <div class="col-xs-12 col-sm-10 pull-left">             
                
                <ul id="myTab1" class="nav nav-pills navbar-inverse nav-justified well-sm hidden-print">
                    <li class="active"><a href="#home1" data-toggle="tab" >Contatos</a></li>
                    <li><a href="#profile1" data-toggle="tab">Pedidos <span class="badge">{{count($cliente->pedidos)}}</span></a></li>        
                    <li><a href="#dropdown1-1" tabindex="-1" data-toggle="tab">Tarefas <span class="badge">{{count($cliente->tarefas)}}</span></a></li>
                    <li><a href="#dropdown1-2" tabindex="-1" data-toggle="tab">Conversas <span class="badge">{{count($cliente->conversas)}}</span></a></li>
                </ul>
                
                <div id="myTabContent" class="tab-content panel-body disabled">
                    <div class="tab-pane fade active in " id="home1">

                        <div class="row">

                            <div class="col-sm-6">
                                <table id="pedidos" class="table table-condensed">
                                    <tbody>
                                        
                                        <tr class="">
                                            <td class="text-right"><strong>Empresa</strong></td>
                                            <td>{{$cliente->empresa}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>CNPJ</strong></td>
                                            <td>{{$cliente->cnpj}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>IE</strong></td>
                                            <td>{{$cliente->ie}}</td>
                                        </tr>       
                                        <tr>
                                            <td class="text-right"><strong>Endereço</strong></td>
                                            <td>{{$cliente->endereco}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>Bairro</strong></td>
                                            <td>{{$cliente->bairro}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>Cidade</strong></td>
                                            <td>{{$cliente->cidade}}/{{$cliente->uf}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>CEP</strong></td>
                                            <td>{{$cliente->cep}}</td>
                                        </tr>  
                                                     
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="hidden-xs col-sm-6">
                                <table class="well table table-condensed">
                                    <tbody class="bg-info">
                                        <tr>
                                            <td class="text-right"><strong>Telefone</strong></td>
                                            <td>
                                                <h3 class="title">{{$cliente->telefone}}  </h3>                                               
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>Celular</strong></td>
                                            <td><h3 class="title">{{$cliente->celular}}</h3></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>E-mail</strong></td>
                                            <td>
                                                <?php if( isset($cliente->email) ){ ?>
                                                    <a href="{{ url( '/emails/create/?mail_to='.$cliente->email ) }}" class="btn btn-link send" data-toggle="modal" data-target="#email">
                                                        {{$cliente->email}}
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <hr>

                                
                                <a href="{{ url('/emails/create/?owner_type=cliente&owner_id='.$cliente->id) }}" class="btn-block btn btn-primary send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope"></i> Enviar dados por e-mail</a>
                                
                            </div>

                        </div>


                    </div>
                    <div class="tab-pane fade row" id="profile1">
                            <div class="page-header">
                                <div class="dropdown pull-right">
                                    <a href="{{url('pedidos/create/'.$cliente->id)}}" class="btn btn-success" >
                                        <i class="fa fa-plus"></i> Novo pedido</a>
                                    </a>
                                    <a href="{{url('pedidos')}}" class="btn btn-primary" >
                                        <i class="fa fa-list"></i> Ver todos</a>
                                    </a>
                                </div>
                                <h2 class="title">Pedidos do cliente</h2>
                            </div>
                        <div class="panel-body bg-info">
                            @include('pedidos.list', array('pedidos' => $cliente->pedidos))                            
                        </div>
                    </div>
                    <div class="tab-pane fade row" id="dropdown1-1">
                        <div class="page-header">
                            <div class="dropdown pull-right">
                                <a href="{{url('tarefas/create?cliente_id='.$cliente->id)}}" class="btn btn-success" >
                                    <i class="fa fa-plus"></i> Nova tarefa</a>
                                </a>
                                <a href="{{url('tarefas')}}" class="btn btn-primary" >
                                    <i class="fa fa-list"></i> Ver todas</a>
                                </a>
                            </div>
                            <h2 class="title">Tarefas do cliente</h2>
                        </div>

                        <div class="panel-body bg-info">
                                
                            @include('tarefas.panels.index')
                            
                        </div>
                       

                    </div>
                    <div class="tab-pane fade row" id="dropdown1-2">
                        <div class="page-header">
                            <div class="dropdown pull-right">
                                <a class="btn btn-success" data-toggle="modal" href="#conversas_create">
                                    <i class="fa fa-plus"></i> Nova conversa
                                </a>
                                <a href="{{url('relatorios')}}" class="btn btn-primary" >
                                    <i class="fa fa-list"></i> Relatórios
                                </a>
                            </div>
                            <h2 class="title">Conversas do cliente</h2>
                        </div>
                        {{--@include('conversas.panels.index', array('conversas' => $cliente->conversas))--}}
                        <div class="panel-body bg-info">
                            <div class="list-group">
                                @foreach ($cliente->conversas as $conversa)
                                    @include('conversas.panels.item')
                                @endforeach
                            </div>
                        </div>
                    

                        @include('conversas.panels.create')
                        
                    </div>
                </div>
                    
            </div>

        </div>
    </div>                       


</div>