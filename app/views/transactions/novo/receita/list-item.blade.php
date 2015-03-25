<tr class="{{ ($transaction->isOverdue()) ? 'bg-warning' : '' }} {{ ( $transaction->current ) ? 'active disabled' : '' }}">
    <td width="20">        
        <a href="{{ url( '/financeiro/'.$transaction->id.'/edit' ) }}" class="text-uppercase text-default" data-toggle="modal" data-target="#transactions_modal">
            <?php if ($transaction->current) { ?>
                <i class="fa fa-chevron-circle-right text-muted" title="Lançamento do tipo RECEITA"></i>
            <?php }else{ ?>
                <i class="icon-inbox text-default" title="Lançamento do tipo RECEITA"></i>
            <?php } ?>
        </a>
    </td>
    <td class="description">                                                               
        <a href="{{ url( '/financeiro/'.$transaction->id ) }}" class="text-uppercase text-default" data-toggle="modal" data-target="#transactions_modal">
            {{ !empty($transaction->description) ? $transaction->description : '<span class="text-muted">( sem descrição )</span>' }}
            @if ( $transaction->getRecurringTransactions->count() > 1 )
                <small class="text-muted">{{ $transaction->recurring_cycle }}/{{ $transaction->getRecurringTransactions->count() }}</small>
            @endif
        </a>
    </td>
    <td align="right" class="text-default">
        <a href="{{ url( '/financeiro/'.$transaction->id ) }}" class="text-uppercase text-default" data-toggle="modal" data-target="#transactions_modal">
            R$ {{ number_format( (float)$transaction->amount, '2', ',', '.') }}
        </a>
    </td>
    <td width="30">                                                        
        <small>
            @if ( $transaction->isOverdue() )
                <span class="label label-danger">ATRASADA</span>
            @elseif( $transaction->done )
                <span class="label label-success">PAGO</span>
            @endif
        </small>
    </td>
</tr> 