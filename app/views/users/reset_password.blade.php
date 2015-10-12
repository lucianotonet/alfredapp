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
    <p class="text-center">Recuperação de senha</p>

    <form method="POST" action="{{{ URL::to('/users/reset_password') }}}" accept-charset="UTF-8">
        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif

        <br>

        <input type="hidden" name="token" value="{{{ $token }}}">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <label for="password">Nova senha</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>


        <div class="form-actions form-group">
            <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
        </div>
    </form>


    <br>

    <p class="text-center">
        <a class="btn btn-link" onclick="window.history.back();"><i class="fa fa-chevron-left"></i> Voltar</a>
    </p>      

</div> <!-- /container -->    
@stop
