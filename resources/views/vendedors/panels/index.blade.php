<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <a href="{{url('vendedors/create')}}" class="btn btn-info pull-right">
            <i class="fa fa-plus"></i> Adicionar
        </a>        
        <h3 class="panel-title">Vendedores</h3>         
    </div>

  
    <div class="list-group list-vendedors">

    @foreach ($vendedores as $vendedor)
        {{-- expr --}}
        <a href="vendedors/{{$vendedor->id}}" class="list-group-item">
            <span class="pull-left cliente-avatar" style="background-color:#3bafda"> 
                <img src="img/avatar-small.png" alt=""> 
            </span> 
            <div class="search-data"> 
                <strong class="list-group-item-heading">{{$vendedor->empresa}}</strong><br> 
                <strong>{{$vendedor->nome}}</strong><br> 
                <i class="fa fa-map-marker"></i> {{$vendedor->cidade}} |
                <i class="fa fa-phone"></i> {{$vendedor->telefone}} |        
                <i class="fa fa-envelope"></i> {{$vendedor->email}}
            </div>
        </a>

    @endforeach

    </div>
</div>