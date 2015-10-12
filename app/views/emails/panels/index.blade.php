<div class="panel panel-primary">	
	<div class="panel-heading">
		<h3 class="panel-title">E-mails</h3>
	</div>	
	<table class="table table-hover">
		<thead class="">
			<tr>				
				<th>Para</th>
				<th>Assunto</th>
				<th>Data do envio</th>
			</tr>
		</thead>
		<tbody>
		  	@foreach ($emails as $email)
				<tr>					
					<td>{{ $email->to }}</td>
					<td>{{ $email->subject }}</td>
					<td>{{ strftime("%A, %d de %B às %H:%M", strtotime( $email->created_at )) }}</td>
				</tr>		  		
		  	@endforeach 
		</tbody>
	</table>
	<div class="panel-body">	   
		{{ $emails->appends( Request::all() )->links() }}		
	</div>
</div>