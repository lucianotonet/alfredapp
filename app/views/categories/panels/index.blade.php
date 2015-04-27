<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <div class="btn-group pull-right">           
            <a class="btn btn-default btn-sm" data-toggle="modal" href='#category_create'>
                <i class="fa fa-plus"></i> Adicionar categoria
            </a>
        </div>
        <h3 class="title">CATEGORIAS</h3>                    
    </div>


        <div class="panel-body">
            <div class="col-sm-3 col-md-3 col-lg-3">
                <ul id="" class="nav nav-pills nav-stacked">
                    <li class="">
                        <a href="#categories_produtos" data-toggle="tab">Produtos</a>
                    </li>
                    <li class="">
                        <a href="#categories_tarefas" data-toggle="tab">Tarefas</a>
                    </li>
                    <li class="active">
                        <a href="#categorias_outros" data-toggle="tab">Outros</a>
                    </li>
                </ul>
            </div>
                
            <div id="" class="tab-content col-sm-9">
                <div class="tab-pane fade" id="categories_produtos">                
                    <div class="list-group">                       
                        @foreach($categories as $category)
                        <a href='#edit_category_{{$category->id}}' class="list-group-item" >
                            {{ $category->name }}
                        </a>                        
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="categories_tarefas">
                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee.</p>
                </div>
                <div class="tab-pane fade active in" id="categorias_outros">
                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone...</p>
                </div>
            </div>
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
                <h4 class="modal-title">Nova categoria</h4>
            </div>
            <div class="modal-body">
                @include('categories.panels.create', array('owner_type'=>'Produto'))
                &nbsp;
            </div>            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

