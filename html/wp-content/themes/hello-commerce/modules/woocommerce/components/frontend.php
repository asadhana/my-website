<?php

namespace HelloCommerce\Modules\Woocommerce\Components;

use HelloCommerce\Includes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Frontend {

	public function enqueue_kit_style_style( $styles ) {
		if ( Utils::is_elementor_active() ) {
			Utils::elementor()->kits_manager->frontend_before_enqueue_styles();
		}

		return $styles;
	}

	public function __construct() {
		add_filter( 'woocommerce_enqueue_styles', [ $this, 'enqueue_kit_style_style' ] );
	}
}
