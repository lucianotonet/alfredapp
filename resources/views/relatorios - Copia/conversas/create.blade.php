@if ($relatorios->conversasNaoEnviadas > 0)
	
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h3 class="title">{{ $relatorios->conversasNaoEnviadas }} conversas não reportadas</h3>

		{{ Form::model( new Relatorio, array('class'=>'')) }}

			{{ Form::hidden('resource_name', 'conversa') }}

			<p>&nbsp;</p>

			<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Ver conversas</a>
			<button type="submit" class="btn btn-success" >Gerar relatório</button>

			<div class="modal fade" id="modal-id">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header primary bg-primary">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title title">Conversas não reportadas</h4>
						</div>
							
						<div class="modal-body">

							
								@foreach ($relatorios->clientes as $cliente)

									<br>
									
									<div class="panel">
									
										@include('clientes.panels.item', $cliente)

										
										@foreach ($cliente->conversas as $conversa)										
											@include('conversas.panels.item', $conversa)												
										@endforeach

									</div>
									
								@endforeach
								
			
						
						</div>	

						<div class="modal-footer bg-info">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
						</div>
					</div>
				</div>
			</div>
			
		{{ Form::close() }}

	</div>
@else
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h3 class="title"><i class="fa fa-check"></i> Nenhuma conversa para enviar</h3>

	</div>
@endif