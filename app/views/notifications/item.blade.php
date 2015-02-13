<div class="alert alert-{{$notification->class}} notification fade in" data-url="{{url('notifications/'.$notification->id.'/close')}}" >	
	@if ($notification->status)
		<em class="pull-right" ><span class="icon-check"></span> lida</em>	
	@else
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>	
	@endif
	<h4>{{$notification->title}}</h4>
	<p>{{$notification->message}}</p>
	@if ( $notification->tarefa_id )
		<p ><a class="btn btn-sm btn-{{$notification->class}}" href="{{url('tarefas/'.$notification->tarefa_id)}}">Ver tarefa</a></p>		
	@endif
</div>