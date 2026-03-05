<div class="list-group-item text-uppercase text-default">

	<div class="">		
		<i class="fa icon {{ $event->icon }}" style="min-width: 15px; margin-right: 5px; text-align: center;"></i>
		<a href="{{ url( 'agenda/'.$event->id ) }}" data-target="#modal" data-toggle="modal">
			{{ $event->title }}
		</a>				
	</div>	

	<small class="text-muted">		
		<strong>
		<?php  if( isset( $event->time_start ) ){
					echo '<i class="fa fa-clock-o"></i> '.date('H:i', strtotime($event->time_start));
				} ?>
		</strong> 
		{{ isset( $event->time_end ) ? '<small> até </small>' : '' }}
		{{ isset( $event->date_end ) ? date('d/m/Y', strtotime( $event->date_end )) . ', ' : '' }}
		{{ isset( $event->time_end ) ? '<small> às </small>' . date('H:i', strtotime($event->time_end)) : '' }}
	</small>

</div>