{{ Form::open(array('url' => 'categories', 'method' => 'POST', 'class'=>'form-horizontal' )) }}
	<div class="form-group">
		{{ Form::label('name', 'Nome:', array("class"=>"col-sm-2 control-label")) }}			 
        <div class="col-sm-10"> 
			{{ Form::text('name', '', ["class"=>"form-control", "required"=>'required']) }}
		</div>
	</div>	
	<div class="form-group">
		<div class="col-sm-2">&nbsp;</div>
        <div class="col-sm-10">
			<button type="submit" class="btn btn-primary">Salvar</button>	
		</div>
	</div>		
	
	{{ Form::hidden('owner_type', @$owner_type) }}
	{{ Form::hidden('owner_id') }}
	
{{ Form::close() }}	