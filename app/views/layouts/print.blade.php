<?php use Carbon\Carbon as Carbon; ?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Printing Page</title>

		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

		<link href="//bootswatch.com/yeti/bootstrap.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Font Awesome -->		
		{{ HTML::style('css/font-awesome.min.css') }}
		{{-- IcoMoon --}}
		{{ HTML::style('css/icomoon/style.css')}}

		<!-- Custom styles -->
		{{ HTML::style('css/style.css') }}

	</head>
	<body>

		<div class="container">
			@yield('content')
		</div>		

		
		<script src="//code.jquery.com/jquery.js"></script>		
		<!-- Bootstrap JavaScript -->
		<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->
		<script>
			$(document).ready(function() {
				window.print();
			});
		</script>
	</body>
</html>