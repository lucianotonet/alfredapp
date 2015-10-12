<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <a href="{{url('clientes/create')}}" class="btn btn-default pull-right">
            <i class="fa fa-plus"></i> Adicionar
        </a>  
        <h3 class="panel-title">
            Clientes
        </h3>        
    </div>

    <div class="panel-body">       
        <strong>Procurar cliente</strong>            
        <form action="{{url('/clientes')}}" id="search" class="form-horizontal" role="form">
            <div class="input-group input-group-lg">
                <input class="form-control input-lg" type="text" placeholder="Digite o nome, empresa ou cidade..." name="query" autofocus>
                <span class="input-group-btn">
                    <button class="btn btn-info btn-lg" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div> 
        </form>

        <div class="list-group list-clientes"></div>

    </div>    

</div>


<div class="panel panel-primary">

    <?php 
    $states = array(
                "AC"=>"Acre",
                "AL"=>"Alagoas",
                "AM"=>"Amazonas",
                "AP"=>"Amapá",
                "BA"=>"Bahia",
                "CE"=>"Ceará",
                "DF"=>"Distrito Federal",
                "ES"=>"Espírito Santo",
                "GO"=>"Goiás",
                "MA"=>"Maranhão",
                "MT"=>"Mato Grosso",
                "MS"=>"Mato Grosso do Sul",
                "MG"=>"Minas Gerais",
                "PA"=>"Pará",
                "PB"=>"Paraíba",
                "PR"=>"Paraná",
                "PE"=>"Pernambuco",
                "PI"=>"Piauí",
                "RJ"=>"Rio de Janeiro",
                "RN"=>"Rio Grande do Norte",
                "RO"=>"Rondônia",
                "RS"=>"Rio Grande do Sul",
                "RR"=>"Roraima",
                "SC"=>"Santa Catarina",
                "SE"=>"Sergipe",
                "SP"=>"São Paulo",
                "TO"=>"Tocantins"); 
    ?>

    <table class="table table-hover">
        <thead class="bg-primary">
            <tr>
                <th>Nome</th>
                <th>Empresa</th>
                <th>Cidade</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td><a href="{{ URL::to('clientes/'.$customer->id) }}">{{ $customer->nome }}</a></td>
                    <td>{{ $customer->empresa }}</td>
                    <td>{{ $customer->cidade }} / {{ array_search( $customer->uf, $states) }}</td>
                    <td>                        
                        <div class="btn-group pull-right">
                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opções <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('emails/create?owner_type=cliente&owner_id='.$customer->id) }}" data-toggle="modal" data-target="#modal">
                                        Enviar dados por e-mail
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('pedidos/create/'.$customer->id) }}" >
                                        Adicionar novo pedido
                                    </a>        
                                </li>
                                <li>
                                    <a href="{{ url('emails/create?mail_to='.$customer->email) }}" data-toggle="modal" data-target="#modal">Enviar e-mail</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('clientes/'.$customer->id.'/edit') }}" >
                                        Editar dados do cliente
                                    </a>
                                </li>
                            </ul>
                        </div>                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{ $customers->links() }}