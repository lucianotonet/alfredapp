@extends('layouts.master')

@section('content')

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				PRODUTOS
			</h3>                    
		</div>

		<div class="panel-body">

			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<div class="pull-right">										
						<a class="btn btn-success" data-toggle="modal" data-target="#modal" href="{{ url('produtos/create') }}">
							<i class="fa fa-plus"></i> Adicionar produto
						</a>
						<a class="btn btn-default" data-toggle="modal" data-target="#modal" href="{{ url('categories/create?owner_type=produto') }}">
							<i class="fa fa-plus"></i> Adicionar acabamento
						</a>
					</div>

					<li role="presentation" class="{{ (!Route::is('produtos.acabamentos')) ? 'active' : '' }}">
						<a href="{{ url('produtos')  }}">Produtos</a>
					</li>
					<li role="presentation" class="{{ (Route::is('produtos.acabamentos')) ? 'active' : '' }}">
						<a href="{{ url('produtos/acabamentos') }}">Acabamentos</a>
					</li>
				</ul>
				
			</div>
		</div>
		<div class="panel-body">
			<div role="tabpanel" class="tab-pane active">

				@if(Route::is('produtos.acabamentos'))
					@include('produtos.panels.acabamentos')		
				@else
					@include('produtos.panels.index')	
				@endif	

			</div>
		</div>
	</div>

</div>

@stop