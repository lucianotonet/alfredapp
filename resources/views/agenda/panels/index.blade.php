<?php use Carbon\Carbon as Carbon;	
if( count( $events ) ){ ?>                    
        @foreach ( $events as $key => $value )
            <div class="list-group-item disabled">
                <span class="text-uppercase">
                    <?php $dt = new Carbon( $key ); ?>
                    <?php 
                        if( $dt->isToday() ){
                            echo "<strong>hoje</strong>, " . strftime("%A %d de %B", strtotime( $key ));
                        }else
                        if( $dt->isTomorrow() ){
                            echo "<strong>amanhã</strong>, " . strftime("%A %d de %B", strtotime( $key ));
                        }else
                        if( $dt->isYesterday() ){
                            echo "<strong>ontem</strong>, " . strftime("%A %d de %B", strtotime( $key ));
                        }else{
                            echo strftime("%A, %d de %B", strtotime( $key ));
                        }
                    ?>
                </span>
            </div>
            @foreach ( $value as $event )

                <?php if( "Tarefa" == get_class( $event ) ){ ?>
                    @include('tarefas.panels.item',array('tarefa'=>$event))
                <?php }else{ ?>
                    @include('agendaevents.item')
                <?php } ?>                

            @endforeach
        @endforeach

    <?php }else{ ?>
        <div class="well text-center">                    
            <h2>Nada agendado para <br/><strong>{{ $labels['title'] }}</strong></h2>
            <p>
                Adicione um novo evento ou tarefa:<br/>                            
                <a href="{{ url( 'agenda/create/' ) }}" class="btn btn-success" data-toggle="modal" data-target="#modal">
                    <i class="icon-circle-plus"></i>                        
                    Adicionar
                </a>                    
            </p>    
        </div>
    <?php } ?>

</table>
</div>