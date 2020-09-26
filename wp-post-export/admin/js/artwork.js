jQuery(document).ready(function($) {
	var posts_screen = jQuery( '.edit-php.post-type-post' ),
	title_action   	= posts_screen.find( '.page-title-action:first' );
	title_action.after('<a href="javascript:void(0);" name="wp_export_all_posts" class="page-title-action wp-custom-export-btn button-primary">Export Posts</a>');
	jQuery(document).on('click', '.wp-custom-export-btn', function() {
			
		var data = {
				action: 'load_export_custom_data',
		};
		
		$.ajax({
			method : 'POST',
			url    : ajax_url,
			data   :data,
					success: function( response ) {
						if(response){
							var data = response;
							$('<a></a>').attr('id','downloadFile').attr('href','data:text/csv;charset=utf8,' + encodeURIComponent(data)).attr('download','post-data.csv').appendTo('body');
							$('#downloadFile').get(0).click();	
						}else{
							 alert( "Someting Wrong" );
						}	
					}
		});
	});
});
