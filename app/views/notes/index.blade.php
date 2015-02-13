@extends('layouts.master')

@section('content')

    <div class="container">   

        <div class="panel panel-primary">        
            <div class="panel-heading">
                <a href="notes/create"  data-toggle="modal" data-target="#modal" class="btn btn-success btn-sm pull-right">
                    <i class="fa fa-plus"></i>
                    Nova
                </a>
                <h3 class="title">
                    <i class="icon-edit"></i>
                    NOTAS
                </h3>
            </div>
            
            <div class="list-group">
                @foreach ($notes as $note)
                    
                    @include('notes.panels.item')

                @endforeach
            </div>

        </div>

    </div>

@stop