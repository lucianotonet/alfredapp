<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">
        <div class="btn-group pull-left">
            <h3 class="title">vendedores</h3> 
        </div>
        <div class="btn-group pull-right">
            <a href="{{url('vendedors/create')}}" class="btn btn-info">
                <i class="fa fa-plus"></i> Adicionar vendedor
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

    

    <div class="list-group list-vendedors">

    @foreach ($vendedores as $vendedor)
        {{-- expr --}}
        <a href="vendedores/{{$vendedor->id}}" class="list-group-item">
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

@section('script')
    <script>
        $(document).ready(function(){
            console.log('Ligado!');
        });
    </script>
@stop