<div class="panel panel-primary" >
    <div class="panel-heading">

        <div class="dropdown pull-right">
          <a href="{{url('clientes/'.$cliente->id.'/edit')}}" class="btn btn-success btn-sm">
            <i class="fa fa-edit"></i> Editar</a>
          </a>
          <a href="#" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
            <!-- <li role="presentation info"><a href="#" class=""><i class="fa fa-edit"></i> Editar</a></li> -->
            <li role="presentation" class="divider"></li>


            <!-- <li role="presentation bg-danger">
                <a role="menuitem" tabindex="-1" href="#">
                    <i class="fa fa-times"></i> Excluir
                </a>
            </li> -->

            {{ Form::open(array('url' => 'clientes/' . $cliente->id, 'class' => '')) }}
                <button type="submit" class="btn btn-danger btn-block btn-sm" onclick="return confirm('Excluir permanetenmente?')" role="menuitem">
                    <i class="fa fa-times"></i> Excluir
                </button>
                <input type="hidden" name="_method" value="DELETE">
            {{ Form::close() }}


          </ul>
        </div>

        <h3 class="panel-title title">CLIENTE</h3>

    </div>


    <div class="boxed contact light panel-body">


            <!-- <div class="title">
               <h3>CLIENTE</h3>
               <a href="#" class="share-contact">Share this contact</a>
            </div> -->

            <div class="row contact-data">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">

                    <div class="contact-avatar">
                        <img src="{{asset('img/avatar.png')}}" alt="" class="img-thumbnail img-responsive">
                    </div>


                    <!-- <div class="send-msg">
                        <div class="btn-group btn-group.btn-group-justified">

                        </div>
                    </div> -->

                </div>


                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                    <h2 class="title"><i class="fa fa-building-o"></i> {{$cliente->empresa}}</h2>
                    <h4 class="subtitle">{{$cliente->nome}}</h4>
                    <br>
                    <div class="row">
                        <ul class="details">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                @if ($cliente->telefone)
                                    <li class="">

                                            <i class="fa fa-phone"></i> {{$cliente->telefone}}

                                    </li>
                                @endif
                                @if ($cliente->celular)
                                    <li class="">

                                            <i class="fa fa-mobile"></i> {{$cliente->celular}}

                                    </li>
                                @endif
                                @if ($cliente->email)
                                    <li class=""><i class="fa fa-envelope"></i> {{$cliente->email}}</li>
                                @endif


                                @if ($cliente->ie)
                                    <li class=""><i class="fa text-right"></i><strong>IE:</strong> {{$cliente->ie}}</li>
                                @endif
                                @if ($cliente->cnpj)
                                    <li class=""><i class="fa text-right"></i><strong>CNPJ:</strong> {{$cliente->cnpj}}</li>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                @if ($cliente->endereco)
                                <li>
                                    <i class="fa fa-map-marker"></i>
                                    {{$cliente->endereco}}<br>

                                    @if ($cliente->bairro) Bairro {{$cliente->bairro}}<br> @endif

                                    {{$cliente->cidade}}-{{$cliente->uf}}<br>
                                    {{$cliente->cep}}
                                </li>
                            @endif
                            </div>


                        </ul>
                    </div>
                </div>

            </div>

    </div>


    <ul class="list-group status">
        <li class="status-group-item active col-md-4 col-lg-4 col-sm-4 col-xs-4" data-toggle="tab" data-target="#panel-pedidos">
            <a href="#panel-pedidos">
                <h2 class="title pull-left">{{count( $cliente->pedidos )}}</h2>
                <i class="fa fa-edit fa-2x"></i>
                <br>
                <span>Pedidos</span>
            </a>
        </li>
        <li class="status-group-item col-md-4 col-lg-4 col-sm-4 col-xs-4" data-toggle="tab" data-target="#panel-conversas">
            <a href="#panel-conversas" ng-controller="conversasController">
                <h2 class="title pull-left">@{{conversas.length}}</h2>
                <i class="fa fa-comments fa-2x"></i>
                <br>
                <span>Conversas</span>
            </a>
        </li>
        <li class="status-group-item col-md-4 col-lg-4 col-sm-4 col-xs-4" data-toggle="tab" data-target="#panel-tarefas">
            <a href="#panel-tarefas" ng-controller="tarefasController">
                <h2 class="title pull-left">@{{tarefas.length}}</h2>
                <i class="fa fa-check-square-o fa-2x"></i>
                <br>
                <span>Tarefas</span>
            </a>
        </li>        
    </ul>

</div>


<div class="clearfix"></div>


<div class="panel panel-primary tab-content">
    <div class="tab-pane" id="panel-pedidos">

        <div class="dropdown pull-right">
            <a href="{{url('pedidos/create',$cliente->id)}}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Novo pedido</a>
            </a>
            <a href="{{url('pedidos')}}" class="btn btn-primary btn-sm">
                <i class="fa fa-list"></i> Ver todos</a>
            </a>
        </div>
        <h2 class="title">Pedidos do cliente</h2>

        <hr>

        <!-- PEDIDOS -->
        <h4 class="title">{{count( $cliente->pedidos )}} pedidos</h4>
        <br>
        <div class="table-responsive">
            <table class="table" style="min-width:850px;">
                <thead>
                    <tr>
                        <th width="20">Nº</th>
                        <th width="80">Data</th>
                        <th>Cliente</th>
                        <th>Fornecedor</th>
                        <th width="120" align="right">Total</th>
                        <th width="" align="right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cliente->pedidos as $pedido)
                        <tr>
                            <!-- <td>
                                <i class="fa fa-circle fa-led {{( @$pedido->status == '2' ) ? 'success' : 'danger'}}"></i>
                            </td> -->
                            <td>{{$pedido->id}}</td>
                            <td>{{date("d/m", strtotime( $pedido->updated_at) )}}</td>
                            <td>
                                <a href="{{ url('/pedidos/'.$pedido->id) }}" >
                                    {{ ($pedido->cliente['empresa']) ? $pedido->cliente['empresa'] : @$pedido->cliente['nome'] }}
                                </a>
                            </td>
                            <td>{{($pedido->fornecedor->empresa)?$pedido->fornecedor->empresa: @$pedido->fornecedor->nome}}</td>
                            <td class="money">{{$pedido->total}}</td>
                            <td align="right">

                                    <div class="dropdown btn-group">
                                        <a href="{{ url('/emails/create/pedido/'.$pedido->id) }}" class="btn btn-primary btn-sm send" data-toggle="modal" data-target="#email">
                                           <i class="fa fa-envelope"></i>
                                        </a>
                                        <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" class="btn btn-primary btn-sm">
                                            Opções <span class="caret"></span>
                                        </a>


                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                            <li role="presentation">
                                                <a href="{{ url('/pedidos/'.$pedido->id) }}" role="menuitem" tabindex="-1" class="">
                                                   <i class="fa fa-chevron-right"></i> Ver
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="{{ url('/pedidos/'.$pedido->id.'/edit') }}" class="" role="menuitem" tabindex="-1" >
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                            </li>
                                            <li role="presentation" class="divider"></li>
                                            <!-- <li role="presentation">
                                                <a href="{{ url('/pedidos/send/'.$pedido->id) }}" role="menuitem" tabindex="-1" class="">
                                                   <i class="fa fa-envelope"></i> Enviar agora
                                                </a>
                                            </li> -->
                                            <li role="presentation">
                                                <a href="{{ url('/pedidos/preview/'.$pedido->id) }}" class="" role="menuitem" tabindex="-1" >
                                                    <i class="fa fa-eye"></i> Visualizar impressão
                                                </a>
                                            </li>
                                            <li role="presentation" class="divider"></li>
                                            <li role="presentation">
                                                {{ Form::open(array('url' => 'pedidos/' . $pedido->id, 'class' => '')) }}
                                                    {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger btn-block btn-sm', 'type'=>'sumbit', 'onclick'=>'javascript:return confirm("Deseja excluir este pedido da lista?")', 'role'=>"menuitem", 'tabindex'=>"-1" )) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::close() }}
                                            </li>

                                        </ul>


                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <?php // print_r($cliente->pedidos); exit; ?>
                </tbody>
            </table>

        </div>

   </div>


            <div class="tab-pane" id="panel-conversas"  ng-controller="conversasController">

                <div class="dropdown pull-right">
                  <button class="btn btn-success btn-sm" data-toggle="collapse" data-target="#add_conversa">
                    <i class="fa fa-plus"></i> Nova conversa</a>
                  </button>
                  <!-- <a href="#" class="btn btn-primary btn-sm">
                    <i class="fa fa-list"></i> Ver todas</a>
                  </a> -->
                </div>
                <h2 class="title">@{{conversas.length}} conversas</h2>


                <div class="collapse colapsed" id="add_conversa">
                    @include('conversas.panels.create')
                </div>

                <p class="text-center" ng-show="loading"><span class="fa fa-circle-o-notch fa-2x fa-spin text-info info"></span></p>


                 <table class="table table-hover">
                     <tbody>


                            @include('conversas.item')


                    </tbody>
                </table>



            </div>


            <div class="tab-pane" id="panel-tarefas" ng-controller="tarefasController">
                 <div class="dropdown pull-right">
                  <a href="{{url('tarefas/create?cliente_id='.$cliente->id)}}" class="btn btn-success btn-sm" data-toggle="collapse" data-target="#add_tarefa">
                    <i class="fa fa-plus"></i> Nova tarefa</a>
                  </a>

                </div>
                <h2 class="title">@{{tarefas.length}} tarefas</h2>


                <div class="collapse colapsed" id="add_tarefa">
                    {{--@include('tarefas.panels.create')--}}
                </div>

                <p class="text-center" ng-show="loading"><span class="fa fa-circle-o-notch fa-2x fa-spin text-info info"></span></p>


                 <table class="table table-hover">
                     <tbody>


                            @include('tarefas.item', array( 'tarefas' => $tarefas->getCollection() ))


                    </tbody>
                </table>
            </div>


            

        </div>


@section('scripts')
<script>
angular.module('apiService', [])
.factory('Conversa', function($http) {

    return {
        // get all the comments
        get : function() {
            return $http.get('<?php echo url("clientes/".$cliente->id."/conversas") ?>');
        },

        // save a comment (pass in comment data)
        save : function(conversaData) {

            return $http({
                method: 'POST',
                url: '<?php echo url("conversas") ?>',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(conversaData)
            });
        },

        // destroy a comment
        destroy : function(id) {
            console.log('<?php echo url("conversas") ?>/' + id);
            return $http.delete('<?php echo url("conversas") ?>/' + id);
        }
    }

})
.factory('Tarefa', function($http) {

    return {
        // get all the resources
        get : function() {
            return $http.get('<?php echo url("clientes/".$cliente->id."/tarefas") ?>');
        },

        // save a comment (pass in comment data)
        save : function(tarefaData) {

            return $http({
                method: 'POST',
                url: '<?php echo url("tarefas") ?>',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(tarefaData)
            });
        },

        check : function(id) {
            console.log(id);
            return $http.get('<?php echo url("tarefas") ?>/' + id + '/check' );
            // return $http({
            //     method: 'GET',
            //     url: '<?php echo url("tarefas") ?>/' + id + '/check',
            //     headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            //     data: $.param(id)
            // });
        },

        // destroy a comment
        destroy : function(id) {
            console.log('<?php echo url("tarefas") ?>/' + id);
            return $http.delete('<?php echo url("tarefas") ?>/' + id);
        }
    }

});


// public/js/controllers/mainCtrl.js
angular.module('mainCtrl', [])

    // inject the Comment service into our controller
    .controller('conversasController', function($scope, $http, Conversa, Tarefa, $filter) {
        // object to hold all the data for the new comment form
        $scope.conversaData             = {};
        $scope.conversaData.cliente_id  = "<?php echo $cliente->id ?>";
        $scope.conversaData.tarefa      = $filter("date")( $scope.conversaData.tarefa, 'yyyy-MM-dd');

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        // get all the comments first and bind it to the $scope.conversas object
        // use the function we created in our service
        // GET ALL COMMENTS ====================================================
        $scope.getConversas = function(){
            Conversa.get()
                .success(function(data) {

                    var length = data.length;

                   for (var i=0; i<length; i++) {
                      //data[i].created_at = moment( data[i].created_at );
                      data[i].created_at = moment( data[i].created_at ).day();
                   }


                  //  console.log(data);

                    $scope.conversas = data;
                    $scope.loading = false;
                });
        };
        $scope.getConversas();        

        // function to handle submitting the form
        // SAVE A CONVERSA ======================================================
        $scope.submitConversa = function() {
            $scope.loading = true;

            // save the Conversa. pass in comment data from the form
            // use the function we created in our service
            Conversa.save($scope.conversaData)
                .success(function(data) {

                    // if successful, we'll need to refresh the comment list
                    $scope.getConversas();
                    // Conversa.get()
                    //     .success(function(getData) {
                    //         $scope.conversas = getData;
                    //         $scope.loading = false;
                    //     });

                })
                .error(function(data) {
                    console.log(data);
                });
        };

        // function to handle deleting a conversa
        // DELETE A CONVERSA ====================================================
        $scope.deleteConversa = function(id) {
            $scope.loading = true;

            // use the function we created in our service
            Conversa.destroy(id)
                .success(function(data) {
                    // if successful, we'll need to refresh the comment list
                    $scope.getConversas();
                    // Conversa.get()
                    //     .success(function(getData) {
                    //         $scope.conversas = getData;
                    //         $scope.loading = false;
                    //     });

                })
                .error(function(data) {
                    alert(data);
                    console.log(data);
                });
        };

    })

    // inject the Comment service into our controller
    .controller('tarefasController', function($scope, $http, $location, Tarefa) {
        // object to hold all the data for the new comment form
        $scope.tarefaData             = {};
        $scope.tarefaData.cliente_id  = "<?php echo $cliente->id ?>";

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        // get all the comments first and bind it to the $scope.tarefas object
        // use the function we created in our service
        // GET ALL COMMENTS ====================================================
        $scope.getTarefas = function(){
            Tarefa.get()
                .success(function(data) {

                    var length = data.length;

                   for (var i=0; i<length; i++) {
                      //data[i].created_at = moment( data[i].created_at );
                      data[i].created_at = moment( data[i].created_at ).day();
                   }


                  //  console.log(data);

                    $scope.tarefas = data;
                    $scope.loading = false;
                });
        };
        $scope.getTarefas();

        // function to handle submitting the form
        // SAVE A CONVERSA ======================================================
        $scope.submitTarefa = function() {
            $scope.loading = true;

            // save the Tarefa. pass in comment data from the form
            // use the function we created in our service
            Tarefa.save($scope.tarefaData)
                .success(function(data) {

                    // if successful, we'll need to refresh the comment list
                    $scope.getTarefas();

                })
                .error(function(data) {
                    console.log(data);
                });
        };


        // function to handle submitting the form
        // SAVE A CONVERSA ======================================================
        $scope.checkTarefa = function(id) {
            $scope.loading = true;

            // save the Tarefa. pass in comment data from the form
            // use the function we created in our service
            Tarefa.check(id)
                .success(function(data) {
                    console.log(data);
                    // if successful, we'll need to refresh the comment list
                    $scope.getTarefas();

                })
                .error(function(data) {
                    console.log(data);
                });
        };

        // function to handle deleting a tarefa
        // DELETE A CONVERSA ====================================================
        $scope.deleteTarefa = function(id) {
            $scope.loading = true;

            // use the function we created in our service
            Tarefa.destroy(id)
                .success(function(data) {
                    // if successful, we'll need to refresh the comment list
                    $scope.getTarefas();

                })
                .error(function(data) {
                    alert(data);
                    console.log(data);
                });
        };


        $scope.openTarefa = function(id){
            window.location = '<?php echo url("tarefas") ?>/'+id;            
        }

    });






(function($) {
    var mainApp = angular.module('mainApp', ['mainCtrl', 'apiService']);
    //var mainApp = angular.module('mainApp', ['tarefasCtrl', 'tarefasService']);


    /**
     *  AJAX
     */
    // $('#quick_add').on('submit',function(e){

    //     e.preventDefault();

    //     var request = $.ajax({
    //       url: $(this).attr('action'),
    //       type: $(this).attr('method'),
    //       data: $(this).serialize(),
    //       dataType: "json"
    //     });


    //     request.done(function( msg ) {

    //         $.each( msg, function(i, item) {
    //             console.log(item);
    //             //  var clienteItem =   '<a href="tarefas/'+item.id+'" class="list-group-item">'
    //             //                     +'    <span class="pull-left cliente-avatar" style="background-color:#3bafda">'
    //             //                     +'        <img src="img/avatar-small.png" alt="">'
    //             //                     +'    </span>'
    //             //                     +'    <div class="search-data">'
    //             //                     +'        <strong class="list-group-item-heading">'+item.nome+'</strong><br>'
    //             //                     +'        <strong>'+item.empresa+'</strong><br>'
    //             //                     +'        <i class="fa fa-map-marker"></i> '+item.cidade+' - '+item.uf+' | '
    //             //                     +'        <i class="fa fa-phone"></i> '+item.telefone+'|'
    //             //                     +'        <i class="fa fa-mobile"></i> '+item.celular+' '
    //             //                     +'    </div>'
    //             //                     +'</a>';

    //             // $( clienteItem ).appendTo( $('.list-tarefas') );
    //         });

    //         //tarefas_list.slideDown('slow');
    //     });

    //     request.fail(function( jqXHR, textStatus ) {
    //        console.log( "Request failed: " + textStatus );
    //     });
    // });

})(jQuery);
</script>
@stop