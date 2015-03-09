<div class="panel panel-primary">        
    <div class="panel-heading">
        <button type="button" class="close pull-right" data-dismiss="modal">
            <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
        </button>
        <h3 class="title">
            <i class="icon-edit"></i>
            NOVA NOTA
        </h3>
    </div>
    {{ Form::open(array('url' => 'notes', 'method' => 'post', 'id' => 'quick_add')) }}                  

        {{ Form::textarea('note') }}
        {{ Form::hidden( 'resource_name', null ) }}
        {{ Form::hidden( 'resource_id', null) }}
            
        <div class="panel-footer">
            <button type="submit" class="btn btn-success btn-sm pull-right">
                <i class="fa fa-check"></i>
                Salvar
            </button>
            <a href="" class="btn btn-primary btn-sm" data-dismiss="modal">
                <i class="fa fa-chevron-left"></i>
            </a>
        </div>
    {{ Form::close() }}                

<?php if( Request::ajax() ){ ?>
<script>
    (function($) {
        /**
         * WYSIWYG
         */
        tinymce.init({
            selector: "textarea",                
            mode : "textareas",
            language : "pt",
            menubar: false,
            toolbar_items_size: 'small',
            statusbar : false,
            preview_styles: true,
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            theme_advanced_font_sizes: "14px,16px,18px,20px",
            font_size_style_values : "14px,16px,18px,20px",
            plugins: [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste"
            ],
            toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist "
        });


        /**
         *  AJAX
         */
        $('#quick_add').on('submit',function(e){

            e.preventDefault();

            var request = $.ajax({
              url: $(this).attr('action'),
              type: $(this).attr('method'),
              data: $(this).serialize(),
              dataType: "json"
            });

             
            request.done(function( msg ) {
                   
                $.each( msg, function(i, item) { 
                    console.log(item);
                    //  var clienteItem =   '<a href="clientes/'+item.id+'" class="list-group-item">'
                    //                     +'    <span class="pull-left cliente-avatar" style="background-color:#3bafda">'
                    //                     +'        <img src="img/avatar-small.png" alt="">'
                    //                     +'    </span>'
                    //                     +'    <div class="search-data">'
                    //                     +'        <strong class="list-group-item-heading">'+item.nome+'</strong><br>'
                    //                     +'        <strong>'+item.empresa+'</strong><br>'
                    //                     +'        <i class="fa fa-map-marker"></i> '+item.cidade+' - '+item.uf+' | '
                    //                     +'        <i class="fa fa-phone"></i> '+item.telefone+'|'
                    //                     +'        <i class="fa fa-mobile"></i> '+item.celular+' '
                    //                     +'    </div>'
                    //                     +'</a>';

                    // $( clienteItem ).appendTo( $('.list-clientes') );
                });
                
                //clientes_list.slideDown('slow');                
            });
             
            request.fail(function( jqXHR, textStatus ) {
               console.log( "Request failed: " + textStatus );
            });
        })

    })(jQuery);
   </script>
<?php } ?>
</div>