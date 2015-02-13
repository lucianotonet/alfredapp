@extends('layouts.master')

@section('content')

<div class="container">   

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="title">
				<div class="pull-right">{{date('d/m/Y',strtotime($relatorio->updated_at))}}</div>
				Relatório nº {{$relatorio->id}} 
			</h3>
		</div>


		<!-- RELATÓRIO DE DESPESAS -->
		@if ( count($relatorio->despesas) > 0 )

		<div class="panel-body">    	
			<h3 class="title">
				Relatório de despesas
			</h3>

			<hr>
				

            <div class="table-responsive">
                <table class="table preview-table">
                    <thead>
                        <tr>
                            <th width="100">Data</th>
                            <th width="170">Cidade</th>
                            <th>Descrição</th>
                            <th width="120" class="text-right">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                       	                          
						@foreach ($relatorio->despesas as $despesa)							
							@include('despesas.panels.item', $despesa)				        	
						@endforeach

                    </tbody> <!-- preview content goes here-->
                </table>
            </div>         
            <div class="row text-right">
                <div class="col-xs-12">
                    <br>
                    <h4>Total <strong><span class="preview-total money" style="font-size:1.2em;">{{$relatorio->total}}</span></strong></h4>
                    <input type="hidden" name="total" value="" id="total" required>
                </div>
            </div>    
            <hr>               
		</div>      
		@endif  


		<!-- RELATÓRIO DE DESPESAS -->
		@if ( count($relatorio->conversas) > 0 )
		<div class="panel-body">
			<h3 class="title">				
				Relatório de conversas
			</h3>
		</div>

		
                       	                          
			@foreach ($relatorio->clientes as $cliente)
				
            	<div class="list-group">
					@include('clientes.panels.item', $cliente)		
					
					@foreach ($cliente->conversas as $conversa)
						
						@include('conversas.panels.item', $conversa)		
					
					@endforeach
            	</div>       

            	<!-- <div class="list-group bg-info">&nbsp;</div> -->

			@endforeach

            <hr>      
		@endif  
		
		<div class="panel-footer hidden-print">
			<div class="btn-group btn-group-justified">
				<a href="javascript: window.history.back();" class="btn btn-info"><i class="fa fa-chevron-left"></i> Voltar</a>
				<a href="{{url('relatorios/'.$relatorio->id.'/pdf')}}" class="btn btn-primary"><i class="fa fa-download"></i> Baixar PDF</a>
				<a href="#" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
			</div>
		</div>


	</div>     




</div>

@stop