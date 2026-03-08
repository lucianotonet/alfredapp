<div class="list-group-item">

	{{ Form::open(array('url' => 'tarefas/' . $tarefa->id . '/excluir', 'class'=>'pull-right text-muted')) }}
	{{ Form::hidden('_method', 'DELETE') }}

	<p class="pull-right text-right">		

		@if ($tarefa->done)
		<i class="fa fa-check text-success"></i> Tarefa Concluída <br>
		<a class="btn btn-xs btn-primary hidden-print" href="{{url('tarefas/'.$tarefa->id.'/check')}}" title="Reabrir tarefa">
			<i class="fa fa-undo"></i> Reabrir
		</a>
		@else
		<a class="btn btn-xs btn-success hidden-print" href="{{url('tarefas/'.$tarefa->id.'/check')}}">
			<i class="fa fa-check"></i> Concluir
		</a>
		@endif
		
	</p>


	{{ Form::close() }} 

	<p>		
		<a href="{{ url( 'tarefas/'.$tarefa->id ) }}" data-target="#modal" data-toggle="modal">
			<i class="fa icon {{ $tarefa->icon }}"></i>
			{{ $tarefa->title }}
		</a>
	</p>

	@if ( $tarefa->cliente )				
		@include( 'clientes.panels.item', array( 'cliente' => $tarefa->cliente ) )
	@endif
	
</div>