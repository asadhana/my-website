<?php

namespace HelloCommerce\Modules\ConversionBanner\Components;

use HelloCommerce\Includes\Utils;
use HelloCommerce\Modules\AdminHome\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Conversion_Banner {

	private function render_conversion_banner() {
		?>
		<div id="ehp-admin-cb" style="width: calc(100% - 48px)">
		</div>
		<?php
	}

	private function is_conversion_banner_active(): bool {
		if ( get_user_meta( get_current_user_id(), 'ehp_cb_dismissed', true ) ) {
			return false;
		}

		if ( Utils::is_hello_plus_setup_wizard_done() ) {
			return false;
		}

		$current_screen = get_current_screen();
		if ( ! $current_screen ) {
			return false;
		}

		$allowed_screens = [
			'dashboard',
			'edit-post',
			'edit-page',
			'edit-elementor_library',
			'themes',
			'plugins',
			'plugin-install',
		];

		return in_array( $current_screen->id, $allowed_screens, true );
	}

	private function enqueue_scripts() {
		$handle = 'hello-commerce-conversion-banner';
		$asset_path = HELLO_COMMERCE_SCRIPTS_PATH . 'hello-commerce-conversion-banner.asset.php';
		$asset_url = HELLO_COMMERCE_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			$asset_url . 'hello-commerce-conversion-banner.js',
			array_merge( $asset['dependencies'], [ 'wp-util' ] ),
			$asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-commerce' );

		$title = __( 'Welcome to Hello Commerce', 'hello-commerce' );
		$description = __( 'Access the full suite of features, including shop website kits, header and footer templates, and extra widgets.', 'hello-commerce' );
		$button_text = __( 'Begin setup', 'hello-commerce' );
		$button_link = Utils::get_hello_plus_activation_link();
		$show_text = true;

		if ( Utils::is_hello_plus_active() ) {
			$show_text = false;
			if ( ! Utils::is_hello_plus_setup_wizard_done() ) {
				$button_link = self_admin_url( 'admin.php?page=hello-plus-setup-wizard' );
				$title = __( 'Almost there', 'hello-commerce' );
				$description = __( 'Choose a template kit and start customizing your online shop.', 'hello-commerce' );
				$button_text = __( 'Finish setup', 'hello-commerce' );
			}
		}

		$is_installing_plugin_with_uploader = 'upload-plugin' === filter_input( INPUT_GET, 'action', FILTER_UNSAFE_RAW );

		wp_localize_script(
			$handle,
			'ehp_cb',
			[
				'ajax_url' => self_admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'ehp_cb_nonce' ),
				'imageUrl' => HELLO_COMMERCE_IMAGES_URL . 'banner-image.png',
				'buttonText' => $button_text,
				'buttonUrl' => $button_link,
				'isHelloPlusInstalled' => Utils::is_hello_plus_installed(),
				'nonceInstall' => wp_create_nonce( 'updates' ),
				'showText' => $show_text,
				'beforeWrap' => $is_installing_plugin_with_uploader,
				'title' => $title,
				'description' => $description,
			]
		);
	}

	public function dismiss_theme_notice() {
		check_ajax_referer( 'ehp_cb_nonce', 'nonce' );

		update_user_meta( get_current_user_id(), 'ehp_cb_dismissed', true );

		wp_send_json_success( [ 'message' => __( 'Notice dismissed.', 'hello-commerce' ) ] );
	}

	public function __construct() {

		add_action( 'wp_ajax_ehp_dismiss_theme_notice', [ $this, 'dismiss_theme_notice' ] );

		add_action( 'current_screen', function () {
			if ( ! $this->is_conversion_banner_active() ) {
				return;
			}

			add_action( 'in_admin_header', function () {
				$this->render_conversion_banner();
			}, 11 );

			add_action( 'admin_enqueue_scripts', function () {
				$this->enqueue_scripts();
			} );
		} );
	}
}
