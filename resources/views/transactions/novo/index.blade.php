<?php use Carbon\Carbon as Carbon; ?>
@extends('layouts.master')

@section('styles')
    <!-- CSS THEME -->
    <link rel="stylesheet" href="" id="bootstrap-theme-css">
@stop

@section('content')
<div class="container">
    
	<div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">VISÃO GERAL | <a href="{{ url('financeiro/lancamentos') }}">LANÇAMENTOS</a> | <a href="{{ url('financeiro/relatorios') }}">RELATÓRIOS</a></h3>
                </div>
                <div class="panel-body">

                    <p class="lead text-center text-uppercase">
                        <strong>{{ (new Carbon() )->formatLocalized('%B de %Y') }}</strong>
                    </p>

                    <div class="row">
                        
                        <div class="col-md-6">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Resumo de {{ (new Carbon() )->formatLocalized('%B') }}</th>
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
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <dl>
                                                <dt>Total de receitas</dt>
                                                <dd>
                                                    <span class="text-success lead"><strong>R$ {{ number_format( $balance['total_receitas'], '2', ',', '.' ) }}</strong></span>
                                                </dd>
                                            </dl> 
                                        </td>
                                        <td>
                                            <dl>
                                                <dt>Total de depesas</dt>
                                                <dd>
                                                    <span class="text-danger lead"><strong>R$ {{ number_format( $balance['total_depesas'], '2', ',', '.' ) }}</strong></span>
                                                </dd>
                                            </dl> 
                                        </td>
                                        <td align="right">
                                            <dl>
                                                <dt>Saldo atual</dt>
                                                <dd>
                                                    <span class="text-primary fa-2x">R$ {{ number_format( $balance['saldo_atual'], '2', ',', '.' ) }}</span>
                                                </dd>
                                            </dl>                                              
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                                   
                        </div>

                        <div class="col-md-6">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Adicionar rápido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="btn-group btn-group-justified">                                

                                                <a href="{{ url( '/financeiro/create/?type=receita' ) }}" class="btn btn-success" data-toggle="modal" data-target="#transactions_modal">
                                                    <i class="icon-inbox"></i>                        
                                                    Registrar receita
                                                </a>
                                                <a href="{{ url( '/financeiro/create/?type=despesa' ) }}" class="btn btn-danger" data-toggle="modal" data-target="#transactions_modal">
                                                    <i class="icon-outbox"></i>
                                                    Registrar despesa
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                                    
                        </div>

                        <div class="col-md-6">

                            <table class="table table-hover">
                                <thead>
                                    <th colspan="4">
                                        <a href="{{  url('financeiro/lancamentos/?filter_type=receita')  }}" class="pull-right text-primary"><small>VER TODAS <i class="fa fa-chevron-circle-right"></i></small></a>
                                        Contas à receber
                                    </th>
                                </thead>
                                <?php if( count( $receitas['today'] ) ){ ?>
                                    <thead class="btn-sm">
                                        <tr class="active text-uppercase">
                                            <th colspan="4">
                                                Hoje
                                                <?php if( count( $receitas['today'] ) ){ ?>
                                                    <small class="badge badge-primary">{{ count( $receitas['today'] ) }}</small>
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    
                                        <?php foreach ($receitas['today'] as $transaction) { ?>
                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                        <?php } ?>

                                    </tbody>
                                <?php } ?>

                                      
                                <?php if( count( $receitas['overdue'] ) ){ ?>
                                    <thead class="btn-sm">
                                        <tr class="active text-uppercase">
                                            <th colspan="4">
                                                Atrasadas
                                                <?php if( count( $receitas['overdue'] ) ){ ?>
                                                    <small class="badge badge-danger">{{ count( $receitas['overdue'] ) }}</small>
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    
                                        <?php foreach ( $receitas['overdue'] as $transaction) { ?>
                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                        <?php } ?>

                                    </tbody>
                                <?php }else{ ?>                                    
                                    <tbody>
                                        <tr class="success text-uppercase">
                                            <td colspan="4">
                                                <i class="fa fa-check text-success"></i> Nenhuma receita pendente
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php } ?>

                                <?php if( count( $receitas['next'] ) ){ ?>
                                    <thead class="active btn-sm">
                                        <tr class="active">
                                            <th colspan="4" class="text-uppercase">
                                                Próximas  
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    
                                        <?php 
                                        $tmp = 0;
                                        foreach ( $receitas['next']  as $transaction) if ( $tmp++ < 5  ) { ?>
                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                        <?php } ?>

                                    </tbody>
                                <?php } ?>                                                                        
                            </table>   

                            <table class="table table-hover">
                                <thead>
                                    <th colspan="4">
                                        <a href="{{  url('financeiro/lancamentos/?filter_type=despesa')  }}" class="pull-right text-primary"><small>VER TODAS <i class="fa fa-chevron-circle-right"></i></small></a>
                                        Contas à pagar
                                    </th>
                                </thead>
                                <?php if( count( $despesas['today'] ) ){ ?>
                                    <thead class="btn-sm">
                                        <tr class="active text-uppercase">
                                            <th colspan="4">
                                                Hoje
                                                <?php if( count( $despesas['today'] ) ){ ?>
                                                    <small class="badge badge-danger">{{ count( $despesas['today'] ) }}</small>
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    
                                        <?php foreach ($despesas['today'] as $transaction) { ?>
                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                        <?php } ?>

                                    </tbody>
                                <?php } ?>

                                      
                                <?php if( count( $despesas['overdue'] ) ){ ?>
                                    <thead class="btn-sm">
                                        <tr class="active text-uppercase">
                                            <th colspan="4">                                                
                                                Atrasadas
                                                <?php if( count( $despesas['overdue'] ) ){ ?>
                                                    <small class="badge badge-danger">{{ count( $despesas['overdue'] ) }}</small>
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    
                                        <?php foreach ($despesas['overdue'] as $transaction) { ?>
                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                        <?php } ?>

                                    </tbody>
                                <?php }else if( !count( $despesas['today'] ) ){ ?>   
                                    <tbody>
                                        <tr class="bg-success text-uppercase">
                                            <td colspan="4">
                                                
                                                <strong><i class="fa fa-check"></i></strong> Nenhuma despesa atrasada!
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php } ?>

                                <?php if( count( $despesas['next'] ) ){ ?>
                                    <thead class="active btn-sm">
                                        <tr class="active" class="text-uppercase">
                                            <th colspan="4">
                                                Próxima
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php $tmp = 0; ?>
                                        <?php foreach ($despesas['next'] as $transaction)  if ( $tmp++ < 1  ) { ?>
                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                        <?php } ?>

                                    </tbody>
                                <?php } ?>                                                                        
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
    <script>
        // $.get("http://api.bootswatch.com/3/", function (data) {
        //     var themes = data.themes;
        //     var select = $("select#bootstrap-theme-changer");
        //     select.add;

            
        //     themes.forEach(function(value, index){
        //         console.table(value);
        //         select.append($("<option />")
        //                       .val(value.cssMin)
        //                       .text(value.name));
        //     });

        //     select.change(function(){
        //         $("link#bootstrap-theme-css").attr("href", $(this).val());                    
        //     }).change();                    
            

        // }, "json").fail(function(){
        //     alert("Failure!");
        // });
    </script>  


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
                            
                            if( $transaction->type == 'receita' ){ $amount_receitas += $transaction->amount; };
                            if( $transaction->type == 'despesa' ){ $amount_despesas -= $transaction->amount; };
                            
                            if ( $transaction->date != @$date){
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