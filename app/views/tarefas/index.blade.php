@extends('layouts.master')

@section('content')

	<!-- Custom styles -->
	{{ HTML::style('css/tarefas.css') }}
    
    <div class="container">    
		<div class="panel panel-primary">
			<div class="panel-heading">				
				<h3 class="panel-title">
					<i class="icon icon-calendar"></i>
					AGENDA
				</h3>
			</div>

			<!-- Nav tabs -->
        
			<div class="panel-body">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ url( '/tarefas/print?' . http_build_query( Request::all() ) ) }}" class="btn btn-primary">
					        <i class="fa fa-print"></i>
					        Imprimir                                               
					    </a>			
					</div>
					<div class="btn-group">
						<a href="{{url('/tarefas/create')}}" class="btn btn-success" data-toggle="modal" data-target="#modal">
							<i class="fa fa-plus"></i> Adicionar
						</a>
					</div>
				</div>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="">
						<a href="{{ url('/agenda') }}">AGENDA</a>
					</li>
					<li role="presentation" class="active">
						<a href="{{ url('/tarefas') }}">TAREFAS</a>
					</li>
				</ul>
				
				<br>

				<div class="btn-group">
				
					<a href="{{ url( '/tarefas?' . http_build_query( array_merge( Request::except('page'), ['view'=>'today'] ) ) ) }}" class="btn {{ (Input::get('view') == 'today' || Input::get('view') == NULL) ? 'btn-primary active' : 'btn-default' }}">
						Hoje <span class="badge badge-success">{{count($tarefas->hoje)}}</span>
					</a>
					<a href="{{ url( '/tarefas?' . http_build_query( array_merge( Request::except('page'), ['view'=>'late'] ) ) ) }}" class="btn {{ (Input::get('view') == 'late') ? 'btn-primary active' : 'btn-default' }}">
						Atrasadas <span class="badge badge-danger">{{count($tarefas->pendentes)}}</span>
					</a>
					<a href="{{ url( '/tarefas?' . http_build_query( array_merge( Request::except('page'), ['view'=>'next'] ) ) ) }}" class="btn {{ (Input::get('view') == 'next') ? 'btn-primary active' : 'btn-default' }}">
						Próximas <span class="badge badge-success">{{count($tarefas->proximas)}}</span>
					</a>
					<a href="{{ url( '/tarefas?' . http_build_query( array_merge( Request::except('page'), ['view'=>'done'] ) ) ) }}" class="btn {{ (Input::get('view') == 'done') ? 'btn-primary active' : 'btn-default' }}">
						Concluídas <span class="badge badge-primary">{{count($tarefas->concluidas)}}</span>
					</a>
					
				</div>

				<div class="pull-right form-inline">                        
            		            		
            		<div class="form-group">
						<label for="">Exibir:</label>
	            		<div class="btn-group">
	            			<button type="button" class="btn btn-default dropdown-toggle text-capitalize" data-toggle="dropdown" aria-expanded="false">
	            				{{ (Input::get('order') == 'asc') ? 'Mais antigo antes' : 'Mais recente antes' }} <span class="caret"></span>
	            			</button>
	            			<ul class="dropdown-menu" role="menu">
	            				<li>
	            					<a href="{{ url( '/tarefas?' . http_build_query( array_merge( Request::all(), ['order'=>'asc'] ) ) ) }}">
	            						Mais antigo antes
	            					</a>
	            				</li>
	            				<li>
	            					<a href="{{ url( '/tarefas?' . http_build_query( array_merge( Request::all(), ['order'=>'desc'] ) ) ) }}">
	            						Mais recente antes
	            					</a>
	            				</li>	            				
	            			</ul>
	            		</div>	            		
					</div>            		
	            	
                </div><!-- /input-group -->

			</div>

        	<div class="panel-body">
        		@include('tarefas.panels.index')
        	</div>
    
		</div>
    </div>
        
@stop