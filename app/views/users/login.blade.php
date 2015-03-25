@extends('layouts.master')

@section('content')

<style>
p.text-center img.img-responsive{
	margin: 0 auto;
}

.form-signin {
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
	/*margin-bottom: 10px;*/
}
.form-signin-heading{
	text-align: center;
}
.form-signin .checkbox {
	/* font-weight: normal;*/
}
.form-signin .form-control {
	position: relative;
	height: auto;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	padding: 10px;
	font-size: 16px;
}
.form-signin .form-control:focus {
	z-index: 2;
}
.form-signin input[type="text"],
.form-signin input[type="email"] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
</style>

<div class="container">

	<form class="form-signin" role="form" method="POST" action="{{{ URL::to('/users/login') }}}" accept-charset="UTF-8">

		<p class="text-center">
			<img src="<?php echo asset('img/logo/logo.png'); ?>" alt="" class="img-responsive">
		</p>        
		<p class="text-center">Por favor, identifique-se</p>

		@if (Session::get('error'))     
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{{ Session::get('error') }}<br>
			<a href="{{{ URL::to('/users/forgot_password') }}}" class="alert-link">Esqueceu a senha?</a>
		</div> 
		@endif

		@if (Session::get('notice'))
		<div class="alert alert-info">
			{{ Session::get('notice') }}
		</div>
		@endif

		<input type="hidden" name="_token" value="{{ Session::getToken() }}">        
		<input class="form-control" placeholder="Nome ou E-mail" type="text" name="email" id="email" value="{{ Input::old('email') }}">
		<input type="password" class="form-control" name="password" id="password" placeholder="Senha" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

		<br>

		<label class="pull-left">
			<input type="checkbox" id="flat-checkbox-1" class="icheckbox_flat-blue info" name="remember" {{ (Input::old('remember')) ? 'checked' : '' }} >
			<label for="flat-checkbox-1">Permanecer conectado</label>
		</label> 

		<br>

		@if ( Config::get('settings.app_allow_register') )
		<p class="text-center">
			<a href="{{ url('users/create') }}" class="btn btn-link">Novo cadastro</a>
		</p>      
		@endif

	</form>

	{{-- Confide::makeLoginForm()->render() --}}

</div> <!-- /container -->    

@stop