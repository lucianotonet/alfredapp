@extends('layouts.master')

@section('content')

    <div class="container">   

        <!-- Breadcrumbs -->
        <ol class="breadcrumb breadcrumb-arrow hidden-print">
            <li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('relatorios')}}">Relatórios</a></li>         
            <li><a href="{{url('relatorios#despesas')}}">Despesas</a></li>    
            <li class="active"><span>Novo</span></li>  
        </ol>


        <div class="panel panel-primary" ng-controller="despesasController">
            <div class="panel-heading">
                <h3 class="panel-title title">RELATÓRIO DE DESPESAS</h3>
            </div>
        
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12">
                        <legend></legend>
                    </div>
                    <!-- panel preview -->
                    
                    <div class="col-sm-5">
                        <h4 class="title">ADICIONAR DESPESA</h4>

                        @include('despesas.panels.create')      

                    </div> <!-- / panel preview -->

                    <div class="col-sm-7">                    
                        <h4 class="title">Itens do relatório:</h4>                   
                        <small>{{count( $despesas )}} despesas não enviadas</small>

                        <!-- <form name="despesasForm" ng-submit="submitRelatorio()"> -->
                            <div class="row">
                                <div class="col-xs-12">


                                        <div class="table-responsive">
                                            <table class="table preview-table">
                                                <thead>
                                                    <tr>
                                                        <!-- <th></th> -->
                                                        <th width="100">Data</th>
                                                        <th width="170">Cidade</th>
                                                        <th>Descrição</th>
                                                        <th width="120" class="text-right">Valor</th>
                                                        <th width="30"></th>                                            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                @foreach ($despesas as $despesa)
                                                    <tr class="<?php if( $despesa->valor < 0 ) echo 'bg-danger' ?>">
                                                       <!--  <td>
                                                            <?php if( $despesa->valor > 0 ){ ?>
                                                                <i class="fa fa-arrow-up text-success"></i>
                                                            <?php }else if( $despesa->valor == 0 ){ ?>
                                                                <i class="fa fa-question text-warning"></i>
                                                            <?php }else{ ?>
                                                                <i class="fa fa-arrow-down text-danger"></i>
                                                            <?php } ?>
                                                        </td> -->
                                                        <td>{{ date('d/m/Y', strtotime($despesa->date) ) }}</td>
                                                        <td>{{$despesa->cidade}}</td>
                                                        <td>{{$despesa->descricao}}</td>
                                                        <td class="text-right">
                                                            <strong>R$ {{$despesa->valor}}</strong>
                                                        </td>
                                                        <td>
                                                            {{ Form::open(array('url' => 'despesas/' . $despesa->id, 'class' => '')) }}
                                                                <button class="btn-link" type="submit" onclick='javascript:return confirm("Deseja excluir este despesa?")' role="menuitem" href="">
                                                                    <span class="glyphicon glyphicon-remove pull-right text-danger"></span>
                                                                </button> 
                                                                                                                                    
                                                                {{ Form::hidden('_method', 'DELETE') }}
                                                            {{ Form::close() }}    
                                                        </td>
                                                    </tr>                                                    
                                                @endforeach

                                                </tbody> <!-- preview content goes here-->
                                            </table>
                                        </div>                            
                                </div>
                            </div>
                            <div class="row text-right">
                                <div class="col-xs-12">
                                    <br>
                                    <h4>Total R$ <strong class="preview-total">{{ $despesas->total }}</strong></h4>
                                    <input type="hidden" name="total" value="" id="total" required>
                                </div>
                            </div>

                            @if ( count( $despesas ) )

                                <div class="row">
                                    <div class="col-xs-12">
                                        <hr style="border:1px dashed #dddddd;">
                                        {{Form::open(array('url' => 'relatorios', 'id' => 'relatorio_create'))}}
                                            {{Form::hidden('type','despesas')}}
                                            <button type="submit" class="btn btn-primary btn-block despesa-fechar">FECHAR RELATÓRIO</button>
                                        {{Form::close()}}
                                    </div>                
                                </div>
                                    
                            @endif
                        

                    </div>
                </div>
            </div>
        </div>


    </div>





</div>

@stop