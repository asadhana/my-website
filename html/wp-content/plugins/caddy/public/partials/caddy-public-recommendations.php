<?php
/**
 * Product recommendations screen html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$cc_product_recommendation = get_option( 'cc_product_recommendation' );
if ( empty( $product_id ) || 'enabled' !== $cc_product_recommendation ) {
	return;
}

$product = wc_get_product( $product_id );
$orderby = 'rand';
$order   = 'desc';

// Get the recommendation type setting, default to upsells for backward compatibility
$cc_product_recommendation_type = get_option( 'cc_product_recommendation_type' );

// Initialize array to store recommended product IDs
$recommended_products = array();

// Get recommendations based on type
if (!empty($cc_product_recommendation_type)) {
    switch ($cc_product_recommendation_type) {
        case 'caddy-recommendations':
            $recommended_products = get_post_meta($product_id, '_caddy_recommendations', true);
            break;
            
        case 'cross-sells':
            $recommended_products = $product->get_cross_sell_ids();
            break;
            
        case 'upsells':
            $recommended_products = $product->get_upsell_ids();
            break;
    }
} else {
    // Backward compatibility: use upsells if no type is set
    $recommended_products = $product->get_upsell_ids();
}

// Filter visible products
$final_recommended_products = array();
if (!empty($recommended_products)) {
    foreach ($recommended_products as $recommended_id) {
        $recommended_product = wc_get_product($recommended_id);
        if ($recommended_product && 'publish' === $recommended_product->get_status()) {
            $final_recommended_products[] = $recommended_id;
        }
    }
}

// Fallback to best sellers if no recommendations found
if (empty($final_recommended_products)) {
    // First get product IDs with visibility filter applied via a function
    // rather than using tax_query directly
    $args = array(
        'limit' => 6, // Get one extra in case the current product is in the results
        'status' => 'publish',
        'orderby' => 'meta_value_num',
        'order'   => 'DESC',
        // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
        'meta_key' => 'total_sales',
        'visibility' => 'visible', // This replaces the tax_query
    );
    
    $products = wc_get_products($args);
    
    // Filter out current product in PHP instead of using exclude
    $final_recommended_products = array();
    $count = 0;
    foreach ($products as $recommended_product) {
        if ($recommended_product->get_id() != $product_id && $count < 5) {
            $final_recommended_products[] = $recommended_product->get_id();
            $count++;
        }
    }
}
?>

<?php if ( ! empty( $final_recommended_products ) && ! class_exists( 'Caddy_Premium' )) { ?>
	<div class="cc-pl-info-wrapper">
		<div class="cc-pl-upsells">
			<label><?php esc_html_e( 'We think you might also like...', 'caddy' ); ?></label>
			<div class="cc-pl-upsells-wrapper">
				<div class="cc-pl-upsells-slider">
					<?php
				foreach ( $final_recommended_products as $recommended_product_id ) {
					global $product;
					$product = wc_get_product( $recommended_product_id );
					$product_image    = $product->get_image();
					$product_name     = $product->get_name();
					$product_price    = $product->get_price_html();
					$product_link     = get_permalink( $recommended_product_id );
					?>
					<div class="slide">
						<div class="up-sells-product">
							<div class="cc-up-sells-image"><a href="<?php echo esc_url( $product_link ); ?>"><?php 
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce function returns escaped HTML
							echo $product_image; ?></a></div>
							<div class="cc-up-sells-details">
								<a href="<?php echo esc_url( $product_link ); ?>" class="title"><?php echo esc_html( $product_name ); ?></a>
								<div class="cc_item_total_price">
									<span class="price"><?php 
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce function returns escaped HTML
									echo $product_price; ?></span>
								</div>
								<?php
								// Set up the product for the loop
								setup_postdata($product->get_id());
								
								// Use WooCommerce's built-in add to cart button function
								woocommerce_template_loop_add_to_cart();
								
								// Reset post data
								wp_reset_postdata();
								?>
							</div>
						</div>
						</div>
					<?php } ?>
				</div>
				<div class="caddy-prev">
					<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" version="1.1" id="Tailless-Line-Arrow-Left-1--Streamline-Core">
						<path d="M13.75 0.68682C13.706 0.70136 13.638499999999999 0.72918 13.6 0.74862C13.49172 0.80328 5.237419999999999 9.06048 5.1315800000000005 9.22C4.8194 9.69054 4.8194 10.30936 5.1315599999999995 10.78C5.19276 10.872280000000002 6.42668 12.1177 9.3839 15.072000000000001C14.07654 19.76 13.61372 19.32936 13.96 19.32978C14.12646 19.329980000000003 14.16488 19.32306 14.27 19.274C14.41248 19.20752 14.56516 19.06538 14.6301 18.93874C14.690840000000001 18.82024 14.726379999999999 18.62038 14.70954 18.491880000000002C14.702200000000001 18.435840000000002 14.673060000000001 18.336 14.6448 18.27C14.5967 18.15768 14.33296 17.88932 10.52196 14.075000000000001L6.45052 10 10.52196 5.925C14.33296 2.1106800000000003 14.5967 1.84232 14.6448 1.73C14.71158 1.5741 14.72838 1.43654 14.69988 1.27938C14.669760000000002 1.11322 14.605440000000002 0.99154 14.48664 0.876C14.347480000000001 0.74062 14.18934 0.67386 13.99 0.66636C13.894459999999999 0.66278 13.79776 0.6709999999999999 13.75 0.68682" stroke="none" fill="currentColor" fill-rule="evenodd"></path>
					</svg>
				</div>
            	<div class="caddy-next">
            		<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded safe HTML ?>
                	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" version="1.1" id="Tailless-Line-Arrow-Right-1--Streamline-Core">
                    	<path d="M5.83 0.68688C5.61066 0.7596200000000001 5.43864 0.91026 5.3468 1.11C5.29948 1.21294 5.29164 1.2556 5.291799999999999 1.41C5.29196 1.5643 5.30016 1.60856 5.34928 1.72C5.404160000000001 1.8445 5.57904 2.0225999999999997 9.47804 5.925L13.54948 10 9.47804 14.075000000000001C5.57904 17.9774 5.404160000000001 18.1555 5.34928 18.28C5.30008 18.39162 5.29198 18.435460000000003 5.29198 18.59C5.29198 18.744 5.299980000000001 18.78764 5.34742 18.8921C5.41748 19.04638 5.5714 19.20006 5.73 19.27404C5.8351 19.32306 5.87358 19.329980000000003 6.04 19.32978C6.38628 19.32936 5.92346 19.76 10.6161 15.072000000000001C13.57332 12.1177 14.80724 10.872280000000002 14.868440000000001 10.78C15.025640000000001 10.54298 15.1 10.292539999999999 15.1 10C15.1 9.70746 15.025640000000001 9.45702 14.868440000000001 9.22C14.80724 9.12772 13.57332 7.882300000000001 10.6161 4.928C6.84122 1.15686 6.43968 0.76166 6.34 0.7196800000000001C6.205940000000001 0.66322 5.95082 0.6468 5.83 0.68688" stroke="none" fill="currentColor" fill-rule="evenodd"></path>
					</svg>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			$( '.cc-pl-upsells-slider' ).not( '.slick-initialized' ).slick( {
				infinite: true,
				speed: 300,
				slidesToShow: 1,
				slidesToScroll: 1,
				prevArrow: $( '.caddy-prev' ),
				nextArrow: $( '.caddy-next' ),
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			} );
		} );
	</script>
<?php } ?>