<?php $class = ( $transaction->type == 'despesa' ) ? 'danger' : 'success' ?>
<?php $done  = ( $transaction->done == '1' ) 	   ? 'done'   : '' ?>		

	<tr class="transaction_type_{{$transaction->type}} <?php echo ($transaction->done == 1) ? 'active' : '' ?> text-{{ $class }}" data-toggle="modal" href='#transaction_show_{{$transaction->id}}' >

		
		<td class="text-left hidden-xs transaction_done_{{$transaction->done}}" width="70">
			<small class="pull-left">
				<i class="text-muted">{{ $title }}</i>
				<br>

					<!-- <i class="fa fa-refresh" title="Recorrente"></i> -->

				@if ( $transaction->isOverdue() )
					
					<i class="fa fa-warning text-danger" title="Atrasada"></i>
					
				@elseif( $transaction->done )

					<i class="fa fa-check text-{{ $class }}"></i>

				@endif
			</small>
		</td>

		<td class="text-left transaction_done_{{$transaction->done}}">			
			{{ $transaction->description }}			
		</td>
		
		<td class="text-right transaction_done_{{$transaction->done}}" width="140">
			<span class="lead font open_sanscondensed_light">
			
				@if ( $transaction->type == 'receita' )
					@if ( $transaction->done == 1 )
						<s>R$ {{ number_format( (float)$transaction->amount, '2', ',', '.') }}</s>
					@else
						<strong>R$ {{ number_format( (float)$transaction->amount, '2', ',', '.') }}</strong>
					@endif							
				@else						
					@if ( $transaction->done == 1 )
						<s>R$ {{ number_format( (float)$transaction->amount, '2', ',', '.') }}</s>
					@else
						<strong>R$ {{ number_format( (float)$transaction->amount, '2', ',', '.') }}</strong>
					@endif									
				@endif					
			
			</span>

		</td>

	</tr>		

				
	<div class="modal fade" id="transaction_show_{{$transaction->id}}">
		<div class="modal-dialog">
			<div class="modal-content">
				
				@include( 'transactions.panels.show' )

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php $date = $transaction->date; ?>