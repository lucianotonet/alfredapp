@extends('layouts.master')

@section('content')

    <div class="container">     


			<?php
				$link_views 	         = $data;
				$link_views['date_from'] = date('Y-m-d');
			?>
			

    	<div class="panel panel-primary">
			
			<div class="panel-heading">
				<h3 class="panel-title title"><i class="icon-dollar"></i> Controle Financeiro Pessoal</h3>
			</div>
			
			<div class="list-group-item navbar-inverse">
				<ul class="nav nav-pills nav-justified">
					<li role="presentation">
						<a href="{{url('financeiro/')}}">
							<h3 class="title">Resumo</h3>
						</a>
					</li>			
					<li role="presentation" class="active">
						<a href="{{url('financeiro')}}">
							<h3 class="title">Movimentações</h3>
						</a>
					</li>
				</ul>
			</div>
			<!-- <div class="list-group-item">							
				<pre><?php print_r($data) ?><br>
					{{ url( 'financeiro/?'.http_build_query( $data ) ) }}
				</pre>
			</div> -->
			
			<!-- <div class="list-group-item navbar-inverse">
				<nav class="">
					<ul class="nav nav-pills nav-justified">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">Projects</a></li>
						<li><a href="#">Services</a></li>
						<li><a href="#">Downloads</a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
				</nav>
			</div>
 -->


			<div class="list-group-item">		

				<div class="pull-right form-group">
					<a class="btn btn-success" data-toggle="modal" href='#transaction_create'><i class="fa fa-plus"></i> Novo registro</a>
				</div>
								

				<div class="form-inline">

					@if ( $data['view'] != 'range' )
						<div class="form-group">
							<?php $prev_link = $data; $prev_link['prev']++; ?>
							<a href="{{ url( '/financeiro?'.http_build_query( $prev_link, '', '&amp;') ) }}" class="btn btn-primary"><i class="fa fa-chevron-left"></i></a>
						</div>
					@endif

					
						
					<div class="form-group">

						<select name="filter_by" class="form-control transaction_navigation" style="min-width:200px;">
							
							<option value="">{{ ucfirst( $title ) }}</option>
							
							<?php
								$link_views['view'] = 'day'; 
								unset( $link_views['prev'] ); 
								unset( $link_views['next'] );
							?>
								<option value="{{ url( 'financeiro/?'.http_build_query( $link_views, '', '&amp;') ) }}">Hoje</option>
							
							<?php $link_views['view'] = 'week'; ?>
								<option value="{{ url( 'financeiro/?'.http_build_query( $link_views, '', '&amp;') ) }}">Esta semana</option>

							<?php $link_views['view'] = 'month'; ?>
								<option value="{{ url( 'financeiro/?'.http_build_query( $link_views, '', '&amp;') ) }}">Este mês</option>
							
							<option class="" data-toggle="modal" value='#modal'>Escolher datas</option>

						</select>							


						<div class="modal fade" id="transactions_select_range">
							<div class="modal-dialog">
								<div class="modal-content">
									<form action="" method="GET" class="text-center" role="form">												
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title">Selecione o intervalo de datas</h4>
										</div>
										<div class="modal-body form-inline text-center">
											
											{{ Form::hidden('view', 'range') }}
										
											<div class="form-group">
												<input type="date" name="date_from" id="input" class="form-control" value="" required="required" title="">
											</div>
											<div class="form-group">
												<p class="form-control-static"> até </p>
											</div>
											<div class="form-group">
												<input type="date" name="date_to" id="input" class="form-control" value="" required="required" title="">
											</div>

											<br>
											<p class="form-control-static">-</p>
											
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
											<button type="submit" class="btn btn-primary">Ok</button>
										</div>
										
									</form>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->

					</div>

					@if ( $data['view'] != 'range' )
						<div class="form-group">
							<?php $next_link = $data; $next_link['next']++; ?>
							<a href="{{ url( 'financeiro/?'.http_build_query( $next_link, '', '&amp;') ) }}" class="btn btn-primary"><i class="fa fa-chevron-right"></i></a>
						</div>
					@endif

				</div>				
			</div>

			@if (Session::has('info'))		        
		        @foreach (Session::get('info') as $info)
					<div class="{{ @$info['class'] }} list-group-item text-center">
	               		{{@$info['message']}}
					</div>           		            
		        @endforeach
		    @endif	

		    
			@include( $view )
			

			<!-- <table class="table table-hover">
				<thead class="bg-info">
					<tr>
						<th></th>
						<th class="text-right">
							<h4>R$ <strong></strong></h4>
						</th>
						<th width="40"></th>
					</tr>
				</thead>				
			</table>			 -->					   	


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