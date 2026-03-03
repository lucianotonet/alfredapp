@extends('layouts.master')

@section('content')

    <div class="container">
        @include('pedidos.email.preview');
    </div>

    <!-- DOCK NAVBAR -->
    <nav id="dock" class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
        <div class="container">
            <div class="btn-toolbar text-center">            
                <div class="btn-group btn-group-sm">

                    <a onclick="window.history.back()" class="btn btn-info btn-sm"><i class="fa fa-chevron-left"></i></a>             
                    <a href="{{ url('pedidos/'.$pedido->id.'/download') }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Baixar PDF</a>
                    <a href="{{ url('pedidos/preview/'.$pedido->id) }}" class="btn btn-primary btn-sm" ><i class="fa fa-print"></i> Imprimir</a>
                    <a href="{{ url('/emails/create/pedido/'.$pedido->id) }}" class="btn btn-primary btn-sm send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope"></i> Enviar</a>
                    
                </div>
            </div>
        </div>
    </nav>

@stop