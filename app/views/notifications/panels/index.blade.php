<?php use Carbon\Carbon as Carbon;
if( count($notifications) ){ ?>
		
		<div class="list-group">
			<?php foreach ($notifications as $notification) { ?>	
				@include('notifications.panels.item')
			<?php }	?>
		</div>

<?php }else{ ?>
	<div class="well">
		<div class="page-header text-center">
		  	<h2>
		  		<i class="icon icon-bell-o fa-2x text-muted"></i> <i class="icon icon-check fa-2x text-muted"></i>
		  		<br>
		  		<br>
		  		{{ $labels['nothing'] }}
		  	</h2>
		</div>
	</div>
<?php } ?>
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

});
</script>