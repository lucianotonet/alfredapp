<table class="table table-hover">
    <thead>
        <tr>
            <th>Registrar lançamento</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="btn-group btn-group-justified">
                    <a href="{{ url( '/financeiro/create/?type=receita' ) }}" class="btn btn btn-success" data-toggle="modal" data-target="#transactions_modal">
                        <i class="icon-inbox"></i>                        
                        Receita
                    </a>

                    <a href="{{ url( '/financeiro/create/?type=despesa' ) }}" class="btn btn-danger" data-toggle="modal" data-target="#transactions_modal">
                        <i class="icon-outbox"></i>
                        Despesa
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
</table>