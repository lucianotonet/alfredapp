@extends('layouts.master')

@section('content')

<div class="container">        

	<div class="panel panel-primary">
		<div class="panel-heading">
			<a href="{{url('relatorios/despesas')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Novo</a>					
			<h3 class="panel-title title">Relatórios</h3>
		</div>


		<div class="panel-body">
			@include('relatorios.conversas.create', $relatorios)

			@include('relatorios.despesas.create', $relatorios)
		</div>

		@foreach ($relatorios as $relatorio)
			<a href="{{url('relatorios',$relatorio->id)}}" class="list-group-item">
				<small class="pull-right">{{date('d/m/Y',strtotime($relatorio->updated_at))}}</small>
				<i class="icon-file-pdf text-muted"></i> Relatório de despesas - Nº{{$relatorio->id}}
			</a>
		@endforeach

	</div>
</div>

@stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$("#selectr").selecter();
		});
	</script>
@stop