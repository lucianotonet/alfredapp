<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="panel-title title">ENVIAR PEDIDO nº {{$pedido}}</h3>
    </div>

{{Form::open(array('url' => 'pedidos/send', 'method' => 'post'))}}

    <table class="table table-condensed">        
        <tbody>
            <tr>
                <td class="text-right">
                    <h4 class="title">ASSUNTO:</h4>
                </td>
                <td>
                    <input type="text" name="mail_content" id="" cols="30" rows="10" class="form-control"></input>
                </td>
            </tr>
            <tr>
                <td class="text-right">
                    <h4 class="title">MENSAGEM:</h4>
                </td>
                <td>
                    <textarea name="mail_content" id="" cols="30" rows="10" class="form-control"></textarea>
                </td>
            </tr>
            <tr>
                <td class="text-right">Anexo</td>
                <td>
                    <textarea name="mail_content" id="" cols="30" rows="10" class="form-control"></textarea>
                </td>
            </tr>
        </tbody>
    </table>


            
    <div class="panel-body">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
            <h4 class="title">FORNECEDOR:</h4>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <input name="to" type="text" list="fornecedores" class="input-lg form-control" id="send_to_fornecedor" required>
            <datalist id="fornecedores">
                @foreach ($fornecedores as $fornecedor)
                    <option value="{{$fornecedor->email}}">{{$fornecedor->nome}}</option>
                @endforeach              
            </datalist>
        </div>    
        
    </div>

    <div class="panel-body">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
            <h4 class="title">CLIENTE:</h4>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <input name="to_client" type="text" class="input-lg form-control" id="send_to_cliente" value="<?php if ( isset($pedido->cliente->email)) echo $pedido->cliente->email ?>">            
        </div>    
        
    </div>

    <div class="panel-body bg-info">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
            <h4 class="title">CC:</h4>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <input name="cc" type="text" list="vendedores" class="input-lg form-control" id="send_to_vendedor" >
            <datalist id="vendedores">
                @foreach ($vendedores as $vendedor)
                    <option value="{{$vendedor->email}}">{{$vendedor->nome}}</option>
                @endforeach              
            </datalist>
        </div>    
        
    </div>

    <div class="panel-footer hidden-print">
        <div class="btn-group btn-group-lg pull-left">
            <!-- <button type="submit" class="btn btn-primary">
                <i class="fa fa-envelope"></i> Enviar
            </button> -->
            <button type="button" class="btn btn-primary">
                <i class="fa fa-chevron-left"></i> Voltar
            </button>
        </div>
        <div class="btn-group btn-group-lg pull-right text-right">
                <a href="{{ url('/pedidos/preview/'.$pedido) }}" class="btn btn-primary ">
                    <i class="fa fa-eye"></i>
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <span class="glyphicon glyphicon-send"></span> Enviar pedido
                </button>
        </div>   
        <div class="clearfix"></div>
    </div>

    {{Form::hidden('id', $pedido)}}

{{Form::close()}}

</div>