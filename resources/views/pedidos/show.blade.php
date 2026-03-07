@extends('layouts.master')


@section('content')
   
    {{--@include('pedidos.panels.show')--}}
<div class="container" id="pedido">

    <!-- Breadcrumbs -->
    <ol class="breadcrumb breadcrumb-arrow hidden-print">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
        <li><a href="{{url('pedidos')}}">Pedidos</a></li>         
        <li class="active"><span>Ver pedido</span></li> 
    </ol>

    <div class="panel panel-primary hidden-print">
        <div class="panel-heading">
            <h3 class="title">                
                PEDIDO Nº {{$pedido->id}}
            </h3>
        </div>
        <div class="panel-body">

            <!-- <a onclick="window.history.back()" class="btn btn-link"><i class="fa fa-chevron-left"></i></a>       -->
            <div class="pull-right">
                <div class="btn-group">
                    <?php if ($pedido->status == 2) { ?>
                        <a onclick="return confirm('O pedido será arquivado nos registros de {{$pedido->cliente->nome}} ({{$pedido->cliente->empresa}}) e você não poderá mais editá-lo. Deseja arquivar o pedido nº {{$pedido->id}}?')" href="{{ url('pedidos/'.$pedido->id.'/arquivar') }}" class="btn btn-primary"><span class="icon-box-add"></span> Arquivar</a>
                    <?php } ?>
                </div>
                <div class="btn-group">
                    <a href="{{ url('pedidos/preview/'.$pedido->id) }}" class="btn btn-primary print" data-print="pedidoFrame"><i class="fa fa-print"></i> Imprimir</a>
                    <a href="{{ url('pedidos/'.$pedido->id.'/download') }}" class="btn btn-default"><i class="fa fa-download"></i> Baixar PDF</a>
                    <a href="{{ url('/emails/create/?owner_type=pedido&owner_id='.$pedido->id) }}" class="btn btn-default send" data-toggle="modal" data-target="#email"><i class="fa fa-envelope"></i> Enviar</a>
                </div>                
                <div class="btn-group">            
                    <?php if ($pedido->status != 3) { ?>                    
                        <a href="{{ url('pedidos/'.$pedido->id.'/edit') }}" class="btn btn-default" ><i class="fa fa-edit"></i> Editar</a>
                    <?php } ?>
                    <a href="" class="btn btn-danger" ><i class="fa fa-times"></i> Excluir</a>
                </div>                
            </div>
                
            <h3 class="title">{{$pedido->statusTxt}}</h3>
                
        </div>


    </div>

    <iframe class="panel" src="{{url('pedidos/preview/'.$pedido->id)}}" frameborder="0" height="1000" width="100%" id="pedidoFrame"></iframe> 
    
</div>


<!-- DOCK NAVBAR -->
<!-- <nav id="dock" class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
    <div class="container">
        <div class="btn-toolbar text-center">            
            
        </div>
    </div>
</nav> -->

@stop

@section('scripts')
    <script>
        // (function($) {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{url('pedidos/preview/'.$pedido->id)}}",
        //         data: "",
        //         success: function(data) {
        //             // data is ur summary
        //             $('#pedido').html(data);
        //         }

        //     });   
        // })(jQuery);
    </script>
@stop