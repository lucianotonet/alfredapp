@extends('layouts.master')


@section('content')
   
    {{--@include('pedidos.panels.show')--}}
<div class="container" id="pedido">
        
        <iframe src="{{url('pedidos/preview/'.$pedido->id)}}" frameborder="0" height="1200" width="100%"></iframe>

</div>



<!-- DOCK NAVBAR -->
<nav id="dock" class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
    <div class="container">
        <div class="btn-toolbar text-center">            
            <div class="btn-group btn-group-sm">

                <a onclick="window.history.back()" class="btn btn-info btn-sm"><i class="fa fa-chevron-left"></i></a>             
                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Baixar PDF</a>
                <a href="#" class="btn btn-primary btn-sm" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</a>
                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-envelope"></i> Enviar</a>
                
            </div>
        </div>
    </div>
</nav>

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