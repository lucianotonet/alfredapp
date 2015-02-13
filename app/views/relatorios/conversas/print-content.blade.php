<h3>
    <small class="badge pull-right">{{ date('d/m/Y', strtotime($relatorio->updated_at) ) }}</small>
    <small>Relatório Nº{{$relatorio->id}}</small><br>
    Conversas
</h3>

        
@foreach ( $relatorio->conversas as $cliente )
    
    <div class="panel panel-default">

        @include( 'clientes.panels.item' )

        <ul class="list-group">

            @foreach ( $cliente->conversas as $conversa )

                @include('conversas.print.item')                            

            @endforeach

        </ul>   

    </div>              

@endforeach