<li class="list-group-item">

	<div class="pull-right">
		<span class="label label-default">		
			{{ date('d \d\e F, H:i', strtotime($conversa->created_at) ) }}
		</span>				
	</div>	
	
	<p>
		{{$conversa->resumo}}
	</p>
	
</li>