<li class="list-group-item" ng-repeat="tarefa in tarefas" ng-hide="loading" >
    <div class="row">    
    
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div ng-if="1 != tarefa.done">
                <input type="checkbox" style="width:20px; height:20px; margin-right:20px;" class="pull-left form-control" name="done" id="checkbox"  ng-model="checked" ng-init="checked=false" ng-click="checkTarefa(tarefa.id)">                
            </div>
            <div ng-if="1 == tarefa.done">
                <input type="checkbox" style="width:20px; height:20px; margin-right:20px;" class="pull-left form-control" name="done" id="checkbox"  ng-model="checked" ng-init="checked=true" ng-click="checkTarefa(tarefa.id)">                
            </div>
                
            <p class="form-control-static" ng-if="1 != tarefa.done" ng-click="openTarefa(tarefa.id)" style="font-weight:300;" >@{{tarefa.title}}</p>
            <p class="form-control-static" ng-if="1 == tarefa.done" ng-click="openTarefa(tarefa.id)" style="text-decoration:line-through !important; font-weight:300;" >@{{tarefa.title}}</p>
        </div>   
        

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <div class="btn-group btn-group-sm pull-right">
                
                
                <a class="close" ng-click="deleteTarefa(tarefa.id)">
                    &times;
                </a>
            </div>
            
        </div>
        

    </div>
</li> 