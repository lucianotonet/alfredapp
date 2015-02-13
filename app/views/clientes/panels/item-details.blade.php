<table class="table table-hover">        
    <tbody>
        <tr>
            <td width="60" align="center">
                <span class="pull-left cliente-avatar" style="background-color:#3bafda">
                    <img src="{{asset('img/avatar-small.png')}}" alt="" class="img-responsive">
                </span>
            </td>
            <td>
                <dl style="">
                    <dt>Nome</dt>
                    <dd><strong>{{@$cliente->nome}}</strong></dd>
                    <dt>Empresa</dt>
                    <dd>{{@$cliente->empresa}}</dd>
                    <dt>IE</dt>
                    <dd>{{@$cliente->ie}}</dd>
                    <dt>CPF/CNPJ</dt>
                    <dd>{{@$cliente->cnpj}}</dd>
                </dl>

            </td>
            <td>
                <dl style="">
                    <dt>Telefones</dt>
                    <dd><strong>{{@$cliente->telefone}} {{ (@$cliente->celular) ? "<br>".@$cliente->celular : "" }}</strong></dd>
                    <dt>Endereço</dt>
                    <dd>{{@$cliente->endereco}}</dd>
                </dl>

            </td>
        </tr>
        <tr>            
            <td colspan="3" align="center">                
                <small>{{count(@$cliente->pedidos)}} pedidos | {{count(@$cliente->conversas)}} conversas | {{count(@$cliente->tarefas)}} tarefas</small>
            </td>                
        </tr>
    </tbody>
</table>    