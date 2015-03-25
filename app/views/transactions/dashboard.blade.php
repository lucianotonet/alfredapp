							{{-- @include('transactions.panels.create') --}}
@extends('layouts.master')

@section('content')

    <div class="container">    

    	<div class="panel panel-primary">
			
			<div class="panel-heading">
				<h3 class="panel-title title"><i class="icon-dollar"></i> Controle Financeiro Pessoal</h3>
			</div>
			
			<div class="list-group-item navbar-inverse">
				<ul class="nav nav-pills nav-justified">
					<li role="presentation" class="active">
						<a href="{{url('financeiro/')}}">
							<h3 class="title">Resumo</h3>
						</a>
					</li>			
					<li role="presentation">
						<a href="{{url('financeiro')}}">
							<h3 class="title">Movimentações</h3>
						</a>
					</li>
				</ul>
			</div>
			
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 balance_status">
												
						<h1 class="text-center font open_sanscondensed_light <?php if( $labels['balance'] < 0 ) echo 'text-danger' ?> ">R$ {{ $labels['balance'] }}</h1>
						<h4 class="panel-title title text-center">Saldo atual</h4>		
					
					<hr>

						<p class="lead text-center text-capitalize">{{ $labels['date'] }}</p>									
						
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group text-center">
								<label for="" class="title">
									<h4 class="title">Total de despesas no mês</h4>
									<h2 class="text-center font open_sanscondensed_light">R$ {{  $labels['despesas_mes']  }}</h2>
								</label>
							</div>							
						</div>

						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
							<div class="form-group text-center">
								<label for="" class="title">
									<h4 class="title">Total de receitas no mês</h4>
									<h2 class="text-center font open_sanscondensed_light">R$ {{  $labels['receitas_mes']  }}</h2>
								</label>
							</div>							
						</div>


						<div class="btn-group btn-group-justified btn-group-lg">
							<a class="btn btn-success btn-lg btn-block" data-toggle="modal" href='#transaction_create'><i class="fa fa-plus"></i> Adicionar registro</a>
						</div>

					</div>



					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title title">CONTAS A PAGAR</h3>
							</div>
							
							{{ $labels['despesas_atrasadas'] }}

							<table class="table table-hover">

								@foreach ($transactions['despesas'] as $transaction)
	
									@include('transactions.views.item-mini', ['transactions'=>$transactions['despesas'], 'title'=>strftime("%d de %b", strtotime( $transaction->date )) ])

								@endforeach		
		
							</table>


						</div>

						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title title">CONTAS A RECEBER</h3>
							</div>

							{{ $labels['receitas_atrasadas'] }}

							<table class="table table-hover">

								@foreach ($transactions['receitas'] as $transaction)
	
									@include('transactions.views.item-mini', ['transactions'=>$transactions['receitas'], 'title'=>strftime("%d de %b", strtotime( $transaction->date )) ])

								@endforeach		
		
							</table>


						</div>

					</div>					
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						
					</div>
				</div>
			</div>

						
			

		</div>

	</div>

	<!-- MODAL TRANSACTION CREATE -->

		<div class="modal fade" id="transaction_create">
			<div class="modal-dialog">
				<div class="modal-content">
					
					
						@include('transactions.panels.create')

					
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

@stop

@section('scripts')	
	<script src="{{ asset('js/transactions.js') }}" ></script>	
	<link href="{{ asset('css/transactions.css') }}" media="all" type="text/css" rel="stylesheet">
@stop

