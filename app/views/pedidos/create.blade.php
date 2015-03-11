@extends('layouts.master')


@section('content')

<div class="container">

    <!-- Breadcrumbs -->
    <ol class="breadcrumb breadcrumb-arrow hidden-print">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
        <li><a href="{{url('pedidos')}}">Pedidos</a></li>         
        <li class="active"><span>Adicionar pedido</span></li> 
    </ol>


<div class="panel panel-primary">

    <div class="panel-heading">
        <!-- <span class="loading white pull-left"></span> -->
        
        <h3 class="title">NOVO PEDIDO</h3>
             
    </div>
            
{{ Form::open(array('url' => 'pedidos', 'id' => 'pedido_create')) }}

<!-- List group -->
<ul class="list-group">
    <li class="list-group-item">
        <div class="row ">
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-2">                 
                       <h4 class="title text-right">Vendedor</h4>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-10 border-left">        
                        
                        <select name="vendedor_id" id="" class="form-control" required>
                
                            @foreach ($vendedores as $vendedor)
                                <option value="{{$vendedor->id}}">{{$vendedor->nome}}</option>
                            @endforeach
                
                        </select>
                        
                    </div>
                </div>
            </div>
        </div>
    </li>

    
    <li class="list-group-item">
        <div class="row ">            
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                       <h4 class="title text-right">Cliente</h4>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 border-left">
                        
                        <input type="text" name="cliente_name" value="{{ @$cliente->nome }}" class="form-control autocomplete" data-json="{{url('getcontacts')}}" required>
                                                    

                           <div class="costumer_display">
                                @if ( $cliente )
                                    @include('clientes.panels.item')
                                @else
                                    <p class="alert alert-warning"><i class="fa fa-warning"></i> Informe o cliente</p>
                                @endif                                    
                           </div>
                                    
    
                        <input type="hidden" id="cliente_id" name="cliente_id" value="{{ @$cliente->id }}" required>

                    </div>
                </div>
                
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                 
                       <h4 class="title text-right">Fornecedor</h4>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 border-left">        
                        
                        <select name="fornecedor_id" id="fornecedor_id" class="form-control" required>
                
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}">{{$fornecedor->empresa}}</option>
                            @endforeach
                
                        </select>     
                        
                        <input type="hidden" name="url" id="fornecedores_url" value="{{ url('fornecedores') }}">

                        <img src="{{asset('img/preloader.gif')}}" alt="" class="preloader flat animated">

                        <div id="fornecedor_display">

                        </div>    

                    </div>
                    
                </div>
                
            </div>
            
        </div>

    </li>
    <li class="list-group-item">
        
        <div class="row ">
            <div class="col-xs-3 col-sm-4 col-md-4 col-lg-2">                
                <h4 class="title text-right">Entrega</h4>
            </div>
            
            <div class="col-xs-9 col-sm-8 col-md-8 col-lg-5 border-left"> 
                <strong>DATA</strong>                   
                <input type="date" class="form-control input-lg h4 title" name="entrega_data" required>
                <br>
                <strong>FRETE</strong>
                <br>
                    <!-- <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            </div>                    
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            </div>
                        </div>            -->
                        <input type="radio" class="primary" name="frete" value="CIF" checked="true" selected> CIF  
                        <input type="radio" class="primary" name="frete" value="FOB"> FOB               
                 
            </div>
            <div class="col-xs-9 col-sm-8 col-md-8 col-lg-5">    
                <strong>Endereço</strong>
                <textarea name="entrega_endereco" id="" rows="4" class="form-control" required></textarea>    
            </div>                              
            <div class="clearfix"></div>
        </div>                    
        
    </li>
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">                 
                           
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">                    
                </div>  
            </div>
        </div>
    </li>

<li class="list-group-item">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- PRODUTOS -->
            <h3 class="title">Produtos</h3><br>
            <table class="table table-striped table-hover pedido_produtos">
                <thead class="bg-info">
                    <tr>
                        <th width="90">Qtd.</th>
                        <th width="60">Unidade</th>
                        <th>Produto</th>
                        <th>Acabamento</th>
                        <th width="130">Preço</th>
                        <th width="130">Subtotal</th>
                        <th width="40"></th>
                    </tr>
                </thead>
                <tbody>

                <?php //foreach( range(1,10) as $key ) { ?>

                    <tr class="multiple-form-group form-group pedido_produtos_item" data-max="10">                   

                        <td>
                            <input type="number" name="itens[qtd][]" class="form-control produto_qtd" value="1.00" min="0.01" step="any" required>                                       
                        </td>

                        <td>
                            <select name="itens[unidade][]" class="form-control">
                                <option value="m2">m2</option>
                                <option value="m3">m3</option>
                            </select>                    
                        </td>

                        <td>
                            

                            <select name="itens[produto_id][]" class="form-control produtos" required >
                                <option>Selecione um produto</option>
                                @foreach ($produtos as $produto)                            
                                    <option value="{{$produto->id}}" data-catid="{{$produto->category_id}}" data-price="{{$produto->preco}}" >#{{$produto->cod}} - {{$produto->nome}}</option>
                                @endforeach
                            </select>   

                        </td>

                        <td>

                            <select name="itens[produto_category_id][]" class="form-control categories" >                      
                                <option value="">-</option>          
                                @foreach ($categories as $category)                            
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>                    


                        </td>

                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">R$</div> 
                                <input type="text" name="itens[preco][]" class="produto_preco form-control price" value="" required>
                            </div>
                        </td>

                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">R$</div> 
                                <input type="text" name="itens[subtotal][]" class="form-control produto_subtotal price disabled" value="">
                            </div>
                        </td>

                        <td>                    
                        
                            <button type="button" class="btn btn-success btn-plus pull-right">
                                <i class="fa fa-plus"></i>
                            </button>
                        
                        </td>

                    </tr>
                
                <?php  //} ?>

                </tbody>
            </table>

        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

            <h4 class="title">Pagamento</h4>
            <input type="text" name="pgto" class="form-control">  

        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
            
            Total <h3 class="title price produtos_total">R$ 0,00</h3>
        
            <button type="button" class="btn btn-primary pull-right" id="atualiza_pedido" >
                <i class="fa fa-refresh"></i>
                Atualizar
            </button>
            &nbsp;
            <input type="hidden" class="produtos_total" name="total" required>

        </div>
    </div>
</li>


    <li class="list-group-item">
        <p>
            <strong>Observações:</strong>
            <br>
            <textarea name="obs" class="form-control" id="pedido_obs"></textarea>        
        </p>  
    </li>

</ul>

@include('pedidos.panels.observacoes')

    <div class="panel-body bg-info">
        <p>
            <strong>Notas administrativas:</strong> <small>Não aparece no pedido</small><br>
            <textarea name="obs_adm" class="form-control"></textarea>        
        </p>  
    </div>
      

    <div class="panel-footer">
        <div class="btn-group pull-left">
            <!-- <button type="submit" class="btn btn-primary">
                <i class="fa fa-envelope"></i> Enviar
            </button> -->
            <button type="button" class="btn btn-primary">
                <i class="fa fa-chevron-left"></i> Voltar
            </button>
        </div>
        <div class="btn-group pull-right">
            <button type="reset" class="btn btn-warning">
                <i class="fa fa-eraser"></i> Corrige
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> Fechar pedido
            </button>
        </div>   
        <div class="clearfix"></div>
    </div>

{{ Form::close() }}
</div>

</div>

@stop


@section('scripts')
    
    <script>
        /**
         * ---------------------------------
         *      ATUALIZA PEDIDO
         *      Calcula os valores do pedido 
         *  --------------------------------         
         */
        var atualizaPedido = function(e){

            //console.log('Atualizando total');

            e.preventDefault();

            $('.loading').removeClass('fadeOut');
            $('h3.produtos_total').css('color','darkred');

            btn = $(this);
            btn.find('i').addClass('fa-spin');

            var total = [];

            // SUBTOTAIS = Array com valores subtotais
            function atualizaTotal( subtotais ){
                var totalfinal = 0;
                for (var i = 0; i < subtotais.length; i++) {
                    //Soma todos                                       
                    subt = subtotais[i];
                    //subt = subt.replace('.','');
                    totalfinal += parseFloat( subt ) << 0;
                }                

                $('input.produtos_total').val( totalfinal );
                $('h3.produtos_total').text( totalfinal ).css('color','#434a54').priceFormat({        
                    prefix: 'R$ ',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });   


                $('.loading').addClass('fadeOut'); 
                btn.find('i').removeClass('fa-refresh fa-spin').addClass('fa-check');
                setTimeout(function(){
                    btn.find('i').removeClass('fa-check').addClass('fa-refresh');
                }, 2000);
                return;
                //$('.this').removeClass('this');
            };

        // CADA
            $('table.pedido_produtos tr.pedido_produtos_item').each( function( index ) {

                //console.log('Atualizando item '+index);
                $('h3.produtos_total').css('color','darkred');
                btn.find('i').addClass('fa-spin');
                
                $('.this').removeClass('this');
                $(this).addClass('this');

                var itemQtd      = $( this ).find('td .produto_qtd');
                if(itemQtd == '') itemQtd.val('1');
                var itemSubtotal = $( this ).find('td input.produto_subtotal');
                var itemPrecoUn  = $( this ).find('td input.produto_preco');
                var itemSelect   = $( this ).find('td select.produtos');
                var itemId       = itemSelect.val();
                var loading         = $('.loading').slideDown();


                // Pega valores via ajax
                $.ajax({
                    url:    '{{url("produtos")}}/' + itemId,
                    method: 'GET',
                    success: function(data){
                        
                        // Preco unitario
                        //itemPrecoUn.addClass('this');
                        if(itemPrecoUn.val() == ''){
                            itemPrecoUn.val( data.preco );
                        }
                        itemPrecoUn.priceFormat({        
                            prefix: '',
                            centsSeparator: ',',
                            thousandsSeparator: '.'
                        });
                        //itemPrecoUn.removeClass('this');

                        // Subtotal
                        //itemSubtotal.addClass('this');
                        var precoUnitario = itemPrecoUn.val();
                        var subtotal      = precoUnitario.replace( ',', '').replace('.','');

                        //console.log( "Subtotal: " + subtotal );                  

                            subtotal = itemQtd.val() * parseFloat( subtotal );

                        
                        //console.log( "Subtotal X "+itemQtd.val()+": "+subtotal );                  

                        itemSubtotal.val( subtotal );
                        itemSubtotal.priceFormat({        
                            prefix: '',
                            centsSeparator: ',',
                            thousandsSeparator: '.'
                        });
                        
                        //itemSubtotal.removeClass('this');

                        // Adiciona à array Totalfinal
                        total.push( subtotal );
                        atualizaTotal( total );

                    }
                }, 'json');

                //console.log( index + ": " + itemSelect.val() );
            });

        }        
    </script>

    <style>
        #pedido_obs{overflow:scroll; max-height:300px}
    </style>

    <script>
    $(document).ready(function ($) {

        $( ".autocomplete" ).autocomplete({
            serviceUrl: '<?php echo url("getcostumers") ?>',
            groupBy: 'type', 
            onSelect: function (suggestion) {
                $(this).val( suggestion.value );

                var cliente = jQuery.parseJSON( suggestion.data.obj );

                $.ajax({
                    url: '<?php echo url("clientes/'+cliente.id+'/mini") ?>',
                    type: 'GET',
                    dataType: 'html',                    
                })
                .done(function( data ) {
                    //console.log( data );
                    $('.costumer_display').html( data );
                    $('input#cliente_id').val( cliente.id );

                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    //console.log("complete");
                });
                

                console.log( suggestion.data );
            }
        });



        /**
            CHANGE DATA
        **/
        var changeData = function (event) {
            var category_id = $(this).find('option:selected').data('catid');
            var price       = $(this).find('option:selected').data('price');

            $(this).parent('td').next('td').find('select.categories').val( category_id );
            $(this).parent('td').parent('tr').find('td input.produto_preco').val( price );
            $('input.produto_preco').priceFormat({        
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });   

            // atualizaPedido();
        };

        /**
            CHANGE PRODUTOS
        **/
       $('select.produtos').change( changeData );

        //$('#pedido_obs').wysiwyg();

        //$('form#pedido_create').on('change', atualizaPedido);
        $('#atualiza_pedido').on('click', atualizaPedido);
        

        /**
         * -----------------------
         *     CLONE ITEMS
         * -----------------------
         */
        var addFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();

            $(this)
                .toggleClass('btn-default btn-plus btn-danger btn-remove')
                .html('<i class="fa fa-times"></i>');

            $formGroupClone.find('input.produto_preco').val('');
            
            $formGroupClone.find('select.produtos').change( changeData );

            $('input.produto_preco').priceFormat({        
                                            prefix: '',
                                            centsSeparator: ',',
                                            thousandsSeparator: '.'
                                        });     
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-plus').attr('disabled', true);
            };

            //atualizaPedido();
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-plus').attr('disabled', false);
            }

            $formGroup.remove();

            //atualizaPedido();
        };

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-plus', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);

        //--------------------------------------------------------------------------------------
        
    });
    </script>
@stop
