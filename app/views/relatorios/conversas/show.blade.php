@extends('layouts.master')

@section('content')

	<div class="container">   
		
		<!-- Breadcrumbs -->
		<ol class="breadcrumb breadcrumb-arrow hidden-print">
			<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
			<li><a href="{{url('relatorios')}}">Relatórios</a></li>			
			<li class="active"><span>Relatório nº{{$relatorio->id}}</span></li>	
		</ol>


		<div class="panel panel-primary" style="display:block; width:100%!important; height:100%!important;" >
			<div class="panel-body">
				<div class="pull-right">			

					<a href="#{{--url('relatorios/'.$relatorio->id.'/print')--}}" onclick="printFrame( 'printf' );"><i class="fa fa-print"></i> Imprimir</a>		
					<a href="{{ url('/emails/create/?owner_type=relatorio&owner_id='.$relatorio->id) }}" class="btn btn-link send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope"></i> Enviar por e-mail</a>
					
				</div>
			    <h3 class="title">
			    	Relatório <strong>Nº{{$relatorio->id}}</strong>
					@if( count( $relatorio->emails() ) )
					    <!-- <span class="label label-success">		
							Já enviado
						</span> -->
					@else
						<span class="badge label label-danger" title="Não enviado">Não enviado</span>
					@endif
				</h3>
				
				<div class="clearfix"></div>

			</div>    

		</div>		
				
		<iframe src="{{url('relatorios/'.$relatorio->id.'/print')}}" class="panel" width="100%" height="600" id="printf" name="printf">					
			<!-- PDF STREAM -->
		</iframe>	           					   

		<!-- Relatório Header -->

	</div>

@stop