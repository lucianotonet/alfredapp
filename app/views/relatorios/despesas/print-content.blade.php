<h3>
    <small class="badge pull-right">{{ date('d/m/Y', strtotime($relatorio->updated_at) ) }}</small>
    <small>Relatório Nº{{$relatorio->id}}</small><br>
    Despesas
</h3>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="">Data</th>
                <th width="">Cidade</th>
                <th>Descrição</th>
                <th width="" class="text-right">Valor</th>
            </tr>
        </thead>
        <tbody>                          

            @foreach ($relatorio->despesas as $despesa)             
                @include('despesas.panels.item', $despesa)                  
            @endforeach

        </tbody>
    </table>

    <h3 class="text-right"><small>Total </small><?php echo "R$ ".$relatorio->total ?></h3>