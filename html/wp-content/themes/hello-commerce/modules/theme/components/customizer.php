<?php
namespace HelloCommerce\Modules\Theme\Components;

use HelloCommerce\Includes\Utils;
use HelloCommerce\Modules\Theme\Classes\Customizer_Action_Links;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Customizer {
	const CUSTOMIZER_SECTION_NAME = 'hello-commerce-options';

	public function register( $wp_customize ): void {
		if ( ! apply_filters( 'hello-plus-theme/customizer/enable', true ) ) {
			return;
		}

		$wp_customize->add_section(
			self::CUSTOMIZER_SECTION_NAME,
			[
				'title' => esc_html__( 'Header & Footer', 'hello-commerce' ),
				'capability' => 'edit_theme_options',
			]
		);

		$wp_customize->add_setting(
			'ehp-header-footer',
			[
				'sanitize_callback' => false,
				'transport' => 'refresh',
			]
		);

		$wp_customize->add_control(
			new Customizer_Action_Links(
				$wp_customize,
				'ehp-header-footer',
				[
					'section' => self::CUSTOMIZER_SECTION_NAME,
					'priority' => 20,
				]
			)
		);
	}

	public function enqueue_customizer_script() {
		$handle     = 'hello-commerce-customizer';
		$asset_path = HELLO_COMMERCE_SCRIPTS_PATH . $handle . '.asset.php';
		$asset_url  = HELLO_COMMERCE_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			$asset_url . $handle . '.js',
			array_merge( $asset['dependencies'], [ 'wp-util' ] ),
			$asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-commerce' );

		wp_localize_script(
			$handle,
			'ehp_customizer',
			[
				'nonce' => wp_create_nonce( 'updates' ),
				'redirectTo' => Utils::is_hello_plus_active() ? self_admin_url( 'admin.php?page=hello-plus-setup-wizard' ) : '',
			]
		);

		wp_enqueue_style(
			'hello-commerce-customizer',
			HELLO_COMMERCE_STYLE_URL . 'customizer.css',
			[],
			HELLO_COMMERCE_ELEMENTOR_VERSION
		);
	}

	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_customizer_script' ] );
		add_action( 'customize_register', [ $this, 'register' ] );
	}
}
