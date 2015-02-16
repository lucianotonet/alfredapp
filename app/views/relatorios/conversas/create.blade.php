@extends('layouts.master')

@section('content')

<div class="container">   

	<!-- Breadcrumbs -->
	<ol class="breadcrumb breadcrumb-arrow hidden-print">
		<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
		<li><a href="{{url('relatorios#conversas')}}">Relatórios</a></li>			
		<li class="active"><span>Novo relatório</span></li>	
	</ol>	


	




	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="title">NOVO RELATÓRIO DE CONVERSAS</h3>
		</div>
		<div class="panel-body">

		
			<form action="" method="GET" class="form-inline" role="form">
			
				<div class="form-group">
					<label class="" for="input">Cliente:</label><br>
					{{ Form::select('cliente', $filters['clientes'], Input::old('cliente'), array('class'=>'form-control') ) }}
				</div>
				
				<div class="form-group">
					<label for="input" class="">Status:</label><br>				
					{{ Form::select('status', $filters['status'], Input::old('status'), array('class'=>'form-control') ) }}
				</div>
				
				<div class="form-group">
					<label class="" for="input">De:</label><br>
					{{ Form::input('date', 'from', '', array('class' => 'form-control', 'min' => $filters['from']['min'], 'max' => $filters['from']['max'] ) ) }}
				</div>

				<div class="form-group">
					<label class="" for="input">Até:</label><br>
					{{ Form::input('date', 'to', @$filters['from']['max'], array('class' => 'form-control', 'min' => $filters['from']['min'], 'max' => $filters['from']['max'] )  ) }}
				</div>
				
				<div class="form-group">
					<label class="" for="input">&nbsp;</label><br>
					<button type="submit" class="btn btn-primary">Buscar conversas</button>
				</div>
	
			</form>

		</div>

		<?php /* NOTIFICAÇÃO > GERA RELATÓRIO AUTOMATICAMENTE */ ?>
			@if ( $status['nao_enviadas'] > 0)
						
				<div class="alert alert-warning">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p>Você tem {{ $status['nao_enviadas'] }} novas conversas. Gostaria de gerar um <strong>relatório automático</strong> com elas?</p>
					<br>	

					{{Form::open(array('url' => url('relatorios')))}}

						{{ Form::hidden('type', 'conversas') }}
						{{ Form::hidden('auto', 'true') }}						
						
						<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Gerar relatório</button>
						<a class="btn btn-sm btn-default" data-toggle="modal" href='#modal-id'>Ver todas conversas</a>						

					{{ Form::close() }}

						<div class="modal fade" id="modal-id">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header primary bg-primary">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title title">Conversas não reportadas</h4>
									</div>
										
									<div class="modal-body">

										@foreach ($clientes as $cliente)

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
						
				</div>
			{{--@else
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h3 class="title"><i class="fa fa-check"></i> Nenhuma conversa para enviar</h3>

				</div>--}}
			@endif
			<?php /* FIM NOTIFICAÇÃO */ ?>


		<form action="{{url('relatorios')}}" method="POST" role="form">

			{{Form::hidden('type', 'conversas')}}
			
			<div class="panel-body bg-info">
				<div class="pull-right">
					<button type="submit" class="btn btn-primary">Gerar relatório</button>
				</div>
			
				{{$message}}	
				
				<p>Selecione as conversas que deseja adicionar ao relatório e clique em <strong>gerar relatório</strong>.</p>

				<a href="#" class="btn btn-primary btn-sm select_all">Selecionar todas</a>	<br>	
					
				@foreach ( $search_results as $cliente )
					
					<div class="panel">

						@include( 'clientes.panels.item' )

						<ul class="list-group">
						@foreach ( $cliente->conversas as $conversa)

									
								<li class="list-group-item form-inline">
									<div class="form-group">
										<div class="media-left">
											{{ Form::checkbox('conversas_ids[]', $conversa->id, Input::old('conversas_ids'), array("class"=>"checkbox") ) }}											
										</div>	
									</div>
									<div class="form-group">	
										&nbsp;
									</div>
									<div class="form-group">							
										<p class="form-control-static">
											{{$conversa->resumo}}
										</p>												
									</div>
								</li>
								
							

						@endforeach
						</ul>	

					</div>				

				@endforeach
					
								
			</div>

		</form>


	</div>	

</div>

@stop