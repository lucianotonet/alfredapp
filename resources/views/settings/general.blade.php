{{ Form::open(array('url'=>Request::fullUrl(), 'method'=>"POST", 'class'=>"form-horizontal", 'role'=>"form", 'files'=>true)) }}
	
	<div class="page-header">
		<h3>Geral</h3>
	</div>
					
	<div class="form-group">
		<label for="app_title" class="col-sm-2 control-label">Título do APP:</label>
		<div class="col-sm-10">
			<input type="text" name="settings[app_title]" id="app_title" class="form-control" value="{{Config::get('settings.app_title')}}" required="required" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="app_logo" class="col-sm-2 control-label">Logo:</label>
		<div class="col-sm-10">
			{{-- Input::file('image/save', array( 'name'=>"settings[app_logo]", 'id'=>"app_logo", 'value'=>Config::get('settings.app_logo'), 'required'=>"required", 'files'=> true)) --}}
			<input type="text" name="settings[app_logo]" id="app_logo" class="form-control" value="{{Config::get('settings.app_logo')}}" required="required" title="">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<button type="submit" class="btn btn-success"><i class="fa fa-check"></i>  Salvar</button>
		</div>
	</div>
			
	{{-- <input type="file" name="settings[app_logo]" id="app_logo" class="form-control" value="{{Config::get('settings.app_logo')}}" required="required" title="">
	{{ Input::file("settings[app_logo]") }}			 --}}	
{{ Form::close() }}
