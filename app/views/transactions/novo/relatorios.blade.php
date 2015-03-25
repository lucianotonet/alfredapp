@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><a href="{{ url('financeiro/') }}">VISÃO GERAL</a> | <a href="{{ url('financeiro/lancamentos') }}">LANÇAMENTOS</a> | RELATÓRIOS</h3>
                </div>
                <div class="panel-body">  

                        <div class="dropdown text-center pull-left"> 
                            @if ( !in_array( $data['view'], ['range','overdue'] ) )                                       
                                                            
                                <?php $prev_link = $data; $prev_link['prev']++; ?>
                                <a href="{{ url( 'financeiro/relatorios/?'.http_build_query( $prev_link, '', '&amp;') ) }}" class="btn btn-link"><i class="fa fa-chevron-left"></i></a>
                                
                            @endif
                                <a id="select_label" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                    <strong class="text-uppercase">
                                        {{ $title }}
                                        <span class="caret"></span>
                                    </strong>
                                </a>

                            @if ( !in_array( $data['view'], ['range','overdue'] ) )
                        
                                    <?php $next_link = $data; $next_link['next']++; ?>
                                    <a href="{{ url( 'financeiro/relatorios/?'.http_build_query( $next_link, '', '&amp;') ) }}" class="btn btn-link"><i class="fa fa-chevron-right"></i></a>
                                
                            @endif  

                                <ul class="dropdown-menu" role="menu" aria-labelledby="select_label">  
                                    <?php
                                        $link_views['view'] = 'day'; 
                                        unset( $link_views['prev'] ); 
                                        unset( $link_views['next'] );
                                    ?>                                             
                                    <li><a href="{{ url( 'financeiro/relatorios?'.http_build_query( $link_views, '', '&amp;') ) }}">Hoje</a></li>

                                    <?php $link_views['view'] = 'week'; ?>
                                    <li><a href="{{ url( 'financeiro/relatorios?'.http_build_query( $link_views, '', '&amp;') ) }}">Esta semana</a></li>

                                    <?php $link_views['view'] = 'month'; ?>
                                    <li><a href="{{ url( 'financeiro/relatorios?'.http_build_query( $link_views, '', '&amp;') ) }}">Este mês</a></li>

                                    <li><a class="" data-toggle="modal" href='#transactions_select_range'>Escolher período</a></li>
                                
                                </ul>
                        </div>

                        <div class="modal animated fade" id="transactions_select_range">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content panel-primary">
                                    <div class="modal-header panel-heading">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <strong>Selecione o intervalo de datas</strong>
                                    </div>
                                    <div class="modal-body panel-body text-center">
                                        <form action="" method="GET" class="" role="form">                                               
                                            
                                            <input name="view" type="hidden" value="range">
                                        
                                            <div class="form-group">
                                                <input type="date" name="date_from" id="input" class="form-control" value="" required="required" title="">
                                            </div>
                                            <div class="form-group">
                                                <p class="form-control-static"> até </p>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="date_to" id="input" class="form-control" value="" required="required" title="">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Ok</button>
                                            </div>
                                            
                                        </form>
                                    </div>                                            
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    

                                     

                </div>


                @if (Session::has('info'))              
                    @foreach (Session::get('info') as $info)
                        <div class="{{ @$info['class'] }} list-group-item text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{@$info['message']}}
                        </div>
                    @endforeach
                @endif  


                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-6">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Relatório de {{ $title }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div id="curve_chart" style="width: 100%; height: auto"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                                    
                        </div>

                        <div class="col-md-6">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="">Receitas</th>
                                        <th colspan="">Despesas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="50%">
                                            <span class="text-primary">R$ {{ number_format( $balance['receitas_ok'], '2', ',', '.' ) }}</span><br>
                                            <sub class="text-muted">Previsto para o fim do período</sub><br>
                                            <span class="text-muted">R$ {{ number_format( $balance['receitas'], '2', ',', '.' ) }}</span>
                                        </td>
                                        <td width="50%">                                            
                                            <span class="text-danger">R$ {{ number_format( $balance['despesas_ok'], '2', ',', '.' ) }}</span><br>
                                            <sub class="text-muted">Previsto para o fim do período</sub><br>
                                            <span class="text-muted">R$ {{ number_format( $balance['despesas'], '2', ',', '.' ) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                
                            <table class="table table-hover">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <td align="right" width="auto">
                                            <p>
                                                <sub>Saldo atual</sub><br>
                                                <span class="text-primary fa-2x">R$ {{ number_format( $balance['saldo_atual'], '2', ',', '.' ) }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>   

                        </div>

                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>


@stop


@section('scripts')
    
    <script type="text/javascript"
    src="https://www.google.com/jsapi?autoload={
        'modules':[{
            'name':'visualization',
            'version':'1',
            'packages':['corechart'],
            'language': 'br'
        }]
    }"></script>

    <script type="text/javascript">
        google.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'X');
            data.addColumn('number', 'Receitas');
            data.addColumn('number', 'Despesas');
            data.addRows([
                <?php if( count( $transactions_days ) ){
                    
                    foreach ( $transactions_days as $day ){

                        $amount_receitas = 0;
                        $amount_despesas = 0;

                        foreach ( $day as $transaction ){
                            
                            if( $transaction->type == 'receita' && $transaction->done ){ $amount_receitas += $transaction->amount; };
                            if( $transaction->type == 'despesa' && $transaction->done ){ $amount_despesas -= $transaction->amount; };
                            
                            if ( $transaction->date != @$date ){
                                $trans_date = strftime("%Y, %m, %d", strtotime( $transaction->date ) );
                                $date = $transaction->date;
                            }
                        }
                        echo '[ new Date( '.$trans_date.'), '.$amount_receitas.', '.$amount_despesas.'],';
                    }
                } ?>  
            ]);

            var formatter = new google.visualization.NumberFormat({decimalSymbol: ',',groupingSymbol: '.', negativeColor: 'red', negativeParens: true, prefix: 'R$ '});
            formatter.format(data, 1);
            formatter.format(data, 2);

            var options = {
                curveType: 'function',
                legend: { position: 'bottom' },
                vAxis: { format: 'R$ #' },
                colors: ['#8cc152', '#DA4453']
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
@stop

