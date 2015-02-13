@extends('layouts.master')

@section('content')

    <div class="container">        

        @include('relatorios.'.$relatorio->type.'.edit')

    </div>

@stop