<div class="list-group">                       
    @foreach($categories as $category)
    <div class="list-group-item text-uppercase text-default">
        
        {{ Form::open(array('url' => 'categories/' . $category->id, 'class' => 'btn-group pull-right')) }}
            {{ Form::button('<i class="icon icon-cross"></i>', array('class' => 'close', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este item?")', 'tabindex'=>"-1" )) }}
            {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::close() }}
        <a data-toggle="modal" data-target="#modal" href="{{ url('categories/'.$category->id.'/edit') }}"class="list-group-item-heading">            
            <i class="fa fa-bookmark" title=""></i>         
            {{ $category->name }}
        </a>                        

    </div>
    @endforeach
</div>