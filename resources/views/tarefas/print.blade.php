@extends('layouts.print')

@section('content')
	
	<p class="text-center hero">	  	
	  	<strong>TAREFAS</strong>
	</p>
	
	<div class="list-group">
		@include('tarefas.panels.index')
	</div>

@stop