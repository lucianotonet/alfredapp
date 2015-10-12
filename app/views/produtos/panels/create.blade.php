<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="panel-title">Novo produto</h3>
    </div>
    {{ Form::open(array('url' => 'produtos', 'class'=>"form-horizontal" )) }}
        <div class="panel-body">
            <div class="form-group">
                <label for="product_cod" class="col-sm-2 control-label">Código</label>
                <div class="col-sm-10 form-inline">
                    <input type="number" class="form-control" id="product_cod" name="cod" placeholder="Código">
                </div>
            </div>
            <div class="form-group">
                <label for="product_name" class="col-sm-2 control-label">Nome</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="product_name" name="nome" placeholder="Nome">
                </div>
            </div>
            <div class="form-group">
                <label for="product_preco" class="col-sm-2 control-label">Preço</label>
                <div class="col-sm-10 form-inline">
                    <input type="text" class="form-control price" id="product_preco" placeholder="0,00" name="preco">
                
                    <select name="unidade" id="product_unidade" class="form-control">
                        <option value="m2">m2</option>
                        <option value="m3">m3</option>
                    </select>
                </div>
            </div>  

            <div class="form-group has-feedback">
                <label for="input" class="col-sm-2 control-label">Acabamento:</label>
                <div class="col-sm-10">
                    <input type="text" name="category" id="input" class="form-control autocomplete" value="" title="" data-url="categories?owner_type=produto">
                    <span class="form-control-feedback hidden text-muted" aria-hidden="true">
                        <i class="icon-spinner13 fa-spin form-control-static"></i>
                    </span>                                 
                </div>
            </div> 

            <div class="form-group">
                <label for="prduct_detalhes" class="col-sm-2 control-label">Detalhes</label>
                <div class="col-sm-10">
                    <textarea name="detalhes" class="form-control" id="prduct_detalhes" cols="30" rows="6"></textarea>
                </div>                          
            </div>                      
        
        </div>
        <div class="panel-footer">
            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
                </div>              
                <div class="btn-group" role="group">                    
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
                </div>
            </div>  
        </div>
    {{ Form::close() }}           
</div>