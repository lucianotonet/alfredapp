@extends('layouts.master')

@section('content')

<div class="container">        

	<!-- Breadcrumbs -->
	<ol class="breadcrumb breadcrumb-arrow hidden-print">
		<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
		<li class="active"><span>Relatórios</span></li>	
	</ol>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php if( Confide::user() ){ ?>
			<a href="{{url('relatorios/create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Novo</a>					
			<?php } ?>
			<h3 class="panel-title title">Relatórios</h3>
		</div>
	


			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
				      		<li class="active">
				                <a href="#despesas" role="tab" data-toggle="tab">                	            	
				                    <strong><span class="icon-wallet"></span> DESPESAS</strong>
				                </a>
				            </li>
				            <li class="">
				                <a href="#conversas" role="tab" data-toggle="tab">
				                    <strong><span class="icon-chat"></span> CONVERSAS</strong>
				                </a>
				            </li>        	            
				        </ul>
			
				        <div class="tab-content">
			
			
					        <!-- TAB PANE -->
					        <div class="tab-pane active" id="despesas">	        	
									
								@if ( isset( $relatorios->despesas ) )					
						        	<div class="panel-body">
						        		<?php if( Confide::user() ){ ?>
						        		<a href="{{url('/relatorios/create/despesas')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Novo</a>
						        		<?php } ?>
							        	<h3 class="title">
							        		{{count(@$relatorios->despesas)}} relatórios de despesa
							        	</h3>
						        	</div>
			
									@foreach ( $relatorios->despesas as $relatorio )
									<div class="list-group-item">						
			
										{{ Form::open(array('url' => 'relatorios/' . $relatorio->id, 'class' => '')) }}
							                <div class="pull-right">
			
							                    <?php if( Confide::user() ){ ?>
													
													@if( $relatorio->status < 1 )
													<a href="{{ url('/emails/create/?owner_type=relatorio&owner_id='.$relatorio->id) }}" class="btn btn-sm btn-success send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope-o"></i></a>
													@endif
			
								                    <a href="{{ url('/relatorios/'.$relatorio->id.'/edit') }}" class="btn btn-primary btn-sm">
								                        <i class="fa fa-edit"></i>
								                    </a>
			
								                    {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Excluir o relatório?")')) }}
			
								                    {{ Form::hidden('_method', 'DELETE') }}									
												<?php } ?>
			
							                
							                </div>
							            {{ Form::close() }} 
									
										<a href="{{url('relatorios',$relatorio->id)}}" class="">		
											<?php if( Confide::user() ){ ?>					
												@if( $relatorio->status )								
													<span class="badge label label-success" title="Enviado"><i class="fa fa-check"></i></span>
												@else
													<span class="badge label label-danger" title="Não enviado"><i class="fa fa-warning"></i></span>
												@endif
											<?php } ?>
											Relatório Nº{{$relatorio->id}} - {{date('d/m/Y',strtotime($relatorio->created_at))}}
										</a>
									</div>
									@endforeach		  
			
								@else
			
									<div class="panel-body text-center">
							        	<h2 class="title">
							        		Nenhum relatório de despesa
							        	</h2>
							        	<?php if( Confide::user() ){ ?>
						        		<a href="{{url('/relatorios/create/despesas')}}" class="btn btn-success btn-lg"><i class="fa fa-plus"></i> Novo relatório</a>
						        		<?php } ?>
						        	</div>   
			
								@endif
					        </div>
			
					        <!-- TAB PANE -->
					        <div class="tab-pane" id="conversas">
			
					        	@if ( isset( $relatorios->conversas ) )
						        	<div class="panel-body">
						        		<?php if( Confide::user() ){ ?>
						        		<a href="{{url('/relatorios/create/conversas')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Novo</a>	        		
						        		<?php } ?>
							        	<h3 class="title">
							        		{{ count(@$relatorios->conversas) }} relatórios de conversa
							        	</h3>
						        	</div>
			
									@foreach ( $relatorios->conversas as $relatorio )
									<div class="list-group-item">						
			
										{{ Form::open(array('url' => 'relatorios/' . $relatorio->id, 'class' => '')) }}
							                <div class="pull-right">
												
							                    <?php if( Confide::user() ){ ?>
													@if( $relatorio->status < 1 )
													<a href="{{ url('/emails/create/?owner_type=relatorio&owner_id='.$relatorio->id) }}" class="btn btn-sm btn-success send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope"></i></a>
													@endif
					<!-- 
								                    <a href="{{ url('/relatorios/'.$relatorio->id.'/edit') }}" class="btn btn-primary btn-sm">
								                        <i class="fa fa-edit"></i>
								                    </a> -->
								                    
								                    {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Excluir o relatório?")')) }}
			
								                    {{ Form::hidden('_method', 'DELETE') }}
							                	<?php } ?>
												<!-- <a href="#" class="btn btn-sm btn-link">Right</a> -->
			
							                
							                </div>
							            {{ Form::close() }} 
									
										<a href="{{url('relatorios',$relatorio->id)}}" class="">							
											<?php if( Confide::user() ){ ?>
											@if( $relatorio->status )								
												<span class="badge label label-success" title="Enviado"><i class="fa fa-check"></i></span>
											@else
												<span class="badge label label-danger" title="Não enviado"><i class="fa fa-warning"></i></span>
											@endif
											<?php } ?>
											Relatório Nº{{$relatorio->id}} - {{date('d/m/Y',strtotime($relatorio->created_at))}}
										</a>
									</div>
									@endforeach		  		    
			
								@else
			
									<div class="panel-body text-center">
							        	<h2 class="title">
							        		Nenhum relatório de conversas
							        	</h2>
							        	<?php if( Confide::user() ){ ?>
						        		<a href="{{url('/relatorios/create/conversas')}}" class="btn btn-success btn-lg"><i class="fa fa-plus"></i> Novo relatório</a>
						        		<?php } ?>
						        	</div>   
			
								@endif
			
					        </div>
					        
					    </div></div>
			
		
	</div>
</div>

@stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$("#selectr").selecter();

			if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
		    return $('a[data-toggle="tab"]').on('shown', function(e) {
		      return location.hash = $(e.target).attr('href').substr(1);
		    });

		});
	</script>
@stop