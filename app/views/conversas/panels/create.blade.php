<div class="modal fade" id="conversas_create">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url' => 'conversas')) }}
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title title">Registrar conversa</h4>
                </div>
                <div class="modal-body">
                    <p class="form-control-static">
                        <textarea name="resumo" id="" cols="30" rows="10" class="form-control focus " required></textarea>
                    </p>
                </div>
                <div id="conversa_add_next" class="collapse colapsed in bg-info modal-body">
                    <div class="form-control-static form-control-inline">
                        <label for="date" class="control-label">Agendar próxima tarefa:</label>
                        <input type="date" class="form-control" id="date" name="tarefa" value="" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#conversa_add_next" aria-expanded="true" aria-controls="conversa_add_next">
                        <i class="icon-alarm"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                </div>
                {{ Form::hidden('cliente_id', $cliente->id) }}
            {{ Form::close() }}
        </div>
    </div>
</div>