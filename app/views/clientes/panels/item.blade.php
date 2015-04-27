<div class="clearfix">	
	<i class="icon-user text-muted fa-2x pull-left panel-body" style="border-right: 1px solid #ddd; margin-right: 10px "></i>
	<div class="pull-left">
		<strong>{{$cliente->empresa}}</strong> 
	    <small><i class="fa fa-map-marker"></i> {{$cliente->cidade}} - {{$cliente->uf}}</small><br>
	    {{$cliente->nome}} {{ !empty($cliente->email) ? '&lt;'.$cliente->email.'&gt;' : '' }}
	    <br>
	    <small>
		    
		    {{ !empty($cliente->telefone) ? '<i class="fa fa-phone-square"></i> '.$cliente->telefone.' ' : '' }}
		    {{ !empty($cliente->celular) ? '<i class="fa fa-phone-square"></i> '.$cliente->celular.' ' : '' }}	    
		</small>
	</div>	
</div>