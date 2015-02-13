<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title title"><i class="icon-bell-o"></i> Criar notificação</h4>
			</div>
			{{ Form::open(array('url' => 'notifications', 'class'=>"form-horizontal" )) }}
				<div class="modal-body">

					<p>
					
							<div class="form-group">
								<label for="class" class="col-sm-2 control-label">Tipo</label>
								<div class="col-sm-10">
									
									<div class="btn-group" data-toggle="buttons" id="notification_class">
										<label class="btn btn-danger">
											<input type="radio" name="class" id="" value="danger" autocomplete="off"><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-warning">
											<input type="radio" name="class" id="" value="warning" autocomplete="off"><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-primary active">
											<input type="radio" name="class" id="" value="info" autocomplete="off" checked><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-default">
											<input type="radio" name="class" id="" value="default" autocomplete="off"><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-success">
											<input type="radio" name="class" id="" value="success" autocomplete="off"><i class="fa fa-check"></i>
										</label>
									</div>

								</div>
							</div>
							<div class="form-group">
								<label for="date" class="col-sm-2 control-label">Data</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}">
								</div>
							</div>
							<div class="form-group">
								<label for="title" class="col-sm-2 control-label">Título</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title">
								</div>
							</div>
							<div class="form-group">
								<label for="message" class="col-sm-2 control-label">Texto</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" id="message" name="message"></textarea>									
								</div>
							</div>						
							

					</p>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>


				{{Form::hidden('tarefa_id', @$tarefa->id)}}

			{{Form::close()}}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->