<?php

namespace HelloCommerce\Modules\Theme\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Onboarding_Wizard {

	public function filter_get_started_text( array $text ): array {
		$text['title'] = __( 'Welcome! Let\'s create your shop.', 'hello-commerce' );
		$text['description'] = __( 'Thanks for installing the Hello Commerce theme by Elementor. This setup wizard will help you create a shop in moments.', 'hello-commerce' );
		$text['buttonText'] = __( 'Start building my shop', 'hello-commerce' );
		$text['disclaimer'] = __( 'By clicking "Start building my shop," I agree to install and activate the Elementor and WooCommerce plugins. I accept the Elementor', 'hello-commerce' );
		return $text;
	}

	public function filter_ready_to_go_text( array $text ): array {
		$text['title'] = __( 'Congratulations, you’ve created your shop!', 'hello-commerce' );
		$text['description'] = __( 'It’s time to make it yours—add your content, style, and personal touch.', 'hello-commerce' );
		$text['viewSite'] = __( 'View my shop', 'hello-commerce' );
		$text['customizeSite'] = __( 'Customize my shop', 'hello-commerce' );
		return $text;
	}

	public function filter_install_kit_text( array $text ): array {
		$text['title'] = __( 'Choose your shop template kit', 'hello-commerce' );
		$text['description'] = __( 'Explore our versatile shop kits to find one that fits your style or project.', 'hello-commerce' );
		return $text;
	}

	public function __construct() {
		add_filter( 'hello-plus/onboarding/get-started-text', [ $this, 'filter_get_started_text' ] );
		add_filter( 'hello-plus/onboarding/ready-to-go-text', [ $this, 'filter_ready_to_go_text' ] );
		add_filter( 'hello-plus/onboarding/install-kit-text', [ $this, 'filter_install_kit_text' ] );
	}
}
