<div class="list-group-item">

	{{ Form::open(array('url' => 'tarefas/' . $tarefa->id . '/excluir', 'class'=>'pull-right text-muted')) }}
	{{ Form::hidden('_method', 'DELETE') }}

	<p class="pull-right text-right">

		<small>
			<?php if( $tarefa->done ) {	?>				
				<span class="text-success"><i class="fa fa-circle-check-o"></i> CONCLUÍDA</span>
			<?php }else if( $tarefa->atrasada() ) { ?>			
				<span class="text-danger"><i class="icon-notification"></i> ATRASADA</span>
			<?php } ?>
		</small>

		@if ($tarefa->done)
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
		<strong class="">
			<a href="{{ url( 'tarefas/'.$tarefa->id ) }}" data-target="#modal" data-toggle="modal">
				<?php switch ($tarefa->tipo) {
					case '1':
					echo '<i class="fa fa-phone"></i> Ligação';
					break;
					case '2':
					echo '<i class="icon-directions-car"></i> Visita';
					break;
					case '3':
					echo '<i class="icon-paper"></i> Relatório';
					break;
					default:
					echo '<i class="icon-event-available"></i> Compromisso';
					break;
				} ?>    
			</a>
		</strong>
		{{ $tarefa->title }}
	</p>

	@if ( $tarefa->cliente )				
		@include( 'clientes.panels.item', array( 'cliente' => $tarefa->cliente ) )
	@endif
	
</div>