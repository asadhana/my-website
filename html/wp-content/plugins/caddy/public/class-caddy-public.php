<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Caddy
 * @subpackage Caddy/public
 * @author     Tribe Interactive <success@madebytribe.co>
 */
class Caddy_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Prevent WooCommerce mini cart block from registering
		add_action('init', array($this, 'prevent_mini_cart_block_registration'), 20);

	}

	/**
	 * Prevent WooCommerce mini cart block from registering
	 *
	 * @since 2.1.4
	 */
	public function prevent_mini_cart_block_registration() {
		// Unregister the mini-cart block to prevent it from rendering
		if (WP_Block_Type_Registry::get_instance()->is_registered('woocommerce/mini-cart')) {
			unregister_block_type('woocommerce/mini-cart');
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Checking for page builder preview modes to avoid loading styles
		if (isset($_GET['elementor-preview']) || isset($_GET['et_fb'])) {
			return;
		}

		wp_enqueue_style('cc-slick', CADDY_DIR_URL . '/public/css/caddy-slick.min.css', array(), $this->version, 'all');
		wp_enqueue_style('caddy-public', CADDY_DIR_URL . '/public/css/caddy-public.css', array(), $this->version, 'all');
		wp_enqueue_style('caddy-icons', CADDY_DIR_URL . '/public/css/caddy-icons.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Checking for page builder preview modes to avoid loading scripts
		if (isset($_GET['elementor-preview']) || isset($_GET['et_fb'])) {
			return;
		}

		// Localize script data
		$params = array(
			'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
			'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
			'cart_url' => esc_url(wc_get_cart_url()),
			'nonce' => wp_create_nonce('caddy'),
			'is_mobile' => wp_is_mobile(),
		);

		// Core WooCommerce scripts
		wp_enqueue_script('wc-add-to-cart');
		wp_enqueue_script('wc-cart-fragments');
		wp_enqueue_script('wc-add-to-cart-variation');

		// Plugin scripts
		wp_register_script('caddy-tabby-js', CADDY_DIR_URL . '/public/js/tabby.min.js', array('jquery'), $this->version, true);
		wp_register_script('caddy-tabby-polyfills-js', CADDY_DIR_URL . '/public/js/tabby.polyfills.min.js', array('jquery'), $this->version, true);
		wp_register_script('cc-slick-js', CADDY_DIR_URL . '/public/js/slick.min.js', array('jquery'), $this->version, true);
		wp_register_script('caddy-public', CADDY_DIR_URL . '/public/js/caddy-public.js', array(
			'jquery',
			'wc-add-to-cart',
			'wc-cart-fragments',
			'wc-add-to-cart-variation'
		), $this->version, true);

		wp_localize_script('caddy-public', 'cc_ajax_script', $params);

		wp_enqueue_script('caddy-tabby-js');
		wp_enqueue_script('caddy-tabby-polyfills-js');
		wp_enqueue_script('cc-slick-js');
		wp_enqueue_script('caddy-public');
	}

	/**
	 * Load the cc widget
	 */
	public function cc_load_widget() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Checking for page builder preview modes to avoid loading widget
		if ( isset( $_GET['elementor-preview']) || isset($_GET['et_fb']) ) {
			// Return if current screen is elementor editor
			return;
		}

		require_once( plugin_dir_path( __FILE__ ) . 'partials/caddy-public-display.php' );
	}

	/**
	 * Get refreshed cart fragments
	 */
	public function get_refreshed_fragments() {

		// Ensure WooCommerce is loaded and cart is available
		if (!function_exists('WC') || !WC()->cart) {
			wp_send_json_error('WooCommerce not available');
			return;
		}

		// For guest users, ensure session is started
		if (!is_user_logged_in()) {
			WC()->session->set_customer_session_cookie(true);
		}

		// Make sure cart is loaded and calculated
		WC()->cart->calculate_totals();

		// Get fragments
		$fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
		
		// Add our custom fragments
		$fragments = $this->cc_compass_cart_count_fragments($fragments);
		$fragments = $this->cc_shortcode_cart_count_fragments($fragments);
		$fragments = $this->cc_cart_html_fragments($fragments);

		wp_send_json(array(
			'fragments' => $fragments,
			'cart_hash' => WC()->cart->get_cart_hash()
		));
	}

	/**
	 * Ajaxify cart count.
	 *
	 * @param array $fragments Fragments to filter
	 * @return array Modified fragments
	 */
	public function cc_compass_cart_count_fragments($fragments) {
		ob_start();
		$cart_count = is_object(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
		$cc_cart_zero = ($cart_count == 0) ? ' cc-cart-zero' : '';
		?>
		<span class="cc-compass-count<?php echo esc_attr($cc_cart_zero); ?>">
			<?php echo esc_html($cart_count); ?>
		</span>
		<?php
		$fragments['.cc-compass-count'] = ob_get_clean();
		
		return $fragments;
	}

	/**
	 * Ajaxify short-code cart count.
	 *
	 * @param array $fragments Fragments to filter
	 * @return array Modified fragments
	 */
	public function cc_shortcode_cart_count_fragments($fragments) {
		ob_start();
		$cart_count = is_object(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
		$cc_cart_zero = ($cart_count == 0) ? ' cc_cart_zero' : '';
		?>
		<span class="cc_cart_count<?php echo esc_attr($cc_cart_zero); ?>">
			<?php echo esc_html($cart_count); ?>
		</span>
		<?php
		$fragments['.cc_cart_count'] = ob_get_clean();
		
		return $fragments;
	}

	/**
	 * Add cart HTML fragments
	 *
	 * @param array $fragments Fragments to filter
	 * @return array Modified fragments
	 */
	public function cc_cart_html_fragments($fragments) {
		ob_start();
		$this->cc_cart_screen();
		$fragments['div.cc-cart-container'] = ob_get_clean();

		ob_start();
		$this->cc_sfl_screen();
		$fragments['div.cc-sfl-container'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Cart screen template.
	 */
	public function cc_cart_screen() {
		include( plugin_dir_path( __FILE__ ) . 'partials/caddy-public-cart.php' );
	}

	/**
	 * Save for later template.
	 */
	public function cc_sfl_screen() {
		include( plugin_dir_path( __FILE__ ) . 'partials/caddy-public-saves.php' );
	}

	/**
	 * Caddy add item to the cart.
	 * @deprecated Use WooCommerce native add-to-cart endpoint instead
	 */
	public function caddy_add_to_cart() {
		wp_die();
	}

	/**
	 * Remove item from cart
	 */
	public function caddy_remove_item_from_cart() {
		check_ajax_referer('caddy', 'nonce');

		$cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field(wp_unslash($_POST['cart_item_key'])) : '';

		if ($cart_item_key && WC()->cart->get_cart_item($cart_item_key)) {
			WC()->cart->remove_cart_item($cart_item_key);
		}

		WC_AJAX::get_refreshed_fragments();
	}

	/**
	 * Send product removed response with proper fragments
	 */
	private function send_product_removed_response($message) {
		WC()->cart->calculate_totals();
		WC()->cart->maybe_set_cart_cookies();
		
		$fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
		$cart_hash = WC()->cart->get_cart_hash();
		
		wp_send_json(array(
			'product_removed' => true,
			'message' => $message,
			'fragments' => $fragments,
			'cart_hash' => $cart_hash
		));
	}

	/**
	 * Save item for later
	 */
	public function caddy_save_for_later_item() {
		check_ajax_referer('caddy', 'nonce');

		if (isset($_POST['product_id'])) {
			$product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
			
			// Get the 'cart_item_key' parameter from the POST request
			$raw_cart_item_key = filter_input(INPUT_POST, 'cart_item_key', FILTER_DEFAULT);
			
			// Sanitize the 'cart_item_key' parameter
			$post_item_key = sanitize_text_field($raw_cart_item_key);

			$current_user_id = get_current_user_id();

			$cc_sfl_items = get_user_meta($current_user_id, 'cc_save_for_later_items', true);
			if (!is_array($cc_sfl_items)) {
				$cc_sfl_items = array();
			}
			$cc_sfl_items[] = $product_id;
			$unique_sfl_items = array_unique($cc_sfl_items);
			update_user_meta($current_user_id, 'cc_save_for_later_items', $unique_sfl_items);

			// Remove item from the cart
			$cart_items = WC()->cart->get_cart();
			$cc_cart_items = array_reverse($cart_items);

			$final_cart_items = array();
			foreach ($cc_cart_items as $cc_cart_item_key => $cc_cart_item) {
				$final_cart_items[] = $cc_cart_item;
			}
			foreach ($final_cart_items as $cart_item_key => $cart_item) {
				if ($cart_item['key'] == $post_item_key) {
					WC()->cart->remove_cart_item($post_item_key);
				}
			}

			WC()->cart->calculate_totals();
			WC()->cart->maybe_set_cart_cookies();

			$this->get_refreshed_fragments();
		}
		wp_die();
	}

	/**
	 * Window screen template.
	 */
	public function cc_window_screen() {
		include( plugin_dir_path( __FILE__ ) . 'partials/caddy-public-window.php' );
	}


	/**
	 * Remove item from save for later
	 */
	public function caddy_remove_item_from_sfl() {

		//Check nonce
		if ( isset($_POST['nonce']) && wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['nonce'])), 'caddy' ) &&
			 isset( $_POST['product_id'] ) ) {

			$product_id         = filter_input( INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT );
			$current_user_id    = get_current_user_id();
			$cc_sfl_items_array = get_user_meta( $current_user_id, 'cc_save_for_later_items', true );
			if ( ! is_array( $cc_sfl_items_array ) ) {
				$cc_sfl_items_array = array();
			}

			if ( ( $key = array_search( $product_id, $cc_sfl_items_array ) ) !== false ) {
				unset( $cc_sfl_items_array[ $key ] );
			}
			$unique_sfl_items = array_unique( $cc_sfl_items_array );
			update_user_meta( $current_user_id, 'cc_save_for_later_items', $unique_sfl_items );

			$this->get_refreshed_fragments();

		}
		wp_die();
	}

	/**
	 * Apply coupon to cart
	 */
	public function caddy_apply_coupon_to_cart() {
		check_ajax_referer('caddy', 'nonce');

		$coupon_code = isset($_POST['coupon_code']) ? sanitize_text_field(wp_unslash($_POST['coupon_code'])) : '';

		if ($coupon_code) {
			WC()->cart->add_discount($coupon_code);
		}

		WC_AJAX::get_refreshed_fragments();
	}

	/**
	 * Remove coupon from cart
	 */
	public function caddy_remove_coupon_code() {
		check_ajax_referer('caddy', 'nonce');

		$coupon_code = isset($_POST['coupon_code_to_remove']) ? sanitize_text_field(wp_unslash($_POST['coupon_code_to_remove'])) : '';

		if ($coupon_code) {
			WC()->cart->remove_coupon($coupon_code);
		}

		WC_AJAX::get_refreshed_fragments();
	}

	/**
	 * Saved items short-code.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public function cc_saved_items_shortcode( $atts ) {

		// Check if save for later is enabled
		$cc_enable_sfl_options = get_option( 'cc_enable_sfl_options', 'enabled' );
		if ( 'disabled' === $cc_enable_sfl_options ) {
			return '';
		}

		$default = array(
			'text' => '',
			'icon' => '',
		);

		$attributes         = shortcode_atts( $default, $atts );
		$attributes['text'] = ! empty( $attributes['text'] ) ? $attributes['text'] : $default['text'];

		$saved_items_link = sprintf(
			'<a href="%1$s" class="cc_saved_items_list" aria-label="%2$s">%3$s %4$s</a>',
			'javascript:void(0);',
			esc_attr__( 'Saved Items', 'caddy' ),
			( 'yes' === $attributes['icon'] ) ? '<i class="ccicon-heart-empty"></i>' : '',
			esc_html( $attributes['text'] )
		);

		return $saved_items_link;
	}

	/**
	 * Cart items short-code.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public function cc_cart_items_shortcode( $atts ) {

		$default = array(
			'text' => '',
			'icon' => '',
		);

		$cart_items_link    = '';
		$attributes         = shortcode_atts( $default, $atts );
		$attributes['text'] = ! empty( $attributes['text'] ) ? $attributes['text'] : $default['text'];

		$cart_count      = '';
		$cc_cart_class   = '';
		$cart_icon_class = apply_filters( 'caddy_cart_bubble_icon', '<i class="ccicon-cart"></i>' );

		if ( ! is_admin() ) {
			$cart_count    = is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
			$cc_cart_class = ( $cart_count == 0 ) ? 'cc_cart_count cc_cart_zero' : 'cc_cart_count';
		}

		$cart_items_link = sprintf(
			'<a href="%1$s" class="cc_cart_items_list" aria-label="%2$s">%3$s %4$s <span class="%5$s">%6$s</span></a>',
			'javascript:void(0);',
			esc_attr__( 'Cart Items', 'caddy' ),
			( 'yes' === $attributes['icon'] ) ? $cart_icon_class : '',
			esc_html( $attributes['text'] ),
			esc_attr( $cc_cart_class ),
			esc_html( $cart_count )
		);
		
		return $cart_items_link;
	}

	/**
	 * Display caddy cart bubble icon
	 *
	 * @param $cart_icon_class
	 *
	 * @return string
	 */
	public function cc_display_cart_bubble_icon( $cart_icon_class ) {
		return $cart_icon_class;
	}

	/**
	 * Add product to save for later button.
	 */
	public function cc_add_product_to_sfl() {

		$cc_enable_sfl_options = get_option( 'cc_enable_sfl_options' );
		$cc_sfl_btn_on_product = get_option( 'cc_sfl_btn_on_product' );
		$current_user_id       = get_current_user_id();
		$cc_sfl_items_array    = get_user_meta( $current_user_id, 'cc_save_for_later_items', true ); // phpcs:ignore
		$cc_sfl_items_array    = ! empty( $cc_sfl_items_array ) ? $cc_sfl_items_array : array();

		if ( is_user_logged_in() && 'enabled' === $cc_sfl_btn_on_product && 'enabled' === $cc_enable_sfl_options ) {
			global $product;
			$product_id   = $product->get_id();
			$product_type = $product->get_type();
		
			if ( in_array( $product_id, $cc_sfl_items_array ) ) {
				echo sprintf(
					'<a href="%1$s" class="button cc-sfl-btn remove_from_sfl_button" data-product_id="%2$s" data-product_type="%3$s"><i class="ccicon-heart-filled"></i> <span>%4$s</span></a>',
					'javascript:void(0);',
					esc_attr( $product_id ),
					esc_attr( $product_type ),
					esc_html__( 'Saved', 'caddy' )
				);
			} else {
				echo sprintf(
					'<a href="%1$s" class="button cc-sfl-btn cc_add_product_to_sfl" data-product_id="%2$s" data-product_type="%3$s"><i class="ccicon-heart-empty"></i> <span>%4$s</span></a>',
					'javascript:void(0);',
					esc_attr( $product_id ),
					esc_attr( $product_type ),
					esc_html__( 'Save for later', 'caddy' )
				);
			}
		}
	}

	/**
	 * Add product to save for later directly via button.
	 */
	public function caddy_add_product_to_sfl_action() {

		//Check nonce
		if ( isset($_POST['nonce']) && wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['nonce'])), 'caddy' ) &&
			 isset( $_POST['product_id'] ) ) {

			$product_id      = filter_input( INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT );
			$current_user_id = get_current_user_id();

			$cc_sfl_items = get_user_meta( $current_user_id, 'cc_save_for_later_items', true );
			if ( ! is_array( $cc_sfl_items ) ) {
				$cc_sfl_items = array();
			}

			if ( ! in_array( $product_id, $cc_sfl_items ) ) {
				$cc_sfl_items[]   = $product_id;
				$unique_sfl_items = array_unique( $cc_sfl_items );
				update_user_meta( $current_user_id, 'cc_save_for_later_items', $unique_sfl_items );
			}

			$open_cc_compass_flag = true;
			if ( wp_is_mobile() ) {
				$cp_mobile_notices = get_option( 'cp_mobile_notices' );
				if ( 'mob_no_notice' === $cp_mobile_notices ) {
					$open_cc_compass_flag = false;
				}
			} else {
				$cp_desktop_notices = get_option( 'cp_desktop_notices' );
				if ( 'desk_notices_only' === $cp_desktop_notices ) {
					$open_cc_compass_flag = false;
				}
			}

			$this->get_refreshed_fragments();
			$data = array(
				'cc_compass_open' => $open_cc_compass_flag,
			);
			wp_send_json( $data );

		}
		wp_die();
	}

	/**
	 * Hide 'Added to Cart' message.
	 *
	 * @param string $message The HTML message
	 * @param array $products Array of product IDs and quantities
	 * @return string Empty string to hide the message
	 */
	public function cc_empty_wc_add_to_cart_message( $message, $products ) {
		return '';
	}

	/**
	 * Caddy load Custom CSS added to custom css box into footer.
	 */
	public function cc_load_custom_css() {

		$cc_custom_css = get_option( 'cc_custom_css' );
		if ( ! empty( $cc_custom_css ) ) {
			echo '<style>' . wp_kses( stripslashes( $cc_custom_css ), array() ) . '</style>';
		}
	}

	/**
	 * Display compass icon
	 */
	public function cc_display_compass_icon() {
		// Only show free version compass if premium plugin is not active
		if ( ! class_exists( 'Caddy_Premium' ) ) {
			$cart_count   = is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
			$cc_cart_zero = ( $cart_count == 0 ) ? ' cc-cart-zero' : '';
			?>
			<!-- The floating icon -->
			<div class="cc-compass">
				<span class="licon"></span>
				<div class="cc-loader" style="display: none;"></div>
				<span class="cc-compass-count<?php echo esc_attr( $cc_cart_zero ); ?>">
					<?php echo esc_html( $cart_count ); ?>
				</span>
			</div>
			<?php
		}
	}

	/**
	 * Display up-sells slider in product added screen
	 *
	 * @param $product_id
	 */
	public function cc_display_product_upsells_slider( $product_id ) {
		// Only show free version upsells if premium plugin is not active
		if ( ! class_exists( 'Caddy_Premium' ) && ! empty( $product_id ) ) {
			include( plugin_dir_path( __FILE__ ) . 'partials/caddy-public-recommendations.php' );
		}
	}

	/**
	 * Display free shipping congrats text
	 *
	 * @param $cc_shipping_country
	 */
	public function caddy_display_free_shipping_congrats_text( $cc_shipping_country ) {
		
		// SVG code
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M22.87,7.1A.24.24,0,0,0,23,6.86a.23.23,0,0,0-.15-.21L16,3.92a1.13,1.13,0,0,0-.9,0L13,4.94a.24.24,0,0,0-.14.23.24.24,0,0,0,.15.22l6.94,3.07a.52.52,0,0,0,.44,0Z" fill="currentColor"></path><path d="M16.61,19.85a.27.27,0,0,0,.12.22.26.26,0,0,0,.24,0l6.36-3.18a1.12,1.12,0,0,0,.62-1V8.06a.26.26,0,0,0-.13-.22.25.25,0,0,0-.24,0L16.74,11.5a.26.26,0,0,0-.13.22Z" fill="currentColor"></path><path d="M7.52,8.31a.24.24,0,0,0-.23,0,.23.23,0,0,0-.11.2c0,.56,0,2.22,0,7.41a1.11,1.11,0,0,0,.68,1l7.42,3.16a.21.21,0,0,0,.23,0,.24.24,0,0,0,.12-.21V11.78a.26.26,0,0,0-.16-.23Z" fill="currentColor"></path><path d="M15.87,10.65a.54.54,0,0,0,.43,0l2.3-1.23a.26.26,0,0,0,.13-.23.24.24,0,0,0-.15-.22L11.5,5.82a.48.48,0,0,0-.42,0L8.31,7.12a.24.24,0,0,0-.14.23.23.23,0,0,0,.15.22Z" fill="currentColor"></path><path d="M5,13.76,1.07,11.94a.72.72,0,0,0-1,.37.78.78,0,0,0,.39,1l3.9,1.8a.87.87,0,0,0,.31.07.73.73,0,0,0,.67-.43A.75.75,0,0,0,5,13.76Z" fill="currentColor"></path><path d="M5,10.31,2.68,9.23a.74.74,0,0,0-1,.36.75.75,0,0,0,.36,1L4.4,11.65a.7.7,0,0,0,.31.07A.74.74,0,0,0,5,10.31Z" fill="currentColor"></path><path d="M5,6.86,3.91,6.35a.73.73,0,0,0-1,.36.74.74,0,0,0,.36,1L4.4,8.2a.7.7,0,0,0,.31.07A.74.74,0,0,0,5,6.86Z" fill="currentColor"></path></g></svg>';
		
		echo sprintf(
			'<span class="cc-fs-icon">%1$s</span>%2$s<strong> %3$s <span class="cc-fs-country">%4$s</span> %5$s</strong>!',
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML
			$svg,
			esc_html__( 'Congrats, you\'ve activated', 'caddy' ),
			esc_html__( 'free', 'caddy' ),
			esc_html( $cc_shipping_country ),
			esc_html__( 'shipping', 'caddy' )
		);
	}

	/**
	 * Display free shipping spend text
	 *
	 * @param $free_shipping_remaining_amount
	 * @param $cc_shipping_country
	 */
	public function caddy_display_free_shipping_spend_text( $free_shipping_remaining_amount, $cc_shipping_country ) {
		$cc_shipping_country = get_option( 'cc_shipping_country' );
		
		// SVG code
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M22.87,7.1A.24.24,0,0,0,23,6.86a.23.23,0,0,0-.15-.21L16,3.92a1.13,1.13,0,0,0-.9,0L13,4.94a.24.24,0,0,0-.14.23.24.24,0,0,0,.15.22l6.94,3.07a.52.52,0,0,0,.44,0Z" fill="currentColor"></path><path d="M16.61,19.85a.27.27,0,0,0,.12.22.26.26,0,0,0,.24,0l6.36-3.18a1.12,1.12,0,0,0,.62-1V8.06a.26.26,0,0,0-.13-.22.25.25,0,0,0-.24,0L16.74,11.5a.26.26,0,0,0-.13.22Z" fill="currentColor"></path><path d="M7.52,8.31a.24.24,0,0,0-.23,0,.23.23,0,0,0-.11.2c0,.56,0,2.22,0,7.41a1.11,1.11,0,0,0,.68,1l7.42,3.16a.21.21,0,0,0,.23,0,.24.24,0,0,0,.12-.21V11.78a.26.26,0,0,0-.16-.23Z" fill="currentColor"></path><path d="M15.87,10.65a.54.54,0,0,0,.43,0l2.3-1.23a.26.26,0,0,0,.13-.23.24.24,0,0,0-.15-.22L11.5,5.82a.48.48,0,0,0-.42,0L8.31,7.12a.24.24,0,0,0-.14.23.23.23,0,0,0,.15.22Z" fill="currentColor"></path><path d="M5,13.76,1.07,11.94a.72.72,0,0,0-1,.37.78.78,0,0,0,.39,1l3.9,1.8a.87.87,0,0,0,.31.07.73.73,0,0,0,.67-.43A.75.75,0,0,0,5,13.76Z" fill="currentColor"></path><path d="M5,10.31,2.68,9.23a.74.74,0,0,0-1,.36.75.75,0,0,0,.36,1L4.4,11.65a.7.7,0,0,0,.31.07A.74.74,0,0,0,5,10.31Z" fill="currentColor"></path><path d="M5,6.86,3.91,6.35a.73.73,0,0,0-1,.36.74.74,0,0,0,.36,1L4.4,8.2a.7.7,0,0,0,.31.07A.74.74,0,0,0,5,6.86Z" fill="currentColor"></path></g></svg>';
	
		echo sprintf(
			'<span class="cc-fs-icon">%1$s</span>%2$s<strong> <span class="cc-fs-amount">%3$s</span> %4$s</strong> %5$s <strong>%6$s <span class="cc-fs-country">%7$s</span> %8$s</strong>',
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML
			$svg,
			esc_html__( 'Spend', 'caddy' ),
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_price returns escaped HTML
			wc_price( $free_shipping_remaining_amount, array( 'currency' => get_woocommerce_currency() ) ),
			esc_html__( 'more', 'caddy' ),
			esc_html__( 'to get', 'caddy' ),
			esc_html__( 'free', 'caddy' ),
			esc_html( $cc_shipping_country ),
			esc_html__( 'shipping', 'caddy' )
		);
	}

	/**
	 * Free shipping bar html
	 */
	public function cc_free_shipping_bar_html() {

		// Check if premium plugin is active or not
		if ( ! class_exists( 'Caddy_Premium' ) ) {
			
			$calculate_with_tax = 'enabled' === get_option('cc_free_shipping_tax', 'disabled');
			$final_cart_subtotal = $calculate_with_tax ? WC()->cart->get_cart_contents_total() + WC()->cart->get_cart_contents_tax() : WC()->cart->get_displayed_subtotal();

			$cc_free_shipping_amount = get_option( 'cc_free_shipping_amount' );

			$free_shipping_remaining_amount = floatval( $cc_free_shipping_amount ) - floatval( $final_cart_subtotal );
			$free_shipping_remaining_amount = ! empty( $free_shipping_remaining_amount ) ? $free_shipping_remaining_amount : 0;

			// Bar width based off % left
			$cc_bar_amount = 100;
			if ( ! empty( $cc_free_shipping_amount ) && $final_cart_subtotal <= $cc_free_shipping_amount ) {
				$cc_bar_amount = $final_cart_subtotal * 100 / $cc_free_shipping_amount;
			}

			$cc_shipping_country = get_option( 'cc_shipping_country' );
			if ( 'GB' === $cc_shipping_country ) {
				$cc_shipping_country = 'UK';
			}

			$cc_bar_active = ( $final_cart_subtotal >= $cc_free_shipping_amount ) ? ' cc-bar-active' : '';
			?>
			<span class="cc-fs-title">
				<?php
				if ( $final_cart_subtotal >= $cc_free_shipping_amount ) {
					do_action( 'caddy_fs_congrats_text', $cc_shipping_country );
				} else {
					do_action( 'caddy_fs_spend_text', $free_shipping_remaining_amount, $cc_shipping_country );
				}
				?>
			</span>
			<div class="cc-fs-meter">
				<span class="cc-fs-meter-used<?php echo esc_attr( $cc_bar_active ); ?>" style="width: <?php echo esc_attr( $cc_bar_amount ); ?>%"></span>
			</div>
			<?php
		}
	}

	/**
	 * Cart items array list for the cc-cart screen
	 *
	 * @param array $cart_items_array
	 */
	public function cart_items_list( $cart_items_array = array() ) {
		if ( ! empty( $cart_items_array ) ) {
			foreach ( $cart_items_array as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = $_product->get_id();
				
				// Check if the WooCommerce Product Bundles plugin functions exist
				if ( function_exists( 'wc_pb_is_bundle_container_cart_item' ) && wc_pb_is_bundle_container_cart_item( $cart_item ) ) {
					echo '<div class="cc-cart-product-list bundle">';
				} elseif ( function_exists( 'wc_pb_is_bundled_cart_item' ) && wc_pb_is_bundled_cart_item( $cart_item ) ) {
					echo '<div class="cc-cart-product-list bundled_child">';
				} else {
					echo '<div class="cc-cart-product-list">';
				}
				?>
	
				<?php
				$percentage = 0;
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0
					 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key )
				) {
					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$product_image = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( array( 200, 200 ) ), $cart_item, $cart_item_key );
	
					$product_regular_price = get_post_meta( $product_id, '_regular_price', true );
					$product_sale_price    = get_post_meta( $product_id, '_sale_price', true );
					if ( ! empty( $product_sale_price ) ) {
						$percentage = ( ( $product_regular_price - $product_sale_price ) * 100 ) / $product_regular_price;
					}
					$product_stock_qty = $_product->get_stock_quantity();
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
	
					$plus_disable = '';
					if ( $product_stock_qty > 0 ) {
						if ( ( $product_stock_qty <= $cart_item['quantity'] && ! $_product->backorders_allowed() )) {
							$plus_disable = ' cc-qty-disabled';
						}
					}
					?>
					<div class="cc-cart-product">
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="cc-product-link cc-product-thumb"
						   data-title="<?php echo esc_attr( $product_name ); ?>">
							<?php 
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WC product image is already escaped
							echo $product_image; 
							?>
						</a>
						<div class="cc_item_content">
							<div class="cc-item-content-top">
								<div class="cc_item_title">
									<?php
	
									if ( ! $product_permalink ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
									} else {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="cc-product-link">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
									}
									// Meta data.
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WC function returns escaped HTML
									echo wc_get_formatted_cart_item_data( $cart_item );

									// Add Free Gift label
									if (isset($cart_item['caddy_free_gift']) && $cart_item['caddy_free_gift']) {
										echo '<div class="cc-free-gift-label">' . esc_html__('Gift Reward', 'caddy') . '</div>';
									}
									?>
									<div class="cc_item_quantity_wrap">
										<?php 
										// Check if quantity should be locked via filter
										$quantity_args = apply_filters('woocommerce_quantity_input_args', array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->get_max_purchase_quantity(),
											'min_value'   => '0',
											'product_name' => $_product->get_name(),
										), $_product);
										
										// Then use these args when displaying the quantity input
										$min = $quantity_args['min_value'];
										$max = $quantity_args['max_value'];
										
										// Check if product is a free gift - don't allow quantity adjustments for free gifts
										$is_free_gift = isset($cart_item['caddy_free_gift']) && $cart_item['caddy_free_gift'];
										
										if (!$_product->is_sold_individually() && strpos($quantity_args['input_value'], 'type="hidden"') === false && !$is_free_gift) {
											// Only show quantity controls for non-free gift items
											?>
											<div class="cc_item_quantity_update cc_item_quantity_minus" data-type="minus">−</div>
											<input type="text" 
												readonly 
												class="cc_item_quantity" 
												data-product_id="<?php echo esc_attr($product_id); ?>"
												data-key="<?php echo esc_attr($cart_item_key); ?>" 
												value="<?php echo esc_attr($cart_item['quantity']); ?>"
												step="<?php echo esc_attr(apply_filters('woocommerce_quantity_input_step', 1, $_product)); ?>"
												min="<?php echo esc_attr($min); ?>"
												max="<?php echo esc_attr($max); ?>">
											<div class="cc_item_quantity_update cc_item_quantity_plus<?php echo esc_attr($plus_disable); ?>" data-type="plus">+</div>
											<?php add_action('caddy_after_quantity_input', $product_id); ?>
											<?php
										} elseif ($is_free_gift) {
											// For free gifts, we don't show any quantity display at all
										}
										?>
									</div>
								</div>
								<div class="cc_item_total_price">
									<div class="price">
										<?php 
										// Get the product subtotal HTML first
										$product_subtotal = apply_filters('woocommerce_cart_item_subtotal', 
											WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), 
											$cart_item, 
											$cart_item_key
										);
										
										// If it's a free gift, always show "Free" instead of $0
										if (isset($cart_item['caddy_free_gift']) && $cart_item['caddy_free_gift']) {
											echo '<span class="cc-free-price">' . esc_html__('Free', 'caddy') . '</span>';
										} else {
											// Check if the product is on sale and the subtotal doesn't already include a strikethrough price
											if ($_product->is_on_sale() && strpos($product_subtotal, '<del>') === false) {
												// Get regular and sale prices respecting WooCommerce tax display setting
												$tax_display = get_option('woocommerce_tax_display_cart');
												
												if ('incl' === $tax_display) {
													// Get prices including tax
													$regular_price_with_tax = wc_get_price_including_tax($_product, array(
														'qty' => $cart_item['quantity'],
														'price' => $_product->get_regular_price()
													));
													$sale_price_with_tax = wc_get_price_including_tax($_product, array(
														'qty' => $cart_item['quantity'],
														'price' => $_product->get_sale_price()
													));
													
													// Display original price and sale price on the same line
													// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_price returns escaped HTML
													echo '<del>' . wc_price($regular_price_with_tax) . '</del> ' . wc_price($sale_price_with_tax);
												} else {
													// Get prices excluding tax
													$regular_price_without_tax = wc_get_price_excluding_tax($_product, array(
														'qty' => $cart_item['quantity'],
														'price' => $_product->get_regular_price()
													));
													$sale_price_without_tax = wc_get_price_excluding_tax($_product, array(
														'qty' => $cart_item['quantity'],
														'price' => $_product->get_sale_price()
													));
													
													// Display original price and sale price on the same line
													// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_price returns escaped HTML
													echo '<del>' . wc_price($regular_price_without_tax) . '</del> ' . wc_price($sale_price_without_tax);
												}
											} else {
												// Output the product subtotal
												// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce function returns escaped HTML
												echo $product_subtotal;
											}
										}
										?>
									</div>
									<?php
									// Show savings percentage on a separate line, only for sale products
									if ($_product->is_on_sale() && !isset($cart_item['caddy_free_gift'])) {
										// Get regular and sale prices respecting WooCommerce tax display setting
										$tax_display = get_option('woocommerce_tax_display_cart');
										
										if ('incl' === $tax_display) {
											// Get prices including tax
											$regular_price_display = wc_get_price_including_tax($_product, array(
												'qty' => $cart_item['quantity'],
												'price' => $_product->get_regular_price()
											));
											$sale_price_display = wc_get_price_including_tax($_product, array(
												'qty' => $cart_item['quantity'],
												'price' => $_product->get_sale_price()
											));
										} else {
											// Get prices excluding tax
											$regular_price_display = wc_get_price_excluding_tax($_product, array(
												'qty' => $cart_item['quantity'],
												'price' => $_product->get_regular_price()
											));
											$sale_price_display = wc_get_price_excluding_tax($_product, array(
												'qty' => $cart_item['quantity'],
												'price' => $_product->get_sale_price()
											));
										}
										
										$savings = $regular_price_display - $sale_price_display;
										if ($savings > 0) {
											$savings_percentage = round(($savings / $regular_price_display) * 100);
											?>
											<div class="cc_saved_amount">
												<?php 
												/* translators: %s: Savings percentage */
												echo sprintf(esc_html__('(Save %s)', 'caddy'), esc_html($savings_percentage) . '%'); 
												?>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>
							<div class="cc-item-content-bottom">
								<div class="cc-item-content-bottom-left">
	
									<?php
									if ( is_user_logged_in() ) {
										// Check save for later setting (works for both free and premium)
										$cc_enable_sfl_options = get_option( 'cc_enable_sfl_options', 'enabled' );
										$caddy_sfl_button = ( 'enabled' === $cc_enable_sfl_options );
										// Don't show save for later button for free gifts
										if ( isset($cart_item['caddy_free_gift']) && $cart_item['caddy_free_gift'] ) {
											$caddy_sfl_button = false;
										}
										if ( $caddy_sfl_button ) {
											?>
											<div class="cc_sfl_btn">
												<?php
												echo sprintf(
													'<a href="%1$s" class="button cc-button-sm save_for_later_btn" aria-label="%2$s" data-product_id="%3$s" data-cart_item_key="%4$s">%5$s</a>',
													'javascript:void(0);',
													esc_attr__( 'Save for later', 'caddy' ),
													esc_attr( $product_id ),
													esc_attr( $cart_item_key ),
													esc_html__( 'Save for later', 'caddy' )
												);
												?>
												<div class="cc-loader" style="display: none;"></div>
											</div>
											<?php
										}
									}
									?>
								</div>
								<?php
								// Only show remove button if not a free gift
								if (!isset($cart_item['caddy_free_gift']) || !$cart_item['caddy_free_gift']) {
									echo sprintf(
										'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_name="%s"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke="currentColor" d="M1 6H23"></path><path stroke="currentColor" d="M4 6H20V22H4V6Z"></path><path stroke="currentColor" d="M9 10V18"></path><path stroke="currentColor" d="M15 10V18"></path><path stroke="currentColor" d="M8 6V6C8 3.79086 9.79086 2 12 2V2C14.2091 2 16 3.79086 16 6V6"></path></svg></a>',
										'javascript:void(0);',
										esc_attr__( 'Remove this item', 'caddy' ),
										esc_attr( $product_id ),
										esc_attr( $cart_item_key ),
										esc_attr( $product_name )
									);
								}
								?>
							</div>
						</div>
					</div>
				<?php }
				
				// Example of calling do_action with two arguments
				do_action('caddy_cart_after_product', $cart_item, $cart_item_key);
				
				?>
				
				</div>
			<?php }
		}
	}

	public function caddy_add_cart_widget_to_menu($items, $args) {
		$menu_slug = '';
		
		// Handle cases where menu is passed as object or string
		if (is_object($args->menu) && property_exists($args->menu, 'slug')) {
			$menu_slug = $args->menu->slug;
		} elseif (is_string($args->menu)) {
			$menu_slug = $args->menu;
		}

		// Check if this is the menu we want to add the widget to
		if ($menu_slug === get_option('cc_menu_cart_widget')) {
			$cart_widget = new caddy_cart_widget();

			// Simulate the arguments required for the widget method
			$widget_args = array(
				'before_widget' => '<li class="menu-item">',
				'after_widget'  => '</li>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>'
			);
			$instance = array(); // Adjust or populate as needed

			// Use output buffering to capture the widget output
			ob_start();
			$cart_widget->widget($widget_args, $instance);
			$widget_output = ob_get_clean();

			// Append the widget output to the menu items
			$items .= $widget_output;
		}

		return $items;
	}

	public function caddy_add_saves_widget_to_menu($items, $args) {
		// Check if user is logged in
		if (!is_user_logged_in()) {
			return $items;
		}

		// Check if save for later is enabled
		$cc_enable_sfl_options = get_option( 'cc_enable_sfl_options', 'enabled' );
		if ( 'disabled' === $cc_enable_sfl_options ) {
			return $items;
		}

		$menu_slug = '';
		
		// Handle cases where menu is passed as object or string
		if (is_object($args->menu) && property_exists($args->menu, 'slug')) {
			$menu_slug = $args->menu->slug;
		} elseif (is_string($args->menu)) {
			$menu_slug = $args->menu;
		}

		// Check if this is the menu we want to add the widget to
		if ($menu_slug === get_option('cc_menu_saves_widget')) {
			$save_for_later_widget = new caddy_saved_items_widget();

			// Simulate the arguments required for the widget method
			$widget_args = array(
				'before_widget' => '<li class="menu-item">',
				'after_widget'  => '</li>',
				'before_title'  => '', // Title wrappers removed
				'after_title'   => ''
			);

			// Provide default or expected values for the instance
			$instance = array(
				'si_text'    => __('Saves', 'caddy'),  // Default text
				'cc_si_icon' => 'off'                  // Set icon display behavior
			);

			// Use output buffering to capture the widget output
			ob_start();
			$save_for_later_widget->widget($widget_args, $instance);
			$widget_output = ob_get_clean();

			// Append the widget output to the menu items
			$items .= $widget_output;
		}

		return $items;
	}

	/**
	 * Prevent redirect to cart page after adding item
	 */
	public function prevent_cart_redirect($value) {
		return false;
	}

	/**
	 * Handle post-add-to-cart actions
	 */
	public function after_add_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
		WC()->cart->calculate_totals();
		WC_AJAX::get_refreshed_fragments();
	}

	/**
	 * Update cart item quantity
	 */
	public function cc_update_item_quantity() {
		check_ajax_referer('caddy', 'nonce');

		$cart_key = isset($_POST['cart_key']) ? sanitize_text_field(wp_unslash($_POST['cart_key'])) : '';
		$quantity = isset($_POST['qty']) ? (float) $_POST['qty'] : 0;

		if ($cart_key && WC()->cart->get_cart_item($cart_key)) {
			WC()->cart->set_quantity($cart_key, $quantity);
		}

		WC_AJAX::get_refreshed_fragments();
	}

	/**
	 * Always validate add to cart
	 *
	 * @since    1.0.0
	 * @return   bool
	 */
	public function validate_add_to_cart() {
		return true;
	}

	/**
	 * Exclude cart-related AJAX endpoints from caching
	 *
	 * @param array $uri Array of URIs to exclude from caching
	 * @return array Modified array of URIs
	 */
	public function exclude_cart_endpoints_from_cache($uri) {
		$cart_endpoints = array(
			'/\?wc-ajax=add_to_cart',
			'/\?wc-ajax=remove_from_cart',
			'/\?wc-ajax=cc_remove_item_from_cart',
			'/admin-ajax\.php\?action=cc_remove_item_from_cart',
			'/admin-ajax\.php\?action=caddy_get_cart_fragments'
		);

		return array_merge($uri, $cart_endpoints);
	}

	/**
	 * Cache-friendly cart fragments handler
	 * Uses admin-ajax.php instead of wc-ajax for better cache compatibility
	 */
	public function caddy_get_cart_fragments() {
		// No nonce verification needed for read-only cart data
		// This improves caching compatibility
		$this->get_refreshed_fragments();
	}

}