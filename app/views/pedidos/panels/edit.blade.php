<div class="panel panel-primary">

    <div class="panel-heading">
        <!-- <span class="loading white pull-left"></span> -->
        
        <h3 class="title">EDITAR PEDIDO <small>panels</small></h3>
             
    </div>
            
{{ Form::open(array('url' => 'pedidos', 'id' => 'pedido_create')) }}

<!-- List group -->
<ul class="list-group">
    <li class="list-group-item">
        <div class="row ">
            
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                       <h3 class="title text-right">Cliente</h3>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">

                        <?php if( $pedido->cliente ){ ?>
                            
                            <h4 class="title">{{ ( $pedido->cliente->empresa ) ? $pedido->cliente->empresa : $pedido->cliente->nome }}</h4>                
                            <strong>
                                {{ ( $pedido->cliente->cnpj ) ? "(".$pedido->cliente->cnpj . ")<br />" : "" }}
                                {{ ( $pedido->cliente->empresa ) ? $pedido->cliente->nome : "" }}
                            </strong>
                            <p>
                                
                                {{ ( $pedido->cliente->telefone ) ? $pedido->cliente->telefone.'<br />' : ''; }}
                                {{ ( $pedido->cliente->celular ) ? $pedido->cliente->celular.'<br />' : ''; }}
                                {{ '<br />'; }}
                                {{ ( $pedido->cliente->ie ) ? 'IE '.$pedido->cliente->ie.'<br />' : ''; }}                                
                                {{ ( $pedido->cliente->endereco ) ? $pedido->cliente->endereco.'<br />' : ''; }}
                                {{ ( $pedido->cliente->bairro ) ? 'Bairro '.$pedido->cliente->bairro.'<br />' : ''; }}
                                {{ ( $pedido->cliente->cidade ) ? $pedido->cliente->cidade.' - '.$pedido->cliente->uf.'<br />' : ''; }}
                                {{ ( $pedido->cliente->cep ) ? $pedido->cliente->cep.'<br />' : ''; }}
                                
                            </p>
                            
                            <input type="hidden" name="cliente_id" value="{{$pedido->cliente->id}}" required>

                        <?php } ?>

                    </div>
                </div>
                
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                        <h3 class="title text-right">Entrega</h3>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">                    
                        <input type="date" class="form-control input-lg h4 title" name="entrega_data" value="{{$pedido->entrega_data}}" required>               
                        <strong>Endereço</strong>
                        <textarea name="entrega_endereco" id="" rows="4" class="form-control" required>{{$pedido->entrega_endereco}}</textarea>    
                    </div>

                    &nbsp;
                    <div class="clearfix"></div>

                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                
                       <h3 class="title text-right">FRETE</h3>
                    </div>            
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">    
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <input type="radio" class="primary" name="frete" value="CIF" <?php if($pedido->frete == 'CIF' ) echo "checked" ?> > CIF 
                            </div>                    
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <input type="radio" class="primary" name="frete" value="FOB" <?php if($pedido->frete == 'FOB') echo "checked" ?> > FOB               
                            </div>
                        </div>            
                    </div>          
                </div>
                
            </div>
            
        </div>

    </li>
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                 
                       <h3 class="title text-right">Fornecedor</h3>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">        
                        
                        <select name="fornecedor_id" id="" class="form-control title">
                
                            @foreach (@$pedido->fornecedores as $fornecedor)
                                <option value="{{$fornecedor->id}}">{{$fornecedor->nome}} - {{$fornecedor->telefone}}</option>
                            @endforeach
                
                        </select>                       
                       
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="row ">
                    <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4">                 
                       <h3 class="title text-right">Vendedor</h3>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">        
                        
                        <select name="vendedor_id" id="" class="form-control title">
                
                            @foreach ($pedido->vendedores as $vendedor)
                                <option value="{{$vendedor->id}}">{{$vendedor->nome}} - {{$vendedor->telefone}}</option>
                            @endforeach
                
                        </select>   
                        
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">                 
                       <h3 class="title text-right">Pagamento</h3>
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">                    
                        <input type="text" name="pgto" class="form-control" value="{{$pedido->pgto}}">         
                    </div>
            </div>
        </div>
    </li>
</ul>

<div class="panel-body">
    <!-- PRODUTOS -->
    <h3 class="title">Produtos</h3><br>
    <table class="table table-striped table-hover pedido_produtos">
        <thead class="bg-info">
            <tr>
                <th width="90">Qtd.</th>
                <th width="60">Unidade</th>
                <th>Produto</th>
                <th width="130">Preço</th>
                <th width="130">Subtotal</th>
                <th width="40"></th>
            </tr>
        </thead>
        <tbody>

        <?php //foreach( range(1,10) as $key ) { ?>
        <?php foreach( $pedido->itens as $item ) { ?>

            <tr class="multiple-form-group form-group pedido_produtos_item" data-max="10">                   

                <td>
                    <input type="number" name="produtos[qtd][]" class="form-control produto_qtd" value="{{$item['qtd']}}" min="1" required>                                       
                </td>

                <td>
                    <select name="produtos[unidade][]" class="form-control">
                        <option value="m2" <?php if( $item['unidade'] == 'm2' ) echo 'selected' ?>>m2</option>
                        <option value="m3" <?php if( $item['unidade'] == 'm3' ) echo 'selected' ?>>m3</option>
                    </select>                    
                </td>

                <td>
                    <select name="produtos[produto_id][]" class="form-control produtos" required>
                        <option selected>Selecione um produto</option>
                        @foreach ($produtos as $produto)                            
                            <option value="{{$produto->id}}" <?php  print_r($item); //if( $item['produto_id'] == $produto->id ) echo 'selected' ?>>#{{$produto->cod}} - {{$produto->nome}}</option>
                        @endforeach
                    </select>                    
                </td>

                <td>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div> 
                        <input type="text" name="produtos[produtos_preco][]" class="produto_preco form-control price" value="" required>
                    </div>
                </td>

                <td>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div> 
                        <input type="text" name="produtos[produtos_preco_subtotal][]" class="form-control produto_subtotal price" value="" disabled>
                    </div>
                </td>

                <td>                    
                
                    <button type="button" class="btn btn-success btn-add pull-right">
                        <i class="fa fa-plus"></i>
                    </button>
                
                </td>

            </tr>
        
        <?php } ?>

        </tbody>
    </table>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

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



 
    <div class="panel-body">   
        <strong>Observações:</strong><br>
        <textarea name="obs" class="form-control"></textarea>        
    </div>

      
    <div class="panel-footer">
        <div class="btn-group btn-group-lg pull-left">
            <!-- <button type="submit" class="btn btn-primary">
                <i class="fa fa-envelope"></i> Enviar
            </button> -->
            <button type="button" class="btn btn-primary">
                <i class="fa fa-chevron-left"></i> Voltar
            </button>
        </div>
        <div class="btn-group btn-group-lg pull-right">
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
                        alert( $('input.produto_subtotal').val() );
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

    <script>
    $(document).ready(function ($) {

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
                .toggleClass('btn-default btn-add btn-danger btn-remove')
                .html('<i class="fa fa-times"></i>');

            $formGroupClone.find('.produto_preco').val('');
            $('.produto_preco').priceFormat({        
                                            prefix: '',
                                            centsSeparator: ',',
                                            thousandsSeparator: '.'
                                        });     
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            };

            //atualizaPedido();
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }

            $formGroup.remove();

            //atualizaPedido();
        };

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);

        //--------------------------------------------------------------------------------------
        
    });
    </script>
@stop