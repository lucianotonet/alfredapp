<?php use Carbon\Carbon as Carbon; ?>
@extends('layouts.master')

@section('styles')
	{{ HTML::style('css/agenda.css') }}
@stop

@section('content')
	<div class="container">
		<div class="panel panel-primary">
            <div class="panel-heading">             
                <h3 class="panel-title">
                    <i class="icon icon-calendar"></i>
                    AGENDA
                </h3>
            </div>
			<div class="panel-body">
				<div class="pull-right">
                    <div class="btn-group">
                        <a href="{{ url( 'agenda/print/?' . http_build_query( Request::all() ) ) }}" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                            Imprimir                                               
                        </a>            
                    </div>
                    <div class="btn-group">
                        <a href="{{url('agenda/create')}}" class="btn btn-success" data-toggle="modal" data-target="#modal">
                            <i class="fa fa-plus"></i> Adicionar
                        </a>
                    </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="{{ url('/agenda') }}">AGENDA</a>
                    </li>
                    <li role="presentation" class="">
                        <a href="{{ url('/tarefas') }}">TAREFAS</a>
                    </li>
                </ul>
			
                <br>
       
				<div class="pull-right form-inline">                        
            		            		
            		<div class="form-group">
						<label for="">Exibir:</label>
	            		<!-- Single button -->
	            		<div class="btn-group">
	            			<button type="button" class="btn btn-default dropdown-toggle text-capitalize" data-toggle="dropdown" aria-expanded="false">
	            				{{ $labels['filter'] }} <span class="caret"></span>
	            			</button>
	            			<ul class="dropdown-menu" role="menu">
	            				<li><a href="{{ $navigation_links['filter_type_agendaevent'] }}">Eventos</a></li>
	            				<li><a href="{{ $navigation_links['filter_type_tarefa'] }}">Tarefas</a></li>
	            				<li><a href="{{ $navigation_links['filter_type_all'] }}">Tudo</a></li>	            				
	            			</ul>
	            		</div>	 
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle text-capitalize" data-toggle="dropdown" aria-expanded="false">
                                {{ (Input::get('order') == 'asc') ? 'Mais antigo antes' : 'Mais recente antes' }} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url( 'agenda/?' . http_build_query( array_merge( Request::all(), ['order'=>'asc'] ) ) ) }}">
                                        Mais antigo antes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url( 'agenda/?' . http_build_query( array_merge( Request::all(), ['order'=>'desc'] ) ) ) }}">
                                        Mais recente antes
                                    </a>
                                </li>                               
                            </ul>
                        </div>                  		
					</div>            		
	            	
                </div><!-- /input-group -->

                


				<div class="dropdown pull-left"> 
                    @if ( isset($navigation_links['prev']) )                                       
                                                                                
                        <a href="{{ $navigation_links['prev'] }}" class="btn btn-link"><i class="fa fa-chevron-left"></i></a>
                        
                    @endif
						<a id="select_label" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">                        
                            <strong class="text-uppercase">
                                {{ $labels['title'] }}
                                <span class="caret"></span>
                            </strong>
                        </a>

                    @if ( isset($navigation_links['next']) )                                           
                        <a href="{{ $navigation_links['next'] }}" class="btn btn-link"><i class="fa fa-chevron-right"></i></a>
                    @endif  

                        <ul class="dropdown-menu" role="menu" aria-labelledby="select_label">  
                            <li><a href="{{ $navigation_links['view_today_link'] }}">Hoje</a></li>                                
                            <li><a href="{{ $navigation_links['view_thisweek_link'] }}">Esta semana</a></li>
                            <li><a href="{{ $navigation_links['view_thismonth_link'] }}">Este mês</a></li>                                
                        </ul>                       
                </div>               

			</div>

            <div class="panel-body">                

				@include('agenda.panels.index')
					
		  	</div>
		</div>
	</div>
@stop

@section('scripts')
    <script>
        $('.modal').on('hidden.bs.modal', function (e) {
            $(this).removeData('bs.modal');
        })
    </script>
@stop