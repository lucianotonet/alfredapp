@extends('layouts.print')

@section('content')
	
	
	<p class="text-center hero">	  	
	  	<strong>AGENDA</strong> <br>		
		<small class="text-muted">Eventos para {{ $labels['title'] }}</small>
	</p>

	<div class="list-group">
		@include('agenda.panels.index')
	</div>

@stop