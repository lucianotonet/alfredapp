@extends('layouts.master')

@section('content')
   
	
	<div class="container">   


		<div class="">
		
			<?php   
				use Faker\Factory as Faker;
				$faker = Faker::create('pt_BR');
			?>            

			<div class="well well=lg">     
				<h3 class="pull-right title">
				   <a href="<?php echo url('/logout'); ?>">Sair <i class="fa fa-sign-out"></i></a>
				</h3>           
				<h3 class="title"><?php echo Saudacoes::ola() ?></h3>
			</div>



			<!-- Tarefas -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="btn-group btn-group-sm pull-right">
						<!-- <a href="{{url('tarefas/create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</a> -->
						<a class="btn btn-default btn-sm" data-toggle="modal" href='#tarefas_create'><i class="fa fa-plus"></i> Adicionar</a>

						<a href="{{url('tarefas')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> Ver todas</a>
					</div>
					<h3 class="panel-title title">Próximas tarefas</h3>
				</div>
				<div class="panel-body bg-default">
					@if ( isset($tarefas->proximas) and count($tarefas->proximas) ) 
						<ul class="row tarefas">
							@foreach ($tarefas->proximas as $tarefa)		
								<li class="col-sm-6 col-xs-12 col-md-4 tarefa">
									@include('tarefas.panels.item', $tarefa)							
								</li>
							@endforeach
						</ul>					
					@endif	
				</div>
			</div>


			

					
				

				@section('styles')
				<style>
					
					.timeline{

					}
					.timeline li .timeline-title{
						border-bottom: 1px solid #cecece;
					}
					.timeline li:before{
						border-left: 1px solid rgb(203, 203, 203);
						content: "";
						position: relative;
						margin-left: 20px;
						height: 20px;
						display: -webkit-box;
						top: 0px;  
					}
					.timeline > li > .timeline-badge {
						color: #fff;
						width: 50px;
						height: 50px;
						line-height: 50px;
						font-size: 1.4em;
						text-align: center;
						position: absolute;
						top: 16px;
						left: 50%;
						margin-left: -25px;
						background-color: #999999;
						z-index: 100;
						border-top-right-radius: 50%;
						border-top-left-radius: 50%;
						border-bottom-right-radius: 50%;
						border-bottom-left-radius: 50%;
					}
					.timeline li:first-child:before{        
						display: none;        
					}
					.timeline li:first-child:before .title{        
						margin-top: 0px;
						padding-top: 0px;
					}
					.timeline li{
						margin: 0px;
					}
				</style>    
				@stop




					
				
		</div> 	
	</div>

	<div class="modal fade" id="tarefas_create">
		<div class="modal-dialog">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			@include('tarefas.panels.create')

		</div>
	</div>
		
@stop


@section('dock')
	
@stop