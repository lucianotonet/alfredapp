<div class="panel panel-primary">
	<div class="panel-heading">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 class="panel-title"><i class="icon-calendar"></i> Adicionar</h3>
	</div>
	{{ Form::open(array('route' => 'users.store', 'method' => 'POST', "class"=>"", "role"=>"form", "id"=>"user_create" )) }}

	<div class="panel-body form-horizontal">		

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label">Username:</label>
			<div class="col-sm-9">								
				<input type="text" class="form-control" name="username" placeholder="" required="required" value="">									
			</div>
		</div>						

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label">E-mail:</label>
			<div class="col-sm-9">				
				<input type="email" class="form-control" name="email" placeholder="" required="required" value="">									
			</div>
		</div>			

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label">Senha:</label>
			<div class="col-sm-9">				
				<input type="password" class="form-control" id="password_field" name="password" placeholder="Digita uma senha" required="required" value="">									
			</div>
		</div>		

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label"></label>
			<div class="col-sm-9">				
				<input type="password" class="form-control" id="password_confirmation_field" name="password_confirmation" placeholder="Repita a senha" required="required" value="">									
			</div>
		</div>	

	</div>	

	<div class="panel-footer navbar-inverse">	

		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">					
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
			</div>				
			<div class="btn-group" role="group">					
				<button type="submit" id="create_user_submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
			</div>
		</div>

	</div>	
	{{ Form::close() }}
</div>			


<script>
$(function() {

	/*
    	MODAL RELOAD    
    */ 
    $.each( $("#modal [data-target=#modal]"), function(index, val) {
    	$(this).removeAttr('data-toggle');
    });

    $("#modal [data-target=#modal]").click(function(ev) {
        // alert();
        ev.preventDefault();
        $("#modal .modal-content").html( $('.loading-splash').html() );

        var target = $(this).attr("href");
        $("#modal .modal-content").load(target, function() { 
        	$("#modal").modal("show"); 
        })
        
    });


    $("#create_user_submit").click(function(){   

        $(".error").hide();
        var hasError = false;
        var passwordVal = $("#password_field").val();
        var checkVal = $("#password_confirmation_field").val();

        if (passwordVal == '') {
            $("#password_field").after('<span class="error text-danger">Por favor digite uma senha.</span>');
            hasError = true;
        } else if (checkVal == '') {
            $("#password_confirmation_field").after('<span class="error text-danger">Por favor repita a senha.</span>');
            hasError = true;
        } else if (passwordVal != checkVal ) {
            $("#password_confirmation_field").after('<span class="error text-danger">As senhas não correspondem.</span>');
            hasError = true;
        }

        if(hasError == true) {
        	return false;
        }
    });

    $("[name='username']").change(function(){
    	$(".error-username").hide();
        var hasError = false;
        // Check username
        var username = $(this).val();
        if( username != '' ){
	        $.ajax({
	        	url: '<?php echo url("users/checkusername/") ?>',        	
	        	dataType: 'json',  
	        	data: {'username':username}      	
	        })
	        .done(function( data ) {
	        	if( data > 0 ){
	        		$("[name='username']").after('<span class="error-username text-danger">Este nome de usuário já está cadastrado! Utilize outro.</span>');
	        		hasError = true;	
	        	}
	        	console.log( data );
	        })
	        .fail(function() {
	        	$("[name='username']").before('<div class="alert alert-danger">Ocorreu um erro ao verificar o nome de usuário.<br/>Por favor, informe o administrador do sistema.</div>');
	        		hasError = true;        		
	        });        	
        }

    });        	

    $("[name='email']").change(function(){
    	$(".error-email").hide();
        var hasError = false;
        // Check email
        var email = $(this).val();
        if( email != '' ){
	        $.ajax({
	        	url: '<?php echo url("users/checkmail/") ?>',        	
	        	dataType: 'json',  
	        	data: {'email':email}      	
	        })
	        .done(function( data ) {
	        	if( data > 0 ){
	        		$("[name='email']").after('<span class="error-email text-danger">Este endereço de e-mail já está sendo usado! Por favor, utilize outro.</span>');
	        		hasError = true;	
	        	}
	        	console.log( data );
	        })
	        .fail(function() {
	        	$("[name='email']").before('<div class="alert alert-danger">Ocorreu um erro ao verificar o e-mail.<br/>Por favor, informe o administrador do sistema.</div>');
	        		hasError = true;        		
	        });
	    };

        if(hasError == true) {
        	return false;
        }

    });

});	

</script>