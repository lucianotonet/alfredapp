jQuery(document).ready(function($) {
    
    // RECURRING
    $('#transaction_create .recurring_type').change(function(event) {
        if( $(this).val() == 'never' ){
            $('#transaction_create .recurring_times').addClass('hidden');
        }else{
            $('#transaction_create .recurring_times').removeClass('hidden');
        }
    });
    $('.isRecurring').click( function(event) {              
        $('select.recurring_type').toggleClass('hidden');
        /* Act on the event */
    });

    // PAGO
    $('#transaction_done .btn').click(function(event) {             
        $('#transaction_done .btn i.fa').toggleClass('fa-check-square-o');
        $('#transaction_done .btn i.fa').toggleClass('fa-square-o');
        $(this).toggleClass('btn-success');             
    });

    $('.transaction_amount').change(function(event) {
        if( $(this).val() < 0 ){
            $('.transaction_type .despesa input').prop('checked', true);
        }else{
            $('.transaction_type .receita input').prop('checked', true);
        }
            
    }); 


    // function selectCallback(value) {
    //     if( value == "#modal" ) {            
    //         $('.modal#transactions_select_range').modal();
    //     }else{
    //         location.href = value;
    //     }
    // }
    // $('select.transaction_navigation').selecter({
    //     callback: selectCallback,
    //     //links: true,
    //     cover: false
    // });

    $('select.transaction_navigation').change(function(event) {

        var value = $(this).val();        
            if( value == "#modal" ) {            
                $('.modal#transactions_select_range').modal();
            }else
            if( value != "" ){
                location.href = value;
            }
    });


    // DONE
    $(".transaction_done .btn").click(function(event) {
        //alert( $(this).find('checkbox').val() );
    });


    // MODAL
    $('#modal').on('show.bs.modal', function (event) {
    
        var link = $(event.relatedTarget);
        // $(this).find(".modal-content").load( link.attr("href") );

        $(this).find(".modal-content").load( link.attr("href") );
        //  function(){
        //         /* Stuff to do after the page is loaded */
        //         //alert();
        //         $(this).find(".modal-content input.price").priceFormat({        
        //                                                     prefix: '',
        //                                                     centsSeparator: ',',
        //                                                     thousandsSeparator: '.',
        //                                                     allowNegative: false
        //                                                 });
        // }


        
    })   

});    