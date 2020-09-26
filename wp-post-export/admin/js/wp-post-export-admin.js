(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	jQuery(document).ready(function($) {
		/* Include Button in Admin Area */
		var posts_screen = jQuery( '.edit-php.post-type-post' ),
		title_action   	= posts_screen.find( '.page-title-action:first' );
		title_action.after('<a href="javascript:void(0);" name="wp_export_all_posts" class="page-title-action wp-custom-export-btn button-primary">Export Posts</a>');	
	});
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
								 alert( "Something Wrong.Please Try Again." );
							}	
						}
			});
	});
})( jQuery );
