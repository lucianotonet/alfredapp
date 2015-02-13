<div id="balance_edit" class="panel panel-primary">
		
	<div class="panel-heading">
		<h3 class="panel-title title">Alterar saldo</h3>			
	</div>

	{{ Form::model($balance, [ 'method' => 'PATCH', 'route' =>[ 'financeiro.balance.update', $balance->id ] ] ) }}
		
		<div class="panel-body form-horizontal">


			<div class="form-group">
				<label class="control-label col-sm-3 col-xs-1" for="">
					<h3 class="title">R$</h3>
				</label>					
				<div class="col-xs-11 col-sm-9 col-md-9 col-lg-9">	

					<input type="text" name="amount" id="inputAmount" class="form-control input-lg text-right balance_amount price" value="{{$balance->amount}}" step="0,01" min="0,00" required="required" title="">	

				</div>
			</div>

					

		</div>	

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

	{{ Form::close() }}
</div>

<script>
	jQuery(document).ready(function($) {
		$("input.price").priceFormat({        
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            allowNegative: false
        });
	});		
</script>