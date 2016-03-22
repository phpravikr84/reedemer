jQuery(document).ready(function($){

/**
* ----------------------------------------------------------------------------------------
*    Image Upload Field
* ----------------------------------------------------------------------------------------
*/

	"use strict";

	var mediaUploader;

	$(document).on('click', '.ssd-upload-image-button',function(e) {
		e.preventDefault();

		var $upload_button = $(this);
		var button_name = $upload_button.data('name');
	    // If the uploader object has already been created, reopen the dialog
	    if (mediaUploader) {
	    	mediaUploader.open();
	    	return;
	    }
	    // Extend the wp.media object
	    mediaUploader = wp.media.frames.file_frame = wp.media({
	    	title: 'Select Image',
	    	button: {
	    		text: 'Select'
	    	},
	    	multiple: false
	    });

	    // When a file is selected, grab the URL and set it as the text field's value
	    mediaUploader.on('select', function() {
	    	var attachment = mediaUploader.state().get('selection').first().toJSON();
	    	$upload_button.prev().val(attachment.url);
	    	$('input[type="hidden"][name="' + button_name + '"]').val(attachment.id );
	    });
	    // Open the uploader dialog
	    mediaUploader.open();
	});

/**
* ----------------------------------------------------------------------------------------
*    Multi Select Field
* ----------------------------------------------------------------------------------------
*/

	function initMultiSelect( widget_el ) {
        widget_el.find( '.ssdwf-multi-select:not(.selectized)' ).selectize({
        	create: true,
        	sortField: {
        		field: 'text',
        		direction: 'asc'
        	},
        	dropdownParent: 'body'
        });

    }

	function onFormUpdate( e, widget_el ) {

        if (  widget_el.find( '.ssdwf-multi-select' ) ) {
            initMultiSelect( widget_el, 'widget-added' === e.type );
        }
    }

	$(document).on( 'widget-added widget-updated', onFormUpdate );

	$( '#widgets-right .widget:has(.ssdwf-multi-select)' ).each( function () {
		initMultiSelect( $(this) );
	});

	


})