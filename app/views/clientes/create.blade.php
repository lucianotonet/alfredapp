@extends('layouts.master')

@section('content')

    <div class="container">
    
        @include('clientes.panels.create')
        
    </div>

@stop       

@section('scripts')

	<script> 
	    $(document).ready(function() {			
		});
	</script> 

@stop