<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.madebytribe.com
 * @since      1.0.0
 *
 * @package    Caddy
 * @subpackage Caddy/admin/partials
 */

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'caddy' ) );
}

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameter to determine which tab to display
$caddy_tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( sanitize_text_field(wp_unslash($_GET['tab'])) ) : 'settings';

$caddy_tabs_name = array(
	'settings' => array(
		'tab_name' => __( 'Settings', 'caddy' ),
		'tab_icon' => 'dashicons cc-icon-settings',
	),
	'styles'   => array(
		'tab_name' => __( 'Styling', 'caddy' ),
		'tab_icon' => 'dashicons cc-icon-styles',
	)
);

/**
 * Filters the caddy tab names.
 *
 * @param array $caddy_tabs_name Caddy tab names.
 *
 * @since 1.3.0
 *
 */
$caddy_tabs = apply_filters( 'caddy_tab_names', $caddy_tabs_name );

// Display settings updated message if needed
if (get_transient('caddy_settings_updated')) {
    delete_transient('caddy_settings_updated');
    ?>
    <div class="updated">
        <p>
            <strong><?php echo esc_html( __( 'Settings saved.', 'caddy' ) ); ?></strong> <?php echo esc_html( __( 'If you\'re using any caching plugins please be sure to ', 'caddy' ) ); ?>
            <strong><?php echo esc_html( __( 'clear your cache. ', 'caddy' ) ); ?></strong></p>
    </div>
<?php } ?>

<div class="wrap">

	<?php do_action( 'caddy_admin_header' ); ?>

	<h2 class="nav-tab-wrapper">
		<?php
		foreach ( $caddy_tabs as $key => $value ) {
			$active_tab_class = ( $key == $caddy_tab ) ? ' nav-tab-active' : '';
			?>
			<a class="nav-tab<?php echo esc_attr( $active_tab_class ); ?>" href="?page=caddy&amp;tab=<?php echo esc_attr( $key ); ?>"><i class="<?php echo esc_attr( $value['tab_icon'] ); ?>"></i>&nbsp;<?php echo esc_html( $value['tab_name'] ); ?></a>
		<?php } ?>
	</h2>

	<?php do_action( 'cc_before_setting_options' ); ?>
	<div class="cc-settings-wrap">
		<?php do_action( 'caddy_admin_tab_screen' ); ?>
		<div class="cc-notices-container">

			<?php do_action( 'cc_upgrade_to_premium' ); ?>
			<div class="cc-box cc-links">
				<h3><?php echo esc_html( __( 'More Premium Plugins', 'caddy' ) ); ?></h3>
				<ul class="cc-product-links">
					<li>
						<img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/klaviyo-logo.jpg' ); ?>" width="40" height="40" />
						<div>
							<a href="https://www.madebytribe.com/products/klaviyo-toolkit/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=caddy-links"
							   target="_blank"><?php echo esc_html( __( 'Klaviyo ToolKit', 'caddy' ) ); ?></a>
							<p><?php echo esc_html( __( 'Improve your WooCommerce email marketing with Klaviyo.', 'caddy' ) ); ?></p>
						</div>
					</li>
					<li>
						<img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/rk-logo-avatar.svg' ); ?>" width="40" height="40" />
						<div>
							<a href="https://www.getretentionkit.com/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=caddy-links"
							   target="_blank"><?php echo esc_html( __( 'RetentionKit', 'caddy' ) ); ?></a>
							<p><?php echo esc_html( __( 'Learn why users cancel their WC subscriptions with exit surveys, offer renewal discounts to stay and more.', 'caddy' ) ); ?></p>
						</div>
					</li>
				</ul>
			</div>
			<div class="cc-box cc-links">
				<h3><?php echo esc_html( __( 'Caddy Quick Links', 'caddy' ) ); ?></h3>
				<ul>
					<li>
						<a href="https://usecaddy.com/docs/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( 'Read the documentation', 'caddy' ) ); ?></a>
					</li>
					<li>
						<a href="https://usecaddy.com/my-account/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( 'Register / Log into your account', 'caddy' ) ); ?></a>
					</li>
					<li>
						<a href="https://wordpress.org/support/plugin/caddy/reviews/#new-post" target="_blank"><?php echo esc_html( __( 'Leave a review', 'caddy' ) ); ?></a>
					</li>
					<li>
						<a href="https://usecaddy.com/contact-us/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( 'Contact support', 'caddy' ) ); ?></a>
					</li>
				</ul>
			</div>

		</div>
	</div>
	<?php do_action( 'cc_after_setting_options' ); ?>
	<div class="cc-footer-links">
		<?php echo esc_html( __( 'Made with', 'caddy' ) ); ?> <span style="color: #e25555;">♥</span> <?php echo esc_html( __( 'by', 'caddy' ) ); ?>
		<a href="<?php echo esc_url( 'https://www.madebytribe.com' ); ?>" target="_blank"><?php echo esc_html( __( 'TRIBE', 'caddy' ) ); ?></a>
	</div>
</div>