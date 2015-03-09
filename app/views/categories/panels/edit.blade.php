{{ Form::model($category, [ 'method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'category_edit', 'route' =>[ 'categories.update', $category->id ] ] ) }}
	
	<div class="form-group">
		{{ Form::label('name', 'Nome:', array("class"=>"col-sm-2 control-label")) }}			 
        <div class="col-sm-10">	
			{{ Form::text('name', $category->name, ["class"=>"form-control", "required"=>'required']) }}
		</div>
	</div>	

	<div class="form-group">
		<div class="col-sm-2">&nbsp;</div>
        <div class="col-sm-10">
			<button type="submit" class="btn btn-primary">Salvar</button>	
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>    
		</div>
	</div>



	{{-- Form::label('owner_id', 'Owner_id:') --}}
	{{ Form::hidden('owner_id') }}
	{{-- Form::label('owner_type', 'Owner_type:') --}}
	{{ Form::hidden('owner_type') }}
{{ Form::close() }}