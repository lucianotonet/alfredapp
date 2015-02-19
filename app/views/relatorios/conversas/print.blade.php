<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap CSS -->
    {{ HTML::style('http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css') }}

</head>
<body class="">
    &nbsp;
    <div class="container">
        @include('relatorios.conversas.print-content')                            
    </div>

    <!-- jQuery -->
    {{ HTML::script("http://code.jquery.com/jquery.js") }}
    <!-- Bootstrap JavaScript -->
    {{ HTML::script("http://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js") }}
    
</body>
</html>