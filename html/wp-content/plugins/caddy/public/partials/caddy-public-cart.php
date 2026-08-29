<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! is_object( WC()->cart ) ) {
	return;
}

// Determine if the cart is empty and set a class accordingly
$cc_empty_class = WC()->cart->is_empty() ? ' cc-empty' : '';

// Get the free shipping amount setting first
$cc_free_shipping_amount = get_option('cc_free_shipping_amount');

// Calculate cart total for free shipping
$cart_total = 0;

// Get cart subtotal excluding virtual products
foreach (WC()->cart->get_cart() as $cart_item) {
    $product = $cart_item['data'];
    
    // Skip virtual products in the free shipping calculation
    if ($product->is_virtual()) {
        continue;
    }
    
    $item_total = WC()->cart->get_product_subtotal($product, $cart_item['quantity']);
    $item_total = preg_replace('/[^0-9.]/', '', $item_total); // Remove currency symbols
    $cart_total += floatval($item_total);
}

// Calculate the remaining amount for free shipping
$free_shipping_remaining_amount = floatval($cc_free_shipping_amount) - floatval($cart_total);
$free_shipping_remaining_amount = !empty($free_shipping_remaining_amount) ? $free_shipping_remaining_amount : 0;

// Calculate the width of the free shipping bar as a percentage
$cc_bar_amount = 100;
if (!empty($cc_free_shipping_amount) && $cart_total <= $cc_free_shipping_amount) {
    $cc_bar_amount = ($cart_total * 100 / $cc_free_shipping_amount);
}

// Get the WooCommerce currency symbol
$wc_currency_symbol = get_woocommerce_currency_symbol();

// Get the total count of items in the cart
$total_cart_item_count = is_object(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;

// Flag to determine if free shipping bar is enabled
$cc_free_shipping_bar = true;

// Retrieve the current user's ID and their saved for later items
$current_user_id = get_current_user_id();
$cc_sfl_items_array = get_user_meta($current_user_id, 'cc_save_for_later_items', true);
if (!is_array($cc_sfl_items_array)) {
	$cc_sfl_items_array = array();
}
$cc_sfl_items = array_reverse(array_unique($cc_sfl_items_array));

// Get the shipping country and branding options
$cc_shipping_country = get_option('cc_shipping_country');
$cc_disable_branding = get_option('cc_disable_branding'); // Get disable branding option
$cc_disable_branding_class = ('disabled' === $cc_disable_branding) ? ' cc-no-branding' : '';

// Retrieve the currency symbol and cart items
$currency_symbol = get_woocommerce_currency_symbol();
$cart_items = WC()->cart->get_cart();
$cart_items_data = array_reverse($cart_items);

// Find the first product ID in the cart
$first_product_id = 0;
$first_cart_item = array_slice($cart_items_data, 0, 1, true);
if (!empty($first_cart_item)) {
	foreach ($first_cart_item as $first_product) {
		$first_product_id = $first_product['product_id'];
	}
}

// Determine if free shipping bar should be active
$cc_bar_active = ($cart_total >= $cc_free_shipping_amount) ? ' cc-bar-active' : '';
$cc_fs_active_class = (!empty($cc_free_shipping_amount) && $cc_free_shipping_bar) ? ' cc-fs-active' : '';

?>

<div class="cc-cart-container">

	<?php do_action( 'caddy_before_cart_screen_data' ); ?>

	<div class="cc-notice"><i class="ccicon-close"></i></div>
	
	<?php if ( ! empty( $cc_free_shipping_amount ) && $cc_free_shipping_bar ) { ?>
		<div class="cc-fs cc-text-left">
			<?php do_action( 'caddy_free_shipping_title_text' ); // Free shipping title html ?>
		</div>
	<?php } ?>
	
	<div class="cc-body-container">
		<div class="cc-body<?php echo esc_attr( $cc_empty_class . $cc_fs_active_class . $cc_disable_branding_class ); ?>">
	
			<?php do_action( 'caddy_display_registration_message' ); ?>
	
			<?php if ( ! WC()->cart->is_empty() ) { ?>
	
				<?php do_action( 'caddy_before_cart_items' ); ?>
	
				<div class="cc-row cc-cart-items cc-text-center">
					<?php Caddy_Public::cart_items_list( $cart_items ); ?>
	
				</div>
	
				<!--Product recommendation screen-->
				<div class="cc-product-upsells-wrapper">
					<?php
					if ( 0 !== $first_product_id ) {
						do_action( 'caddy_product_upsells_slider', $first_product_id );
					}
					?>
				</div>
				
				<?php do_action( 'caddy_after_cart_items' ); ?>
	
				
			<?php } else { ?>
				<div class="cc-empty-msg">
					<img class="cc-empty-cart-img" src="<?php echo esc_url( plugin_dir_url( __DIR__ ) ); ?>img/cart-empty.svg" alt="Empty Cart">
					<span class="cc-title"><?php esc_html_e( 'Your Cart is Empty!', 'caddy' ); ?></span>
	
					<?php if ( ! empty( $cc_sfl_items ) ) { ?>
						<p><?php esc_html_e( 'You haven\'t added any items to your cart yet, but you do have products in your saved list.', 'caddy' ); ?></p>
						<a href="javascript:void(0);" class="cc-button cc-view-saved-items"><?php esc_html_e( 'View Saved Items', 'caddy' ); ?></a>
					<?php } else { ?>
						<p><?php esc_html_e( 'It looks like you haven\'t added any items to your cart yet.', 'caddy' ); ?></p>
						<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="cc-button"><?php esc_html_e( 'Browse Products', 'caddy' ); ?></a>
					<?php } ?>
				</div>
			<?php } ?>
	
		</div>
	</div>
	<?php do_action( 'caddy_after_cart_screen_data' ); ?>

	<?php if ( ! WC()->cart->is_empty() ) { ?>
		<div class="cc-cart-actions<?php echo esc_attr( $cc_disable_branding_class ); ?>">

			<?php do_action( 'caddy_before_cart_screen_totals' ); ?>
			<?php if ( wc_coupons_enabled() ) {
				$applied_coupons = WC()->cart->get_applied_coupons();
				?>
				<div class="cc-coupon">
					<div class="woocommerce-notices-wrapper">
						<?php
						$notices = wc_get_notices();
						// Only print error notices
						if (isset($notices['error'])) {
							WC()->session->set('wc_notices', ['error' => $notices['error']]);
							wc_print_notices();
						}
						?>
					</div>
					<a class="cc-coupon-title" href="javascript:void(0);">
						<?php esc_html_e( 'Apply a promo code', 'caddy' ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" version="1.1" id="Tailless-Line-Arrow-Up-1--Streamline-Core">
							<path d="M9.6881 4.9297C9.524140000000001 4.965380000000001 9.37644 5.02928 9.22 5.13224C9.1265 5.19378 7.92168 6.38728 4.928 9.3839C0.24 14.07654 0.6706399999999999 13.61372 0.67022 13.96C0.67002 14.126520000000001 0.6769799999999999 14.165080000000001 0.72642 14.2721C0.79824 14.4275 0.953 14.581199999999999 1.10956 14.65258C1.2111 14.698879999999999 1.25632 14.707180000000001 1.40956 14.7076C1.56528 14.70804 1.6078200000000002 14.700239999999999 1.72 14.65076C1.84446 14.59584 2.02348 14.42008 5.925 10.52196L10 6.45052 14.075000000000001 10.52196C17.88932 14.33296 18.15768 14.5967 18.27 14.6448C18.336 14.673060000000001 18.435840000000002 14.702200000000001 18.491880000000002 14.70954C18.62038 14.726379999999999 18.82024 14.690840000000001 18.93874 14.6301C19.06538 14.56516 19.20752 14.41248 19.274 14.27C19.32306 14.16488 19.329980000000003 14.12646 19.32978 13.96C19.32936 13.61372 19.76 14.07654 15.072000000000001 9.3839C12.1177 6.42668 10.872280000000002 5.19276 10.78 5.1315599999999995C10.4682 4.92474 10.05878 4.849060000000001 9.6881 4.9297" stroke="none" fill="currentColor" fill-rule="evenodd"></path>
						</svg>
					</a>
					<div class="cc-coupon-form" style="display: none;">
						<div class="coupon">
							<form name="apply_coupon_form" id="apply_coupon_form" method="post">
								<input type="text" name="cc_coupon_code" id="cc_coupon_code" placeholder="<?php echo esc_attr__( 'Promo code', 'caddy' ); ?>" />
								<input type="submit" class="cc-button-sm cc-coupon-btn" name="cc_apply_coupon" value="<?php echo esc_attr__( 'Apply', 'caddy' ); ?>">
							</form>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if ( ! empty( $applied_coupons ) ) { ?>
			<div class="cc-discounts">
				<div class="cc-discount">
					<?php 
					foreach ( $applied_coupons as $code ) {
						$coupon_detail = new WC_Coupon( $code );
						?>
						<div class="cc-applied-coupon">
							<img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) ); ?>img/tag-icon.svg" alt="Discount Code">
							<span class="cc_applied_code"><?php echo esc_html( $code ); ?></span>
							<a href="javascript:void(0);" class="cc-remove-coupon"><i class="ccicon-close"></i></a>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				// Get coupon discounts only
				$coupon_discount_amount = 0;
				if ( wc_coupons_enabled() ) {
					$applied_coupons = WC()->cart->get_applied_coupons();
					if ( ! empty( $applied_coupons ) ) {
						foreach ( $applied_coupons as $code ) {
							$coupon = new WC_Coupon( $code );
							// Get discount amount respecting tax display setting
							$tax_display = get_option( 'woocommerce_tax_display_cart' );
							$inc_tax = ( 'incl' === $tax_display );
							$coupon_discount_amount = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), !$inc_tax );
						}
					}
				}

				// Display coupon discount amount if greater than 0
				if ($coupon_discount_amount > 0) {
					echo '<div class="cc-savings">' . 
						esc_html__('-', 'caddy') . 
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_price returns escaped HTML
						wc_price($coupon_discount_amount) . 
						'</div>';
				}
				?>
			</div>
			<?php } ?>
			<div class="cc-totals">
				<div class="cc-total-box">
					<div class="cc-total-text">
						<?php 
						echo esc_html__( 'Subtotal - ', 'caddy' ) . esc_html( $total_cart_item_count ) . ' ' . 
						esc_html( _n( 'item', 'items', $total_cart_item_count, 'caddy' ) ); 
						?>
						<br><span class="cc-subtotal-subtext"><?php esc_html_e( 'Shipping &amp; taxes calculated at checkout.', 'caddy' ); ?></span>
					</div>

					<?php
					// Let WooCommerce handle the subtotal calculation with discounts
					$cart_subtotal = WC()->cart->get_displayed_subtotal();
					
					// Get the coupon discount amount
					$coupon_discount_amount = 0;
					if (wc_coupons_enabled()) {
						$applied_coupons = WC()->cart->get_applied_coupons();
						if (!empty($applied_coupons)) {
							$tax_display = get_option('woocommerce_tax_display_cart');
							$inc_tax = ('incl' === $tax_display);
							
							foreach ($applied_coupons as $code) {
								$coupon = new WC_Coupon($code);
								$coupon_discount_amount += WC()->cart->get_coupon_discount_amount($coupon->get_code(), !$inc_tax);
							}
						}
					}
					
					// Calculate the total (subtotal minus coupon discount)
					$cart_total = $cart_subtotal - $coupon_discount_amount;
					
					// Calculate original total (before any discounts) for comparison
					$original_total = 0;
					foreach (WC()->cart->get_cart() as $cart_item) {
						$product = $cart_item['data'];
						$original_price = $product->get_regular_price();
						$original_total += floatval($original_price) * $cart_item['quantity'];
					}
					?>
					<div class="cc-total-amount">
						<?php 
						// Show the original total if it's greater than the cart total
						if ($original_total > $cart_total) {
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_price returns escaped HTML
							echo '<span class="cc-original-price"><del>' . wc_price($original_total) . '</del></span> ';
						}
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_price returns escaped HTML
						echo wc_price($cart_total, array('currency' => get_woocommerce_currency()));
						?>
					</div>
				</div>
			</div>

			<?php do_action( 'caddy_after_cart_screen_totals' ); ?>
			<?php 
				$checkout_lock_svg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="cc-icon-lock"><path fill="currentColor" fill-rule="evenodd" d="M8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7V10H8V7ZM6 10V7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7V10H21V23H3V10H6ZM11 18.5V14.5H13V18.5H11Z" clip-rule="evenodd"></path></svg>';
				$checkout_arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5px" class="cc-icon-arrow-right"><line x1="0.875" y1="12" x2="23.125" y2="12" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></line><polyline points="16.375 5.5 23.125 12 16.375 18.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></polyline></svg>';
			?>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="cc-button cc-button-primary"><?php 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML
			echo $checkout_lock_svg; ?> <?php esc_html_e( 'Checkout Now', 'caddy' ); ?><?php 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML
			echo $checkout_arrow_svg; ?></a>

			<?php do_action( 'caddy_after_cart_screen_checkout_button' ); ?>

		</div>
	<?php } ?>
	<input type="hidden" name="cc-compass-count-after-remove" class="cc-cart-count-after-product-remove" value="<?php echo esc_attr( $total_cart_item_count ); ?>">

	<?php
	$cc_compass_desk_notice = get_option( 'cp_desktop_notices', '' );
	$cc_compass_mob_notice  = get_option( 'cp_mobile_notices', 'mob_disable_notices' );
	$cc_compass_mob_notice  = ( wp_is_mobile() ) ? $cc_compass_mob_notice : '';
	$cc_is_mobile = ( wp_is_mobile() ) ? 'yes' : 'no';
	?>
	<input type="hidden" name="cc-compass-desk-notice" class="cc-compass-desk-notice" value="<?php echo esc_attr( $cc_compass_desk_notice ); ?>">
	<input type="hidden" name="cc-compass-mobile-notice" class="cc-compass-mobile-notice" value="<?php echo esc_attr( $cc_compass_mob_notice ); ?>">
	<input type="hidden" class="cc-is-mobile" value="<?php echo esc_attr( $cc_is_mobile ); ?>">

	<?php
	if ( 'disabled' !== $cc_disable_branding ) {
		$cc_affiliate_id = get_option( 'cc_affiliate_id' );
		$powered_by_link = ! empty( $cc_affiliate_id ) ? 'https://www.usecaddy.com?ref=' . esc_attr( $cc_affiliate_id ) : 'https://www.usecaddy.com';
		?>
		<div class="cc-poweredby cc-text-center">
			<?php
			
			// SVG code
			$powered_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.44,9.27A.48.48,0,0,0,20,9H12.62L14.49.61A.51.51,0,0,0,14.2,0a.5.5,0,0,0-.61.17l-10,14a.49.49,0,0,0,0,.52A.49.49,0,0,0,4,15h7.38L9.51,23.39A.51.51,0,0,0,9.8,24a.52.52,0,0,0,.61-.17l10-14A.49.49,0,0,0,20.44,9.27Z" fill="currentColor"></path></svg>';
			
			echo sprintf(
				'%1$s %2$s %3$s <a href="%4$s" rel="noopener noreferrer" target="_blank">%5$s</a>',
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML
				$powered_svg,
				esc_html__( 'Powered', 'caddy' ),
				esc_html__( 'by', 'caddy' ),
				esc_url( $powered_by_link ),
				esc_html__( 'Caddy', 'caddy' )
			);
			?>
		</div>
	<?php } ?>
</div>