<div class="panel panel-primary">
    <!-- Default panel contents -->

    <div class="panel-heading">        
        <a href="{{url('fornecedors/create')}}" class="btn btn-info pull-right">
            <i class="fa fa-plus"></i> Adicionar fornecedor
        </a>        
        <h3 class="title">fornecedores</h3>         
    </div>
 
    

    <div class="list-group list-fornecedors">

    @foreach ($fornecedores as $fornecedor)
        {{-- expr --}}
        <a href="fornecedors/{{$fornecedor->id}}" class="list-group-item">
            <span class="pull-left cliente-avatar" style="background-color:#3bafda"> 
                <img src="img/avatar-small.png" alt=""> 
            </span> 
            <div class="search-data"> 
                <strong class="list-group-item-heading">{{$fornecedor->empresa}}</strong><br> 
                <strong>{{$fornecedor->nome}}</strong><br> 
                <i class="fa fa-map-marker"></i> {{$fornecedor->cidade}} |
                <i class="fa fa-phone"></i> {{$fornecedor->telefone}} |        
                <i class="fa fa-envelope"></i> {{$fornecedor->email}}
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