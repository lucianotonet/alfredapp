@extends('layouts.master')

@section('styles')
<!-- <link rel="stylesheet" href="{{asset('css/contacts.css')}}"> -->
@stop

@section('content')

    <div class="container">        

        {{-- @include('clientes.panels.show') --}}

        @include('clientes.panels.details')

    </div>

@stop