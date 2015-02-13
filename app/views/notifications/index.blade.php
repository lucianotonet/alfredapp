@extends('layouts.master')

@section('content')
    <div class="container">

        <div class="panel panel-primary" id="notifications">

            <div class="panel-heading">
                <div class="pull-right">
                    <a class="btn btn-success btn-sm" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>                    
                </div>
                <h3 class="panel-title title"><i class="icon-bell-o"></i> NOTIFICAÇÕES</h3>
            </div>        
            
            @include('notifications.panels.index')                

        </div>
    
    </div>
@stop


@section('styles')

@stop


@section('scripts')

@stop