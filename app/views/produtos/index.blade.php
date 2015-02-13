@extends('layouts.master')


@section('content')

<div class="container">
        @include('produtos.panels.index')

        @include('categories.panels.index')
</div>

@stop