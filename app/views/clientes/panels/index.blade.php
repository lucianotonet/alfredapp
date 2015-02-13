<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <div class="btn-group pull-left">
            <h3 class="title">Procurar cliente</h3>            
        </div>
        <div class="btn-group pull-right">
            <a href="{{url('clientes/create')}}" class="btn btn-info btn-sm">
                <i class="fa fa-plus"></i> Adicionar
            </a>
        </div>
    </div>

    <!-- <div class="input-group input-group-lg search">
        <input class="form-control input-lg autocomplete" type="text" placeholder="Procurar..." autofocus>
        <span class="input-group-btn">
            <button class="btn btn-info btn-lg" type="button">
                <i class="fa fa-search"></i>
            </button>
        </span>
    </div> -->

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

    <div class="list-group list-clientes">



    </div>

</div>


<!-- <div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title title"><i class="icon-flame"></i> TOP 10</h3>
    </div>
    
    @foreach ($clientes->topten as $cliente)
        @include( 'clientes.panels.item' )     
    @endforeach

</div> -->