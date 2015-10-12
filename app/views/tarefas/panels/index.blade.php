<div class="list-group">
	@foreach ($tarefas->days as $day => $tasks)		
		<?php 			
			$dt = new Carbon\Carbon;
			 App::setLocale("pt_BR.utf-8");
   			setlocale(LC_ALL, "pt_BR.utf-8", "pt_BR", "pt_BR.iso-8859-1", "portuguese");		
			$dt = $dt->createFromFormat( 'Y-m-d',$day );
			//echo $dt->formatLocalized('%A, %d de %B de %Y - %H:%M:%S');
			// exit;
		 ?>		
		<div class="list-group-item disabled">{{ $dt->formatLocalized('%A, %d de %B') }}</div>
		@foreach ($tasks as $tarefa)
			@include('tarefas.panels.item')						
		@endforeach	
	@endforeach	
</div>

{{ $tarefas->appends( Request::except('page') )->links() }}