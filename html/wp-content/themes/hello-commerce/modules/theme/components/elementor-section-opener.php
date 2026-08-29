<?php

namespace HelloCommerce\Modules\Theme\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elementor_Section_Opener {

	public function __construct() {
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_section_opener_script' ] );
	}

	public function enqueue_section_opener_script() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$active_section = isset( $_GET['active-section'] ) ? sanitize_text_field( wp_unslash( $_GET['active-section'] ) ) : '';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$active_tab = isset( $_GET['active-tab'] ) ? sanitize_text_field( wp_unslash( $_GET['active-tab'] ) ) : '';

		if ( ! $active_section && ! $active_tab ) {
			return;
		}

		$handle = 'hello-commerce-elementor-section-opener';
		$asset_url  = HELLO_COMMERCE_SCRIPTS_URL;
		$asset_path = HELLO_COMMERCE_SCRIPTS_PATH . $handle . '.asset.php';

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$script_asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			$asset_url . $handle . '.js',
			array_unique( array_merge( $script_asset['dependencies'], [ 'jquery', 'elementor-editor' ] ) ),
			$script_asset['version'],
			true
		);
	}
}
