<?php use Carbon\Carbon as Carbon; ?>

@extends('layouts.master')

@section('content')
<div class="container">
    

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><a href="{{ url('financeiro/') }}">VISÃO GERAL</a> | LANÇAMENTOS | <a href="{{ url('financeiro/relatorios') }}">RELATÓRIOS</a></h3>
                </div>
                <div class="panel-body">  

                    <div class="dropdown pull-left"> 
                        @if ( !in_array( $data['view'], ['range','overdue'] ) )                                       
                                                        
                            <?php $prev_link = $data; $prev_link['prev']++; ?>
                            <a href="{{ url( 'financeiro/lancamentos/?'.http_build_query( $prev_link, '', '&amp;') ) }}" class="btn btn-link"><i class="fa fa-chevron-left"></i></a>
                            
                        @endif
                            <a id="select_label" class="btn btn-primary" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                <strong class="text-uppercase">
                                    {{ $title }}
                                    <span class="caret"></span>
                                </strong>
                            </a>

                        @if ( !in_array( $data['view'], ['range','overdue'] ) )
                    
                            <?php $next_link = $data; $next_link['next']++; ?>
                            <a href="{{ url( 'financeiro/lancamentos/?'.http_build_query( $next_link, '', '&amp;') ) }}" class="btn btn-link"><i class="fa fa-chevron-right"></i></a>
                            
                        @endif  

                            <ul class="dropdown-menu" role="menu" aria-labelledby="select_label">  
                                <?php
                                    $link_views['view'] = 'day'; 
                                    unset( $link_views['prev'] ); 
                                    unset( $link_views['next'] );
                                ?>                                             
                                <li><a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $link_views, '', '&amp;') ) }}">Hoje</a></li>

                                <?php $link_views['view'] = 'week'; ?>
                                <li><a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $link_views, '', '&amp;') ) }}">Esta semana</a></li>

                                <?php $link_views['view'] = 'month'; ?>
                                <li><a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $link_views, '', '&amp;') ) }}">Este mês</a></li>

                                <li><a class="" data-toggle="modal" href='#transactions_select_range'>Escolher período</a></li>
                            
                            </ul>
                    </div>

                    <div class="pull-right form-inline">
                    
                        {{-- <div class="form-group"> --}}
                            {{-- <label class="" for="">Registrar lançamento: </label> --}}
                            
                            <div class="btn-group">                                

                                <a href="{{ url( '/financeiro/create/?type=receita' ) }}" class="btn btn-success" data-toggle="modal" data-target="#transactions_modal">
                                    <i class="icon-inbox"></i>                        
                                    Registrar receita
                                </a>
                                <a href="{{ url( '/financeiro/create/?type=despesa' ) }}" class="btn btn-danger" data-toggle="modal" data-target="#transactions_modal">
                                    <i class="icon-outbox"></i>
                                    Registrar despesa
                                </a>
                            </div>
                        {{-- </div> --}}
                        
                    </div>

                    


                        <!-- <select name="filter_by" class="form-control transaction_navigation">
                            <option value="">Hoje</option>
                            <option value="http://alfred/financeiro/?view=day&amp;date_from=2015-03-16">Hoje</option>
                            <option value="http://alfred/financeiro/?view=week&amp;date_from=2015-03-16">Esta semana</option>
                            <option value="http://alfred/financeiro/?view=month&amp;date_from=2015-03-16">Este mês</option>
                            <option class="" data-toggle="modal" value="#modal">Escolher datas</option>
                        </select>          -->                  


                        <div class="modal animated fade" id="transactions_select_range">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content panel-primary">
                                    <div class="modal-header panel-heading">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <strong>Exibir lançamentos de:</strong>
                                    </div>
                                    <div class="modal-body panel-body text-center">
                                        <form action="" method="GET" class="form-inline" role="form">                                               
                                            
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
                                        <th colspan="5">

                                            <div class="form-inline pull-right">                                                
                                            
                                                <div class="text-uppercase dropdown btn-group">
                                                    <a id="filter_type" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false" class="btn-link btn-sm">
                                                        {{ $labels['filter_type'] or 'todos' }}
                                                        {{-- <span class="caret"></span> --}}
                                                    </a>

                                                    <ul class="dropdown-menu" role="menu" aria-labelledby="filter_type">
                                                        <li>
                                                            <?php $filter_type = $data; ?>
                                                            <?php $filter_type['filter_type'] = 'despesa'; ?>
                                                            <a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_type, '', '&amp;') ) }}">Despesas</a>
                                                        </li>
                                                        <li>
                                                            <?php $filter_type['filter_type'] = 'receita'; ?>
                                                            <a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_type, '', '&amp;') ) }}">Receitas</a>
                                                        </li>
                                                        <li>
                                                            <?php unset( $filter_type['filter_type'] ); ?>
                                                            <a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_type, '', '&amp;') ) }}">Todos</a>
                                                        </li>
                                                    </ul>    
                                                </div>
                                                
                                                <div class="text-uppercase dropdown btn-group">
                                                    <a id="filter_done" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false" class="btn-link btn-sm">
                                                        {{ $labels['filter_done'] or 'todas' }}
                                                        {{-- <span class="caret"></span> --}}
                                                    </a>

                                                    <ul class="dropdown-menu" role="menu" aria-labelledby="filter_done">
                                                        <li>
                                                            <?php $filter_done = $data; ?>
                                                            <?php $filter_done['filter_done'] = 1; ?>
                                                            <a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_done, '', '&amp;') ) }}">Efetivadas</a>
                                                        </li>
                                                        <li>
                                                            <?php $filter_done['filter_done'] = "'0'"; ?>
                                                            <a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_done, '', '&amp;') ) }}">Não efetvadas</a>
                                                        </li>
                                                        <li>
                                                            <?php unset( $filter_done['filter_done'] ); ?>
                                                            <a href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_done, '', '&amp;') ) }}">Todas</a>
                                                        </li>
                                                    </ul>    
                                                </div>

                                                <div class="text-uppercase dropdown btn-group">

                                                    <?php $filter_order = $data; ?>                                                            
                                                    <?php $filter_order['filter_order'] = ('desc' == @$filter_order['filter_order'] ) ? 'asc' : 'desc'; ?>

                                                    <a id="filter_type" href="{{ url( 'financeiro/lancamentos?'.http_build_query( $filter_order, '', '&amp;') ) }}" class="btn-link btn-sm">
                                                        {{ $labels['filter_order'] or '<i class="fa fa-chevron-down"></i>' }}
                                                    </a>

                                                </div>
                                                
                                                
                                            </div>

                                            Lançamentos de {{ $title }}
                                        </th>
                                    </tr>
                                </thead>                                          
                                <tbody>        

                                <?php if( count( $transactions_days ) ){ ?>
                                
                                    @foreach ( $transactions_days as $day )
                                        @foreach ( $day as $transaction )
                                            @if ( $transaction->date != @$date)
                                                <tr>
                                                    <td rowspan="{{ count($day)+1 }}" width="50" class="text-uppercase text-right" title="{{ (new Carbon( $transaction->date ) )->formatLocalized('%A, %d de %B de %Y') }}" >
                                                    <?php $dt = new Carbon( $transaction->date ); ?>
                                                    <?php 
                                                        if( $dt->isToday() ){
                                                            echo "<strong>hoje</strong>";
                                                        }else
                                                        if( $dt->isTomorrow() ){
                                                            echo "amanhã";
                                                        }else
                                                        if( $dt->isYesterday() ){
                                                            echo "ontem";
                                                        }else{
                                                            echo $dt->format('d/m/y');
                                                        }
                                                    ?>
                                                    </td>
                                                </tr>                                                    
                                            @endif  

                                            @include('transactions.novo.'.$transaction->type.'.list-item')
                                            
                                            <?php //$done  = ( $transaction->done == '1' )       ? 'done'   : '' ?>
                                                                                                    
                                            <?php $date = $transaction->date; ?>

                                        @endforeach
                                    @endforeach

                                <?php } ?>   

                                
                                </tbody>
                            </table>                                    
                                                                                 
                        </div>


                        <div class="col-md-6">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-right">Saldo atual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="right">
                                            <p>                                                    
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
</div>

@stop


@section('scripts')
    <script>
        $('#transactions_modal').on('hidden.bs.modal', function (e) {
            $(this).removeData('bs.modal');
        })
    </script>
@stop