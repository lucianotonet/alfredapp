@extends('layouts.master')


@section('content')

<div class="container">
	<div class="panel panel-primary">
    
	    <!-- Default panel contents -->
	    <div class="panel-heading">
	        <div class="btn-group pull-left">
	            <h3 class="title">Editar produto</h3>            
	        </div>       
	    </div>
	    
	  
	    @include('produtos.panels.edit')

    </div>
</div>
    
@stop