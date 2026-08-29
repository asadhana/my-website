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

<?php
// GET STYLE OPTIONS
$cc_custom_css = get_option( 'cc_custom_css' );
$cc_custom_css = ! empty( $cc_custom_css ) ? esc_html( stripslashes( $cc_custom_css ) ) : '';
?>
<form method="post" action="" id="cc-styles-settings-form">
	<?php wp_nonce_field('caddy-styles-settings-save', 'caddy_styles_settings_nonce'); ?>
	<input type="hidden" name="cc_submit_hidden" value="Y">
	<div id="cc-style-settings" class="cc-settings-pane">
		<div class="cc-settings-container">
			<?php do_action( 'caddy_before_color_selectors_section' ); ?>
			<h2><i class="dashicons dashicons-color-picker section-icons"></i>&nbsp;<?php echo esc_html( __( 'Custom Styles', 'caddy' ) ); ?></h2>
			<p><?php echo esc_html( __( 'General style customization options.', 'caddy' ) ); ?></p>
			
			<?php do_action( 'caddy_before_custom_css_row' ); ?>
			<table class="form-table cc-style-table">
				<tbody>
				<tr>
					<th scope="row">
						<label for="cc_custom_css"><?php echo esc_html( __( 'Custom CSS', 'caddy' ) ); ?></label>
					</th>
					<td class="color-picker">
						<label><textarea name="cc_custom_css" id="cc_custom_css" rows="10" cols="50"><?php echo esc_textarea( $cc_custom_css ); ?></textarea></label>
					</td>
				</tr>
				</tbody>
			</table>
			<?php do_action( 'caddy_after_custom_css_row' ); ?>
			<?php
			$caddy_license_status = get_option( 'caddy_premium_edd_license_status' );
			if ( ! isset( $caddy_license_status ) || 'valid' !== $caddy_license_status ) {
				?>
				<div class="cc-unlock-msg">
					<div><span class="dashicons dashicons-unlock"></span><?php echo esc_html( __( 'Unlock 7 different cart icons, change bubble position, set 15+ custom color options & more with ', 'caddy' ) ); ?><a
								href="<?php echo esc_url( 'https://www.usecaddy.com' ); ?>" target="_blank"><?php echo esc_html( __( 'Caddy Pro', 'caddy' ) ); ?></a></div>
				</div>
				<?php
			} ?>
			
		</div>
		<p class="submit cc-primary-save">
			<input type="submit" name="Submit" class="button-primary cc-primary-save-btn" value="<?php esc_attr_e( 'Save Changes', 'caddy' ); ?>" />
		</p>
	</div>
</form>
<?php 
