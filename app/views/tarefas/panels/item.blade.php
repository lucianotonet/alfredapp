<div class="panel panel-default">
	<div class="panel-heading">
			
		<?php 
            // BUG FiX
            //   Resolve problema de múltiplas instâncias com ID iguais
            $rand = rand();
        ?>

		{{ Form::open(array('url' => 'tarefas/' . $tarefa->id . '/excluir')) }}
            {{ Form::hidden('_method', 'DELETE') }}
			<div class="btn-group btn-group-sm pull-right">
				
                {{-- <a href="{{ URL::previous() }}" class="btn btn-primary">
                    <i class="fa fa-chevron-left"></i> Voltar
                </a> --}}
				<a href="{{url('tarefas',$tarefa->id)}}" class="btn btn-sm  btn-default">
					<i class="fa fa-eye"></i>
				</a>
                <a href="{{ url('tarefas/'.$tarefa->id.'/edit') }}" class="btn btn-sm btn-default">
                    <i class="fa fa-edit"></i>
                </a>
			
                <div class="btn-group btn-group-sm">
                	{{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-default', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir a tarefa da lista?")')) }}
                </div>                       
				

			</div>

        {{ Form::close() }} 


		<h4 class="panel-title title">
			<a href="{{url('tarefas/'.$tarefa->id)}}">
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
		</h4>
	</div>

	<a href="{{url('tarefas/'.$tarefa->id)}}" class="list-group-item clearfix">		
		
		<p class=" pull-right">
			<?php if( $tarefa->done ) {	?>				
				<span class="badge badge-success"><i class="fa fa-check"></i> Concluída</span>
			<?php }else	if( $tarefa->atrasada() ) { ?>			
				<span class="badge badge-danger"><i class="fa fa-warning"></i> Atrasada</span>
			<?php }else { ?>
				<!-- <span class="badge badge-warning"><i class="icon-ampulhette"></i> Aguardando</span> -->
			<?php } ?>
		</p>
		
		@if ($tarefa->title)		
			<p class="">					
				<i class="fa fa-info-circle fa-2x pull-left close"></i>
				{{$tarefa->title}}
			</p>				
		@endif
						

	</a>
	

	@if ( $tarefa->cliente )				
		@include( 'clientes.panels.item', array( 'cliente' => $tarefa->cliente ) )
	@endif

	
	<div class="panel-footer navbar-inverse">

		<p class="pull-right">
			@if ($tarefa->done)

				

				<a class="btn btn-sm btn-default" href="{{url('tarefas/'.$tarefa->id.'/check')}}" title="Reabrir tarefa">
					 <i class="fa fa-undo"></i> Reabrir
				</a>
				<!-- <a class="btn btn-sm btn-primary disabled" data-toggle="modal" href='#concluir_tarefa_{{$tarefa->id}}_{{$rand}}'>
					 <i class="fa fa-check"></i>
				</a> -->
			@else
				<a class="btn btn-xs btn-success" href="{{url('tarefas/'.$tarefa->id.'/check')}}">
					 <i class="fa fa-check"></i> Concluir
				</a>
			@endif
		</p>
		

		@if ($tarefa->start != '0000-00-00 00:00:00')
		
			<a class="btn btn-link btn-xs">	
				{{ date('l, d \d\e F', strtotime($tarefa->start) ) }}			
			</a>				
		
		@endif

	</div>      

</div>



<div class="modal modal-primary fade" id="concluir_tarefa_{{$tarefa->id}}_{{$rand}}">
    <div class="modal-dialog">
        {{ Form::open(array('url' => 'tarefas/' . $tarefa->id, 'method' => 'PATCH')) }}
        <div class="modal-content">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title title">Concluir </h3>
				<p>Resumo da conclusão da tarefa:</p>
            </div>
            <div class="modal-body">
                <textarea name="resumo" class="form-control" id="" cols="30" rows="10"></textarea>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-chevron-left"></i> Voltar</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Concluir tarefa</button>
            </div>
        </div><!-- /.modal-content -->
        {{ Form::close() }}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->