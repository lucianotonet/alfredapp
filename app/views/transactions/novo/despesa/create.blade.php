<div class="panel panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="icon-outbox"></i> REGISTRAR DESPESA</h3>
	</div>
  	{{ Form::open(array('route' => 'financeiro.store', 'method' => 'POST', "class"=>"", "role"=>"form", "id"=>"transaction_create" )) }}
		<table class="table panel-body form-horizontal">			
			<tbody>
				<tr>
					<td>
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Descrição:</label>
							<div class="col-sm-9">
								<input type="text" name="description" id="input" class="form-control text-uppercase" value="" required="required" title="">
							</div>
						</div>
						<div class="form-group">
							<label for="input" class="col-sm-3 control-label">Valor:</label>
							<div class="col-sm-9">								
								<div class="input-group input-group">
								  <span class="input-group-addon bg-default" id="sizing-addon1">R$</span>
								  <input type="text" class="form-control money" name="amount" placeholder="0,00" step="0,01" min="0,00" aria-describedby="sizing-addon1">
								</div>
							</div>
						</div>						
						<div class="collapse" id="transaction_moreinfo">

							<div class="form-group">
								<label for="input" class="col-sm-3 control-label">Data:</label>
								<div class="col-sm-9">
									<input type="date" name="date" id="input" class="form-control" value="{{date('Y-m-d')}}" required="required" title="">
								</div>
							</div>

							<div class="form-group has-feedback">
								<label for="input" class="col-sm-3 control-label">Categoria:</label>
								<div class="col-sm-9">
									<input type="text" name="category" id="input" class="form-control autocomplete" value="" title="">
									<span class="form-control-feedback hidden text-muted" aria-hidden="true">
										<i class="icon-spinner13 fa-spin form-control-static"></i>
									</span>  								
								</div>
							</div>

							<div class="form-group active">
								<label for="recurring_type" class="col-sm-3 control-label">Repetir:</label>
								<div class="col-sm-9 col-md-9 col-lg-9 form-inline">
		
									<div class="input-group">
										<select name="recurring_type" class="form-control recurring_type" required="required">
											<option value="never" selected>Nunca</option>
											<option value="daily">Diariamente</option>
											<option value="weekly">Semanalmente</option>
											<option value="biweekly">Quinzenalmente</option>
											<option value="monthly">Mensalmente</option>
											<option value="bimonthly">Bimestralmente</option>
											<option value="trimonthly">Trimestralmente</option>
											<option value="sixmonthly">Semestralmente</option>
											<option value="yearly">Anualmente</option>
										</select>	
									  	
									  	<span class="input-group-addon bg-primary hidden recurring_times"> até </span>								    

										<select name="recurring_times" class="hidden recurring_times form-control">
											{{-- <option value="0">Sem parar</option>						 --}}
											<option value="1" selected>1x</option>
											@for ($i = 2; $i <= 361; $i++)
												<option value="{{$i}}">{{$i}}x</option>
											@endfor
										</select>	
									</div>
												
								</div>						
							</div>

						</div>


						<div class="text-right">
							<a clas="btn-sm" data-toggle="collapse" href="#transaction_moreinfo" aria-expanded="false" aria-controls="transaction_moreinfo">
							    <i class="fa fa-plus-circle"></i> Mais detalhes
							</a>
						</div>

						
					</td>
					<td width="120">
						<div class="btn-toggle" data-toggle="buttons">
				            <label class="btn btn-block btn-success panel-body active" for="option1">
				                <input type="radio" name="done" id="option1" value="0" autocomplete="off" checked>
				                <i class="fa fa-thumbs-o-up fa-2x"></i>
				                <br>
				                PAGO
				            </label>
				            <label class="btn btn-block btn-danger panel-body" for="option2">
				                <input type="radio" name="done" id="option2" value="1" autocomplete="off">
				                <i class="fa fa-thumbs-o-down fa-2x"></i>
				                <br>
				                NÃO PAGO
				            </label>          
				        </div>
        			</td>
				</tr>
			</tbody>
		</table>

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
	    $('#transaction_create .recurring_type').change(function(event) {
	        if( $(this).val() == 'never' ){
	            $('#transaction_create .recurring_times').addClass('hidden');
	        }else{
	            $('#transaction_create .recurring_times').removeClass('hidden');
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