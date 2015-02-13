<tr class="<?php if( $despesa->valor < 0 ) echo 'bg-danger' ?>">
    <td>{{ date('d/m/Y', strtotime($despesa->date) ) }}</td>
    <td>{{$despesa->cidade}}</td>
    <td>{{$despesa->descricao}}</td>
    <td class="text-right">
        <strong>R$ {{$despesa->valor}}</strong>
    </td>    
</tr>