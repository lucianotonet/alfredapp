<!-- EXPERIMENTAL STYLES -->
<style>
#email > div > div > div > form > div > div.btn-group.btn-group-sm.pull-left > button{
    display: none;
}
</style>

<div class="panel panel-primary" >
    <div class="panel-heading">
        <a href="{{url('pedidos/create')}}" class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i>
            Novo pedido
        </a>
        <h3 class="title">PEDIDOS</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#naoenviados" role="tab" data-toggle="tab">
                    <strong>ABERTOS</strong>
                </a>
            </li>
            <li>
                <a href="#todos" role="tab" data-toggle="tab">
                    <strong>FECHADOS</strong>
                </a>
            </li>                    
        </ul>



        <!-- Tab panes -->
        <div class="tab-content">

            <!-- TAB PANE -->
            <div class="tab-pane active" id="naoenviados">

                <h4 class="title">{{count( $pedidos->aguardando )}} pedidos aguardando</h4>
                <br>
                <div class="table-responsive">
                    <table id="pedidos_aguardando" class="table">
                        <thead class="bg-primary">
                            <tr>                            
                                <th width="20">Nº</th>   
                                <th width="80">Data</th>
                                <th>Cliente</th>                
                                <th>Fornecedor</th>
                                <th width="120" align="right">Total</th>                
                                <th width="160" align="right"></th>
                            </tr>
                        </thead>
                        <tbody class="fade in">
                            @foreach($pedidos->aguardando as $pedido)
                            <tr>
                                <!-- <td>
                                    <i class="fa fa-circle fa-led {{( @$pedido->status == '2' ) ? 'success' : 'danger'}}"></i>
                                </td> -->
                                <td>{{$pedido->id}}</td>
                                <td>{{ date( "d/m/Y", strtotime($pedido->created_at) ) }}</td>
                                <td>
                                    <a href="{{ url('/pedidos/'.$pedido->id) }}" >                                    
                                        {{ ($pedido->cliente['empresa']) ? $pedido->cliente['empresa'] : @$pedido->cliente['nome'] }}
                                    </a>
                                </td>
                                <td>{{($pedido->fornecedor->empresa)?$pedido->fornecedor->empresa: @$pedido->fornecedor->nome}}</td>
                                <td><span class="money">{{$pedido->total}}</span></td>
                                <td width="auto" align="right">


                                    {{ Form::open(array('url' => 'pedidos/' . $pedido->id, 'class' => 'text-right', 'style' => 'min-width:175px;' )) }}

                                    <a href="{{ url('/emails/create/?owner_type=pedido&owner_id='.$pedido->id) }}" class="btn btn-link btn-sm send" data-toggle="modal" data-target="#email">
                                     <i class="fa fa-envelope"></i>
                                 </a> 

                                 <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                    <i class="fa fa-print"></i>
                                </a>  

                                <div class="btn-group btn-group-sm">
                                    {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm danger text-danger', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este pedido da lista?")', 'tabindex'=>"-1" )) }}
                                </div> 

                                {{ Form::hidden('_method', 'DELETE') }}

                                {{ Form::close() }}  

                                            <!-- <a href="{{ url('/pedidos/'.$pedido->id) }}" role="menuitem" tabindex="-1" class="">
                                               <i class="fa fa-chevron-right"></i>
                                           </a>  --> 

                                       </td>
                                   </tr>
                                   @endforeach                   
                                   <?php // print_r($pedidos); exit; ?>
                               </tbody>
                           </table>

                       </div>

                   </div>

                   <!-- TAB PANE -->
                   <div class="tab-pane" id="todos">
                    <h4 class="title">{{count($pedidos->enviados)}} pedidos fechados e enviados</h4>
                    <br>
                    <div class="table-responsive">
                        <table  id="pedidos_enviados" class="table" style="min-width:850px;">
                            <thead class="bg-primary">
                                <tr>                            
                                    <th width="20">Nº</th>   
                                    <th width="80">Data</th>
                                    <th>Cliente</th>                
                                    <th>Fornecedor</th>
                                    <th width="120" align="right">Total</th>                
                                    <th width="160" align="right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos->enviados as $pedido)
                                <tr>
                                <!-- <td>
                                    <i class="fa fa-circle fa-led {{( @$pedido->status == '2' ) ? 'success' : 'danger'}}"></i>
                                </td> -->
                                <td>{{$pedido->id}}</td>
                                <td>{{ date( "d/m/Y", strtotime($pedido->created_at) ) }}</td>
                                <td>
                                    <a href="{{ url('/pedidos/'.$pedido->id) }}" >                                    
                                        {{ ($pedido->cliente['empresa']) ? $pedido->cliente['empresa'] : @$pedido->cliente['nome'] }}
                                    </a>
                                </td>
                                <td>{{($pedido->fornecedor->empresa)?$pedido->fornecedor->empresa: @$pedido->fornecedor->nome}}</td>
                                <td><span class="money">{{$pedido->total}}</span></td>
                                <td align="right">

                                    {{ Form::open(array('url' => 'pedidos/' . $pedido->id, 'class' => 'text-right', 'style' => 'min-width:175px;' )) }}

                                    <a href="{{ url('/emails/create/?owner_type=pedido&owner_id='.$pedido->id) }}" class="btn btn-link btn-sm send" data-toggle="modal" data-target="#email">
                                     <i class="fa fa-envelope"></i>
                                 </a> 

                                 <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="btn btn-link btn-sm" role="menuitem" tabindex="-1" >
                                    <i class="fa fa-print"></i>
                                </a>  

                                <div class="btn-group btn-group-sm">
                                    {{ Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-danger btn-sm', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir este pedido da lista?")', 'tabindex'=>"-1" )) }}
                                </div> 

                                {{ Form::hidden('_method', 'DELETE') }}

                                {{ Form::close() }}  


                            </div>
                        </td>
                    </tr>
                    @endforeach                   
                    <?php // print_r($pedidos); exit; ?>
                </tbody>
            </table>

        </div>
    </div>
    </div>

</div>
</div>               

</div>












@section('scripts')
<script>
    // $('.send').click(function(){


    //     $('.modal-body').load( $(this).attr("href"), function(result){

    //         $('.modal').one('shown.bs.modal', function (e) {
    //             // this handler is detached after it has run once
    //             console.log('1');
    //         }).one('hidden.bs.modal', function(e) {
    //             // this handler is detached after it has run once
    //             console.log('2');
    //         }).modal({show:true});

    //     // $('.modal').modal({show:true});
    //     //(function($) {
    //         /**
    //          * WYSIWYG
    //          */

    //     //})(jQuery);
    //     //
    //     });


    // });

jQuery(document).ready(function($) {
    $('#pedidos_enviados').dynatable();
    $('#pedidos_aguardando').dynatable();
});

</script>
@stop