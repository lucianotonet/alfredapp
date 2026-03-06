<div class="panel panel-primary">
    <div class="panel-heading">
    <!-- <span class="loading white pull-left"></span> -->        
        <h3 class="title">ADICIONAR CLIENTE</h3>        
    </div>

    <div class="panel-body">
                        

            {{ Form::open(array('url' => 'clientes', 'id' => 'cliente_create')) }}

                <div class="row">
                    <div class="col col-md-12">
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>                      
                                <input type="text" class="form-control " id="" placeholder="Empresa" name="empresa" required>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control " id="" placeholder="Nome" name="nome">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col-md-6">
                        <!-- Contatos -->
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control mask phone" id="" placeholder="Telefone" name="telefone">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control mask phone" id="" placeholder="Celular" name="celular">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control " id="" placeholder="E-mail" name="email">
                            </div>
                        </div>
                        <!-- Extra -->
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control " id="" placeholder="IE (Inscrição Estadual)" name="ie">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control mask cnpj" id="" placeholder="CNPJ" name="cnpj">
                            </div>
                        </div>  
                    </div>
                    <div class="col col-md-6">
                        <!-- Endereço -->
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control " id="" placeholder="Endereço" name="endereco">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control " id="" placeholder="Bairro" name="bairro">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control " id="" placeholder="Cidade" name="cidade" required>
                            </div>                    
                        </div>
                        <div class="form-group form-group-lg">                    
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <select name="uf" id="" class="form-control ">                            
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AM">AM</option>
                                    <option value="AP">AP</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RO">RO</option>
                                    <option value="RS" selected>RS</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SE">SE</option>
                                    <option value="SP">SP</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>                    
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="text" class="form-control mask cep" id="" placeholder="CEP" name="cep">
                            </div>
                        </div> 
                    </div>            
                </div>


        </div>
        
        <div class="panel-footer">

            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group pull-left">
                    <a href="{{ url('/clientes') }}" class="btn btn-primary">
                        <i class="fa fa-chevron-left"></i> Voltar
                    </a>                
                </div>
                <div class="btn-group pull-right">               
                    <button type="reset" class="btn btn-info">
                        <i class="fa fa-undo"></i> Limpar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Salvar
                    </button>
                </div>
            </div>

        </div>
</div>

{{ Form::close() }}