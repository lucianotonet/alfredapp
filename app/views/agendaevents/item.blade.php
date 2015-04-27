<div class="list-group-item text-uppercase text-default">

	<p class="list-group-item-heading">
		<i class="fa icon {{ $event->icon }}" title=""></i>		
		{{ $event->title }}
	</p>	

	<small class="text-muted">		
		<strong>{{ isset( $event->time_start ) ? date('H:i', strtotime($event->time_start)) : '' }}</strong> 
		{{ isset( $event->time_end ) ? '<small> até </small>' : '' }}
		{{ isset( $event->date_end ) ? date('d/m/Y', strtotime( $event->date_end )) . ', ' : '' }}
		{{ isset( $event->time_end ) ? '<small> às </small>' . date('H:i', strtotime($event->time_end)) : '' }}
	</small>

</div>