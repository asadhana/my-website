(function( $ ) {
	'use strict';

	//=============================================================================
	// GLOBAL VARIABLES
	//=============================================================================
	var ccWindow = $( '.cc-window' );
	var cc_quanity_update_send = true;
	var expectingCartUpdate = false;


	//=============================================================================
	// UTILITY FUNCTIONS
	//=============================================================================
	
	/**
	 * Generate skeleton HTML for cart items loading state
	 * 
	 * @param {number|null} customCount - Optional custom number of skeleton items to display
	 * @return {string} HTML string containing skeleton loaders
	 */
	function getSkeletonHTML(customCount) {
		const cartCount = customCount || parseInt($('.cc-compass-count').text()) || 1;
		
		const skeletonItem = `
		<div class="cc-skeleton-item">
			<div class="cc-skeleton cc-skeleton-thumb"></div>
			<div class="cc-skeleton-content">
				<div class="cc-skeleton cc-skeleton-line medium"></div>
				<div class="cc-skeleton cc-skeleton-line short"></div>
			</div>
		</div>
		`;
		
		return skeletonItem.repeat(cartCount);
	}

	/**
	 * Get WooCommerce AJAX URL for an endpoint
	 * 
	 * @param {string} endpoint - The endpoint to get URL for
	 * @return {string} The complete AJAX URL
	 */
	function getWcAjaxUrl(endpoint) {
		if (cc_ajax_script.wc_ajax_url) {
			return cc_ajax_script.wc_ajax_url.replace('%%endpoint%%', endpoint);
		}
		return '/?wc-ajax=' + endpoint;
	}

	/**
	 * Handle common AJAX response for cart operations
	 * 
	 * @param {Object} response - The AJAX response
	 */
	function handleCartResponse(response) {
		if (response && response.fragments) {
			$.each(response.fragments, function(key, value) {
				$(key).replaceWith(value);
			});
			$(document.body).trigger('wc_fragments_refreshed');
		}
	}
	
	//=============================================================================
	// CART MANAGEMENT FUNCTIONS
	//=============================================================================
	
	/**
	 * Load and display the cart screen with updated fragments
	 *
	 * @param {string} productAdded - Optional parameter indicating if a product was added ('yes' or 'move_to_cart')
	 */
	function cc_cart_screen(productAdded = '') {
		if (window.cc_cart_ajax && window.cc_cart_ajax.readyState !== 4) {
			window.cc_cart_ajax.abort();
		}

		window.cc_cart_ajax = $.ajax({
			type: 'POST',
			url: cc_ajax_script.ajaxurl,
			data: {
				action: 'caddy_get_cart_fragments',
				_: new Date().getTime()
			},
			cache: false,
			beforeSend: function() {
				$('.cc-cart-items').html(getSkeletonHTML());
			},
			error: function(xhr, status, error) {
				if (status !== 'abort') {
					$('.cc-cart-items').html('<div class="cc-cart-error">Unable to load cart. <a href="' + cc_ajax_script.cart_url + '">View cart page</a>.</div>');
				}
			},
			success: function(response) {
				handleCartResponse(response);

				var tabs = new Tabby('[data-tabs]');
				tabs.toggle('#cc-cart');

				if ('yes' == productAdded) {
					$('.cc-window-wrapper').show();
				} else if ('move_to_cart' === productAdded) {
					$('.cc_cart_from_sfl').removeClass('cc_hide_btn');
					$('.cc_cart_from_sfl').parent().find('.cc-loader').hide();
					$('.cc-coupon .woocommerce-notices-wrapper').remove();
					$('.cc-cart').removeAttr('hidden');
				}
			}
		});
	}

	/**
	 * Update cart item quantity
	 * @param {string} cartKey - The cart item key
	 * @param {number} newQty - The new quantity
	 */
	function cc_update_cart_quantity(cartKey, newQty) {
		$('.cc-cart-items').html(getSkeletonHTML());

		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('cc_update_item_quantity'),
			data: {
				cart_key: cartKey,
				qty: newQty,
				nonce: cc_ajax_script.nonce
			},
			success: handleCartResponse,
			error: function() {
				cc_refresh_cart();
			},
			complete: function() {
				$('.cc-window-wrapper').show();
			}
		});
	}

	/**
	 * Update item quantity in the cart
	 * Handles quantity increment and decrement buttons
	 * 
	 * @param {Object} el - The button element that was clicked
	 */
	function cc_quantity_update_buttons(el) {
		var wrap = $(el).parents('.cc-cart-product-list');
		var input = $(wrap).find('.cc_item_quantity');
		var key = $(input).data('key');
		var number = parseInt($(input).val());
		var type = $(el).data('type');
		
		if ('minus' == type) {
			number--;
		} else {
			number++;
		}
		
		if (number < 1) {
			// If quantity would be less than 1, trigger remove item instead
			var removeButton = $(el).closest('.cc-cart-product').find('a.remove_from_cart_button');
			removeButton.trigger('click');
			return;
		}

		cc_update_cart_quantity(key, number);
	}

	/**
	 * Remove an item from the cart
	 * 
	 * @param {Object} button - The remove button that was clicked
	 */
	function cc_remove_item_from_cart(button) {
		var cartItemKey = button.data('cart_item_key');

		$('.cc-cart-items').html(getSkeletonHTML());
		$('.cc-compass .ccicon-cart').hide();
		$('.cc-compass .cc-loader').show();

		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('cc_remove_item_from_cart'),
			data: {
				cart_item_key: cartItemKey,
				nonce: cc_ajax_script.nonce
			},
			success: handleCartResponse,
			error: function() {
				cc_refresh_cart();
			},
			complete: function() {
				$('.cc-compass .ccicon-cart').show();
				$('.cc-compass .cc-loader').hide();
				$('.cc-window-wrapper').show();
			}
		});
	}

	/**
	 * Display the cart items list in the cart window
	 */
	function cc_cart_item_list() {
		if ( !ccWindow.hasClass( 'visible' ) ) {
			$( '.cc-compass' ).trigger( 'click' );
		}
	}

	/**
	 * Refresh the cart contents via AJAX
	 * Gets updated fragments and refreshes the cart display
	 */
	function cc_refresh_cart() {
		if (window.cc_refresh_ajax && window.cc_refresh_ajax.readyState !== 4) {
			window.cc_refresh_ajax.abort();
		}

		window.cc_refresh_ajax = $.ajax({
			type: 'POST',
			url: cc_ajax_script.ajaxurl,
			data: {
				action: 'caddy_get_cart_fragments',
				_: new Date().getTime()
			},
			cache: false,
			success: handleCartResponse,
			error: function(xhr, status, error) {
				if (status !== 'abort') {
					$('.cc-cart-items').html('<div class="cc-cart-error">Unable to refresh cart. <a href="javascript:void(0)" onclick="cc_refresh_cart()">Try again</a>.</div>');
				}
			}
		});
	}

	//=============================================================================
	// COUPON MANAGEMENT FUNCTIONS
	//=============================================================================

	/**
	 * Apply a coupon code from the cart screen
	 */
	function cc_coupon_code_applied_from_cart_screen() {
		var coupon_code = $('.cc-coupon-form #cc_coupon_code').val();

		$('#cc-cart').css('opacity', '0.3');

		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('cc_apply_coupon_to_cart'),
			data: {
				nonce: cc_ajax_script.nonce,
				coupon_code: coupon_code
			},
			success: handleCartResponse,
			complete: function() {
				$('#cc-cart').css('opacity', '1');
				var tabs = new Tabby('[data-tabs]');
				tabs.toggle('#cc-cart');
			}
		});
	}

	/**
	 * Remove a coupon code from the cart screen
	 * 
	 * @param {Object} $remove_code - The remove coupon button that was clicked
	 */
	function cc_coupon_code_removed_from_cart_screen($remove_code) {
		var coupon_code_to_remove = $remove_code.parent('.cc-applied-coupon').find('.cc_applied_code').text();

		$('#cc-cart').css('opacity', '0.3');

		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('cc_remove_coupon_code'),
			data: {
				nonce: cc_ajax_script.nonce,
				coupon_code_to_remove: coupon_code_to_remove
			},
			success: handleCartResponse,
			complete: function() {
				$('#cc-cart').css('opacity', '1');
				var tabs = new Tabby('[data-tabs]');
				tabs.toggle('#cc-cart');
			}
		});
	}

	//=============================================================================
	// SAVE FOR LATER FUNCTIONALITY
	//=============================================================================

	/**
	 * Save an item for later
	 * Moves an item from the cart to the save-for-later list
	 * 
	 * @param {Object} $button - The save for later button that was clicked
	 */
	function cc_save_for_later($button) {
		var product_id = $button.data('product_id');
		var cart_item_key = $button.data('cart_item_key');

		$('#cc-cart').css('opacity', '0.3');
		$button.addClass('cc_hide_btn');
		$button.parent().find('.cc-loader').show();

		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('cc_save_for_later'),
			data: {
				nonce: cc_ajax_script.nonce,
				product_id: product_id,
				cart_item_key: cart_item_key
			},
			success: function(response) {
				handleCartResponse(response);
				var tabs = new Tabby('[data-tabs]');
				tabs.toggle('#cc-saves');
			},
			complete: function() {
				$button.removeClass('cc_hide_btn');
				$button.parent().find('.cc-loader').hide();
				$('#cc-cart').css('opacity', '1');
			}
		});
	}

	/**
	 * Move an item from save-for-later to cart
	 * 
	 * @param {Object} $button - The move to cart button that was clicked
	 */
	function cc_move_to_cart($button) {
		var product_id = $button.data('product_id');

		$button.addClass('cc_hide_btn');
		$button.parent().find('.cc-loader').show();

		// First, add to cart using WooCommerce's standard method
		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('add_to_cart'),
			data: {
				product_id: product_id,
				quantity: 1
			},
			success: function(response) {
				if (response.error) {
					$button.removeClass('cc_hide_btn');
					$button.parent().find('.cc-loader').hide();
					// Handle error - don't remove from SFL
				} else {
					// Cart addition successful, now remove from SFL using existing method
					$.ajax({
						type: 'POST',
						url: getWcAjaxUrl('cc_remove_item_from_sfl'),
						data: {
							nonce: cc_ajax_script.nonce,
							product_id: product_id
						},
						success: function(sfl_response) {
							cc_cart_screen('move_to_cart');
						},
						error: function() {
							cc_cart_screen('move_to_cart');
						}
					});
				}
			},
			error: function() {
				$button.removeClass('cc_hide_btn');
				$button.parent().find('.cc-loader').hide();
				cc_refresh_cart();
			}
		});
	}

	/**
	 * Remove an item from the save-for-later list
	 * 
	 * @param {Object} button - The remove button that was clicked
	 */
	function cc_remove_item_from_save_for_later(button) {
		var productID = button.data('product_id');

		$('#cc-saves').css('opacity', '0.3');

		$.ajax({
			type: 'POST',
			url: getWcAjaxUrl('cc_remove_item_from_sfl'),
			data: {
				nonce: cc_ajax_script.nonce,
				product_id: productID
			},
			success: function(response) {
				handleCartResponse(response);
				var tabs = new Tabby('[data-tabs]');
				tabs.toggle('#cc-saves');
			},
			complete: function() {
				$('#cc-saves').css('opacity', '1');
			}
		});
	}

	/**
	 * Display the saved items list in the cart window
	 */
	function cc_saved_item_list() {
		$( '.cc-compass' ).toggleClass( 'cc-compass-open' );
		$( 'body' ).toggleClass( 'cc-window-open' );

		$( '.cc-pl-info-container' ).hide();
		$( '.cc-window-wrapper' ).show();

		$( '.cc-overlay' ).show();

		var tabs = new Tabby( '[data-tabs]' );
		tabs.toggle( '#cc-saves' );

		ccWindow.animate( { 'right': '0' }, 'slow' ).addClass( 'visible' );
	}

	/**
	 * Navigate back to cart from product info view
	 */
	function cc_back_to_cart() {
		$( '.cc-pl-info-container' ).hide();
		$( '.cc-window-wrapper' ).show();
	}

	//=============================================================================
	// DOCUMENT READY - EVENT HANDLERS & INITIALIZATION
	//=============================================================================

	jQuery( document ).ready( function( $ ) {

		// Initialize cart screen on page load
		setTimeout( function() {
			cc_cart_screen();
		}, 200 );

		//-------------------------------------------------------------------------
		// ACCESSIBILITY & NAVIGATION
		//-------------------------------------------------------------------------
		
		// Tab usability
		$( '.cc-nav ul li a' ).mousedown( function() {
			$( this ).addClass( 'using-mouse' );
		} );

		$( 'body' ).keydown( function() {
			$( '.cc-nav ul li a' ).removeClass( 'using-mouse' );
		} );

		// cc-window tabbing
		var tabs = new Tabby( '[data-tabs]' );

		// Tab navigation events
		$( document ).on( 'click', '.cc-nav ul li a', function() {
			var current_tab = $( this ).attr( 'data-id' );
			if ( 'cc-cart' === current_tab ) {
				$( '.cc-pl-upsells-slider' ).resize();
			}
		} );

		//-------------------------------------------------------------------------
		// CART WINDOW INTERACTIONS
		//-------------------------------------------------------------------------
		
		// Clicking outside of mini cart
		$( document ).mouseup( function( e ) {
			var container = $( '.cc-window.visible, .cc-compass, #toast-container' );

			if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
				if ( ccWindow.hasClass( 'visible' ) ) {

					$( '.cc-compass' ).toggleClass( 'cc-compass-open' );
					$( 'body' ).toggleClass( 'cc-window-open' );

					$( '.cc-overlay' ).hide();
					ccWindow.animate( { 'right': '-1000px' }, 'slow' ).removeClass( 'visible' );

					if ( $( '#toast-container' ).length > 0 ) {
						$( '#toast-container' ).animate( { 'right': '25px' }, 'fast' ).toggleClass( 'cc-toast-open' );
					}
				}
			}
		} );

		// Compass click handler (toggle cart window)
		$(document).on('click', '.cc-compass', function() {
			$(this).toggleClass('cc-compass-open');
			$('body').toggleClass('cc-window-open');

			if (ccWindow.hasClass('visible')) {
				$('.cc-overlay').hide();
				$('.cc-window-wrapper').hide();
				ccWindow.animate({'right': '-1000px'}, 'slow').removeClass('visible');
			} else {
				$('.cc-overlay').show();
				$('.cc-window-wrapper').show();

				$('.cc-cart-items').html(getSkeletonHTML());
				
				tabs.toggle('#cc-cart');
				
				ccWindow.animate({'right': '0'}, 'slow').addClass('visible');

				cc_refresh_cart();
			}
		});

		// Close button for cart window
		$( document ).on( 'click', '.ccicon-x', function() {
			$( '.cc-overlay' ).hide();
			ccWindow.animate( { 'right': '-1000px' }, 'slow' ).removeClass( 'visible' );
			$( '.cc-compass' ).toggleClass( 'cc-compass-open' );
			$( 'body' ).toggleClass( 'cc-window-open' );
		} );

		//-------------------------------------------------------------------------
		// CART ITEM MANAGEMENT
		//-------------------------------------------------------------------------
		
		// Remove cart item
		$( document ).on( 'click', '.cc-cart-product-list .cc-cart-product a.remove_from_cart_button', function() {
			var button = $( this );
			cc_remove_item_from_cart( button );
		} );

		// Item quantity update
		$( document ).on( 'click', '.cc_item_quantity_update', function() {
			var $this = $(this);
			var quantityInput = $this.siblings('.cc_item_quantity');
			var currentQuantity = parseInt(quantityInput.val(), 10);
			
			if ($this.hasClass('cc_item_quantity_minus') && currentQuantity === 1) {
				// When quantity is 1 and user clicks minus, remove the item instead
				var removeButton = $this.closest('.cc-cart-product').find('a.remove_from_cart_button');
				removeButton.trigger('click');
				return false; // Prevent any further processing
			} else {
				cc_quantity_update_buttons($this);
			}
		} );
		
		// Cart items list button clicked
		$( document ).on( 'click', '.cc_cart_items_list', function() {
			cc_cart_item_list();
		} );

		// View cart button clicked
		$( document ).on( 'click', '.added_to_cart.wc-forward, .woocommerce-error .button.wc-forward', function( e ) {
			e.preventDefault();
			cc_cart_item_list();
		} );

		// Product added view cart button
		$( document ).on( 'click', '.cc-pl-info .cc-pl-actions .cc-view-cart', function() {
			tabs.toggle( '#cc-cart' );
		} );

		//-------------------------------------------------------------------------
		// SAVE FOR LATER FUNCTIONALITY
		//-------------------------------------------------------------------------
		
		// Remove from save for later
		$( document ).on( 'click', 'a.remove_from_sfl_button', function() {
			var button = $( this );
			cc_remove_item_from_save_for_later( button );
		} );

		// Save for later button click from the Caddy cart screen
		$( document ).on( 'click', '.save_for_later_btn', function() {
			cc_save_for_later( $( this ) );
		} );

		// Move to cart button clicked
		$( document ).on( 'click', '.cc_cart_from_sfl', function() {
			cc_move_to_cart( $( this ) );
		} );

		// Move to cart button
		$( document ).on( 'click', '.cc_back_to_cart', function() {
			cc_back_to_cart();
		} );

		// Saved items list button clicked
		$( document ).on( 'click', '.cc_saved_items_list', function() {
			cc_saved_item_list();
		} );

		// Clicks on a view saved items
		$( document ).on( 'click', '.cc-view-saved-items', function() {
			var tabs = new Tabby( '[data-tabs]' );
			tabs.toggle( '#cc-saves' );
		} );

		// Handle variations with save for later
		if ( $( '.variations_form' ).length > 0 ) {
			$( '.cc_add_product_to_sfl' ).addClass( 'disabled' );
			$( this ).each( function() {
				$( this ).on( 'found_variation', function( event, variation ) {
					$( '.cc_add_product_to_sfl' ).removeClass( 'disabled' );
				} );

				$( this ).on( 'reset_data', function() {
					$( '.cc_add_product_to_sfl' ).addClass( 'disabled' );
				} );
			} );
		}

		//-------------------------------------------------------------------------
		// COUPON HANDLING
		//-------------------------------------------------------------------------
		
		// Apply coupon form submission
		$( document ).on( 'submit', '#apply_coupon_form', function( e ) {
			e.preventDefault();
			cc_coupon_code_applied_from_cart_screen();
		} );

		// Remove coupon
		$( document ).on( 'click', '.cc-applied-coupon .cc-remove-coupon', function() {
			cc_coupon_code_removed_from_cart_screen( $( this ) );
		} );

		// Coupon form toggle
		$(document).on('click', '.cc-coupon-title', function() {
			var $couponForm = $('.cc-coupon-form');
			var $couponWrapper = $('.cc-coupon');
			
			if ($couponForm.is(':hidden')) {
				$couponWrapper.addClass('cc-coupon-open');
				$couponForm.slideDown(300);
			} else {
				$couponForm.slideUp(300, function() {
					$couponWrapper.removeClass('cc-coupon-open');
				});
			}
		});

		// Update the error notice click handler
		$(document).on('click', '.cc-coupon .woocommerce-error', function(e) {
			var $error = $(this);
			var clickX = e.pageX - $error.offset().left;
			
			if (clickX > $error.width() - 40) {
				$(this).closest('.woocommerce-notices-wrapper').fadeOut(200);
			}
		});

		//-------------------------------------------------------------------------
		// ADD TO CART HANDLING
		//-------------------------------------------------------------------------
		
		// Add a flag to track the source of the event
		var handlingOurAjaxResponse = false;

		// Add a flag to prevent double handling
		var handlingCartUpdate = false;

		// Handle add to cart button clicks for guest users
		$(document).on('click', '.add_to_cart_button, .single_add_to_cart_button', function() {
			expectingCartUpdate = true;
		});

		// Handle WooCommerce cart updates for guest users
		$('body').on('added_to_cart wc_fragments_refreshed', function(event) {
			// If this is a fragments refresh after add-to-cart, open cart
			if (event.type === 'wc_fragments_refreshed' && expectingCartUpdate) {
				expectingCartUpdate = false;
				if (!ccWindow.hasClass('visible')) {
					$('.cc-compass').trigger('click');
				}
			}
		});

		/**
		 * Handle WooCommerce 'added_to_cart' event
		 * 
		 * Triggered when products are successfully added to the cart.
		 * Manages cart window display based on:
		 * - Device type (mobile/desktop)
		 * - User preferences for notifications
		 * - Whether the product was added from recommendations
		 * 
		 * Prevents duplicate event handling with the handlingCartUpdate flag.
		 * 
		 * @param {Event} e - The event object
		 * @param {Object} fragments - Cart fragments returned from WooCommerce
		 * @param {string} cart_hash - The cart hash
		 * @param {Object} this_button - The button that triggered the add to cart action
		 */
		$('body').on('added_to_cart', function(e, fragments, cart_hash, this_button) {

			if (handlingCartUpdate) {
				return;
			}

			handlingCartUpdate = true;

			var cpDeskNotice = $('.cc-compass-desk-notice').val(),
				cpMobNotice = $('.cc-compass-mobile-notice').val();

			var isRecommendationButton = $(this_button).closest('.cc-pl-recommendations').length > 0;

			if (isRecommendationButton) {
				cc_cart_screen('', {fragments: fragments, cart_hash: cart_hash});
			}

			if (cc_ajax_script.is_mobile && !ccWindow.hasClass('visible') && 'mob_disable_notices' === cpMobNotice) {
				setTimeout(function() {
					$('.cc-compass').trigger('click');
					handlingCartUpdate = false;
				}, 20);
			} else if (!cc_ajax_script.is_mobile && !ccWindow.hasClass('visible')
				&& ('desk_disable_notices' === cpDeskNotice || 'desk_notices_caddy_window' === cpDeskNotice || '' === cpDeskNotice)) {
				setTimeout(function() {
					$('.cc-compass').trigger('click');
					handlingCartUpdate = false;
				}, 20);
			} else {
				handlingCartUpdate = false;
			}
		});

		// Listen for add to cart form submissions
		$(document.body).on('submit', 'form.cart', function(e) {
			e.preventDefault();

			var $form = $(this);
			var $button = e.originalEvent && e.originalEvent.submitter 
				? $(e.originalEvent.submitter) 
				: $form.find('button[type="submit"]');

			// Create FormData object
			var formData = new FormData($form[0]);
			
			// If product ID isn't in form, try to get it from URL
			if(!formData.has('add-to-cart') && $form.attr('action')){
				var matches = $form.attr('action').match(/add-to-cart=([0-9]+)/);
				if(matches){
					formData.append('add-to-cart', matches[1]);
				}
			}

			// Add button data if it has name/value
			if($button.attr('name') && $button.attr('value')){
				formData.append($button.attr('name'), $button.attr('value'));
			}

			// Add caddy_ajax parameter
			formData.append('caddy_ajax', true);

			// Show loading state
			$button.addClass('loading');
			
			// Add to cart via Ajax
			$.ajax({
				type: 'POST',
				url: wc_add_to_cart_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart'),
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					if (response.error) {
						// Let WooCommerce handle the error display
						return true;
					}
					
					// Update fragments
					if (response.fragments) {
						$.each(response.fragments, function(key, value) {
							$(key).replaceWith(value);
						});
						$(document.body).trigger('wc_fragments_refreshed');
					}

					// Open the cart drawer
					$('.cc-compass').addClass('cc-compass-open');
					$('body').addClass('cc-window-open');
					$('.cc-overlay').show();
					$('.cc-window-wrapper').show();
					$('.cc-cart-items').html(getSkeletonHTML());
					ccWindow.animate({'right': '0'}, 'slow').addClass('visible');
					
					// Load cart screen with productAdded flag
					cc_cart_screen('yes');

					// Ensure wrapper stays visible after fragments refresh
					$(document.body).one('wc_fragments_refreshed', function() {
						$('.cc-window-wrapper').show();
					});
				},
				complete: function() {
					$button.removeClass('loading');
				}
			});
		});
		
	});

})( jQuery );