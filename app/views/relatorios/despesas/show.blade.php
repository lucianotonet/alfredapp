@extends('layouts.master')

@section('content')

	<div class="container">   
		
		<!-- Breadcrumbs -->
		<ol class="breadcrumb breadcrumb-arrow hidden-print">
			<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
			<li><a href="{{url('relatorios')}}">Relatórios</a></li>			
			<li class="active"><span>Ver relatório</span></li>	
		</ol>


		<div class="panel panel-primary" style="display:block; width:100%!important; height:100%!important;" >
			<div class="panel-body">
				<div class="pull-right">	

					<script>
						function printpage(url)
						{

							child = window.open(url, "", "height=100%, width=100%");  //Open the child in a tiny window.
							window.focus();  //Hide the child as soon as it is opened.
							child.print();  //Print the child.
							//child.close();  //Immediately close the child.

						}
					</script>				

					{{ Form::open(array('url' => 'relatorios/' . $relatorio->id, 'class' => '')) }}
		                
							<a href="#{{--url('relatorios/'.$relatorio->id.'/print')--}}" onclick="printFrame( 'printf' );" class="btn btn-sm btn-info" ><i class="fa fa-print"></i> Imprimir</a>		
							
							<a href="{{ url('/emails/create/?owner_type=relatorio&owner_id='.$relatorio->id) }}" class="btn btn-success btn-sm send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope-o"></i> Enviar por e-mail</a>
						
							<?php if( Confide::user() ){ ?>
								<a href="{{ url('relatorios/'.$relatorio->id.'/edit') }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editar</a>		                   
							
		                    {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger btn-sm', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Excluir o relatório?")')) }}

		                    {{ Form::hidden('_method', 'DELETE') }}
							<!-- <a href="#" class="btn btn-sm btn-link">Right</a> -->
							<?php } ?>

		                	                
		            {{ Form::close() }} 


				</div>
			    <h3 class="title">
			    	Relatório <strong>Nº{{$relatorio->id}}</strong>
			    	<?php if( Confide::user() ){ ?>
						@if( $relatorio->status )
							<span class="badge label label-success" title="Enviado"><i class="fa fa-check"></i> Enviado</span>
						    <!-- <span class="label label-success">		
								Já enviado
							</span> -->
						@else
							<span class="badge label label-danger" title="Não enviado">Não enviado</span>
						@endif
					<?php } ?>
				</h3>
				
				<div class="clearfix"></div>

			</div>    

	

		</div>		
				
		<iframe src="{{url('relatorios/'.$relatorio->id.'/print')}}" class="panel" width="100%" height="600" id="printf" name="printf">					
			<!-- PDF STREAM -->
		</iframe>	           					   

		<!-- Relatório Header -->
		

	</div>

@stop



