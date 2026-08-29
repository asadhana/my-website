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
<form name="caddy-form" id="caddy-display-form" method="post" action="">
	<?php wp_nonce_field('caddy-display-settings-save', 'caddy_display_settings_nonce'); ?>
	<input type="hidden" name="cc_submit_hidden" value="Y">
	<div class="cc-settings-container">
		<h2><span class="section-icons"><img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-display.svg' ); ?>" /></span>&nbsp;<?php echo esc_html( __( 'Display Behavior', 'caddy' ) ); ?></h2>
		<p><?php esc_html_e('Select what Caddy should do after a product is added to cart or saved for later.', 'caddy'); ?></p>
		<?php if ( $caddy_license_status !== 'valid' ) { ?>
			<div class="cc-box cc-box-cta cc-upgrade">
				<img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-lock.svg' ); ?>" />
				<h3><?php echo esc_html( __( 'Unlock a Display Settings with Caddy Pro', 'caddy' ) ); ?></h3>
				<p><?php echo esc_html( __( 'Change the location of the cart bubble, cart drawer behaviour, and more. Plus:', 'caddy' ) ); ?></p>
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
			<table class="form-table">
				<tbody>
					<?php do_action( 'caddy_display_settings_start' ); ?>
					<?php do_action( 'caddy_display_settings_end' ); ?> 
				</tbody>
			</table>
		<?php } ?>
	</div>
	<?php if ( $caddy_license_status == 'valid' ) { ?>
		<p class="submit cc-primary-save">
			<input type="submit" name="Submit" class="button-primary cc-primary-save-btn" value="<?php echo esc_attr__( 'Save Changes', 'caddy' ); ?>" />
		</p>
	<?php } ?>
</form>