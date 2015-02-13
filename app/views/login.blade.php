<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Flat UI - Free Bootstrap Framework and Themes</title>
    <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

    <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="css/flat-ui.css" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  
  <div class="row green"> 
    <div class="container">


        {{ Form::open(array('url' => 'login')) }}
          <div class="login-form">
            
            <h4>Painel administrativo</h4>

            <!-- if there are login errors, show them here -->
            @if (count($errors) >= 1)
                <div class="errorHandler alert alert-danger">  <!-- no-display -->                    
                    <i class="fa fa-remove-sign"></i>
                    {{ $errors->first('email') }}
                    {{ $errors->first('password') }}
                </div>
            @endif


            <div class="form-group">
              <!-- <input type="text" class="form-control login-field" value="" placeholder="Digite seu nome" id="login-name" />
              <label class="login-field-icon fui-user" for="login-name"></label> -->
              {{ Form::text('email', Input::old('email'), array('placeholder' => 'Digite seu e-mail', 'class' => 'form-control input-lg login-field')) }}
              {{ Form::label('email', ' ', array("class"=>"login-field-icon fui-user" )) }}
            </div>

            <div class="form-group">
              <!-- <input type="password" class="form-control login-field" value="" placeholder="Digite sua senha" id="login-pass" />
              <label class="login-field-icon fui-lock" for="login-pass"></label> -->
              {{ Form::password('password', array('placeholder' => 'Digite sua senha', 'class' => 'form-control login-field')) }}
              {{ Form::label('password', ' ', array("class"=>"login-field-icon fui-lock" )) }}
            </div>

            
            {{ Form::submit('Entrar', array('class'=>'btn btn-primary btn-lg btn-block')) }}
            <a class="login-link" href="#">Perdeu a senha?</a>

          </div>
        {{ Form::close() }}        


    </div>
  </div>

    <!-- Load JS here for greater good =============================-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
    <script src="js/jquery.stacktable.js"></script>
    <script src="http://vjs.zencdn.net/4.3/video.js"></script>
    <script src="js/application.js"></script>
  </body>
</html>