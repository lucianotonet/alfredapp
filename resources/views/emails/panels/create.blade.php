<div class="panel panel-primary" >


            <div class="panel-heading">
                <button type="button" class="close pull-right" data-dismiss="modal">
                    <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
                </button>
                <h3 class="panel-title title"><i class="fa fa-envelope"></i> Enviar e-mail</h3>
            </div>

        {{Form::open(array('url' => 'emails', 'method' => 'post', 'id' => 'sendmail' ))}}

            <table class="table table-condensed">        
                <tbody>
                    <tr>
                        <td class="text-right">
                            <label class="form-control-static">Para</label>
                        </td>

                        <td>                            

                            <div class="contacts">                                
                                <div class="form-group multiple-form-group input-group">                                        
                                    
                                    <input type="text" name="to[]" class="form-control autocomplete" data-json="{{url('emails/getcontacts')}}" value="{{ @$email['mail_to'] }}" required>
                                    
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-add">+</button>
                                    </span>

                                </div>
                            </div>

                        </td>

                     
                    </tr>
                   
                    <tr class="">
                        <td class="text-right">
                            <label class="form-control-static">Assunto</label>
                        </td>
                        <td>
                            <input type="text" name="subject" class="form-control" value="{{@$email['subject']}}"/>
                        </td>
                       
                    </tr>
                    <tr class="">
                        <td class="text-right">
                            <label class="form-control-static">Mensagem</label>
                        </td>
                        <td>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control">{{@$email['message']}}</textarea>
                        </td>
                    </tr>

                    @if ( isset( $email['attachments'] ) )                        
                        <tr class="info">
                            <td class="text-right">
                                <h4 class="title"><i class="fa fa-paperclip"></i></h4>
                            </td>
                            <td>
                                <a href="{{asset( $email['attachments'] )}}" class="btn btn-link" target="_new">
                                    <i class="fa fa-file-pdf-o"></i> {{$email['attachments']}}
                                </a>                                
                            </td>
                        </tr>
                        {{Form::hidden('attachments', $email['attachments'] )}}
                    @endif

                    @if ( $email['owner_type'] == 'cliente' )
                        <tr class="info">
                            <td class="text-right">
                                <h4 class="title"><i class="fa fa-user"></i></h4>
                            </td>
                            <td>
                                 
                                @include('clientes.panels.item-details',['cliente'=>$resource])

                            </td>
                        </tr>
                    @endif
                    
                </tbody>
            </table>


            <div class="panel-footer hidden-print">                
                <div class="btn-group btn-group-sm pull-right text-right">
                    <button type="submit" class="btn btn-sm btn-success pull-right">
                        <span class="fa fa-envelope"></span> Enviar
                    </button>
                </div>   
                <div class="clearfix">
                    
                </div>
            </div>

            {{Form::hidden('owner_type', $email['owner_type'] )}}
            {{Form::hidden('owner_id', $email['owner_id'] )}}

        {{Form::close()}}

        </div>


    <script>
    $(document).ready(function() {
        magicSendMail();        

        $( ".autocomplete" ).autocomplete({
            serviceUrl: '<?php echo url("emails/getcontacts") ?>',
            groupBy: 'type', 
            onSelect: function (suggestion) {
                $(this).val( suggestion.value );
            }
        });

        /**
         * WYSIWYG
         */
        $('#sendmail textarea').wysihtml5({
            toolbar: {
                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                "emphasis": true, //Italics, bold, etc. Default true
                "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                "html": true, //Button which allows you to edit the generated HTML. Default false
                "link": false, //Button to insert a link. Default true
                "image": false, //Button to insert an image. Default true,
                "color": false, //Button to change color of font  
                "blockquote": false, //Blockquote  
                "size": 'xs', //default: none, other options are xs, sm, lg
                "fa": true
            }        
        });
    });
    </script>