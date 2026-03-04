<table class="table table-hover">
	<thead>
		<tr class="bg-primary">
			<th>#</th>
			<th>Nome</th>
			<th>Acabamento</th>
			<th class="text-right">Valor</th>
		</tr>
	</thead>
	<tbody>
	    @foreach($produtos as $key => $produto)    
	    	<tr>
	    		<td>
	    			<a data-toggle="modal" data-target="#modal" href="{{ url( 'produtos/'.$produto->id ) }}" class="">
			            <strong>{{ $produto->cod }}</strong> 			            
			        </a>
	    		</td>
	    		<td>
			        <a data-toggle="modal" data-target="#modal" href="{{ url( 'produtos/'.$produto->id ) }}" class="">
			            {{ $produto->nome }}            			            
			        </a>
			    </td>
			    <td>
					{{ !empty($produto->category->name) ? '<small class="text-muted">'.$produto->category->name.'</small>' : '' }}
			    </td>
			    <td class="text-right">
			    	<a data-toggle="modal" data-target="#modal" href="{{ url( 'produtos/'.$produto->id ) }}" class="">
			    		R$ {{ $produto->preco }} {{ isset($produto->unidade) ? '<small>/'.$produto->unidade.'</small>' : '' }}
			        </a>
			    </td>
	    	</tr>
	    @endforeach              		
	</tbody>
</table>

{{ $produtos->appends( Request::except('page') )->links() }} 