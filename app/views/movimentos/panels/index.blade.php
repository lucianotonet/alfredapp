 <div class="panel panel-primary">
    <div class="panel-heading">
        <a href="{{ url('/movimentos/create') }}" class="btn btn-primary btn-sm send pull-right" > <!-- data-toggle="modal" data-target="#modal" -->
           <i class="fa fa-plus"></i>
        </a> 
        <h3 class="panel-title title">MOVIMENTAÇÕES</h3>
    </div>            
    <div class="list-group" id="movimentos">              
            
        <?php if( count($movimentos->hoje) ){  ?>

                <a class="list-group-item list-group-item-<?php if($movimentos->hoje->total > 0){echo 'success';} ?>" data-toggle="collapse" data-parent="#movimentos" href="#movimento_hoje">                    
                    <h3 class="title pull-right">
                        R$ {{$movimentos->hoje->total}}
                    </h3>
                    <h3 class="title">
                        HOJE
                    </h3>
                </a>

                <div id="movimento_hoje" class="panel-collapse collapse collapsed"> 

                    @foreach ($movimentos->hoje as $movimento)    

                        <a class="list-group-item" data-toggle="collapse" data-parent="#movimentos" href="#movimento_{{$movimento->id}}">
                            <h4 class="title pull-right <?php echo ( $movimento->status == "0") ? 'danger' : '' ?>">
                                R$ {{$movimento->valor}}
                            </h4> 
                            <h4 class="title">
                                <i class="fa fa-level-<?php echo ( $movimento->valor < 0 ) ? 'down' : 'up' ?>"></i>{{--$movimento->data--}}
                            </h4>
                        </a>

                        <div id="movimento_{{$movimento->id}}" class="panel-collapse collapse collapsed bg-<?php echo ( $movimento->status == "0") ? 'danger' : 'success' ?>"> 

                            <div class="panel-body">
                                <p>{{$movimento->desc}}</p>
                               
                            
                                <div class="clearfix"></div>
                            </div>
                            
                        </div>


                    @endforeach
        
            </div>

        <?php } ?>


        <?php if( count($movimentos->ontem) ){  ?>

                <a class="list-group-item list-group-item-<?php echo($movimentos->ontem->total <= 0) ? 'danger' : 'success'; ?>" data-toggle="collapse" data-parent="#movimentos" href="#movimento_ontem">                    
                    <h3 class="title pull-right">
                        R$ {{$movimentos->ontem->total}}
                    </h3>
                    <h3 class="title">
                        ontem
                    </h3>
                </a>

                <div id="movimento_ontem" class="panel-collapse collapse collapsed"> 

                    @foreach ($movimentos->ontem as $movimento)    

                        <a class="list-group-item" data-toggle="collapse" data-parent="#movimentos" href="#movimento_{{$movimento->id}}">
                            <h4 class="title pull-right <?php echo ( $movimento->status == "0") ? 'danger' : '' ?>">
                                R$ {{$movimento->valor}}
                            </h4> 
                            <h4 class="title">
                                <i class="fa fa-level-<?php echo ( $movimento->valor < 0 ) ? 'down' : 'up' ?>"></i>{{--$movimento->data--}}
                            </h4>
                        </a>

                        <div id="movimento_{{$movimento->id}}" class="panel-collapse collapse collapsed bg-<?php echo ( $movimento->status == "0") ? 'danger' : 'success' ?>"> 

                            <div class="panel-body">
                                <p>{{$movimento->desc}}</p>
                               
                            
                                <div class="clearfix"></div>
                            </div>
                            
                        </div>


                    @endforeach
        
            </div>

        <?php } ?>
        
    </div>        

</div>