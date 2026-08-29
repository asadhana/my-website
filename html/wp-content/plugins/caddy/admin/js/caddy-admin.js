(function( $ ) {
	'use strict';

	// Tab navigation
	$(document).ready(function() {
		// Set the active tab on page load if it's in the URL hash
		var hash = window.location.hash;
		if (hash) {
			// Remove the active class from all tabs
			$('.tabs li').removeClass('active');
			$('.tab-content .tab').removeClass('active');
			
			// Add active class to the tab specified in the URL hash
			$('.tabs li a[href="' + hash + '"]').parent().addClass('active');
			$(hash).addClass('active');
			
			// Update the hidden field with the tab ID (without the # symbol)
			$('#active_tab').val(hash.substring(1));
		}
		
		// Handle tab clicks
		$('.tabs li').click(function() {
			var tab_id = $(this).find('a').attr('href');
			$('.tabs li').removeClass('active');
			$('.tab-content .tab').removeClass('active');
			$(this).addClass('active');
			$(tab_id).addClass('active');
			
			// Update the URL hash without page reload
			if (history.pushState) {
				history.pushState(null, null, tab_id);
			} else {
				location.hash = tab_id;
			}
			
			// Update the hidden field with the active tab ID (without the # symbol)
			$('#active_tab').val(tab_id.substring(1));
			
			return false;
		});
		
		// Set the active tab in the hidden field before form submission
		$('form').submit(function() {
			var activeTab = $('.tabs li.active a').attr('href');
			if (activeTab) {
				$('#active_tab').val(activeTab.substring(1));
			}
		});
	});

	// Dismiss the opt-in notice
	$( document ).on( 'click', '.cc-optin-notice .notice-dismiss', function() {
		cc_dismiss_optin_notice();
	} );

	// Dismiss the opt-in notice when form submitted
	$( '#caddy-email-signup' ).submit( function( e ) {
		cc_dismiss_optin_notice();
	} );

	/* Dismiss welcome notice screen function */
	function cc_dismiss_welcome_notice() {
		// AJAX Request to dismiss the welcome notice
		var data = {
			action: 'dismiss_welcome_notice',
			nonce: caddyAjaxObject.nonce,
		};

		$.ajax( {
			type: 'post',
			url: caddyAjaxObject.ajaxurl,
			data: data,
			success: function( response ) {
			}
		} );
	}

	/* Dismiss the opt-in notice */
	function cc_dismiss_optin_notice() {
		var data = {
			action: 'dismiss_optin_notice',
			nonce: caddyAjaxObject.nonce,
		};
		$.ajax( {
			type: 'post',
			url: caddyAjaxObject.ajaxurl,
			data: data,
			success: function( response ) {
			}
		} );
	}

	// Copy shortcode to clipboard
	$(document).ready(function() {
		$('.copy-shortcode-button').click(function() {
			var $button = $(this);
			navigator.clipboard.writeText($('#cc_cart_widget_shortcode').val()).then(function() {
				$button.text('Copied!').addClass('button-copied');
				setTimeout(function() {
					$button.html('<span class="dashicons dashicons-admin-page"></span>').removeClass('button-copied');
				}, 2000);
			});
		});
	});

})( jQuery );
