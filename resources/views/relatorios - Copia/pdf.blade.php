<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>RELATÓRIO</title>
</head>
<body>	

    <div class="container">        

        <h1 class="title">RELATÓRIO {{$relatorio->id}}</h1>

		despesas <br>
		@foreach ($relatorio->despesas as $despesa)
			
        		{{ $despesa->id }}
        	<br>
		@endforeach

		conversas <br>
		@foreach ($relatorio->conversas as $conversa)
			
        		{{ $conversa->id }}
        	<br>
		@endforeach


    </div>

</body>
</html>