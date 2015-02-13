<div class="list-group-item customer-item bordered">    

    <a href="{{ url( 'clientes', $cliente->id ) }}">
        <span class="pull-left cliente-avatar" style="background-color:#3bafda">
            <img src="{{asset('img/avatar-small.png')}}" alt="" class="img-responsive">
        </span>
        <div class="search-data">
            <strong class="list-group-item-heading">{{$cliente->nome}}</strong><br>
            <strong>{{$cliente->empresa}}</strong><br>
            <i class="fa fa-map-marker"></i> {{$cliente->cidade}} - {{$cliente->uf}} |
            <i class="fa fa-phone"></i> {{$cliente->telefone}}|
            <i class="fa fa-mobile"></i> {{$cliente->celular}}
        </div>
    </a>

</div>