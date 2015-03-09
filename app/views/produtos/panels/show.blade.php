<div class="panel panel-primary">
    
    <!-- Default panel contents -->
    <div class="panel-heading">
        <div class="btn-group pull-left">
            <h3 class="title">Ver produto</h3>            
        </div>       
    </div>
    
    <div class="panel-body">
        
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group form-group-lg">
                            
                                <input type="text" class="disabled form-control input-lg" id="" placeholder="Código" name="cod" value="{{$produto->cod}}" readonly>
                            
                        </div>
                        <br>
                    </div>
                    <div class="col-xs-12 col-md-10">
                        <div class="form-group form-group-lg">
                            
                                <input type="text" class="form-control input-lg disabled" id="" placeholder="Nome" name="nome" value="{{$produto->nome}}" readonly>
                            
                        </div>
                        <br>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        
                        <div class="form-group form-group-lg">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>                            
                                <input type="text" class="form-control input-lg price disabled" id="" placeholder="Preco" name="preco" value="{{$produto->preco}}" readonly>
                            </div>
                        </div>

                        <br>
                        
                        <div class="form-group form-group-lg">
                            
                            <select name="unidade" id="" class="form-control input-lg disabled" readonly>
                               <option value="m2"<?php if ( $produto->unidade == 'm2' ) echo 'selected'  ?> >m2</option> 
                               <option value="m3"<?php if ( $produto->unidade == 'm3' ) echo 'selected'  ?> >m3</option> 
                            </select>    
                            
                        </div>

                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    
                        <textarea name="detalhes" class="form-control disabled" id="" cols="30" rows="6" readonly>{{$produto->detalhes}}</textarea>

                    </div>
                </div>           

    </div>

    <div class="panel-footer">

        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group-lg pull-left">
                <a href="#" class="btn btn-primary" onclick="javascript: window.history.back()">
                    <i class="fa fa-chevron-left"></i> Voltar
                </a>               
            </div>
            <div class="btn-group btn-group-lg pull-right">  
                {{ Form::open(array('url' => 'produtos/' . $produto->id, 'class' => '')) }}        
                        
                        {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger btn-lg btn-brick', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Deseja excluir este item da lista?")')) }}

                        {{ Form::hidden('_method', 'DELETE') }}

                        <a href="{{url('/produtos/'.$produto->id.'/edit')}}" class="btn btn-success btn-lg btn-brick">
                            <i class="fa fa-edit"></i> Editar
                        </a>

                {{ Form::close() }} 
            </div>
        </div>
        
    </div>
    
</div>