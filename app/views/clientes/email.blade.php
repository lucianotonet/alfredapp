@extends('layouts.email')

@section('title')
	<table>
		<tr>
			<td>				
				<h3>Dados do cliente</h3>
			</td>
		</tr>
	</table>	
@stop
	
@section('content')
<hr>

	<table>
		<tr>
			<td>				

				<table class="table table-hover" cellspacing="10">        
				    <tbody>
				        <tr>
				            <td width="60" align="top"  valign="top">
				                <img src="http://rayhiltz.com/wp-content/uploads/2013/01/BlueHead.png" width="60" hegth="60" alt="" class="img-responsive">				                
				            </td>
				            <td vertical-align="top">

				            	<table cellspacing="8">

				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">Nome</td>
				            			<td ><strong>{{ $resource['nome'] }}</strong></td>
				            		</tr>
				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">Empresa</td>
				            			<td ><strong>{{$resource['empresa']}}</strong></td>
				            		</tr>				            		
				            	
				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">Telefones</td>
										<td >
						                    <strong>{{$resource['telefone']}} {{ ($resource['celular']) ? "<br>".$resource['celular'] : "" }}</strong>
			            				</td>
				            		</tr>
				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">E-mail</td>
										<td >
						                    <strong>{{@$resource['email']}}</strong>
			            				</td>
				            		</tr>
				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">Endereço</td>
										<td >
						                    <strong>
						                    	{{$resource['endereco']}}, {{$resource['bairro']}}<br>
						                    	{{$resource['cidade']}}/{{$resource['uf']}}<br>
												CEP {{$resource['cep']}}
											</strong>
			            				</td>
				            		</tr>

				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">IE</td>
				            			<td ><strong>{{$resource['ie']}}</strong></td>
				            		</tr>
				            		<tr>
				            			<td style="font-size:70%; padding-top:3px; color:#aaaaaa;text-align:right;" valign="top">CPF/CNPJ</td>
				            			<td ><strong>{{$resource['cnpj']}}</strong></td>
				            		</tr>
				            	
				            	</table>				            
							                    
				            </td>
				        </tr>
				        
				    </tbody>
				</table>    

			</td>
		</tr>
	</table>		
@stop
