<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <div class="btn-group pull-right">           
            <a class="btn btn-default btn-sm" data-toggle="modal" href='#category_create'>
                <i class="fa fa-plus"></i> Adicionar Acabamento
            </a>
        </div>
        <h3 class="title">ACABAMENTOS</h3>                    
    </div>

    <table class="table table-hover">        
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    <a data-toggle="modal" href='#edit_category_{{$category->id}}' class="btn btn-link">
                        {{ $category->name }}
                    </a>
                </td>                
                <td class="text-right" width="140">
                    {{ Form::open(array('url' => 'categories/' . $category->id, 'class' => 'btn-group btn-group-sm')) }}
                        <a data-toggle="modal" href='#edit_category_{{$category->id}}' class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>                        
                        {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger  btn-sm', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este item?")', 'role'=>"menuitem", 'tabindex'=>"-1" )) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::close() }}                   
                </td>
            </tr>

            <!-- EDIT CATEGORY MODAL -->
            <div class="modal fade" id="edit_category_{{$category->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title title">Editar</h4>
                        </div>
                        
                            
                        @include('categories.panels.edit')
                        
                        &nbsp;
                                               
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- / EDIT CATEGORY MODAL -->

            @endforeach          
        </tbody>
    </table>

</div>



<!-- CREATE CATEGORY MODAL -->

<div class="modal fade" id="category_create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title title">Novo acabamento</h4>
            </div>
            <div class="modal-body">
                @include('categories.panels.create', array('owner_type'=>'Produto'))
                &nbsp;
            </div>            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

