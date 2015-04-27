{{ Form::open(array('url'=>URL::route('settings.store'), 'method'=>"POST", 'class'=>"form-horizontal", 'role'=>"form", 'files'=>true)) }}
	
	<div class="page-header">
		<h3>Notificações</h3>
	</div>
					
	<div class="form-group">
		<label for="notifications" class="col-sm-2 control-label">Enviar para:</label>
		<div class="col-sm-10">
			<input type="text" name="settings[notifications]" id="notifications" class="form-control" value="{{Config::get('settings.notifications')}}" title="" placeholder="">
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
