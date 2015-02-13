<ul class="nav nav-tabs nav-justified">
	<li class="active">
		<a href="#hoje" data-toggle="tab">
			<h3 class="title">HOJE <span class="badge badge-success">{{count($tarefas->hoje)}}</span></h3>
		</a>
	</li>
	<li>
		<a href="#pendentes" data-toggle="tab">
			<h3 class="title <?php if( count($tarefas->pendentes) ){ echo 'danger'; } ?>">Atrasadas <span class="badge badge-danger">{{count($tarefas->pendentes)}}</span></h3>
		</a>
	</li>			
	<li>
		<a href="#proximas" data-toggle="tab">
			<h3 class="title">Próximas <span class="badge badge-success">{{count($tarefas->proximas)}}</span></h3>
		</a>
	</li>
	<li>
		<a href="#concluidas" data-toggle="tab">
			<h3 class="title">Concluídas <span class="badge badge-primary">{{count($tarefas->concluidas)}}</span></h3>
		</a>
	</li>
</ul>

<div class="tab-content well well-sm">
	<div class="tab-pane fade active in row" id="hoje">
		
		@foreach ($tarefas->hoje as $tarefa)
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				@include('tarefas.panels.item')						
			</div>
		@endforeach	
	
	</div>
	<div class="tab-pane fade row" id="pendentes">
		@foreach ($tarefas->pendentes as $tarefa)
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				@include('tarefas.panels.item')						
			</div>
		@endforeach
	</div>
	<div class="tab-pane fade row" id="proximas">
		@foreach ($tarefas->proximas as $tarefa)
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				@include('tarefas.panels.item')						
			</div>
		@endforeach
	</div>
	<div class="tab-pane fade row" id="concluidas">
		@foreach ($tarefas->concluidas as $tarefa)
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				@include('tarefas.panels.item')						
			</div>
		@endforeach
	</div>
</div>