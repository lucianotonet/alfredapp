<table class="table twelve columns" width="100%">
    <thead >        
        <tr style="border-bottom: 1px solid #313131;">
            <th style="text-align:left" width="">Data</th>
            <th style="text-align:left" width="auto">Cidade</th>
            <th style="text-align:left" width="">Descrição</th>
            <th style="text-align:right" width="" align="right">Valor</th>            
        </tr>                                
    </thead>    

    <?php $total = 0; ?>
        
    @foreach ($relatorio->get_despesas() as $despesa)      
        <tr>
            <td>{{ date('d/m/Y', strtotime($despesa->date) ) }}</td>
            <td>{{ $despesa->cidade }}</td>
            <td>{{ $despesa->descricao }}</td>
            <td style="text-align:right"><strong>R$ {{ number_format($despesa->valor, '2', ',', '.') }}</strong></td>                
        </tr>      

        <?php $total = ($total + $despesa->valor); ?> 
        {{-- @include('despesas.panels.item', $despesa) --}}
    @endforeach

    <tr>                
        <td colspan="4">
            <h3 style="text-align:right;"><small>Total </small><?php echo "R$ ".number_format($total, '2', ',', '.') ?></h3>
        </td>
    </tr>
    
</table>            