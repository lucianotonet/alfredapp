{{ Form::open(array('url'=>URL::route('settings.store'), 'method'=>"POST", 'class'=>"form-horizontal", 'role'=>"form", 'files'=>true)) }}
	
	<div class="page-header">
		<h3>E-mail</h3>	  
	</div>
				
	<div class="form-group">
		<label for="mail_name" class="col-sm-2 control-label">Remetente Nome</label>
		<div class="col-sm-10">
			<input type="text" name="mail[from][name]" id="mail_name" class="form-control" value="{{ Config::get('mail.from.name') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="mail_address" class="col-sm-2 control-label">Remetente E-mail</label>
		<div class="col-sm-10">
			<input type="email" name="mail[from][address]" id="mail_address" class="form-control" value="{{	Config::get('mail.from.address') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="" class="col-sm-2 control-label">Assinatura:</label>
		<div class="col-sm-10">
			<textarea class="form-control wysiwyg" name="settings[mail_signature]" rows="3">{{ Config::get('settings.mail_signature') }}</textarea>
		</div>
	</div>

	<hr>

	<div class="form-group">
		<label for="input" class="col-sm-2 control-label">Driver:</label>
		<div class="col-sm-10">
			{{ Form::select('mail[driver]', [	
										'smtp' 		=> 'SMTP',
										'mail' 		=> 'PHP Mail',
										'sendmail' 	=> 'PHP Sendmail',
										'mailgun' 	=> 'Mailgun',
										'mandrill' 	=> 'Mandrill',
										'log' 		=> 'Just Log',
										], Config::get('mail.driver'),
										array( "class"=>"form-control")); }}
			
		</div>
	</div>

	
	<div class="form-group">
		<label for="host" class="col-sm-2 control-label">HOST</label>
		<div class="col-sm-10">
			<input type="text" name="mail[host]" id="host" class="form-control" value="{{ Config::get('mail.host') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="port" class="col-sm-2 control-label">PORTA</label>
		<div class="col-sm-10">
			<input type="number" name="mail[port]" id="port" class="form-control" value="{{ Config::get('mail.port') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="encryption" class="col-sm-2 control-label">CRIPTOGRAFIA</label>
		<div class="col-sm-10">			
			{{ Form::select('mail[encryption]', [										
										'tls' 	=> 'TLS',
										'ssl' 	=> 'SSL',										
										], Config::get('mail.encryption'),
										array( "class"=>"form-control")); }}
		</div>
	</div>

	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">USERNAME</label>
		<div class="col-sm-10">
			<input type="text" name="mail[username]" id="username" class="form-control" value="{{ Config::get('mail.username') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="password" class="col-sm-2 control-label">PASSWORD</label>
		<div class="col-sm-10">
			<input type="text" name="mail[password]" id="password" class="form-control" value="{{ Config::get('mail.password') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<label for="sendmail" class="col-sm-2 control-label">SENDMAIL</label>
		<div class="col-sm-10">
			<input type="text" name="mail[sendmail]" id="sendmail" class="form-control" value="{{ Config::get('mail.sendmail') }}" title="">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
		</div>
	</div>

{{ Form::close() }}