@extends('layouts.master')

@section('content')

    <div class="container">        
		<div class="list-group-item">
        	@include('notifications.item')
		</div>
    </div>

@stop