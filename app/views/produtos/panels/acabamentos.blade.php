<div class="list-group">
    @foreach($acabamentos as $key => $acabamento)
        <div class="list-group-item text-uppercase text-default">
        
	        {{ Form::open(array('url' => 'categories/' . $acabamento->id, 'class' => 'btn-group pull-right')) }}
	            {{ Form::button('<i class="icon icon-cross"></i>', array('class' => 'close', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este item?")', 'tabindex'=>"-1" )) }}
	            {{ Form::hidden('_method', 'DELETE') }}
	        {{ Form::close() }}
	        <a data-toggle="modal" data-target="#modal" href="{{ url('categories/'.$acabamento->id.'/edit') }}"class="list-group-item-heading">            
	            <i class="fa fa-bookmark" title=""></i>         
	            {{ $acabamento->name }}
	        </a>                        

	    </div>
    @endforeach              
</div>

{{ $acabamentos->appends( Request::except('page') )->links() }} 