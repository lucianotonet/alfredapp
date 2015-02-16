@extends('layouts.email')

@section('title')

	<table>
		<tr>
			<td>				
				<h3>Relatório nº{{ $email['owner_id'] }} - {{ $resource['type'] }}</h3>
			</td>
			<td>				
				<h3 style="text-align:right;"><small>{{ date('d/m/Y - H:i', strtotime($resource['updated_at']) ) }}</small><h3>
			</td>
		</tr>
	</table>	
@stop
	
@section('content')
	<table>
		<tr>
			<td>				

				<p style="text-align:center;">
					<a href="{{url('relatorios/'.$email['owner_id'] )}}" class="btn-primary">VER RELATÓRIO</a>
				</p>

			</td>
		</tr>
	</table>			

	{{--@include( $email['owner_type'].'s.'.$resource['type'].'.email-content', array('relatorio'=>$resource) )	--}}

	<!-- <table>
		<tr>
			<td><iframe src="{{url( 'relatorios/'.$email['owner_id'].'/print' )}}" width="100%" height="500" frameborder="0"></iframe></td>
		</tr>
	</table> -->
@stop