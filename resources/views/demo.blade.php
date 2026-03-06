@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6">

            <!--
            ################################################

               TAREFAS

            ################################################
            -->
            <div class="panel panel-primary tarefas-index">
                <!-- Default panel contents -->
                <div class="panel-heading">

                    <!-- <span class="loading white pull-left"></span> -->
                    <div class="btn-group"> 
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <h3 class="pull-left title">TAREFAS 
                            <span class="caret"></span></h3>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#" data-toggle="collapse" data-target=".teste">Procurar</a>
                            </li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>                
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                        </ul>
                    </div> 

                    <div class="pull-right">            
                        <i class="fa fa-circle fa-led success"></i>
                    </div>

                    <div class="clearfix"></div>
                </div>                    
                
                <div class="input-group input-group-lg search">
                    <span class="input-group-btn">
                        <button class="btn btn-danger btn-lg" type="button">
                            <i class="fa fa-search fa-fw"></i>
                        </button>
                    </span>
                    <input class="form-control input-lg" type="text" placeholder="Procurar..." autofocus>
                </div>

                <ul class="list-group">
                    @foreach($tarefas as $tarefa)
                        <li class="list-group-item {{ $tarefa->done ? 'disabled' : '' }} tarefa-{{ $tarefa->id }}">
                            {{ Form::open() }}
                                <i class="pull-left">
                                    <input type="checkbox" class="primary" name="done" id="tarefa-{{ $tarefa->id }}"  {{ $tarefa->done ? 'checked' : '' }} />
                                </i>
                                
                                <label for="tarefa-{{ $tarefa->id }}" style="{{ $tarefa->done ? 'text-decoration: line-through;' : '' }}">{{ $tarefa->nome }}</label>

                                <a href="#" class="opentask">
                                    <span class="pull-right glyphicon glyphicon-chevron-right btn-xs"></span>
                                </a>

                                <input type="hidden" name="id" value="{{ $tarefa->id }}">
                            {{ Form::close() }}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>



        <div class="col-md-6">
            
            @include('clientes.panels.index')

        </div>


        <div class="col-md-6">
            
            @include('conversas.panels.index')

        </div>


    </div>

</div>

@stop