@extends('layouts.master')

@section('content')

    <div class="container">        
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Adicionar Categoria</h3>
			</div>
			<div class="panel-body">
				@include('categories.panels.create')
			</div>
		</div>
    </div>

@stop