@extends('layouts.master')


@section('content')

<div class="container">  

	<!-- Breadcrumbs -->
    <ol class="breadcrumb breadcrumb-arrow hidden-print">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
        <li class="active"><span>Pedidos</span></li>              
    </ol>

    @include('pedidos.panels.index')
           
</div>
    
@stop