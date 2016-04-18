(function($){
	
	/**
	 *  acf/setup_fields
	 *
	 *  This event is triggered when ACF adds any new elements to the DOM. 
	 *
	 *  @since	1.0.0
	 *
	 *  @param	event		e: an event object. This can be ignored
	 *  @param	Element		postbox: An element which contains the new HTML
	 *
	 *  @return	N/A
	 */

	 if( typeof acf.add_action !== 'undefined' ) {

		acf.add_action('ready append', function( $el ){

			// $(postbox).find('.acf-iconpicker').each(function(){
			acf.get_fields({ type : 'fonticonpicker'}, $el).each(function(){
			
				$(this).find('.acf-iconpicker').each(function(){
			
					// The check is made so repeaters wont trigger the script before time
					if ( !$(this).parents('.row-clone').length ){
						
						// Let's iconpick!!!
						$(this).fontIconPicker({
							iconsPerPage: 33
						});
						acf.unload.off();
						
					}

				});

			});
		});

	} else {

		$(document).live('acf/setup_fields', function(e, postbox){

			$(postbox).find('.acf-iconpicker').each(function(){
			
				// The check is made so repeaters wont trigger the script before time
				if ( !$(this).parents('.row-clone').length ){
					
					// Let's iconpick!!!
					$(this).fontIconPicker();
					
				}

			});
		});

	}

})(jQuery);
