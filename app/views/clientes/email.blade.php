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

				<table class="table table-hover">        
				    <tbody>
				        <tr>
				            <td width="60" align="top"  valign="top">
				                <span class="pull-left cliente-avatar" style="background-color:#3bafda">
				                    <img src="{{asset('img/avatar-small.png')}}" alt="" class="img-responsive">
				                </span>
				            </td>
				            <td vertical-align="top">

				            	<table class="table table-hover">
				            		<tbody>
				            			<tr>
				            				<td>
				            					<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">Nome</small>
												<br>
							                    <strong>{{ $resource['nome'] }}</strong>		
				            				</td>
				            			</tr>
				            			<tr>
				            				<td>
				            					<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">Empresa</small>
												<br>
							                    {{$resource['empresa']}}																	                 
				            				</td>
				            			</tr>
				            			<tr>
				            				<td>
				            					<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">IE</small>
												<br>
							                    {{$resource['ie']}}																	                 
				            				</td>
				            			</tr>
				            			<tr>
				            				<td>
				            					<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">CPF/CNPJ</small>
												<br>
							                    {{$resource['cnpj']}}																	                 
				            				</td>
				            			</tr>
				            		</tbody>
				            	</table>
				            		
				            			
				            </td>
				            <td valign="top" >
				            	
					             <table class="table table-hover">
				            		<tbody>
				            			<tr>
				            				<td>   
				            			
						            			<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">Telefones</small>
												<br>				                    
							                    <strong>{{$resource['telefone']}} {{ ($resource['celular']) ? "<br>".$resource['celular'] : "" }}</strong>

					                		</td>
				            			</tr>
				            			<tr>
				            				<td>   
				            			
						            			<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">E-mail</small>
												<br>				                    
							                    {{@$resource['email']}}

					                		</td>
				            			</tr>
				            			<tr>
				            				<td>    
				            		 
						            			<small style="font-size:70%;color:#aaaaaa;line-height:24px;margin:0 auto -4px;text-decoration:underline;">Endereço</small>
												<br>				                    
							                    {{$resource['endereco']}}
												{{$resource['bairro']}}
												{{$resource['cidade']}}{{$resource['uf']}}
												{{$resource['cep']}}



							               </td>
				            			</tr>
				            		</tbody>
				            	</table> 
							                    
				            </td>
				        </tr>
				        
				    </tbody>
				</table>    

			</td>
		</tr>
	</table>		
@stop
