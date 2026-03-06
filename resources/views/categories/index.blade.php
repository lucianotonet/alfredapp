@extends('layouts.master')

@section('content')

    <div class="container">        

    	<div class="panel panel-primary">
		    
		    <div class="panel-heading">
		        <h3 class="panel-title">CATEGORIAS</h3>                    
		    </div>		        

		    <div class="panel-body">
		    	<div class="btn-group pull-right">           
		            <a class="btn btn-primary" data-toggle="modal" data-target="#modal" href="{{ url('categories/create') }}">
		                <i class="fa fa-plus"></i> Adicionar categoria
		            </a>
		        </div>
		    </div>		        

		    <div class="panel-body">    
		        <div class="row">
		            <div class="col-sm-3 col-md-3 col-lg-3">
				    	<div class="list-group">
				    		@foreach ($types as $type => $cats)
								<a class="list-group-item {{ (!empty( $type ) and Input::get('owner_type') == $type) ? 'active' : '' }}" href="{{ url( 'categories/?owner_type='.$type ) }}">
									{{ !empty( $type ) ? $type : '<small>(sem nome)</small>' }}
									<span class="badge">{{ count($cats) }}</span>
								</a>			    		
				    		@endforeach	
				    		<a class="list-group-item {{ ( !Input::has('owner_type') ) ? 'active' : '' }}" href="{{ url( 'categories/' ) }}">
								Todas
								<span class="badge"></span>
							</a>						
						</div>	                
		            </div>
		            <div class="col-sm-9">

						@include('categories.panels.index')

						{{ $categories->appends( Request::except('page') )->links() }} 

					</div>		        	
		        </div>
            </div>

       	</div>	                	            

    </div>

@stop