<div href="#" class="list-group-item">
           
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
        <span>{{date('d \d\e F', strtotime( $note->created_at ) )}}</span><br>
        <small><i class="icon-clock"></i> {{date('H:i', strtotime( $note->created_at ) )}}</small>
    </div>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">                                
        {{$note->note}}
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right">                                
        {{ Form::open(array('url' => 'notes/' . $note->id, 'class' => '')) }}                             
            <button type="submit" class="close pull-right" data-dismiss="modal" onclick="javascript:return confirm('Deseja mesmo excluir esta nota?')">
                <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
            </button>                            
            {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::close() }}
        
    </div>

    <div class="clearfix"></div>

</div>