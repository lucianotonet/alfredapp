@extends('layouts.master')

@section('content')

<div class="container">   

	<!-- Breadcrumbs -->
	<ol class="breadcrumb breadcrumb-arrow hidden-print">
		<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
		<li><a href="{{url('relatorios')}}">Relatórios</a></li>			
		<li><a href="{{url('relatorios#conversas')}}">Conversas</a></li>	
		<li class="active"><span>Novo</span></li>	
	</ol>	


	<?php /* NOTIFICAÇÃO > GERA RELATÓRIO AUTOMATICAMENTE */ ?>
	@if ( $status['nao_enviadas'] > 0)
				
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h3 class="title">{{ $status['nao_enviadas'] }} conversas não reportadas</h3>

			{{Form::open(array('url' => url('relatorios')))}}

				{{ Form::hidden('type', 'conversas') }}
				{{ Form::hidden('auto', 'true') }}

				<p>&nbsp;</p>

				<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Ver conversas</a>
				<button type="submit" class="btn btn-success">Gerar relatório</button>

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


		<form action="{{url('relatorios')}}" method="POST" role="form">

			{{Form::hidden('type', 'conversas')}}
			
			<div class="panel-body bg-info">
				<div class="pull-right">
					<button type="submit" class="btn btn-primary">Gerar relatório</button>
				</div>
			
				{{$message}}				
			</div>
					
			<div class="panel-body bg-info">			
					
				@foreach ( $search_results as $cliente )
					
					<div class="panel">

						@include( 'clientes.panels.item' )

						<ul class="list-group">
						@foreach ( $cliente->conversas as $conversa)

									
								<li class="list-group-item form-inline">
									<div class="form-group">
										<div class="btn-group btn-group-xs checkbox media-left" data-toggle="buttons">
											<label class="btn btn-default btn-xs">			
												<i class="fa fa-check fa-2x"></i>
												{{ Form::checkbox('conversas_ids[]', $conversa->id, Input::old('conversas_ids'), array(""=>"") ) }}
											</label>
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