{{ Form::open(array('url' => 'financeiro/' . $transaction->id, 'class' => '')) }}
	
	<div class="panel-body bg-danger">
				
		<button type="button" class="close" data-toggle="collapse" data-target="#transaction_delete_only" aria-expanded="false" aria-controls="transaction_delete_only">&times;</button>

		<div class="form-horizontal">
			<div class="form-group">							
				<div class="col-sm-10 col-sm-offset-2">								
					<strong class="radio"><i class="fa fa-warning"></i> Existem {{ $transaction->getRecurringTransactions->count() - 1 }} lançamentos recorrentes!</strong>
				</div>
			</div>
			
			<div class="form-group">							
				<div class="col-sm-10 col-sm-offset-2">
					<div class="radio">
						<label>
							<input type="radio" name="apply_changes_to" value="this" checked="checked">
							Excluir somente este lançamento
						</label>
					</div>
				</div>
			
			<?php 			
				if( ($transaction->getRecurringTransactions->count() - $transaction->recurring_cycle) >= 1 ){
			?>							
											
					<div class="col-sm-10 col-sm-offset-2">
						<div class="radio">
							<label>
								<input type="radio" name="apply_changes_to" value="next">
								Excluir este e os próximos <strong>{{ $transaction->getRecurringTransactions->count() - $transaction->recurring_cycle }}</strong> lançamentos recorrentes
							</label>
						</div>
					</div>
				
			<?php } ?>
			
				<div class="col-sm-10 col-sm-offset-2">
					<div class="radio">
						<label>
							<input type="radio" name="apply_changes_to" value="all">
							Excluir <strong>todos</strong>
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<a href="#" class="btn btn-default" data-dismiss="modal" data-target="#transaction_modal" aria-expanded="false" aria-controls="transaction_modal">
						Cancela
					</a>					
		            <button type="submit" class="btn btn-danger" role="menuitem">
		                <i class="icon-trash"></i> Excluir
		            </button>
				</div>
			</div>

			
	        

		</div>
		
	</div>

	<input type="hidden" name="_method" value="DELETE">

{{ Form::close()}} 