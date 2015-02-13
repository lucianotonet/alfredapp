<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <div class="btn-group pull-right">
            <a class="btn btn-default btn-sm" data-toggle="modal" href='#produto_create'>
                <i class="fa fa-plus"></i> Adicionar produto
            </a>
        </div>
        <h3 class="title">PRODUTOS</h3>                    
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Cód</th>
                <th>Nome</th>
                <th width="auto">Acabamento</th>
                <th>Preço</th>
                <th>Un.</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $key => $produto)
            <tr>
                <td width="60">
                    <strong>{{ $produto->cod }}</strong>
                </td>
                <td>
                    <a data-toggle="modal" href='#edit_produto_{{$produto->id}}' class="btn btn-link">
                        {{ $produto->nome }}
                    </a>
                </td>
                <td width="auto">{{ @$produto->category->name }}</td>
                <td>R$ {{ $produto->preco }}</td>
                <td width="60">{{ $produto->unidade }}</td>
                <td class="text-right" width="140">
                    {{ Form::open(array('url' => 'produtos/' . $produto->id, 'class' => 'btn-group btn-group-sm')) }}
                        <a data-toggle="modal" href='#edit_produto_{{$produto->id}}' class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a> 
                        {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este produto?")', 'role'=>"menuitem", 'tabindex'=>"-1" )) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::close() }}  
                </td>
            </tr>

            <!-- EDIT PRODUTO MODAL -->
            <div class="modal fade" id="edit_produto_{{$produto->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title title">Editar</h4>
                        </div>
                        
                            
                        @include('produtos.panels.edit')
                        
                        &nbsp;
                                               
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- / EDIT PRODUTO MODAL -->


            @endforeach          
        </tbody>
    </table>

</div>


<!-- CREATE PRODUTO MODAL -->

<div class="modal fade" id="produto_create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title title">Novo produto</h4>
            </div>
            <div class="modal-body">
                @include('produtos.panels.create')
                &nbsp;
            </div>            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->