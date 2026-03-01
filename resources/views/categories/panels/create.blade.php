<div class="panel panel-primary">
	<div class="panel-heading">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 class="panel-title">Adicionar</h3>
	</div>
	
	{{ Form::open(array('url' => 'categories', 'method' => 'POST', 'class'=>'form-horizontal' )) }}
	
	<div class="panel-body">
		<div class="form-group">
			{{ Form::label('name', 'Nome:', array("class"=>"col-sm-2 control-label")) }}			 
			<div class="col-sm-10"> 
				{{ Form::text('name', '', ["class"=>"form-control", "required"=>'required']) }}
			</div>
		</div>			
		
	</div>

	<div class="panel-footer navbar-inverse">	
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">					
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
			</div>				
			<div class="btn-group" role="group">					
				<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
			</div>
		</div>
	</div>			

	{{ Form::hidden('owner_type', Input::get('owner_type')) }}
	{{ Form::hidden('owner_id') }}

	{{ Form::close() }}	
</div>