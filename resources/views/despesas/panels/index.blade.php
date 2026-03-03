<div class="container" ng-app="mainApp">

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

                    <form name="despesasForm" ng-submit="submitDespesa()">
        
                      <div class="panel panel-default">
                          <div class="panel-body form-horizontal payment-form bg-info">
                              
                              <div class="form-group">
                                  <label for="valor" class="col-sm-3 control-label input-lg">R$</label>
                                  <div class="col-sm-9">
                                      <input type="number" class="input-despesa form-control input-lg" id="valor" name="valor" min="0.00" step="0.01" ng-model="despesaData.valor" value="@{{despesaData.valor}}" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="description" class="col-sm-3 control-label">Descrição</label>
                                  <div class="col-sm-9">
                                      <input type="text" ng-model="despesaData.descricao" value="@{{despesaData.descricao}}" class="input-despesa form-control" id="descricao" name="descricao">
                                  </div>
                              </div>                            
                              <div class="form-group">
                                  <label for="description" class="col-sm-3 control-label">Cidade</label>
                                  <div class="col-sm-9">
                                      <input type="text" class="input-despesa form-control" id="cidade" name="cidade" ng-model="despesaData.cidade" value="@{{despesaData.cidade}}">
                                  </div>
                              </div> 
                              <div class="form-group">
                                  <label for="date" class="col-sm-3 control-label">Data</label>
                                  <div class="col-sm-9">                                  
                                
                                      <input type="date" class="form-control" ng-model="despesaData.date" value="@{{ despesaData.date | date: yyyy-MM-dd }}"/>
                                      <!-- <small class="error" ng-show="despesasForm.date.$error.required">
                                        <i class="fa fa-arrow-top"></i> Obrigatório
                                      </small>
                                      <small class="error" ng-show="despesasForm.date.$error.date">
                                        <i class="fa fa-warning"></i> Data inválida
                                      </small>   -->                              
      
                                  </div>

                              </div>   


                              <div class="form-group">
                                  <div class="col-sm-12 text-right">

                                      <button type="submit" class="btn btn-default despesa_add">
                                          <span class="glyphicon glyphicon-plus"></span> Adicionar
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>   

                    </form>         

                </div> <!-- / panel preview -->

                <div class="col-sm-7">                    
                    <h4 class="title">PREVIEW:</h4>                   
                    <small>@{{despesas.length}} não enviadas</small>

                    {{-- Form::open(array('url' => 'relatorios', 'id' => 'relatorio_create')) --}}
                    <form name="despesasForm" ng-submit="submitRelatorio()">
                        <div class="row">
                            <div class="col-xs-12">


                                    <div class="table-responsive">
                                        <table class="table preview-table">
                                            <thead>
                                                <tr>
                                                    <th width="100">Data</th>
                                                    <th width="170">Cidade</th>
                                                    <th>Descrição</th>
                                                    <th width="120" class="text-right">Valor</th>
                                                    <th width="30"></th>                                            
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                              <tr ng-repeat="despesa in despesas">
                                                <td>@{{despesa.date}}</td>
                                                <td>@{{despesa.cidade}}</td>
                                                <td>@{{despesa.descricao}}</td>
                                                <td class="text-right">R$ @{{despesa.valor}}</td>
                                                <td><span class="glyphicon glyphicon-remove pull-right" ng-click="deleteDespesa( despesa.id )"></span></td>
                                              </tr>

                                            </tbody> <!-- preview content goes here-->
                                        </table>
                                    </div>                            
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="col-xs-12">
                                <br>
                                <h4>Total R$ <strong class="preview-total">@{{total}}</strong></h4>
                                <input type="hidden" name="total" value="" id="total" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr style="border:1px dashed #dddddd;">
                                <button type="submit" class="btn btn-primary btn-block despesa-fechar">FECHAR E ENVIAR</button>
                            </div>                
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


</div>



@section('scripts')
<script>
//(function($) {
    var mainApp = angular.module('mainApp', ['mainCtrl', 'apiService']);
//})(jQuery);

angular.module('apiService', [])

.factory('despesa', function($http) {

    return {
        // get all the despesas
        get : function() {
            return $http.get('<?php echo url("despesas") ?>');
        },

        // save a despesa (pass in despesa data)
        save : function(despesaData) {

            return $http({
                method: 'POST',
                url: '<?php echo url("despesas") ?>',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(despesaData)
            });
        },

        // destroy a despesa
        destroy : function(id) {
            console.log('<?php echo url("despesas") ?>/' + id);
            return $http.delete('<?php echo url("despesas") ?>/' + id);
        },
    }

})
.factory('relatorio', function($http) {

    return {
        // get all the despesas
        get : function() {
            return $http.get('<?php echo url("relatorios") ?>');
        },

        // save a despesa (pass in despesa data)
        save : function(relatorioData) {

            return $http({
                method: 'POST',
                url: '<?php echo url("relatorios") ?>',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(relatorioData)
            });
        },

        // destroy a relatorio
        destroy : function(id) {
            console.log('<?php echo url("relatorios") ?>/' + id);
            return $http.delete('<?php echo url("relatorios") ?>/' + id);
        },
    }

});


// public/js/controllers/mainCtrl.js
angular.module('mainCtrl', [])
    
     // inject the despesa service into our controller
    .controller('despesasController', function($scope, $http, relatorio, despesa, $filter) {
        // object to hold all the data for the new despesa form
        $scope.despesaData             = {};
        $scope.relatorioData           = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        $scope.despesaData.date  = $filter("date")(Date.now(), 'yyyy-MM-dd');//new Date();// Date();Date();
        

        // get all the despesas first and bind it to the $scope.despesas object
        // use the function we created in our service
        // GET ALL despesaS ====================================================

        $scope.getDespesas = function(){
          despesa.get()
            .success(function(data) {
                //console.log(data);

                var length       = data.length;              
                $scope.despesas  = data;                


                var total = 0.00;
                for (var i = length - 1; i >= 0; i--) {
                    // SOMA O TOTAL   
                    valor = $scope.despesas[i].valor;                    
                    valor = valor.replace(".", "");
                    valor = valor.replace(",", ".");               


                    total += parseFloat(valor);
                    //total += parseFloat( $scope.despesas[i].valor.replace(",", "") );                    
                }; 
                //$scope.total    = 'R$ ' + parseFloat( total );

                total        = $filter('number')(total,2);
                //total        = total.replace(",", ".").replace(".", ",");
                //total        = total; 
                total        = total;
                $scope.total = total;

                console.log(total);
                //console.log($scope.total);
                $scope.loading  = false;

            });
        }
        $scope.getDespesas();

        // function to handle submitting the form
        // SAVE A despesa ======================================================
        $scope.submitDespesa = function() {
            $scope.loading = true;

            $scope.despesaData.date = $filter("date")( $scope.despesaData.date, 'yyyy-MM-dd');
            //console.log($scope.despesaData);

            // save the despesa. pass in despesa data from the form
            // use the function we created in our service
            despesa.save($scope.despesaData)
                .success(function(data) {

                    // if successful, we'll need to refresh the despesa list
                    $scope.getDespesas();

                })
                .error(function(data) {
                    console.log(data);
                });
        };

        // function to handle deleting a despesa
        // DELETE A despesa ====================================================
        $scope.deleteDespesa = function(id) {
            $scope.loading = true;

            // use the function we created in our service
            despesa.destroy(id)
                .success(function(data) {
                    // if successful, we'll need to refresh the despesa list
                    $scope.getDespesas();
                    

                })
                .error(function(data) {                    
                    console.log(data);
                });
        };



        $scope.getRelatorios = function(){
          relatorio.get()
            .success(function(data) {
                //console.log(data);

                var length       = data.length;              
                $scope.relatorios  = data;                


                //var total = 0;
                for (var i = length - 1; i >= 0; i--) {
                    // SOMA O TOTAL                    
                    
                }; 
                //$scope.total    = 'R$ ' + parseFloat( total );
                //$scope.total    = total;//$filter('number')(total,2);
//                console.log($scope.total);
                $scope.loading  = false;

            });
        }
        $scope.getRelatorios();

        $scope.submitRelatorio = function() {
            $scope.loading = true;

            //console.log($scope.relatorioData);

            // save the relatorio. pass in relatorio data from the form
            // use the function we created in our service
            relatorio.save($scope.relatorioData)
                .success(function(data) {

                    console.log(data);

                    // if successful, we'll need to refresh the relatorio list
                    $scope.getDespesas();
                    $scope.getRelatorios();



                    //Envia por email
                     // $('#email').modal({
                     //               keyboard: true,
                     //               remote:   "<?php echo url('/relatorios/3') ?>"
                     //             });

                })
                .error(function(data) {
                    console.log(data);
                });
        };



    })
    
    // inject the despesa service into our controller
    // .controller('relatoriosController', function($scope, $http, relatorio, $filter) {
    //     // object to hold all the data for the new relatorio form
    //     $scope.relatorioData             = {};        

    //     // loading variable to show the spinning loading icon
    //     $scope.loading = true;

    //     $scope.relatorioData.crated_at  = $filter("date")(Date.now(), 'yyyy-MM-dd');//new Date();// Date();Date();
        

    //     // get all the relatorios first and bind it to the $scope.relatorios object
    //     // use the function we created in our service
    //     // GET ALL relatorioS ====================================================

    //     $scope.getRelatorios = function(){
    //       relatorio.get()
    //         .success(function(data) {
    //             //console.log(data);

    //             var length       = data.length;              
    //             $scope.relatorios  = data;                


    //             var total = 0;
    //             for (var i = length - 1; i >= 0; i--) {
    //                 // SOMA O TOTAL                    
                    
    //             }; 
    //             //$scope.total    = 'R$ ' + parseFloat( total );
    //             $scope.total    = total;//$filter('number')(total,2);
    //             console.log($scope.total);
    //             $scope.loading  = false;

    //         });
    //     }
    //     $scope.getRelatorios();

    //     // function to handle submitting the form
    //     // SAVE A relatorio ======================================================
    //     // $scope.submitRelatorio = function() {
    //     //     $scope.loading = true;

    //     //     $scope.relatorioData.date = $filter("date")( $scope.relatorioData.date, 'yyyy-MM-dd');
    //     //     //console.log($scope.relatorioData);

    //     //     // save the relatorio. pass in relatorio data from the form
    //     //     // use the function we created in our service
    //     //     relatorio.save($scope.relatorioData)
    //     //         .success(function(data) {

    //     //             // if successful, we'll need to refresh the relatorio list
    //     //             $scope.getRelatorios();

    //     //         })
    //     //         .error(function(data) {
    //     //             console.log(data);
    //     //         });
    //     // };

    //     // function to handle deleting a relatorio
    //     // DELETE A relatorio ====================================================
    //     $scope.deleteRelatorio = function(id) {
    //         $scope.loading = true;

    //         // use the function we created in our service
    //         relatorio.destroy(id)
    //             .success(function(data) {
    //                 // if successful, we'll need to refresh the relatorio list
    //                 $scope.getRelatorios();

    //             })
    //             .error(function(data) {                    
    //                 console.log(data);
    //             });
    //     };


    //     // $scope.submitRelatorio = function() {
    //     //     $scope.loading = true;

    //     //     //console.log($scope.relatorioData);

    //     //     // save the relatorio. pass in relatorio data from the form
    //     //     // use the function we created in our service
    //     //     relatorio.save($scope.relatorioData)
    //     //         .success(function(data) {

    //     //             // if successful, we'll need to refresh the relatorio list
    //     //             $scope.getDespesas();

    //     //             //Envia por email
    //     //             // $('#email').modal({
    //     //             //               keyboard: true,
    //     //             //               remote:   "<?php echo url('emails/create/relatorio/1') ?>"
    //     //             //             });

    //     //         })
    //     //         .error(function(data) {
    //     //             console.log(data);
    //     //         });
    //     // };

    // });
</script>
@stop