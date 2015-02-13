@extends('layouts.master')

@section('content')

	<div class="container">    
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="title">Novo produto</h3>
			</div>
	  		<div class="panel-body">
	    		@include('produtos.panels.create')
	    	 </div>
		</div>
	</div>

@stop