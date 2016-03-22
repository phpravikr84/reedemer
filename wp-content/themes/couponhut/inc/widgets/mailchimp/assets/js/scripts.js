jQuery(document).ready(function($){

	"use strict";

	$('#mailchimp-widget-subscribe').submit(function() {
		var $mailchimpEmail = $("#mailchimp-widget-subscribe #email");
		var $mailchimpMessage = $(".mailchimp-widget-wrapper .mailchimp-widget-message");
		if ( !$mailchimpEmail.val() ) {
			$mailchimpMessage.hide().html('<div class="alert alert-danger">' + subsolarMailchimp.subs_email_empty + '</div>').fadeIn();
		}
		else if ( !valid_email_address($mailchimpEmail.val()) ) {
			$mailchimpMessage.hide().html('<div class="alert alert-danger">' + subsolarMailchimp.subs_email_error + '</div>').fadeIn();
		}
		else {
			$mailchimpMessage.html('<div class="alert alert-info">' + subsolarMailchimp.subs_email_add + '</div>').fadeIn();
			$.ajax({
				url: subsolarMailchimp.ajaxurl,
				data: {
					'action' : '_action_fw_ssd_mailchimp_widget',
					email : $mailchimpEmail.val()
				},
				type: 'POST',
				success: function(response) {
					console.log(response);
					$mailchimpEmail.val('');
					$mailchimpMessage.hide().html(response).fadeIn();
				}
			});
		}

		return false;
	});
	function valid_email_address(email)
	{
		var pattern = new RegExp(/[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+/i);
		return pattern.test(email);
	}

});