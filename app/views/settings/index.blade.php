@extends('layouts.master')

@section('content')

<div class="container">        

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title title">
				<i class="fa fa-cog"></i> Configurações
			</h3>
		</div>

		<div class="panel-body">
			<form action="{{ Request::fullUrl() }}" method="POST" class="form-horizontal" role="form">

				<legend>Geral</legend>
				
				<div class="form-group">
					<label for="app_title" class="col-sm-2 control-label">Título do APP:</label>
					<div class="col-sm-10">
						<input type="text" name="settings[app_title]" id="app_title" class="form-control" value="{{Config::get('settings.app_title')}}" required="required" title="">
					</div>
				</div>

				<div class="form-group">
					<label for="app_logo" class="col-sm-2 control-label">Logo:</label>
					<div class="col-sm-10">
						<input type="text" name="settings[app_logo]" id="app_logo" class="form-control" value="{{Config::get('settings.app_logo')}}" required="required" title="">
					</div>
				</div>


				<legend>E-mail</legend>
				
				<div class="form-group">
					<label for="mail_name" class="col-sm-2 control-label">Remetente Nome</label>
					<div class="col-sm-10">
						<input type="text" name="mail[from][name]" id="mail_name" class="form-control" value="{{Config::get('mail.from.name')}}" title="">
					</div>
				</div>

				<div class="form-group">
					<label for="mail_address" class="col-sm-2 control-label">Remetente E-mail</label>
					<div class="col-sm-10">
						<input type="email" name="mail[from][address]" id="mail_address" class="form-control" value="{{Config::get('mail.from.address')}}" title="">
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Assinatura:</label>
					<div class="col-sm-10">
						<textarea class="form-control wysiwyg" name="settings[mail_signature]" rows="3">{{Config::get('settings.mail_signature')}}</textarea>
					</div>
				</div>

				
				<legend>Avançado</legend>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Configurações originais:</label>
					<div class="col-sm-10">
						<p class="form-control-static">
							<a href="{{ url('settings/reset') }}" class="btn btn-sm btn-danger" onclick="return confirm('Restaurar TODAS as configurações originais?')"><i class="fa fa-undo"></i> Restaurar</a>
						</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-12 text-right">						
						<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
					</div>
				</div>
			</form>
		</div>

	
	</div>

	@stop