<li class="list-group-item">

	<?php 
        // BUG FiX
        //   Resolve problema de múltiplas instâncias com ID iguais
        $rand = rand();
    ?>


	<div class="pull-right">
		{{ Form::open(array('url' => 'conversas/' . $conversa->id, 'class' => 'btn-group')) }}
		    {{ Form::button('<i class="icon-cross"></i>', array('class' => 'close', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Excluir esta conversa permanentemente?")')) }}
		    {{ Form::hidden('_method', 'DELETE') }}
			<button type="button" class="close" data-toggle="modal" href='#conversa_edit_{{$conversa->id}}_{{$rand}}'><i class="icon-edit"></i></button>
		{{ Form::close() }} 		
	</div>
	
	
	<div class="modal fade" id="conversa_edit_{{$conversa->id}}_{{$rand}}">
		<div class="modal-dialog">
			<div class="modal-content">
				{{ Form::model($conversa, [ 'method' => 'PATCH', 'route' =>[ 'conversas.update', $conversa->id ] ] ) }}   
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title title">Editar conversa nº {{$conversa->id}}</h4>
				</div>
				<div class="modal-body">
					<p class="form-control-static">
                        <textarea name="resumo" id="" cols="30" rows="10" class="form-control">{{$conversa->resumo}}</textarea>
                    </p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
	
	<p>
		{{$conversa->resumo}}
	</p>
	<span class="label label-info">		
		{{ date('d \d\e F, H:i', strtotime($conversa->created_at) );  }}
	</span>
	<span class="blank"></span>

	<?php if($conversa->relatorio_id < 1){ ?>
		<span class="label label-danger">		
			Não enviada
		</span>
	<?php } ?>

</li>