<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin settings screen of the plugin.
 *
 * @see        https://www.madebytribe.com
 * @since      1.0.0
 */
?>

<?php
// GET SETTINGS OPTIONS

$cc_disable_branding = get_option( 'cc_disable_branding' );
$cc_disable_branding = ( 'disabled' !== $cc_disable_branding ) ? 'checked' : '';

$cc_affiliate_id = get_option( 'cc_affiliate_id' );

$cc_cart_selected_menu = get_option('cc_menu_cart_widget');
$cc_saves_selected_menu = get_option('cc_menu_saves_widget');

$caddy_license_status = get_option( 'caddy_premium_edd_license_status' );

?>
<form name="caddy-form" id="caddy-general-form" method="post" action="">
	<?php wp_nonce_field('caddy-general-settings-save', 'caddy_general_settings_nonce'); ?>
	<input type="hidden" name="cc_submit_hidden" value="Y">
	<div class="cc-settings-container">
		<h2><span class="section-icons"><img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-general.svg' ); ?>" /></span>&nbsp;<?php echo esc_html( __( 'General', 'caddy' ) ); ?></h2>
		<table class="form-table">
			<tbody>
			<?php do_action( 'caddy_general_settings_start' ); ?>
			<tr>
				<th scope="row">
					<label for="cc_disable_branding"><?php echo esc_html( __( 'Powered by Caddy branding', 'caddy' ) ); ?></label>
				</th>
				<td>
					<div class="cc-toggle cc-toggle--size-small">
						<input type="checkbox" name="cc_disable_branding" id="cc_disable_branding" value="enabled" <?php echo esc_attr( $cc_disable_branding ); ?>>
						<label for="cc_disable_branding">
							<div class="cc-toggle__switch" data-checked="On" data-unchecked="Off"></div>
							<div class="cc-toggle__label-text"><?php echo esc_html( __( 'We appreciate the ', 'caddy' ) ); ?>
								<span class="cc-love">♥</span>
								<?php echo esc_html( __( ' and support!', 'caddy' ) ); ?>
							</div>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cc_affiliate_id"><?php echo esc_html( __( 'Caddy Affiliate ID', 'caddy' ) ); ?></label>
				</th>
				<td>
					<input type="text" name="cc_affiliate_id" id="cc_affiliate_id" value="<?php echo esc_attr( $cc_affiliate_id ); ?>">
					<p class="description"><?php echo esc_html( __( 'Enter money from our Caddy branding link!', 'caddy' ) ); ?> <a href="<?php echo esc_url( 'https://usecaddy.com/become-an-affiliate' ); ?>" target="_blank"><?php echo esc_html__( 'Click here', 'caddy' ); ?></a> <?php echo esc_html( __( 'to sign up', 'caddy' ) ); ?></p>
				</td>
			</tr>
			<?php do_action( 'caddy_after_caddy_branding_row' ); ?>
			</tbody>
		</table>

		<h2><i class="dashicons dashicons-menu section-icons"></i>&nbsp;<?php echo esc_html( __( 'Menu Widgets', 'caddy' ) ); ?></h2>
		<p><?php echo esc_html( __( 'Enable the cart and saves menu widgets.', 'caddy' ) ); ?></p>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="cc_menu_cart_widget"><?php echo esc_html( __( 'Add Cart Widget to Menu', 'caddy' ) ); ?></label>
					</th>
					<td>
						<?php
							$menus = get_terms(array('taxonomy' => 'nav_menu', 'hide_empty' => true));
							
							echo '<select name="cc_menu_cart_widget">';
							echo '<option value="">Select a Menu</option>';
							foreach ($menus as $menu) {
								echo '<option value="' . esc_attr($menu->slug) . '"' . selected($cc_cart_selected_menu, $menu->slug, false) . '>' . esc_html($menu->name) . '</option>';
							}
							echo '</select>';
						?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cc_cart_widget_shortcode"><?php echo esc_html( __( 'Cart Widget Shortcode', 'caddy' ) ); ?></label>
					</th>
					<td>
						<input id="cc_cart_widget_shortcode" type="text" value="[cc_cart_items text='Cart' icon='yes']" readonly>
						<button type="button" class="button copy-shortcode-button" title="Copy to Clipboard">
							<span class="dashicons dashicons-admin-page"></span>
						</button>
						<p class="description"><?php echo esc_html( __( 'Copy the cart shortcode and embed it anywhere.', 'caddy' ) ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cc_menu_saves_widget"><?php echo esc_html( __( 'Add Saves Widget to Menu', 'caddy' ) ); ?></label>
					</th>
					<td>
						<?php
							echo '<select name="cc_menu_saves_widget">';
							echo '<option value="">Select a Menu</option>';
							foreach ($menus as $menu) {
								echo '<option value="' . esc_attr($menu->slug) . '"' . selected($cc_saves_selected_menu, $menu->slug, false) . '>' . esc_html($menu->name) . '</option>';
							}
							echo '</select>';
						?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cc_saves_widget_shortcode"><?php echo esc_html( __( 'Saves Widget Shortcode', 'caddy' ) ); ?></label>
					</th>
					<td>
						<input id="cc_saves_widget_shortcode" type="text" value="[cc_saved_items text='Saves' icon='yes']" readonly>
						<button type="button" class="button copy-shortcode-button" title="Copy to Clipboard">
							<span class="dashicons dashicons-admin-page"></span>
						</button>
						<p class="description"><?php echo esc_html( __( 'Copy the saves shortcode and embed it anywhere.', 'caddy' ) ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
			if ( ! isset( $caddy_license_status ) || 'valid' !== $caddy_license_status ) {
			?>
			<div class="cc-unlock-msg">
				<div><span class="dashicons dashicons-unlock"></span><?php echo esc_html( __( 'Unlock custom messaging, bubble positioning, free shipping meter exlusions, notices & more with ', 'caddy' ) ); ?><a href="<?php echo esc_url( 'https://www.usecaddy.com' ); ?>" target="_blank"><?php echo esc_html( __( 'Caddy Pro', 'caddy' ) ); ?></a></div>
			</div>
			<?php
		}?>
		<?php do_action( 'caddy_general_settings_end' ); ?>
	</div>
	<p class="submit cc-primary-save">
		<input type="submit" name="Submit" class="button-primary cc-primary-save-btn" value="<?php echo esc_attr__( 'Save Changes', 'caddy' ); ?>" />
	</p>
</form>
	
<?php 
