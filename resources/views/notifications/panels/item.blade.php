<a href="{{url('notifications/'.$notification->id)}}" data-toggle="modal" data-target="#modal" class="list-group-item {{ ( $notification->status ) ? 'disabled' : '' }}">		
	<?php if( $notification->type == 'email' ){ ?><i class="fa fa-envelope"></i><?php } ?>
	<?php if( $notification->type == 'notification' ){ ?><i class="fa fa-bell"></i><?php } ?>	
	{{ date('d/m/Y', strtotime($notification->date)) }}
	<br>
	{{$notification->title}}		
</a>