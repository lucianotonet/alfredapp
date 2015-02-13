<div class="panel panel-primary" id="panel-id">
	
		
			<div class="panel-heading">
				<button type="button" class="close" data-dismiss="panel" aria-hidden="true">&times;</button>
				<h4 class="panel-title title"><i class="icon-bell-o"></i> Editar notificação {{$notification->id}}</h4>
			</div>
			
			{{ Form::model($notification, [ 'method' => 'PATCH', 'route' =>[ 'notifications.update', $notification->id ], 'class' => 'form-horizontal' ] ) }}   
				
				<div class="panel-body">

					<p>
					
							<div class="form-group">
								<label for="class" class="col-sm-2 control-label">Tipo</label>
								<div class="col-sm-10">
									
									<div class="btn-group" data-toggle="buttons" id="notification_class">
										<label class="btn btn-danger <?php echo ( 'danger' == $notification->class ) ? 'active' : ''; ?>">
											<input type="radio" name="class" id="" value="danger" autocomplete="off" <?php echo ( 'info' == $notification->class ) ? 'danger' : ''; ?>><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-warning <?php echo ( 'warning' == $notification->class ) ? 'active' : ''; ?>">
											<input type="radio" name="class" id="" value="warning" autocomplete="off" <?php echo ( 'info' == $notification->class ) ? 'warning' : ''; ?>><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-primary <?php echo ( 'info' == $notification->class ) ? 'active' : ''; ?>">
											<input type="radio" name="class" id="" value="info" autocomplete="off" <?php echo ( 'info' == $notification->class ) ? 'warning' : ''; ?>><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-default <?php echo ( 'default' == $notification->class ) ? 'active' : ''; ?>">
											<input type="radio" name="class" id="" value="default" autocomplete="off" <?php echo ( 'info' == $notification->class ) ? 'default' : ''; ?>><i class="fa fa-check"></i>
										</label>
										<label class="btn btn-success <?php echo ( 'success' == $notification->class ) ? 'active' : ''; ?>">
											<input type="radio" name="class" id="" value="success" autocomplete="off" <?php echo ( 'info' == $notification->class ) ? 'success' : ''; ?>><i class="fa fa-check"></i>
										</label>
									</div>

									<style type="text/css">
										#notification_class .btn i{
											transition: 0.5s;
											opacity: 0.1;
											filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=10);
											-ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=10)';									
										}
										#notification_class .btn.active i{
											transition: 0.1s;
											opacity: 1;
											filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
											-ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=100)';									
										}
										
									</style>

								</div>
							</div>
							<div class="form-group">
								<label for="date" class="col-sm-2 control-label">Data</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d',strtotime($notification->date))}}">
								</div>
							</div>
							<div class="form-group">
								<label for="title" class="col-sm-2 control-label">Título</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title" value="{{$notification->title}}">
								</div>
							</div>
							<div class="form-group">
								<label for="message" class="col-sm-2 control-label">Texto</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" id="message" name="message">{{$notification->message}}</textarea>									
								</div>
							</div>						
							

					</p>


				</div>
				<div class="panel-footer ">
					<button type="submit" class="btn btn-success pull-right">Salvar</button>
					<a href="{{ url( URL::previous() ) }}" class="btn btn-primary">Voltar</a>
				</div>
			{{Form::close()}}
		
</div>