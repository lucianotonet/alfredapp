<?php if ( $transaction->type == 'despesa'): ?>

{{ Form::model($transaction, [ 'method' => 'PATCH', 'route' =>[ 'financeiro.update', $transaction->id ] ] ) }}
	   		
	<div class="panel panel-primary">
		
		<div class="panel-heading">
			<h3 class="panel-title title">DETALHAMENTO DA DESPESA</h3>
		</div>

		<div class="panel-body  balance_status">

				<!-- DESPESA -->			
				<div class="row">
					<div class="col-xs-7 col-sm-6 col-md-6 col-lg-6 text-center">
						<h1 class="text-center text-danger font open_sanscondensed_light">R$ {{ FazMeRir::bonito( $transaction->amount ) }}</h1>	
										
					</div>
					<div class="col-xs-5 col-sm-6 col-md-6 col-lg-6">

						<dl>
						  <dt>Descrição</dt>
						  <dd class="lead"><strong>{{ $transaction->description }}</strong></dd>
						</dl>
						<dl>
						  <dt>Data</dt>
						  <dd>{{$transaction->date}}</dd>
						</dl>
						<!-- <dl>
						  <dt>Parcela</dt>
						  <dd>2 de 3</dd>
						</dl> -->							

					</div>
				</div>			
				
		</div>				

 
		<div class="panel-footer">

			<div class="transaction_done btn-group btn-group-justified" data-toggle="buttons">
				<label class="btn btn-lg btn-default <?php if( $transaction->done == 1 ){ echo "active"; }else{ echo ""; } ?>">				
					<span class="">
						<i class="icon-check"></i> Pago
					</span>
	                <input type="checkbox" name="done" autocomplete="off" <?php if( $transaction->done == 1 ){ echo "checked"; } ?> >
					<span class="">
						<i class="icon-caution"></i> Não pago
					</span>
				</label>
			</div>

			&nbsp;

			<div class="btn-group btn-group-justified btn-block">
				<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</a>		
				<a href="{{url('financeiro/'.$transaction->id.'/delete')}}" class="btn btn-danger" onclick="confirm('Deseja mesmo excluir o lançamento?')">	<i class="icon-trash"></i> Excluir</a>
				<a class="btn btn-primary" data-toggle="modal" data-target='#modal' href="{{url('financeiro/'.$transaction->id.'/edit#transaction_edit')}}"><i class="fa fa-edit"></i> Editar</a>		
				<div class="btn-group">
					<button type="submit" class="btn btn-success"> <i class="icon-check"></i> Salvar</button>						
				</div>									
			</div>
		</div>
			
	</div>

	{{ Form::hidden('type', $transaction->type) }}
	{{ Form::hidden('date', $transaction->date) }}
	{{ Form::hidden('description', $transaction->description) }}	

{{ Form::close() }}									
		
<?php else: ?>
	
		

{{ Form::model($transaction, [ 'method' => 'PATCH', 'route' =>[ 'financeiro.update', $transaction->id ] ] ) }}
	   		
	<div class="panel panel-primary">
		
		<div class="panel-heading">
			<h3 class="panel-title title">DETALHAMENTO DA RECEITA</h3>
		</div>

				


		<div class="panel-body  balance_status">

			

				<!-- DESPESA -->			
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
						<h1 class="text-center text-success font open_sanscondensed_light">R$ {{ FazMeRir::bonito( $transaction->amount ) }}</h1>	
						
						<div class="transaction_done btn-group btn-group-justified" data-toggle="buttons">
							<label class="btn btn-lg btn-default <?php if( $transaction->done == 1 ){ echo "active"; }else{ echo ""; } ?>">				
								<span class="">
									<i class="icon-check"></i> Recebido
								</span>
				                <input type="checkbox" name="done" autocomplete="off" <?php if( $transaction->done == 1 ){ echo "checked"; } ?> >
								<span class="">
									<i class="icon-caution"></i> Pendente
								</span>
							</label>
						</div>

					
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

						<dl>
						  <dt>Descrição</dt>
						  <dd class="lead"><strong>{{ $transaction->description }}</strong></dd>
						</dl>
						<dl>
						  <dt>Data</dt>
						  <dd>{{$transaction->date}}</dd>
						</dl>
						<!-- <dl>
						  <dt>Parcela</dt>
						  <dd>2 de 3</dd>
						</dl>	 -->						

					</div>
				</div>
				
				
		</div>				

		<div class="panel-footer">
			<div class="btn-group btn-group-justified btn-block">
				<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</a>		
				<a href="{{url('financeiro/'.$transaction->id.'/delete')}}" class="btn btn-danger" onclick="confirm('Deseja mesmo excluir o lançamento?')">	<i class="icon-trash"></i> Excluir</a>
				<a class="btn btn-primary" data-toggle="modal" data-target='#modal' href="{{url('financeiro/'.$transaction->id.'/edit#transaction_edit')}}"><i class="fa fa-edit"></i> Editar</a>		
				<div class="btn-group">
					<button type="submit" class="btn btn-success"> <i class="icon-check"></i> Salvar</button>						
				</div>									
			</div>
		</div>
			
	</div>

	{{ Form::hidden('type', $transaction->type) }}
	{{ Form::hidden('date', $transaction->date) }}
	{{ Form::hidden('description', $transaction->description) }}	

{{ Form::close() }}	




<?php endif;