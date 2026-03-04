<div class="row">
            <div class="col col-md-6">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        
                        <div class="panel status panel-danger animated bounce visible" data-animation="bounce" data-animation-delay="300">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">25</h1>
                            </div>
                            <div class="panel-body text-center">                        
                                <strong>Atrasadas</strong>
                            </div>
                        </div>

                    </div>          
                    <div class="col-xs-6 col-md-4">
                      
                        <div class="panel status panel-warning animated bounce visible infinite" data-animation="bounce" data-animation-delay="600">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">17</h1>
                            </div>
                            <div class="panel-body text-center">                        
                                <strong>Pra hoje</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6 col-md-4">
                       
                        <div class="panel status panel-info animated bounce visible" data-animation="bounce" data-animation-delay="900">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">+2</h1>
                            </div>
                            <div class="panel-body text-center">                        
                                <strong>Essa semana</strong>
                            </div>
                        </div>

                     
                    </div>
                    <!-- <div class="col-xs-6 col-md-3">
                      
                        <div class="panel status panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">18</h1>
                            </div>
                            <div class="panel-body text-center">                        
                                <strong>Pendentes</strong>
                            </div>
                        </div>

                     
                    </div> -->
                </div>
           
                
                <div class="panel panel-info tarefas-index">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title">HOJE</h3>
                    </div>    
                    
                    <div class="input-group input-group-lg search">
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="button">
                                <i class="fa fa-search fa-fw"></i>
                            </button>
                        </span>
                        <input class="form-control input-lg" type="text" placeholder="Procurar..." autofocus>
                    </div>          

                    <div class="list-group">
                        @foreach($tarefas as $tarefa)
                            <a class="list-group-item {{ $tarefa->done ? 'disabled' : '' }}">
                                {{ Form::open() }}
                                    <i class="pull-left">
                                        <input type="checkbox" class="info" name="done" id="tarefa-{{ $tarefa->id }}" {{ $tarefa->done ? 'checked' : '' }} >
                                    </i>
                                    
                                    <label for="tarefa-{{ $tarefa->id }}" style="{{ $tarefa->done ? 'text-decoration: line-through;' : '' }}">{{ $tarefa->nome }}</label>

                                    <i class="fa fa-chevron-right text-info pull-right"></i>

                                    <input type="hidden" name="id" value="{{ $tarefa->id }}">
                                {{ Form::close() }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        

            <div class="col-md-6">
                
                <div class="panel panel-danger tarefas-index">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title">ATRASADAS</h3>
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
                                        <input type="checkbox" class="green" name="done" id="tarefa-{{ $tarefa->id }}"  {{ $tarefa->done ? 'checked' : '' }} />
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
           
        </div>   
    </div>
    