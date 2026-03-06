{{ Form::model($category, [ 'method' => 'PATCH', 'route' =>[ 'categories.update', $category->id ], 'id' => 'category_edit' ] ) }}
	<ul>
		<li>
			{{ Form::label('name', 'Name:') }}
			{{ Form::text('name', '', ["class"=>"form-control", "required"=>'required']) }}
		</li>
		<li>
			{{ Form::label('slug', 'Slug:') }}
			{{ Form::text('slug', '', ["class"=>"form-control", "required"=>'required']) }}
		</li>
		<li>
			{{-- Form::label('owner_id', 'Owner_id:') --}}
			{{ Form::hidden('owner_id') }}
		</li>
		<li>
			{{-- Form::label('owner_type', 'Owner_type:') --}}
			{{ Form::hidden('owner_type') }}
		</li>
		<li>
			{{ Form::submit() }}
		</li>
	</ul>
{{ Form::close() }}