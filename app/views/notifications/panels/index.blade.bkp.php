<?php use Carbon\Carbon as Carbon; ?>

@include('notifications.panels.create')

<ul class="nav nav-tabs nav-justified">	
	@if ($notifications->naolidas)
		{{-- expr --}}
	@endif
	<li class="active">
		<a href="#naolidas" data-toggle="tab">
			<h3 class="title <?php if( count($notifications->naolidas) ){ echo 'danger'; } ?>">Não lidas <span class="badge badge-danger">{{count($notifications->naolidas)}}</span></h3>
		</a>
	</li>			
	<li>
		<a href="#proximas" data-toggle="tab">
			<h3 class="title">Próximas <span class="badge badge-warning">{{count($notifications->proximas)}}</span></h3>
		</a>
	</li>
	<li>
		<a href="#lidas" data-toggle="tab">
			<h3 class="title">Lidas <span class="badge badge-success">{{count($notifications->lidas)}}</span></h3>
		</a>
	</li>
</ul>

<div class="tab-content ">
	
	<div class="tab-pane fade active in " id="naolidas">
		@if ( count($notifications->naolidas) )

			@foreach ($notifications->naolidas as $notification)
			
					@include('notifications.panels.item')
			
			@endforeach			

		@else
			<div class="panel-body text-center">
				<div class="well well-lg">
			  		<h2 class="title"><img class="axb m4a" src="//ssl.gstatic.com/s2/oz/images/notifications/jingles_eb4e5306b38f83915d82034fa93390d9/desktop_static_1x.png" alt="Mascote Jingles com um sorriso"> Tudo lido!</h2>
					<a class="btn btn-success" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>
			  	</div>
				
			</div>
		@endif
	</div>
	<div class="tab-pane fade" id="proximas">
		
		@if ( count($notifications->proximas) )
			
			@foreach ($notifications->proximas as $notification)
			
					@include('notifications.panels.item')
			
			@endforeach

		@else
			<div class="panel-body text-center">
				<div class="well well-lg">
			  		<h2 class="title"><img class="axb m4a" src="//ssl.gstatic.com/s2/oz/images/notifications/jingles_eb4e5306b38f83915d82034fa93390d9/desktop_static_1x.png" alt="Mascote Jingles com um sorriso"> Nada agendado!</h2>
					<a class="btn btn-success" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>
			  	</div>
				
			</div>
		@endif

	</div>
	<div class="tab-pane fade" id="lidas">

		@if ( count($notifications->lidas) )
			

			@foreach ($notifications->lidas as $notification)
			
					@include('notifications.panels.item')
			
			@endforeach
			<p class="">
				<a href="{{url('notifications/clean')}}" class="btn btn-danger" onclick="return confirm('Excluir notificações já lidas?')"><i class="icon-trash"></i> Limpar tudo</a>
			</p>

		@else
			<div class="panel-body text-center">
				<div class="well well-lg">
			  		<h2 class="title"><img class="axb m4a" src="//ssl.gstatic.com/s2/oz/images/notifications/jingles_eb4e5306b38f83915d82034fa93390d9/desktop_static_1x.png" alt="Mascote Jingles com um sorriso"> Tudo certo!</h2>
					<a class="btn btn-success" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>
			  	</div>
				
			</div>
		@endif

	
	

	</div>	

</div>