@extends('layouts.master')

@section('content')

    <div class="container">        

        @include('transactions.panels.edit')

    </div>

@stop

@section('scripts')	
	<script src="{{ asset('js/transactions.js') }}" ></script>	
	<link href="{{ asset('css/transactions.css') }}" media="all" type="text/css" rel="stylesheet">
@stop