<?php use Carbon\Carbon as Carbon; ?>
{{ Form::model( $transaction, [ 'method' => 'PATCH', 'route' =>[ 'financeiro.update', $transaction->id ], 'class'=>'collapse colapsed in', 'id'=>"transaction_show" ] ) }}
	   		
	<div class="panel panel-primary">
		
		<div class="panel-heading">	
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="panel-title">DETALHAMENTO DA DESPESA</h3>
		</div>

		@if ( $transaction->isOverdue() )
			<div class="list-group-item alert-danger text-center">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong><i class="fa fa-warning"></i></strong> Lançamento vencido <strong class="timeago" title="{{ $transaction->date }}">{{ $transaction->date }}</strong>
			</div>	
		@endif


		<div class="panel-body">

			<div class="row">
				<div class="col-sm-9 form-horizontal">
						
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Descrição:</label>
							<div class="col-sm-9">
								<?php if($transaction->getRecurringTransactions->count() > 1 ){ ?>
									<div class="input-group">
										<input type="text" name="" id="input" class="form-control text-uppercase" value="{{ $transaction->description }}" required="required" title="" readonly="readonly">
									  	<span class="input-group-addon bg-default" id="sizing-addon1">
									  		{{ $transaction->recurring_cycle }} de {{ $transaction->getRecurringTransactions->count() }}
									  	</span>
									</div>								
								<?php } else { ?>
									<input type="text" name="" id="input" class="form-control text-uppercase" value="{{ $transaction->description }}" required="required" title="" readonly="readonly">
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Valor:</label>
							<div class="col-sm-9">								
								<div class="input-group input-group">
								  <span class="input-group-addon bg-default" id="sizing-addon1">R$</span>
								  <input type="text" class="form-control" name="" value="{{ number_format( ($transaction->amount), '2', ',', '.' ) }}" aria-describedby="sizing-addon1" readonly="readonly"> 
								</div>
							</div>
						</div>						
						
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Data:</label>
							<div class="col-sm-9">
								<input type="date" name="" id="input" class="form-control" value="{{ $transaction->date }}" required="required" title="{{ (new Carbon( $transaction->date ) )->formatLocalized('%A, %d de %B de %Y') }}" readonly="readonly">
							</div>
						</div>

						<div class="form-group has-feedback">
							<label for="input" class="col-sm-3 control-label">Categoria:</label>
							<div class="col-sm-9">									
								<input type="text" name="" id="input" class="form-control autocomplete" value="{{ $transaction->category }}" title="" readonly="readonly">
								<span class="form-control-feedback hidden text-muted" aria-hidden="true">
									<i class="icon-spinner13 fa-spin form-control-static"></i>
								</span>  								
							</div>
						</div>

						<div class="form-group">
							<label for="recurring_type" class="col-sm-3 control-label">Recorrência:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 form-inline">
	
								<div class="input-group">
									
									<?php $recurring_type = $transaction->recurring_type; ?>										
									<select name="" class="form-control recurring_type" required="required" readonly="readonly" disabled>
										<option <?php echo ( $recurring_type == "never" ) ? "selected" : "" ?> value="never">Não</option>
										<option <?php echo ( $recurring_type == "daily" ) ? "selected" : "" ?> value="daily">Diário</option>
										<option <?php echo ( $recurring_type == "weekly" ) ? "selected" : "" ?> value="weekly">Semanal</option>
										<option <?php echo ( $recurring_type == "biweekly" ) ? "selected" : "" ?> value="biweekly">Quinzenal</option>
										<option <?php echo ( $recurring_type == "monthly" ) ? "selected" : "" ?> value="monthly">Mensal</option>
										<option <?php echo ( $recurring_type == "bimonthly" ) ? "selected" : "" ?> value="bimonthly">Bimestral</option>
										<option <?php echo ( $recurring_type == "trimonthly" ) ? "selected" : "" ?> value="trimonthly">Trimestral</option>
										<option <?php echo ( $recurring_type == "sixmonthly" ) ? "selected" : "" ?> value="sixmonthly">Semestral</option>
										<option <?php echo ( $recurring_type == "yearly" ) ? "selected" : "" ?> value="yearly">Anual</option>
									</select>	
								  	
								  	<span class="input-group-addon bg-primary <?php echo ( $recurring_type == "never" || empty( $recurring_type ) ) ? "hidden" : "" ?> recurring_times"> até </span>								    

									<select name="" class="<?php echo ( $recurring_type == "never" || empty( $recurring_type ) ) ? "hidden" : "" ?> recurring_times form-control" readonly="readonly" disabled>
										{{-- <option value="0">Sem parar</option>						 --}}
										<option value="1" <?php echo ($transaction->getRecurringTransactions->count() <= 1)?'selected':''; ?>>1x</option>
										@for ($i = 2; $i <= 360; $i++)
											<option value="{{$i}}" <?php echo ($transaction->getRecurringTransactions->count() == $i)?'selected':''; ?> >{{$i}}x</option>
										@endfor
									</select>

								
								</div>
										
								<p class="lead pull-right">
									<a class="" data-toggle="collapse" href="#transaction_recurring" aria-expanded="false" aria-controls="transaction_recurring">
										<i class="icon-circle-plus"></i>
									</a>
								</p>

							</div>						

						</div>
					
				</div>
				<div class="col-sm-3">
					<div class="btn-toggle" data-toggle="buttons">
			            <label class="btn btn-block btn-sm btn-success panel-body <?php echo ( $transaction->done == 1 ) ? "" : "active" ?> " for="option1">
			                <input type="radio" name="done" id="option1" value="0" autocomplete="off" <?php echo ( $transaction->done == 1 ) ? "" : "checked" ?> >
			                <i class="fa fa-thumbs-o-up fa-2x"></i>
			                <br>
			                PAGO
			            </label>
			            <label class="btn btn-block btn-sm btn-danger panel-body <?php echo ( $transaction->done != 1 ) ? "" : "active" ?> " for="option2">
			                <input type="radio" name="done" id="option2" value="1" autocomplete="off" <?php echo ( $transaction->done != 1 ) ? "" : "checked" ?> >
			                <i class="fa fa-thumbs-o-down fa-2x"></i>
			                <br>
			                NÃO PAGO
			            </label>          
			        </div>
				</div>
			</div>
			
		</div>



		<div class="collapse" id="transaction_recurring">
										
			<table class="table table-hover">
				<tbody>


					<?php $recurring_transactions 	= $transaction->getRecurringTransactions; ?>
					<?php 
						// $recurring_transactions 	= $master_transaction->getRecurringTransactions->filter(function($transaction)use($master_transaction){
						// 	if( $transaction->recurring_transaction_id == $master_transaction->id ){
						// 		return $transaction;
						// 	}
						// }); 
					?>
					
					@foreach ( $recurring_transactions as $recurring_transaction )

						<?php if( $recurring_transaction->id == $transaction->id ){ $recurring_transaction->current = true; } ?>

						@include('transactions.novo.despesa.list-item', array('transaction' => $recurring_transaction))

					@endforeach

	 				
					<tr>
						<td width="20">
					        
					    </td>
					    <td>                                                                                                                       
					        
					    </td>
					    <td align="right">
					       <small>TOTAL</small><span class="text-danger lead"> R$ {{ number_format( $transaction->getRecurringTransactions->sum('amount'), '2', ',', '.') }} </span>
					       <br>

							<div class="collapse" id="transaction_status">
								<dl class="">
									<dt>Valor pago </dt>
									<small class="text-danger">R$ {{ number_format( $transaction->getRecurringTransactions->filter(function($t){ if($t->done == 1){ return $t; } })->sum('amount'), '2', ',', '.') }} </small>
								<br>
									<dt>Valor restante </dt>
									<small class="text-danger">R$ {{ number_format( $transaction->getRecurringTransactions->filter(function($t){ if($t->done != 1){ return $t; } })->sum('amount'), '2', ',', '.') }} </small>
								</dl>
							</div>

					    </td>
					    <td width="30" class="text-center lead">     
					    	<a class="" data-toggle="collapse" href="#transaction_status" aria-expanded="false" aria-controls="transaction_status">	<i class="icon-circle-plus"></i>
					    	</a>
					    </td>
					</tr>
	 			</tbody>
	 		</table>
				
		</div>



	

		<div class="panel-footer">
			<div class="btn-group btn-group-justified btn-block">
				<a class="btn btn-default" data-dismiss="modal">
					<i class="fa fa-times"></i> Fechar
				</a>
				<a href="{{url('financeiro/'.$transaction->id.'/delete')}}" class="btn btn-danger" data-toggle="" data-target="#transactions_modal">
			 		<i class="icon-trash"></i> Excluir
				</a>
			
				<a href="{{ url( 'financeiro/'.$transaction->id.'/edit' ) }}" class="btn btn-primary" data-toggle="" data-target="#transactions_modal">
					<i class="icon-edit"></i> Editar
	            </a>						
				<div class="btn-group">
					<button type="submit" class="btn btn-success"> <i class="icon-check"></i> Salvar</button>						
				</div>									
			</div>
		</div>
		
			
	</div>

	{{ Form::hidden('apply_changes_to', 'this') }}
	{{ Form::hidden('type', $transaction->type) }}
	{{ Form::hidden('date', $transaction->date) }}
	{{ Form::hidden('amount', $transaction->amount) }}
	{{ Form::hidden('description', $transaction->description) }}	

{{ Form::close() }}	

	

<script>
	jQuery(document).ready(function($) {

		// Time ago
	    jQuery.timeago.settings.strings = {
	       prefixAgo: "",
	       prefixFromNow: "em",
	       suffixAgo: null,
	       suffixFromNow: "b",
	       seconds: "alguns segundos",
	       minute: "há um minuto",
	       minutes: "há %d minutos",
	       hour: "há uma hora",
	       hours: "à %d horas atrás",
	       day: "ontem",
	       days: "há %d dias",
	       month: "mês passado",
	       months: "há %d meses",
	       year: "ano passado",
	       years: "há %d anos"
	    };
	    $('.timeago').timeago();



	    // Modal
	    $.each( $("#transactions_modal [data-target=#transactions_modal]"), function(index, val) {
	    	$(this).removeAttr('data-toggle');
	    });
	    
		$("#transactions_modal [data-target=#transactions_modal]").click(function(ev) {
			// alert();
		    ev.preventDefault();
			$("#transactions_modal .modal-content").html( $('.loading-splash').html() );

		    var target = $(this).attr("href");
		    $("#transactions_modal .modal-content").load(target, function() { 
			  	$("#transactions_modal").modal("show"); 
			})
		});

	   

	 	


	 // 	$('[data-toggle="tab"]').click(function(e) {
		//     var $this = $(this),
		//         loadurl = $this.attr('href'),		        
		//         targ = $this.attr('data-target');

		//     // $.get(loadurl, function(data) {
		//     //     $(targ).children().html(data);

		//     // });

		//     $.ajax({
		//     	url: loadurl,		    	
		//     	dataType: 'html',		    	
		//     })
		//     .done(function(data) {
		//     	$(targ).html(data);
		//     	$this.tab('show');
		//     })
		//     .fail(function() {
		//     	$this.tab('hide');
		//     });
		    
		//     return false;
		// });

	});	
</script>