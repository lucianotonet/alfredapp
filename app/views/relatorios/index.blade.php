@extends('layouts.master')

@section('content')

<div class="container">        

	<!-- Breadcrumbs -->
	<ol class="breadcrumb breadcrumb-arrow hidden-print">
		<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
		<li class="active"><span>Relatórios</span></li>	
	</ol>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<a href="{{url('relatorios/create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Novo</a>					
			<h3 class="panel-title title">Relatórios</h3>
		</div>
	


		<ul class="nav nav-tabs" role="tablist">
      		<li class="active">
                <a href="#despesas" role="tab" data-toggle="tab">                	            	
                    <strong><span class="icon-wallet"></span> DESPESAS</strong>
                </a>
            </li>
            <li class="">
                <a href="#conversas" role="tab" data-toggle="tab">
                    <strong><span class="icon-chat"></span> CONVERSAS</strong>
                </a>
            </li>        	            
        </ul>

        <div class="tab-content">


	        <!-- TAB PANE -->
	        <div class="tab-pane active" id="despesas">	        	
					
				@if ( isset( $relatorios->despesas ) )					
		        	<div class="panel-body">
		        		<a href="{{url('/relatorios/create/despesas')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Novo</a>
			        	<h3 class="title">
			        		{{count(@$relatorios->despesas)}} relatórios de despesa
			        	</h3>
		        	</div>

					@foreach ( $relatorios->despesas as $relatorio )
					<div class="list-group-item">
						<div class="pull-right">
							<a href="#" class="btn btn-sm btn-link">Left</a>
							<a href="#" class="btn btn-sm btn-link">Middle</a>
							<a href="#" class="btn btn-sm btn-link">Right</a>
						</div>
						<a href="{{url('relatorios',$relatorio->id)}}" class="">
							
							
							@if( count( @$relatorio->emails() ) )
								<i class="fa fa-check text-success"></i>
							@else
								<i class="fa fa-circle text-danger"></i>
							@endif
							Relatório Nº{{$relatorio->id}} - {{date('d/m/Y',strtotime($relatorio->updated_at))}}
						</a>
					</div>
					@endforeach		  

				@else

					<div class="panel-body text-center">
			        	<h2 class="title">
			        		Nenhum relatório de despesa
			        	</h2>
		        		<a href="{{url('/relatorios/create/despesas')}}" class="btn btn-success btn-lg"><i class="fa fa-plus"></i> Novo relatório</a>
		        	</div>   

				@endif
	        </div>

	        <!-- TAB PANE -->
	        <div class="tab-pane" id="conversas">

	        	@if ( isset( $relatorios->coversas ) )
		        	<div class="panel-body">
		        		<a href="{{url('/relatorios/create/conversas')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Novo</a>	        		
			        	<h3 class="title">
			        		{{ count(@$relatorios->conversas) }} relatórios de conversa
			        	</h3>
		        	</div>
		            @foreach ($relatorios->conversas as $relatorio)
						<a href="{{url('relatorios',$relatorio->id)}}" class="list-group-item">
							<small class="pull-right">{{date('d/m/Y',strtotime($relatorio->updated_at))}}</small>
							<i class="icon-file-pdf text-muted"></i> Relatório Nº{{$relatorio->id}} - {{ ucfirst( $relatorio->type ) }}
						</a>
					@endforeach	

				@else

					<div class="panel-body text-center">
			        	<h2 class="title">
			        		Nenhum relatório de conversas
			        	</h2>
		        		<a href="{{url('/relatorios/create/conversas')}}" class="btn btn-success btn-lg"><i class="fa fa-plus"></i> Novo relatório</a>
		        	</div>   

				@endif

	        </div>
	        
	    </div>
			
		
	</div>
</div>

@stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$("#selectr").selecter();

			if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
		    return $('a[data-toggle="tab"]').on('shown', function(e) {
		      return location.hash = $(e.target).attr('href').substr(1);
		    });

		});
	</script>
@stop