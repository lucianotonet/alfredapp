<div class="panel panel-primary">
    <div class="panel-heading">
    <!-- <span class="loading white pull-left"></span> -->        
        <h3 class="title">EDITAR CLIENTE</h3>        
    </div>
    
    <div class="panel-body">   
        
        {{ HTML::ul($errors->all()) }}

    </div>

    {{ Form::model($cliente, [ 'method' => 'PATCH', 'route' =>[ 'clientes.update', $cliente->id ] ] ) }}   
    
        <div class="panel-body">
            
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-12">

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-briefcase"></span>
                            </div>          

                            {{ Form::text('empresa', NULL, array('class' => 'form-control input', 'placeholder' => 'Empresa' ) ) }}            

                        </div>
                    </div>


                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-briefcase"></span>
                            </div>          

                            {{ Form::text('nome', NULL, array('class' => 'form-control input', 'placeholder' => 'Nome' ) ) }}            

                        </div>
                    </div>

                </div>
                    
                <div class="col col-md-6">    

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-earphone"></span>
                            </div>          

                            {{ Form::text('telefone', NULL, array('class' => 'form-control input mask phone', 'placeholder' => 'Telefone' ) ) }}            

                        </div>
                    </div>


                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-phone"></span>
                            </div>          

                            {{ Form::text('celular', NULL, array('class' => 'form-control input mask phone', 'placeholder' => 'Celular' ) ) }}            

                        </div>
                    </div>

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-envelope"></span>
                            </div>

                            {{ Form::text('email', NULL, array('class' => 'form-control input', 'placeholder' => 'E-mail' ) ) }}       

                        </div>
                    </div>

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-envelope"></span>
                            </div>

                            {{ Form::text('ie', NULL, array('class' => 'form-control input mask ie', 'placeholder' => 'IE' ) ) }}       

                        </div>
                    </div>

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-envelope"></span>
                            </div>

                            {{ Form::text('cnpj', NULL, array('class' => 'form-control input mask cnpj', 'placeholder' => 'CNPJ' ) ) }}       

                        </div>
                    </div>

                </div>

                <div class="col col-md-6">    

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-earphone"></span>
                            </div>          

                            {{ Form::text('endereco', NULL, array('class' => 'form-control input', 'placeholder' => 'Endereço' ) ) }}            

                        </div>
                    </div>


                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-phone"></span>
                            </div>          

                            {{ Form::text('bairro', NULL, array('class' => 'form-control input', 'placeholder' => 'Bairro' ) ) }}            

                        </div>
                    </div>

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-envelope"></span>
                            </div>

                            {{ Form::text('cidade', NULL, array('class' => 'form-control input', 'placeholder' => 'Cidade' ) ) }}       

                        </div>
                    </div>

                    <div class="form-group form-group">                    
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

                            {{ Form::select('uf', $estados, $cliente->estado, array('class'=>'form-control input') ) }}
                            
                        </div>                    
                    </div>

                    <div class="form-group form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-map-marker"></span>
                            </div>

                            {{ Form::text('cep', NULL, array('class' => 'form-control input mask cep', 'placeholder' => 'CEP' ) ) }}       

                        </div>
                    </div>

                </div>

            </div>

    
        </div>

        <div class="panel-footer">

            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group pull-left">
                    <a href="{{ url('/clientes') }}" class="btn btn-primary">
                        <i class="fa fa-chevron-left"></i> Voltar
                    </a>                
                </div>
                <div class="btn-group btn-group pull-right">               
                    <a class="btn btn-danger" onclick="return teste()">
                        <i class="fa fa-times"></i> Excluir
                    </a>
                    <button type="reset" class="btn btn-info">
                        <i class="fa fa-undo"></i> Corrigir
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Salvar
                    </button>
                </div>
            </div>

        </div>
        
    {{ Form::close() }}    

</div>   