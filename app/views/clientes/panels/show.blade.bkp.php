<div class="panel panel-primary">
    
    <div class="panel-heading">
        <h3 class="title pull-left">Ver cliente</h3>
        <i class="fa fa-circle fa-led success pull-right"></i>
        <div class="clearfix"></div>
    </div>

        
        <div class="panel-body">

            {{ Form::model($cliente, [ 'method' => 'GET' ] ) }}   
            <div class="row">

                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
                    <img src="{{asset('img/avatar.png')}}" alt="" class="img-responsive" style="max-width: 160px;margin: 0 auto;">
                    <br>
                    <div class="well" style="max-width: 400px; margin: 0 auto 10px;">
                        <a href="{{url('pedidos/create',$cliente->id)}}" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-shopping-cart"></span> Novo Pedido</a>
                        <a href="{{url('conversas/create',$cliente->id)}}" class="btn btn-primary btn-lg btn-block">
                            <span class="glyphicon glyphicon-comment"></span> Nova Conversa                            
                        </a>
                        <!-- <button type="button" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon glyphicon-saved"></span> Nova Tarefa                            
                        </button> -->
                    </div>
                </div>
                

                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

                    <div class="row">
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                </div>          

                                {{ Form::text('empresa', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Empresa', 'readonly' => 'readonly' ) ) }}            

                            </div>
                        </div>


                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                </div>          

                                {{ Form::text('nome', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Nome', 'readonly' => 'readonly' ) ) }}            

                            </div>
                        </div>

                    </div>
                        
                    
                    <div class="col col-md-6">    

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-earphone"></span>
                                </div>          

                                {{ Form::text('telefone', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Telefone', 'readonly' => 'readonly' ) ) }}            

                            </div>
                        </div>


                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-phone"></span>
                                </div>          

                                {{ Form::text('celular', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Celular', 'readonly' => 'readonly' ) ) }}            

                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </div>

                                {{ Form::text('email', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'E-mail', 'readonly' => 'readonly' ) ) }}       

                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </div>

                                {{ Form::text('ie', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'IE', 'readonly' => 'readonly' ) ) }}       

                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </div>

                                {{ Form::text('cnpj', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'CNPJ', 'readonly' => 'readonly' ) ) }}       

                            </div>
                        </div>

                    </div>

                    <div class="col col-md-6">    

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-earphone"></span>
                                </div>          

                                {{ Form::text('endereco', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Endereço', 'readonly' => 'readonly' ) ) }}            

                            </div>
                        </div>


                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-phone"></span>
                                </div>          

                                {{ Form::text('bairro', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Bairro', 'readonly' => 'readonly' ) ) }}            

                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </div>

                                {{ Form::text('cidade', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'Cidade', 'readonly' => 'readonly' ) ) }}       

                            </div>
                        </div>

                        <div class="form-group form-group-lg">                    
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                </div>

                                <?php 
                                    $estados = array(
                                            "AC" => "AC",
                                            "AL" => "AL",
                                            "AM" => "AM",
                                            "AP" => "AP",
                                            "BA" => "BA",
                                            "CE" => "CE",
                                            "DF" => "DF",
                                            "ES" => "ES",
                                            "GO" => "GO",
                                            "MA" => "MA",
                                            "MT" => "MT",
                                            "MS" => "MS",
                                            "MG" => "MG",
                                            "PA" => "PA",
                                            "PB" => "PB",
                                            "PR" => "PR",
                                            "PE" => "PE",
                                            "PI" => "PI",
                                            "RJ" => "RJ",
                                            "RN" => "RN",
                                            "RO" => "RO",
                                            "RS" => "RS",
                                            "RR" => "RR",
                                            "SC" => "SC",
                                            "SE" => "SE",
                                            "SP" => "SP",
                                            "TO" => "TO",
                                        )
                                ?>                
                                <fieldset disabled>
                                    {{ Form::select('uf', $estados, $cliente->estado, array('class'=>'form-control input-lg') ) }}
                                </fieldset>
                                
                            </div>                    
                        </div>

                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                </div>

                                {{ Form::text('cep', NULL, array('class' => 'form-control input-lg', 'placeholder' => 'CEP', 'readonly' => 'readonly' ) ) }}       

                            </div>
                        </div>

                    </div>
                </div> <!-- ROW -->
                </div>

            </div>
            {{ Form::close() }}   
    
        </div>

        <div class="panel-footer">

            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group-lg pull-left">
                    <a href="{{ url('/clientes') }}" class="btn btn-primary btn-brick">
                        <i class="fa fa-chevron-left"></i> Voltar
                    </a>                
                </div>
                

                {{ Form::open(array('url' => 'clientes/' . $cliente->id, 'class' => '')) }}
                    <div class="btn-group btn-group-lg pull-right">               
                        
                        {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger btn-lg btn-brick', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Deseja excluir este cliente da lista?")')) }}

                        {{ Form::hidden('_method', 'DELETE') }}

                        <a href="{{ url('/clientes/'.$cliente->id.'/edit') }}" class="btn btn-info btn-brick">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                    
                    </div>
                {{ Form::close() }} 
            </div>

        </div>
        

</div>    