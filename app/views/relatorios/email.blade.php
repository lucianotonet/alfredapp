@extends('layouts.email')

@section('title')
	<table>
		<tr>
			<td>				
				<h3>Relatório nº{{ $email['owner_id'] }}</h3>
			</td>
		</tr>
	</table>	
@stop
	
@section('content')
	<table>
		<tr>
			<td>				

				<p style="text-align:center;">
					<a href="{{url('relatorios/'.$email['owner_id'].'/print' )}}" class="btn-primary">VER RELATÓRIO</a>
				</p>

			</td>
		</tr>
	</table>		
	<table>
		<tr>
			<td><iframe src="{{url( 'relatorios/'.$email['owner_id'].'/print' )}}" width="100%" height="500" frameborder="0"></iframe></td>
		</tr>
	</table>
@stop