<?php

namespace HelloCommerce\Modules\Woocommerce;

use HelloCommerce\Includes\Module_Base;
use Elementor\Core\Kits\Documents\Kit;
use HelloCommerce\Modules\Settings\Components\Settings_Controller;
use HelloCommerce\Modules\Woocommerce\Components\Settings_Hello_Commerce;
use HelloCommerce\Includes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Module extends Module_Base {
	/**
	 * @inheritDoc
	 */
	public static function get_name(): string {
		return 'woocommerce';
	}

	/**
	 * @inheritDoc
	 */
	protected function get_component_ids(): array {
		return [
			'Frontend',
		];
	}

	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	public function scripts_styles() {
		if ( Settings_Controller::should_skip_hello_commerce_css() ) {
			return;
		}

		wp_enqueue_style(
			'hello-commerce-woocommerce',
			HELLO_COMMERCE_STYLE_URL . 'hello-commerce-woocommerce.css',
			[],
			HELLO_COMMERCE_ELEMENTOR_VERSION
		);
	}

	public function init_site_settings( Kit $kit ) {
		if ( ! Utils::is_woocommerce_active() ) {
			return;
		}

		$kit->register_tab( 'settings-hello-commerce', Settings_Hello_Commerce::class );
	}

	/**
	 * @inheritDoc
	 */
	protected function register_hooks(): void {
		parent::register_hooks();
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts_styles' ] );
		add_action( 'elementor/kit/register_tabs', [ $this, 'init_site_settings' ], 2 );
	}
}
