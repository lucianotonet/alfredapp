<div class="panel panel-primary">
	<div class="panel-heading">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 class="panel-title"><i class="fa fa-user"></i> {{ $user->username }}</h3>
	</div>

	{{ Form::model($user, [ 'method' => 'PATCH', 'route' =>[ 'users.update', $user->id ], "class"=>"form-horizontal", "role"=>"form" ] ) }}  
	

	<div class="panel-body form-horizontal">
	
		<div class="form-group">
			<label for="input" class="col-sm-3 control-label">Username:</label>
			<div class="col-sm-9">								
				<input type="text" class="form-control" name="username" placeholder="" required="required" value="{{ $user->username }}">									
			</div>
		</div>						

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label">E-mail:</label>
			<div class="col-sm-9">				
				<input type="text" class="form-control" name="email" placeholder="" required="required" value="{{ $user->email }}">									
			</div>
		</div>		

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label">Nova Senha:</label>
			<div class="col-sm-9">				
				<input type="password" class="form-control" id="password_field" name="password" placeholder="Digita uma senha" value="">									
			</div>
		</div>		

		<div class="form-group">
			<label for="input" class="col-sm-3 control-label"></label>
			<div class="col-sm-9">				
				<input type="password" class="form-control" id="password_confirmation_field" name="password_confirmation" placeholder="Repita a senha" value="">									
			</div>
		</div>	

	</div>	

	<div class="panel-footer navbar-inverse">	

		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">					
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button>
			</div>				
			<a href="{{url('users/'.$user->id.'/delete')}}" class="btn btn-danger" onclick="return confirm('Excluir este usuário?')">
                <i class="fa fa-trash-o"></i> Excluir
            </a>
			<div class="btn-group" role="group">					
				<button type="submit" class="btn btn-success" id="edit_user_submit"><i class="fa fa-check"></i> Salvar</button>
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

	   /*
	        DATEPICKER
	        */	   
	        $('.datepicker').datepicker({
	        	format: "yyyy-mm-dd",
	        	language: "pt-BR",
	        	orientation: "top right",
	        	autoclose: true,
	        	todayHighlight: true
	        });    


	    /*
	    	ICONPICKER
	    	*/
	    	$('[role=iconpicker]').iconpicker({
	    		arrowClass: 'btn-primary',
	    		arrowPrevIconClass: 'fa fa-chevron-left',
	    		arrowNextIconClass: 'fa fa-chevron-right',
	    		cols: 5,
	    		icon: '<?php echo $user->icon ?>',
	    		iconset: 'fontawesome',   
	    		labelHeader: 'pág {0}',
	    		labelFooter: '{0} - {1} of {2} icons',
	    		placement: 'bottom',
	    		rows: 5,
	    		search: false,
	    		searchText: 'Search',
	    		selectedClass: 'btn-success',
	    		unselectedClass: ''
	    	}).on('change', function(e) { 
	    		$("input[name=icon]").val(e.icon);
	    		console.log(e.icon);
	    	});



	    // AUTOCOMPLETE
	    $('input.autocomplete').autocomplete({            
	    	serviceUrl: "/categories",            
	    	params: {'owner_type':'user'},
	    	onSelect: function (suggestion) {
	    		$(this).val( suggestion.value );
	    	},
	    	onSearchStart: function (query) {
	    		$(this).next('.form-control-feedback').removeClass('hidden');
	    	},
	    	onSearchComplete: function (query, suggestions) {
	    		$(this).next('.form-control-feedback').addClass('hidden')
	    	}
	    });



        $("#edit_user_submit").click(function(){   

	        $(".error").hide();
	        var hasError = false;
	        var passwordVal = $("#password_field").val();
	        var checkVal = $("#password_confirmation_field").val();

	        if (passwordVal != '' && checkVal == '') {
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
	    
	});	
</script>