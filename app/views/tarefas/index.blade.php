@extends('layouts.master')

@section('content')
     
    <?php   
        use Faker\Factory as Faker;
        $faker = Faker::create('pt_BR');
    ?>            
        

    <div class="container">    
		<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="{{url('tarefas/create')}}" class="pull-right btn btn-success">
					<i class="fa fa-plus"></i> Adicionar
				</a>
				<h3 class="panel-title title">Tarefas</h3>
			</div>
        
        	@include('tarefas.panels.index')
    
		</div>

    </div>
        
@stop