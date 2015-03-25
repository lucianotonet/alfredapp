<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="icon-outbox"></i> EDITAR LANÇAMENTO</h3>
	</div>
  	{{ Form::model( $transaction, [ 'method' => 'PATCH', 'route' =>[ 'financeiro.update', $transaction->id ] ] ) }}
		<table class="table panel-body form-horizontal">			
			<tbody>
				<tr>
					<td>
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Descrição:</label>
							<div class="col-sm-9">
								<input type="text" name="description" id="input" class="form-control text-uppercase" value="{{ $transaction->description }}" required="required" title="">
							</div>
						</div>
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Valor:</label>
							<div class="col-sm-9">								
								<div class="input-group input-group">
								  <span class="input-group-addon bg-default" id="sizing-addon1">R$</span>
								  <input type="text" class="form-control money" name="amount" placeholder="0,00" step="0,01" min="0,00" value="{{ $transaction->amount }}" aria-describedby="sizing-addon1">
								</div>
							</div>
						</div>												

						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Data:</label>
							<div class="col-sm-9">
								<input type="date" name="date" id="input" class="form-control" value="{{ $transaction->date }}" required="required" title="">
							</div>
						</div>

						<div class="form-group has-feedback">
							<label for="input" class="col-sm-3 control-label">Categoria:</label>
							<div class="col-sm-9">									
								<input type="text" name="category" id="input" class="form-control autocomplete" value="{{ $transaction->category }}" title="">
								<span class="form-control-feedback hidden text-muted" aria-hidden="true">
									<i class="icon-spinner13 fa-spin form-control-static"></i>
								</span>  								
							</div>
						</div>


						

							<div class="form-group">
								<label for="recurring_type" class="col-sm-3 control-label">Repetir:</label>
								<div class="col-sm-9 col-md-9 col-lg-9 form-inline">
		
									<div class="input-group">
										
										<?php $recurring_type = $transaction->recurring_type; ?>										
										<select name="recurring_type" class="form-control recurring_type" <?php echo ($transaction->getRecurringTransactions->count() > 1 ) ? 'disabled' : '' ?>>
											<option <?php echo ( $recurring_type == "never" ) ? "selected" : "" ?> value="never">Nunca</option>
											<option <?php echo ( $recurring_type == "daily" ) ? "selected" : "" ?> value="daily">Diariamente</option>
											<option <?php echo ( $recurring_type == "weekly" ) ? "selected" : "" ?> value="weekly">Semanalmente</option>
											<option <?php echo ( $recurring_type == "biweekly" ) ? "selected" : "" ?> value="biweekly">Quinzenalmente</option>
											<option <?php echo ( $recurring_type == "monthly" ) ? "selected" : "" ?> value="monthly">Mensalmente</option>
											<option <?php echo ( $recurring_type == "bimonthly" ) ? "selected" : "" ?> value="bimonthly">Bimestralmente</option>
											<option <?php echo ( $recurring_type == "trimonthly" ) ? "selected" : "" ?> value="trimonthly">Trimestralmente</option>
											<option <?php echo ( $recurring_type == "sixmonthly" ) ? "selected" : "" ?> value="sixmonthly">Semestralmente</option>
											<option <?php echo ( $recurring_type == "yearly" ) ? "selected" : "" ?> value="yearly">Anualmente</option>
										</select>	
									  	
									  	<span class="input-group-addon bg-primary <?php echo ( $recurring_type == "never" || empty( $recurring_type ) ) ? "hidden" : "" ?> recurring_times"> até </span>								    

										<select name="recurring_times" class="<?php echo ( $recurring_type == "never" || empty( $recurring_type ) ) ? "hidden" : "" ?> recurring_times form-control" <?php echo ($transaction->getRecurringTransactions->count() > 1 ) ? 'disabled' : '' ?>>											
											<option value="1" <?php echo ($transaction->getRecurringTransactions->count() <= 1)?'selected':''; ?>>1x</option>
											@for ($i = 2; $i <= 360; $i++)
												<option value="{{$i}}" <?php echo ($transaction->getRecurringTransactions->count() == $i)?'selected':''; ?> >{{$i}}x</option>
											@endfor
										</select>
									
									</div>
									
									<?php if($transaction->getRecurringTransactions->count() > 1 ){ ?>
										<p class="lead pull-right">
											<a class="" data-toggle="collapse" href="#transaction_recurring" aria-expanded="false" aria-controls="transaction_recurring">
												<i class="icon-circle-plus"></i>
											</a>
										</p>
									<?php } ?>

								</div>						
							</div>
						
						
					</td>
					<td width="120">
						<div class="btn-toggle" data-toggle="buttons">
				            <label class="btn btn-block btn-success panel-body <?php echo ( $transaction->done == 1 ) ? "" : "active" ?> " for="option1">
				                <input type="radio" name="done" id="option1" value="0" autocomplete="off" <?php echo ( $transaction->done == 1 ) ? "" : "checked" ?> >
				                <i class="fa fa-thumbs-o-up fa-2x"></i>
				                <br>
				                PAGO
				            </label>
				            <label class="btn btn-block btn-danger panel-body <?php echo ( $transaction->done != 1 ) ? "" : "active" ?> " for="option2">
				                <input type="radio" name="done" id="option2" value="1" autocomplete="off" <?php echo ( $transaction->done != 1 ) ? "" : "checked" ?> >
				                <i class="fa fa-thumbs-o-down fa-2x"></i>
				                <br>
				                NÃO PAGO
				            </label>          
				        </div>
        			</td>
				</tr>
			</tbody>
		</table>

		@if( $transaction->getRecurringTransactions->count() > 1 )
			<div class="panel-body bg-warning">

				<div class="form-horizontal">
					<div class="form-group">
						<label for="input" class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<p class="form-control-static">
								<strong>Aplicar estas alterações à:</strong>
							</p>
							<div class="radio">
								<label>
									<input type="radio" name="apply_changes_to" value="this" checked="checked">
									Somente este lançamento
								</label>
							</div>

							<?php 
								if( ($transaction->getRecurringTransactions->count() - $transaction->recurring_cycle) >= 1 ){
							?>
								<div class="radio">
									<label>
										<input type="radio" name="apply_changes_to" value="next">
										Este e os próximos <strong>{{ $transaction->getRecurringTransactions->count() - $transaction->recurring_cycle }}</strong> lançamentos
									</label>
								</div>
							<?php } ?>
							
							<?php
								$transactions_unpaid = $transaction->getRecurringTransactions->filter(function($transaction){
									if( $transaction->done != 1 ){
										return $transaction;
									}
								});
								if( $transactions_unpaid->count() ){ ?>
									<div class="radio">
										<label>
											<input type="radio" name="apply_changes_to" value="unpaid">
											Todos os <strong>{{ count($transactions_unpaid) }}</strong> lançamentos <strong>não efetivados</strong>
										</label>
									</div>

							<?php } ?>

							<div class="radio">
								<label>
									<input type="radio" name="apply_changes_to" value="all">
									Todos os lançamentos <small>(incluíndo já efetivados)</small>
								</label>
							</div>		
						</div>
					</div>
				</div>			
			</div>
		@endif

		<div class="panel-footer navbar-inverse">	
						
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">					
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
				</div>				
				<div class="btn-group" role="group">					
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
				</div>
			</div>
			
		</div>	
		{{ Form::hidden('type', 'despesa') }}
	{{ Form::close() }}
</div>			







<script>
	jQuery(document).ready(function($) {

		// DATE
		$('input[type="date"]').datepicker({
	        format: "yyyy-mm-dd",
	        language: "pt-BR",
	        orientation: "top right",
	        autoclose: true,
	        todayHighlight: true
	    });

		// MASK MONEY
	    $('.money').priceFormat({        
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.',
	        allowNegative: false
	    });

        // RECURRING
	    $('#transactions_modal .recurring_type').change(function(event) {
	        if( $(this).val() == 'never' ){
	            $('#transactions_modal .recurring_times').addClass('hidden');
	        }else{
	            $('#transactions_modal .recurring_times').removeClass('hidden');
	        }
	    });
	    $('.isRecurring').click( function(event) {              
	        $('select.recurring_type').toggleClass('hidden');
	        /* Act on the event */
	    });

	    // AUTOCOMPLETE
	    $('input.autocomplete').autocomplete({            
            serviceUrl: "/categories",            
            params: {'owner_type':'transaction'},
            onSelect: function (suggestion) {
                $(this).val( suggestion.value );
            },
            onSearchStart: function (query) {
            	$(this).next('.form-control-feedback').removeClass('hidden');
            },
            onSearchComplete: function (query, suggestions) {
            	$(this).next('.form-control-feedback').addClass('hidden')
            }
        });

	});
</script>