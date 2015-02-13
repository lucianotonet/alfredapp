

        {{ Form::open(array('url' => 'produtos', 'class'=>"form-horizontal" )) }}
            <div class="form-group">
                <label for="product_cod" class="col-sm-2 control-label">Código</label>
                <div class="col-sm-10 form-inline">
                    <input type="text" class="form-control" id="product_cod" name="cod" placeholder="Código">
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
            <div class="form-group">
                <label for="product_category" class="col-sm-2 control-label">Acabamento</label>
                <div class="col-sm-10 form-inline">                   
                    <select name="category_id" id="product_category" class="form-control">
                            <option value="">-</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach                            
                    </select>
                </div>
            </div> 
            <div class="form-group">
                <label for="prduct_detalhes" class="col-sm-2 control-label">Detalhes</label>
                <div class="col-sm-10">
                    <textarea name="detalhes" class="form-control" id="prduct_detalhes" cols="30" rows="6"></textarea>
                </div>                          
            </div>                      
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        
        {{ Form::close() }}