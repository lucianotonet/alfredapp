@extends('layouts.master')

@section('content')

<div class="container">        

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title title">
				<i class="fa fa-cog"></i> Configurações
			</h3>
		</div>		

		<div class="panel-body">
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">	
					@include( 'settings.menu' )
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
				
					@include( 'settings.'.$module )
						
				</div>	
			</div>
			
			
			
			
		</div>

	
	</div>

	@stop