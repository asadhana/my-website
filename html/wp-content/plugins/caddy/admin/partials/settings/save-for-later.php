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

// GET SFL OPTIONS
$cc_enable_sfl_options = get_option( 'cc_enable_sfl_options', 'enabled' );
$cc_enable_sfl_options = ( 'disabled' !== $cc_enable_sfl_options ) ? 'checked' : '';

?>
<form name="caddy-form" id="caddy-sfl-form" method="post" action="">
	<?php wp_nonce_field('caddy-sfl-settings-save', 'caddy_sfl_settings_nonce'); ?>
	<input type="hidden" name="cc_submit_hidden" value="Y">
	<div class="cc-settings-container">
		<h2><span class="section-icons"><img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-sfl.svg' ); ?>" /></span>&nbsp;<?php echo esc_html( __( 'Save for Later', 'caddy' ) ); ?></h2>
		<p><?php echo esc_html( __( 'Customize the save for later features in your store.', 'caddy' ) ); ?></p>

		<?php if ( ! isset( $caddy_license_status ) || 'valid' !== $caddy_license_status ) { ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="cc_enable_sfl_options"><?php echo esc_html( __( 'Enable Save for Later', 'caddy' ) ); ?></label>
					</th>
					<td>
						<div class="cc-toggle cc-toggle--size-small">
							<input type="checkbox" name="cc_enable_sfl_options" id="cc_enable_sfl_options" value="enabled" <?php echo esc_attr( $cc_enable_sfl_options ); ?>>
							<label for="cc_enable_sfl_options">
								<div class="cc-toggle__switch" data-checked="On" data-unchecked="Off"></div>
							</label>
						</div>
						<p class="description"><?php echo esc_html( __( 'Allow logged-in users to save items for later viewing.', 'caddy' ) ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php } ?>

		<?php if ( ! isset( $caddy_license_status ) || 'valid' !== $caddy_license_status ) { ?>
			<div class="cc-unlock-msg">
				<div><span class="dashicons dashicons-unlock"></span><?php echo esc_html( __( 'Unlock advanced save for later controls, product page settings, analytics & more with ', 'caddy' ) ); ?><a href="<?php echo esc_url( 'https://www.usecaddy.com' ); ?>" target="_blank"><?php echo esc_html( __( 'Caddy Pro', 'caddy' ) ); ?></a></div>
			</div>
			<?php
		} ?>
		<?php if ( $caddy_license_status == 'valid' ) { ?>
			<table class="form-table">
				<tbody>
					<?php do_action( 'caddy_sfl_settings_start' ); ?>
					<?php do_action( 'caddy_sfl_settings_end' ); ?>
				</tbody>
			</table>
		<?php } ?>

	</div>
	<p class="submit cc-primary-save">
		<input type="submit" name="Submit" class="button-primary cc-primary-save-btn" value="<?php echo esc_attr__( 'Save Changes', 'caddy' ); ?>" />
	</p>
</form>
<?php 