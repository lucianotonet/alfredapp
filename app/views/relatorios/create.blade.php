@extends('layouts.master')

@section('content')

    <div class="container">        

		<!-- Breadcrumbs -->
		<ol class="breadcrumb breadcrumb-arrow hidden-print">
			<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
			<li><a href="{{url('relatorios')}}">Relatórios</a></li>			
			<li class="active"><span>Novo relatório</span></li>	
		</ol>

    	<div class="panel panel-primary">
    		<div class="panel-heading">
    			<h3 class="title">Novo relatório</h3>
    		</div>
    		<div class="panel-body">

				
				<h2 class="title text-center">Novo relatório:</h2>

				<hr>

    			<div class="row text-center">

					<a class="btn btn-lg btn-primary" href="{{url('relatorios/create/despesas')}}">
							<div class="icon-wallet fa-2x"></div>
						<strong>Despesas</strong>
					</a>

					<a class="btn btn-lg btn-primary" href="{{url('relatorios/create/conversas')}}">    						
		    			<div class="icon-chat fa-2x"></div>
						<strong>Conversas</strong>
					</a>

    			</div>

    	</div>	

    </div>

@stop