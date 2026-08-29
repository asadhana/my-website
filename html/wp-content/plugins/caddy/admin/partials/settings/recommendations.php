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

$cc_product_recommendation = get_option( 'cc_product_recommendation' );
$cc_product_recommendation = ( 'disabled' !== $cc_product_recommendation ) ? 'checked' : '';

$cc_product_recommendation_type = get_option( 'cc_product_recommendation_type' );

?>
<form name="caddy-form" id="caddy-recommendations-form" method="post" action="">
	<?php wp_nonce_field('caddy-recommendations-settings-save', 'caddy_recommendations_settings_nonce'); ?>
	<input type="hidden" name="cc_submit_hidden" value="Y">
	<div class="cc-settings-container">
		<?php do_action( 'caddy_before_product_recommendations_section' ); ?>
		<h2><span class="section-icons"><img src="<?php echo esc_url( plugin_dir_url( CADDY_PLUGIN_FILE ) . 'admin/img/icon-recs.svg' ); ?>" /></span>&nbsp;<?php echo esc_html( __( 'Product Recommendations', 'caddy' ) ); ?></h2>
		<p><?php echo esc_html( __( 'Display targeted product recommendations every time a product is added to the cart.', 'caddy' ) ); ?></p>
		<table class="form-table">
			<tbody>
			<?php do_action( 'caddy_product_recommendations_settings_start' ); ?>
			<tr>
				<th scope="row">
					<label for="cc_product_recommendation"><?php esc_html_e( 'Enable recommendations', 'caddy' ); ?></label>
				</th>
				<td>
					<div class="cc-toggle cc-toggle--size-small">
						<input type="checkbox" name="cc_product_recommendation" id="cc_product_recommendation" value="enabled" <?php echo esc_attr( $cc_product_recommendation ); ?>>
						<label for="cc_product_recommendation">
							<div class="cc-toggle__switch" data-checked="On" data-unchecked="Off"></div>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cc_product_recommendation_type"><?php esc_html_e( 'Recommendation Type', 'caddy' ); ?></label>
				</th>
				<td>
					<select name="cc_product_recommendation_type" id="cc_product_recommendation_type">
						<option value="" selected><?php esc_html_e( '-- Select recommendation type --', 'caddy' ); ?></option>
						<option value="caddy-recommendations" <?php echo $cc_product_recommendation_type === 'caddy-recommendations' ? 'selected' : ''; ?>	><?php esc_html_e( 'Caddy Recommendations', 'caddy' ); ?></option>
						<option value="cross-sells" <?php echo $cc_product_recommendation_type === 'cross-sells' ? 'selected' : ''; ?>><?php esc_html_e( 'Product Cross-sells', 'caddy' ); ?></option>
						<option value="upsells" <?php echo $cc_product_recommendation_type === 'upsells' ? 'selected' : ''; ?>><?php esc_html_e( 'Product Upsells', 'caddy' ); ?></option>
					</select>
					<p class="description">
						<?php echo esc_html( __( 'Configure which products are displayed within your product\'s "Linked Products" tab', 'caddy' ) ); ?>
					</p>
				</td>
			</tr>
			<?php do_action( 'caddy_product_recommendations_settings_end' ); ?>
			</tbody>
		</table>
		<?php if ( ! isset( $caddy_license_status ) || 'valid' !== $caddy_license_status ) { ?>
			<div class="cc-unlock-msg">
				<div><span class="dashicons dashicons-unlock"></span><?php echo esc_html( __( 'Unlock recommendation fallbacks, customize recommendation text, set exclusions & more with ', 'caddy' ) ); ?><a href="<?php echo esc_url( 'https://www.usecaddy.com' ); ?>" target="_blank"><?php echo esc_html( __( 'Caddy Pro', 'caddy' ) ); ?></a></div>
			</div>
			<?php
		}?>
	</div>
	<p class="submit cc-primary-save">
		<input type="submit" name="Submit" class="button-primary cc-primary-save-btn" value="<?php echo esc_attr__( 'Save Changes', 'caddy' ); ?>" />
	</p>
</form>