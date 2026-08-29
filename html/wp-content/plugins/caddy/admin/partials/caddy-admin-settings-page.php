<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin settings screen of the plugin.
 *
 * @see        https://www.madebytribe.com
 * @since      1.0.0
 */

// Get the active tab from URL hash or default to general settings
$active_tab = 'cc-general-settings'; // Default value, will be overridden by JavaScript

// Add this line to define the license status variable in the main scope
$caddy_license_status = get_option('caddy_premium_edd_license_status');

/**
 * Helper function to display the Pro label
 * 
 * @return string HTML for the Pro label if license is not valid
 */
function caddy_display_pro_label() {
    $caddy_license_status = get_option('caddy_premium_edd_license_status');
    
    if (!isset($caddy_license_status) || $caddy_license_status != 'valid') {
        return '<span class="caddy-pro-label">' . esc_html__('Pro', 'caddy') . '</span>';
    }
    
    return '';
}
?>

    <input type="hidden" id="active_tab" name="active_tab" value="">
    <div class="cc-settings-tabs">
        <ul class="cc-settings-menu tabs">
            <li class="<?php echo $active_tab === 'cc-general-settings' ? 'active' : ''; ?>">
                <a href="#cc-general-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) . 'img/icon-general.svg' ); ?>" />
                    <?php echo esc_html( __( 'General', 'caddy' ) ); ?>
                </a>
            </li>
            <?php if ( !isset($caddy_license_status) || $caddy_license_status != 'valid' ) { ?>		
            <li class="<?php echo $active_tab === 'cc-shipping-meter-settings' ? 'active' : ''; ?>">
                <a href="#cc-shipping-meter-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-free-shipping.svg'; ?>" />
                    <?php echo esc_html( __( 'Free Shipping Meter', 'caddy' ) ); ?>
                </a>
            </li>
            <?php } ?>
            <li class="<?php echo $active_tab === 'cc-recommendations-settings' ? 'active' : ''; ?>">
                <a href="#cc-recommendations-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-recs.svg'; ?>" />
                    <?php echo esc_html( __( 'Recommendations', 'caddy' ) ); ?>
                </a>
            </li>
            <li class="<?php echo $active_tab === 'cc-sfl-settings' ? 'active' : ''; ?>">
                <a href="#cc-sfl-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-sfl.svg'; ?>" />
                    <?php echo esc_html( __( 'Save for Later', 'caddy' ) ); ?>
                </a>
            </li>
            <li class="<?php echo $active_tab === 'cc-display-settings' ? 'active' : ''; ?>">
                <a href="#cc-display-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-display.svg'; ?>" />
                    <?php echo esc_html( __( 'Display', 'caddy' ) ); ?>
                    <?php
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Function returns escaped HTML
echo caddy_display_pro_label();
?>
                </a>
            </li>
            <li>
                <a href="#cc-offers-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-offers.svg'; ?>" />
                    <?php echo esc_html( __( 'Offers', 'caddy' ) ); ?>
                    <?php
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Function returns escaped HTML
echo caddy_display_pro_label();
?>
                </a>
            </li>
            <li>
                <a href="#cc-welcome-message-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-welcome.svg'; ?>" />
                    <?php echo esc_html( __( 'Welcome Message', 'caddy' ) ); ?> 
                    <?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Function returns escaped HTML
echo caddy_display_pro_label(); 
?>
                </a>
            </li>
            <li>
                <a href="#cc-announcement-bar-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-announcement.svg'; ?>" />
                    <?php echo esc_html( __( 'Announcement Bar', 'caddy' ) ); ?> 
                    <?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Function returns escaped HTML
echo caddy_display_pro_label(); 
?>
                </a>
            </li>
            <li>
                <a href="#cc-rewards-meter-settings">
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'img/icon-reward-meter.svg'; ?>" />
                    <?php echo esc_html( __( 'Rewards Meter', 'caddy' ) ); ?> 
                    <?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Function returns escaped HTML
echo caddy_display_pro_label(); 
?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="cc-general-settings" class="tab <?php echo $active_tab === 'cc-general-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/general.php'; ?>
            </div>
            <?php if ( !isset($caddy_license_status) || $caddy_license_status != 'valid' ) { ?>
            <div id="cc-shipping-meter-settings" class="tab <?php echo $active_tab === 'cc-shipping-meter-settings' ? 'active' : ''; ?>">
                <?php include plugin_dir_path( __FILE__ ) . 'settings/free-shipping-meter.php'; ?>
            </div>
            <?php } ?>
            <div id="cc-recommendations-settings" class="tab <?php echo $active_tab === 'cc-recommendations-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/recommendations.php'; ?>
            </div>
            <div id="cc-sfl-settings" class="tab <?php echo $active_tab === 'cc-sfl-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/save-for-later.php'; ?>
            </div>
            <div id="cc-display-settings" class="tab <?php echo $active_tab === 'cc-display-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/display.php'; ?>
            </div>
            <div id="cc-offers-settings" class="tab <?php echo $active_tab === 'cc-offers-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/offers.php'; ?>
            </div>
            <div id="cc-welcome-message-settings" class="tab <?php echo $active_tab === 'cc-welcome-message-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/welcome.php'; ?>
            </div>
            <div id="cc-announcement-bar-settings" class="tab <?php echo $active_tab === 'cc-announcement-bar-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/announcement-bar.php'; ?>
            </div>
            <div id="cc-rewards-meter-settings" class="tab <?php echo $active_tab === 'cc-rewards-meter-settings' ? 'active' : ''; ?>">
				<?php include plugin_dir_path( __FILE__ ) . 'settings/rewards-meter.php'; ?>
            </div>
        </div>
    </div>