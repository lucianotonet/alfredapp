<div class="panel panel-default"> <!-- panel-{{$notification->class}} -->
	
	@include('notifications.item')						

	<div class="panel-footer">

		{{ Form::open(array('url' => 'notifications/' . $notification->id, 'class' => 'pull-right' )) }}
            
            {{ Form::hidden('_method', 'DELETE') }}
			<div class="btn-group btn-group-sm">

				@if ($notification->status)					
					<a class="btn btn-sm btn-link" href="{{url('notifications/'.$notification->id.'/close')}}" title="Marcar como não lida">
						<i class="fa fa-undo"></i>
					</a>
				@endif
                							
                <a href="{{ url('notifications/'.$notification->id.'/edit') }}" class="btn btn-sm btn-link">
                    <i class="fa fa-edit"></i>
                </a>
			
                <div class="btn-group btn-group-sm">
                	{{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-link', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir definitivamente esta notificação?")')) }}
                </div>                       
			</div>

        {{ Form::close() }} 
									
		<a href="{{url('notifications/'.$notification->id)}}" class="btn btn-link btn-sm">{{ date('d/m/Y', strtotime($notification->date)) }}</a>									

	</div>

</div>