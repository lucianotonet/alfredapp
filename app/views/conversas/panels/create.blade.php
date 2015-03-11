<div class="modal fade" id="conversas_create">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url' => 'conversas','class'=>'form-horizontal')) }}
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title title">Registrar conversa</h4>
                </div>
                <div class="modal-body">
                    <p class="form-control-static">
                        <textarea name="resumo" id="" cols="30" rows="10" class="form-control focus " required></textarea>
                    </p>
                </div>                
                <div id="add_tarefa" class="collapse colapsed in modal-body form-horizontal">
                    <p class="form-control-static">
                        <strong class="control-label">Agendar próximo contato:</strong>
                    </p>

                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label text-right">Descrição</label>     
                        <div class="col-sm-9">
                            <textarea class="form-control" id="title" name="tarefa_title"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo" class="col-sm-3 control-label text-right">Tipo</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="tarefa_tipo" id="tipo">
                                <option value="1">Ligação</option>
                                <option value="2">Visita</option>
                                <option value="3">Compromisso</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-sm-3 control-label">Prazo</label>
                        <div class="col-sm-9">
                            <input type="date" class="datepicker form-control" id="start" name="tarefa_date" value="{{date('Y-m-d')}}">
                        </div>
                    </div>                    
                </div>
                <!-- <div id="add_tarefa" class="collapse colapsed in bg-info modal-body">
                    <div class="form-control-static form-control-inline">
                        <input type="date" class="datepicker form-control" id="date" name="tarefa" value="" >
                    </div>
                </div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary pull-left" data-toggle="collapse" data-target="#add_tarefa" aria-expanded="true" aria-controls="add_tarefa">
                        <i class="fa fa-plus"></i> Próxima tarefa
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                </div>
                {{ Form::hidden('cliente_id', $cliente->id) }}
            {{ Form::close() }}
        </div>
    </div>
</div>