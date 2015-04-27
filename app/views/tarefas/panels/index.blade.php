<div class="list-group">
	@foreach ($tarefas->days as $day => $tasks)				
		<div class="list-group-item disabled">{{ strftime("%A, %d de %B de %Y", strtotime( $day )) }}</div>
		@foreach ($tasks as $tarefa)
			@include('tarefas.panels.item')						
		@endforeach	
	@endforeach	
</div>

{{ $tarefas->appends( Request::except('page') )->links() }}