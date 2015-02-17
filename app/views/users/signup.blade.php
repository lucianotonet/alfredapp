@extends('layouts.master')

@section('content')
	<style>
p.text-center img.img-responsive{
	margin: 0 auto;
}

form {
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
}
form .form-signin-heading,
form .checkbox {
	/*margin-bottom: 10px;*/
}
.form-signin-heading{
	text-align: center;
}
form .checkbox {
	/* font-weight: normal;*/
}
form .form-control {
	position: relative;
	height: auto;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	padding: 10px;
	font-size: 16px;
}
form .form-control:focus {
	z-index: 2;
}
form input[type="text"],
form input[type="email"],
form input[type="password"] {
	margin-bottom: -1px;
}

form .form-actions {
	text-align: center;	
}
</style>

<div class="container">

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

		{{ Confide::makeSignupForm()->render(); }} 

	<br>
	<p class="text-center">
		<a href="{{ url('login') }}" class="btn btn-link">Já tenho cadastro</a>
	</p>      

</div> <!-- /container -->    
@stop