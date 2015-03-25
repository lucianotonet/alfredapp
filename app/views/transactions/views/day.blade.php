@if ( count( $transactions ) > 0 )

	<div class="table-responsive">		



		<table class="table table-hover">
			
			<?php $date = ""; ?>

			@foreach ($transactions as $transaction)
			 
					@if ( $transaction->date != @$date)
			
						<thead class="bg-info">
							<tr>
								<th colspan="4" class="text-capitalize text-center">
									{{ strftime("%A, %d de %B", strtotime( $transaction->date )); }}
								</th>
							</tr>
						</thead>	

					@endif

				@include('transactions.views.item')

				<?php $date = $transaction->date; ?>

			@endforeach

		</table>

	</div>

@else

	<div class="panel-body text-center bg-info">	
		<div class="form-group"></div>
		<div class="form-group">
			Nenhum lançamento em {{$title}}					
		</div>
	</div>									

@endif