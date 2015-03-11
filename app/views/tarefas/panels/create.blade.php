<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="title">NOVA TAREFA</h3>
    </div>

    {{ Form::open(array('url' => 'tarefas', 'id' => 'tarefa_create', 'method' => 'post')) }}
    
        <div class="panel-body form-horizontal ">
            @if ( !empty( $cliente ) )                
                <div class="form-group">
                    <label for="tipo" class="col-sm-3 control-label">Cliente</label>
                    <div class="col-sm-9">
                        @include( 'clientes.panels.item', compact( 'cliente' ) )                
                        <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                    </div>
                </div>
            @endif
            @if ( !empty( $conversa ) )
                @include( 'conversas.panels.item', compact( 'conversa' ) )
                <input type="hidden" name="conversa_id" value="{{$conversa->id}}">                
            @endif

            <div class="form-group">
                <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                <div class="col-sm-9">
                    <select class="form-control" name="tipo" id="tipo">
                        <option value="1">Ligação</option>
                        <option value="2">Visita</option>
                        <option value="3">Compromisso</option>
                        <option value="4">Relatório</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Descrição</label>     
                <div class="col-sm-9">
                    <textarea class="form-control" id="title" name="title"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="start" class="col-sm-3 control-label">Prazo</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="start" name="start" value="{{date('Y-m-d')}}">
                </div>
            </div>
        </div>

        <div class="panel-body form-horizontal bg-info">
            <div class="form-group">
                
                <label for="status" class="col-sm-3 control-label"><i class="icon-bell pull-left"></i> Notificação</label>
                <div class="col-sm-9 form-inline">

                    <div class="">
                        <input type="number" class="form-control input-group-item" id="notification" name="notification">                
                        <label for="notification"> dias antes</label>                      
                    </div>
                </div>
            
            </div>
            <div class="form-group">
    
                <label for="notification-text" class="col-sm-3 control-label">Texto</label>     
                <div class="col-sm-9">
                    <textarea class="form-control" id="notification-text" name="notification-text"></textarea>
                </div>
                    
            </div>
            
            <div class="clearfix"></div>
        </div>        


        <div class="panel-footer">
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group-sm pull-right">

                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-check"></i> Salvar
                    </button>

                </div>
            </div>
        </div>

    {{ Form::close() }}

</div>