<div class="panel panel-primary">    
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="panel-title">{{ ( $produto->nome ) ? $produto->nome : 'Produto' }}</h3>
    </div>

    {{ Form::model($produto, [ 'method' => 'PATCH', 'route' =>[ 'produtos.update', $produto->id ], 'class'=>"form-horizontal" ] ) }}
    <div class="panel-body">    
        <div class="form-group">
            <label for="product_cod" class="col-sm-2 control-label">Código</label>
            <div class="col-sm-10 form-inline">            
                {{ Form::input('number', 'cod', $produto->cod, [ "class"=>"form-control", "id"=>"product_cod", "placeholder"=>"Código"] ) }}
            </div>
        </div>
        <div class="form-group">
            <label for="product_name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">            
                {{ Form::input('text', 'nome', $produto->nome, [ "class"=>"form-control", "id"=>"product_name", "placeholder"=>"Nome"] ) }}
            </div>
        </div>
        <div class="form-group">
            <label for="product_preco" class="col-sm-2 control-label">Preço</label>
            <div class="col-sm-10 form-inline">            
                {{ Form::input('text', 'preco', $produto->preco, [ "class"=>"form-control price", "id"=>"product_preco", "placeholder"=>"0,00"] ) }}
                {{ Form::select('unidade', array('m2' => 'm2', 'm3' => 'm3'), $produto->unidade, ["id"=>"product_unidade", "class"=>"form-control"]) }}
            </div>
        </div>   
        <div class="form-group has-feedback">
            <label for="input" class="col-sm-2 control-label">Acabamento:</label>
            <div class="col-sm-10">
                {{ Form::input('text', 'category', @$produto->category->name, [ "class"=>"form-control autocomplete", "data-url" => "categories?owner_type=produto", "data-type" => "produto" ] ) }}                    
                <span class="form-control-feedback hidden text-muted" aria-hidden="true">
                    <i class="icon-spinner13 fa-spin form-control-static"></i>
                </span>                                 
            </div>
        </div> 
        <div class="form-group">
            <label for="prduct_detalhes" class="col-sm-2 control-label">Detalhes</label>
            <div class="col-sm-10">
                {{Form::textarea('detalhes', $produto->detalhes, ["class"=>"form-control", "id"=>"prduct_detalhes", "cols"=>"30", "rows"=>"6"])}}
            </div>                          
        </div>                      
    
    </div>
    <div class="panel-footer">
        <div class="btn-group btn-group-justified btn-block">
            <a class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </a>
            <a href="{{url('produtos/'.$produto->id.'/delete')}}" class="btn btn-danger" onclick="return confirm('Excluir este produto?')">
                <i class="fa fa-trash-o fa-fw"></i> Excluir
            </a>

            <a href="{{ url( 'produtos/'.$produto->id.'/edit' ) }}" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                <i class="icon-edit"></i> Editar
            </a>                        
            <div class="btn-group">
                <button type="submit" class="btn btn-success"> <i class="icon-check"></i> Salvar</button>                       
            </div>                                  
        </div>
    </div>
    {{ Form::close() }}
</div>