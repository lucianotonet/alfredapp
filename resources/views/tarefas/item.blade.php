<div class="list-group-item text-uppercase text-default">     
	<a href="" class="text-uppercase text-default" data-toggle="modal" data-target="#modal">
		<?php switch ($tarefa->tipo) {
			case '1':
			echo '<i class="fa fa-phone"></i>';
			break;
			case '2':
			echo '<i class="icon-directions-car"></i>';
			break;
			case '3':
			echo '<i class="icon-paper"></i>';
			break;
			default:
			echo '<i class="icon-event-available"></i>';
			break;
		} ?>    
	</a>
	                                                           
	<a href="{{ url('tarefas/'.$tarefa->id) }}" class="text-uppercase text-default" data-toggle="modal" data-target="#modal">
		{{ $tarefa->title }}
	</a>
						
</div>