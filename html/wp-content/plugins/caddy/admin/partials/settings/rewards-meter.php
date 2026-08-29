<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin style screen of the plugin.
 *
 * @link       https://www.madebytribe.com
 * @since      1.0.0
 *
 * @package    Caddy
 * @subpackage Caddy/admin/partials
 */
 
?>
<form name="caddy-form" id="caddy-rewards-meter-form" method="post" action="">
	<?php wp_nonce_field('caddy-rewards-meter-settings-save', 'caddy_rewards_meter_settings_nonce'); ?>
	<input type="hidden" name="cc_submit_hidden" value="Y">
	<div class="cc-settings-container">
		<h2><span class="section-icons"><img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-reward-meter.svg' ); ?>" /></span>&nbsp;<?php echo esc_html( __( 'Multi-Tier Rewards Meter', 'caddy' ) ); ?></h2>
		<p><?php esc_html_e('Set up your rewards tiers. Each tier can offer free shipping, a free gift, or a cart discount.', 'caddy'); ?>
		<?php if ( $caddy_license_status == 'valid' ) { ?>	
			<strong>
			<?php echo esc_html( __( 'Important: Free shipping rewards are only available if a free shipping method is configured within your WooCommerce', 'caddy' ) ); ?> <a href="<?php echo esc_url( get_site_url() ); ?>/wp-admin/admin.php?page=wc-settings&tab=shipping"><?php echo esc_html( __( 'shipping settings', 'caddy' ) ); ?></a></strong>.</p>
		<?php } ?>
		<?php if ( $caddy_license_status !== 'valid' ) { ?>
			<div class="cc-box cc-box-cta cc-upgrade">
				<img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-lock.svg' ); ?>" />
				<h3><?php echo esc_html( __( 'Unlock a Multi-Tier Rewards Meter with Caddy Pro', 'caddy' ) ); ?></h3>
				<p><?php echo esc_html( __( 'Offer free shipping, gifts and discounts to shoppers based on their order total. Plus:', 'caddy' ) ); ?></p>
				<ul>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Analytics dashboard.', 'caddy' ) ); ?></li>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Cart & conversion tracking.', 'caddy' ) ); ?></li>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Custom recommendation logic.', 'caddy' ) ); ?></li>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Targeted workflows.', 'caddy' ) ); ?></li>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Total design control.', 'caddy' ) ); ?></li>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Bubble positioning options.', 'caddy' ) ); ?></li>
					<li><span class="dashicons dashicons-saved"></span><?php echo esc_html( __( 'Cart notices, add-ons & more.', 'caddy' ) ); ?></li>
				</ul>

				<?php 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Function returns escaped HTML
			echo caddy_get_limited_time_offer(); 
			?>
				<?php
				echo sprintf(
					'<a href="%1$s" target="_blank" class="button-primary">%2$s</a>',
					esc_url( 'https://usecaddy.com/?utm_source=upgrade-notice&amp;utm_medium=plugin&amp;utm_campaign=plugin-links' ),
					esc_html( __( 'Get Caddy Pro', 'caddy' ) )
				); ?>
			</div>
		<?php } ?>
		<?php if ( $caddy_license_status == 'valid' ) { ?>
			<?php do_action( 'caddy_rewards_meter_settings_start' ); ?>
			<?php do_action( 'caddy_rewards_meter_settings_end' ); ?> 
		<?php } ?>
	</div>
	<?php if ( $caddy_license_status == 'valid' ) { ?>
		<p class="submit cc-primary-save">
			<input type="submit" name="Submit" class="button-primary cc-primary-save-btn" value="<?php echo esc_attr__( 'Save Changes', 'caddy' ); ?>" />
		</p>
	<?php } ?>
</form>
<?php 