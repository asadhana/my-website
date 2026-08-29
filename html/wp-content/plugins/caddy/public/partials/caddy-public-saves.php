<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$current_user_id = get_current_user_id();

$cc_sfl_items_array = get_user_meta( $current_user_id, 'cc_save_for_later_items', true );
if ( ! is_array( $cc_sfl_items_array ) ) {
	$cc_sfl_items_array = array();
}
$cc_sfl_items = array_reverse( array_unique( $cc_sfl_items_array ) );

$cc_disable_branding = get_option( 'cc_disable_branding' ); // Get disable branding
$cc_disable_branding_class = ( 'disabled' === $cc_disable_branding ) ? ' cc-no-branding' : '';

$cc_empty_class = ( empty( $cc_sfl_items ) ) ? ' cc-empty' : '';
?>

<div class="cc-sfl-container">

	<div class="cc-sfl-notice"></div>
	<div class="cc-body-container">
		<div class="cc-body<?php echo esc_attr( $cc_empty_class . $cc_disable_branding_class ); ?>">
	
			<?php do_action( 'caddy_display_registration_message' ); ?>
	
			<?php if ( ! empty( $cc_sfl_items ) ) { ?>
				<div class="cc-row cc-cart-items cc-text-center">
					<?php
					foreach ( $cc_sfl_items as $product_id ) {
						$product = wc_get_product( $product_id );
						if ( empty( $product ) ) {
							continue;
						}
	
						$product_name = $product->get_name();
	
						$product_regular_price = get_post_meta( $product_id, '_regular_price', true );
						$product_sale_price    = get_post_meta( $product_id, '_sale_price', true );
						if ( ! empty( $product_sale_price ) ) {
							$percentage = ( ( $product_regular_price - $product_sale_price ) * 100 ) / $product_regular_price;
						}
						$product_price     = $product->get_price_html();
						$product_permalink = get_permalink( $product_id );
						$product_image     = $product->get_image( array( 200, 200 ) );
						?>
						<div class="cc-cart-product-list">
							<div class="cc-cart-product">
								<a href="<?php echo esc_url( $product_permalink ); ?>" class="cc-product-link cc-product-thumb" data-title="<?php echo esc_attr( $product_name ); ?>">
									<?php 
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce function returns escaped HTML
						echo $product_image; ?>
								</a>
								<div class="cc_item_content">
									<div class="cc_item_title">
										<a href="<?php echo esc_url( $product_permalink ); ?>" class="cc-product-link"
										   data-title="<?php echo esc_attr( $product_name ); ?>"><?php echo esc_html( $product_name ); ?></a>
									</div>
									<?php if ( ! empty( $product_price ) ) { ?>
										<div class="cc_item_total_price">
											<div class="price"><?php 
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce function returns escaped HTML
							echo $product_price; ?></div>
											<?php if ( $product->is_on_sale() ) { ?>
												<div class="cc_saved_amount"><?php echo esc_html__( 'Save ', 'caddy' ) . esc_html( round( $percentage ) ) . '%'; ?></div>
											<?php } ?>
										</div>
									<?php } ?>
									<div class="cc_move_to_cart_btn">
										<?php
										echo sprintf(
											'<a href="%s" class="button cc-button-sm cc_cart_from_sfl" aria-label="%s" data-product_id="%s">%s</a>',
											'javascript:void(0);',
											esc_attr__( 'Move to cart', 'caddy' ),
											esc_attr( $product_id ),
											esc_html__( 'Move to cart', 'caddy' )
										);
										?>
										<div class="cc-loader" style="display: none;"></div>
									</div>
								</div>
								<?php
								echo sprintf(
									'<a href="%s" class="remove remove_from_sfl_button" aria-label="%s" data-product_id="%s"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke="currentColor" d="M1 6H23"></path><path stroke="currentColor" d="M4 6H20V22H4V6Z"></path><path stroke="currentColor" d="M9 10V18"></path><path stroke="currentColor" d="M15 10V18"></path><path stroke="currentColor" d="M8 6V6C8 3.79086 9.79086 2 12 2V2C14.2091 2 16 3.79086 16 6V6"></path></svg></a>',
									'javascript:void(0);',
									esc_attr__( 'Remove this item', 'caddy' ),
									esc_attr( $product_id )
								);
								?>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } else { ?>
				<div class="cc-empty-msg cc-text-center">
					<img class="cc-empty-saves-img" src="<?php echo esc_url( plugin_dir_url( __DIR__ ) ); ?>img/saves-empty.svg" alt="Empty Saves">
					<span class="cc-title"><?php esc_html_e( 'You haven\'t saved any items yet!', 'caddy' ); ?></span>
					<?php if ( is_user_logged_in() ) { ?>
						<p><?php esc_html_e( 'You can save your shopping cart items for later here.', 'caddy' ); ?></p>
						<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="cc-button"><?php esc_html_e( 'Browse Products', 'caddy' ); ?></a>
					<?php } else { ?>
						<p><?php esc_html_e( 'You must be logged into an account in order to save items.', 'caddy' ); ?></p>
						<a href="<?php echo esc_url( trailingslashit( wc_get_account_endpoint_url( '' ) ) ); ?>"
						   class="cc-button"><?php esc_html_e( 'Login or Register', 'caddy' ); ?></a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
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