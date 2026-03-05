	@if (session()->has('alerts')) 

	<div class="container">
		@foreach (session()->get('alerts') as $alert)


		<div class="alert <?php echo @$alert['class'] ?> fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span>
				<span class="sr-only">Close</span>
			</button>

			<p>{{@$alert['message']}}</p>          


			<?php 
			if( isset($alert['links']) ){
				echo "<p>";
				foreach ( $alert['links'] as $item => $value ){ ?>
				<a href="{{$value['link']}}" class="btn {{$item}}">
					{{$value['text']}}
				</a>                    
				<?php }
				echo "</p>";
			}
			?>

		</div>
		@endforeach
		<br>
	</div>
	@endif