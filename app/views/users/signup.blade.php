@extends('layouts.master')

@section('content')
	<style>
p.text-center img.img-responsive{
	margin: 0 auto;
	max-width: 170px;
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



		{{-- Confide::makeSignupForm()->render(); --}} 
		<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
			
			@if (Session::get('error'))
		        <div class="alert alert-error alert-danger">
		            @if (is_array(Session::get('error')))
		                {{ head(Session::get('error')) }}
		            @endif
		        </div>
		    @endif

			 @if (Session::get('notice'))
		        <div class="alert alert-info">{{ Session::get('notice') }}</div>
		    @endif

		    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
		    <fieldset>
		        @if (Cache::remember('username_in_confide', 5, function() {
		            return Schema::hasColumn(Config::get('auth.table'), 'username');
		        }))
		            <div class="form-group">
		                <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
		                <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
		            </div>
		        @endif
		        <div class="form-group">
		            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
		            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
		        </div>
		        <div class="form-group">
		            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
		            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
		        </div>
		        <div class="form-group">
		            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
		            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
		        </div>

		        <div class="form-actions form-group">
		          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
		        </div>

		    </fieldset>
		</form>


	<br>
	<p class="text-center">
		<a href="{{ url('login') }}" class="btn btn-link">Já tenho cadastro</a>
	</p>      

</div> <!-- /container -->    
@stop