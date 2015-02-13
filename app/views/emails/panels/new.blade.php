<div class="panel panel-primary">
  

            <div class="panel-heading">
                <button type="button" class="close pull-right" data-dismiss="modal">
                    <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
                </button>
                <h3 class="panel-title title">Enviar E-mail</h3>
            </div>

        {{Form::open(array('url' => 'emails', 'method' => 'post'))}}

            <table class="table table-condensed">        
                <tbody>
                    <tr>
                        <td class="text-right">
                            <h4 class="title">PARA:</h4>
                        </td>
                        <td>                            
                            <input name="to" type="text" list="mailto" class="form-control" value="{{@$resource->fornecedor->email}}" required>
                            <datalist id="mailto">
                                @foreach ($email['fornecedores'] as $fornecedor)
                                    <option value="{{$fornecedor->email}}">{{$fornecedor->nome}}</option>
                                @endforeach 
                            </datalist>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right">
                            <h4 class="title">CC:</h4>
                        </td>
                        <td>
                            <input name="cc" type="text" list="mailto_cc" class="form-control" value="{{@$resource->cliente->email}}">
                        </td>
                    </tr>                    
                
                    <tr class="info">
                        <td class="text-right">
                            <h4 class="title">ASSUNTO:</h4>
                        </td>
                        <td>                            
                            <?php if( $resource->status == ''){ ?>
                                <input type="text" name="subject" class="form-control" value=""/>
                            <?php }else if($resource->status == '1'){ ?>
                                <input type="text" name="subject" class="form-control" value="PEDIDO {{$resource->id}} - Olmar Primieri ({{@$fornecedor->empresa}})"/>
                            <?php }else if($resource->status == '2'){ ?>
                                <input type="text" name="subject" class="form-control" value="PEDIDO ALTERADO - Olmar Primieri ({{@$fornecedor->empresa}})"/>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="info">
                        <td class="text-right">
                            <h4 class="title">MENSAGEM:</h4>
                        </td>
                        <td>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control">{{$email['message']}}</textarea>
                        </td>
                    </tr>

                    @if ( $email['attachments'] )                        
                        <tr class="info">
                            <td class="text-right">
                                <h4 class="title"><i class="fa fa-paperclip"></i></h4>
                            </td>
                            <td>
                                <h4 class="title">
                                    <i class="fa fa-file-pdf-o"></i> 
                                    {{$email['attachments']}}

                                    {{Form::hidden('attachments', $email['attachments'])}}
                                    {{Form::hidden('resource_id', $resource->id )}}
                                    {{Form::hidden('resource_name', strtolower($email['resourcename']) )}}


                                   <!--  <a href="#" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-primary">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <a href="#" class="btn btn-primary">
                                        <i class="fa fa-print"></i>
                                    </a> -->
                                </h4>
                                
                            </td>
                        </tr>
                    @endif
                    
                </tbody>
            </table>


            <div class="panel-footer hidden-print">
                <div class="btn-group btn-group-sm pull-left">
                    <!-- <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-envelope"></i> Enviar
                    </button> -->
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.history.back()" data-dismiss="modal">
                        <i class="fa fa-chevron-left"></i> Voltar
                    </button>
                </div>
                <div class="btn-group btn-group-sm pull-right text-right">
                    <button type="submit" class="btn btn-sm btn-success pull-right">
                        <span class="glyphicon glyphicon-send"></span> Enviar
                    </button>
                </div>   
                <div class="clearfix">
                    
                </div>
            </div>

            {{Form::hidden('id', 'INFORME O ID')}}

        {{Form::close()}}

        </div>


        