<?php $class = ( $transaction->type == 'despesa' ) ? 'danger' : 'success' ?>
<?php $done  = ( $transaction->done == '1' ) 	   ? 'done'   : '' ?>
		
<tbody>

	<tr class="lead transaction_type_{{$transaction->type}} <?php echo ($transaction->done == 1) ? 'active' : '' ?> text-{{ $class }}" data-toggle="modal" href='#transaction_show_{{$transaction->id}}' >
		<td width="50">
			
			@if ( $transaction->done != 1 )
																			
				<i class="fa fa-circle {{$class}}"></i>		

			@endif
		
		</td>							
		
		<td class="text-left hidden-xs transaction_done_{{$transaction->done}}">
			<span>{{ $transaction->description }}</span>
		</td>
		
		<td class="text-right  transaction_done_{{$transaction->done}}" width="200">
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
		</td>


		<td class="text-left status" width="40">
			
			@if ( $transaction->isOverdue() )
				
				<i class="fa fa-warning text-danger"></i>
				
			@elseif( $transaction->done )

				<i class="fa fa-check text-{{ $class }}"></i>

			@endif
			
		</td>

	</tr>		

				
	<div class="modal fade" id="transaction_show_{{$transaction->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				
				@include( 'transactions.panels.show' )

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


</tbody>