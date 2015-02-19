@include('conversas.panels.create')
<div class="panel panel-primary">
    <div class="panel-heading">
        <a class="btn btn-success pull-right" data-toggle="modal" href='#conversas_create'><i class="fa fa-plus"></i> Nova conversa</a>
        <h3 class="panel-title title">CONVERSAS DO CLIENTE</h3>
    </div>        

    <div class="list-group">
        @foreach ($conversas as $conversa)
            @include('conversas.panels.item')
        @endforeach
    </div>

    <div class="panel-footer">
        
    </div>
</div>