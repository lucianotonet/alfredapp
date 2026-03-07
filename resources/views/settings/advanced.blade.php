<form action="{{ Request::fullUrl() }}" method="POST" class="form-horizontal" role="form">
					
	<div class="page-header">
		<h3>Avançado</h3>
	</div>

	<div class="form-group">
		<label for="" class="col-sm-2 control-label">Configurações originais:</label>
		<div class="col-sm-10">
			<p class="form-control-static">
				<a href="{{ url('settings/reset') }}" class="btn btn-sm btn-danger" onclick="return confirm('Restaurar TODAS as configurações originais?')"><i class="fa fa-undo"></i> Restaurar</a>
			</p>
		</div>
	</div>
	
</form>	